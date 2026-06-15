<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Resources\WebhooksResource;
use Commet\Webhooks\SubscriptionCreatedData;
use Commet\Webhooks\WebhookEvent;
use Commet\Webhooks\WebhookEventType;
use PHPUnit\Framework\TestCase;

class WebhooksTest extends TestCase
{
    private WebhooksResource $webhooks;
    private string $secret;
    private string $payload;
    private string $validSignature;

    protected function setUp(): void
    {
        $this->webhooks = new WebhooksResource();
        $this->secret = 'whsec_test_secret_key';
        $this->payload = json_encode([
            'event' => 'subscription.created',
            'timestamp' => '2026-01-01T00:00:00.000Z',
            'organizationId' => 'org_123',
            'mode' => 'live',
            'apiVersion' => '2025-01-01',
            'data' => [
                'subscriptionId' => 'sub_123',
                'customerId' => 'cus_123',
                'planId' => 'plan_123',
                'planName' => 'Pro',
                'status' => 'pending_payment',
                'startDate' => null,
                'name' => null,
            ],
        ], JSON_THROW_ON_ERROR);
        $this->validSignature = hash_hmac('sha256', $this->payload, $this->secret);
    }

    public function testValidSignaturePasses(): void
    {
        $result = $this->webhooks->verify($this->payload, $this->validSignature, $this->secret);

        $this->assertTrue($result);
    }

    public function testInvalidSignatureFails(): void
    {
        $result = $this->webhooks->verify($this->payload, 'invalid_signature', $this->secret);

        $this->assertFalse($result);
    }

    public function testTamperedPayloadDetected(): void
    {
        $tamperedPayload = '{"event":"subscription.created","data":{"id":"sub_hacked"}}';

        $result = $this->webhooks->verify($tamperedPayload, $this->validSignature, $this->secret);

        $this->assertFalse($result);
    }

    public function testEmptySignatureFails(): void
    {
        $result = $this->webhooks->verify($this->payload, '', $this->secret);

        $this->assertFalse($result);
    }

    public function testNullSignatureFails(): void
    {
        $result = $this->webhooks->verify($this->payload, null, $this->secret);

        $this->assertFalse($result);
    }

    public function testEmptySecretFails(): void
    {
        $result = $this->webhooks->verify($this->payload, $this->validSignature, '');

        $this->assertFalse($result);
    }

    public function testEmptyPayloadFails(): void
    {
        $result = $this->webhooks->verify('', $this->validSignature, $this->secret);

        $this->assertFalse($result);
    }

    public function testVerifyAndParseReturnsTypedEnvelopeOnValidSignature(): void
    {
        $result = $this->webhooks->verifyAndParse($this->payload, $this->validSignature, $this->secret);

        $this->assertInstanceOf(WebhookEvent::class, $result);
        $this->assertSame('subscription.created', $result->event);
        $this->assertSame(WebhookEventType::SUBSCRIPTION_CREATED, $result->event);
        $this->assertSame('org_123', $result->organizationId);
        $this->assertSame('live', $result->mode);
        $this->assertSame('sub_123', $result->data['subscriptionId']);
    }

    public function testVerifyAndParseNarrowsToTypedData(): void
    {
        $result = $this->webhooks->verifyAndParse($this->payload, $this->validSignature, $this->secret);

        $this->assertInstanceOf(WebhookEvent::class, $result);

        $data = $result->asSubscriptionCreated();

        $this->assertInstanceOf(SubscriptionCreatedData::class, $data);
        $this->assertSame('sub_123', $data->subscriptionId);
        $this->assertSame('cus_123', $data->customerId);
        $this->assertSame('Pro', $data->planName);
        $this->assertSame('pending_payment', $data->status);
        $this->assertNull($data->startDate);
        $this->assertNull($data->name);
    }

    public function testVerifyAndParseReturnsNullOnInvalidSignature(): void
    {
        $result = $this->webhooks->verifyAndParse($this->payload, 'bad_sig', $this->secret);

        $this->assertNull($result);
    }

    public function testVerifyAndParseReturnsNullOnInvalidJson(): void
    {
        $badJson = 'not valid json {{{';
        $signature = hash_hmac('sha256', $badJson, $this->secret);

        $result = $this->webhooks->verifyAndParse($badJson, $signature, $this->secret);

        $this->assertNull($result);
    }
}
