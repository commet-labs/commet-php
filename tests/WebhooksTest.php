<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Resources\WebhooksResource;
use Commet\Webhooks\WebhookEvent;
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
        $this->payload = '{"event":"subscription.created","data":{"id":"sub_123"}}';
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

    public function testVerifyAndParseReturnsDataOnValidSignature(): void
    {
        $result = $this->webhooks->verifyAndParse($this->payload, $this->validSignature, $this->secret);

        $this->assertNotNull($result);
        $this->assertSame('subscription.created', $result['event']);
        $this->assertSame('sub_123', $result['data']['id']);
    }

    public function testVerifyAndParseReturnsNullOnInvalidSignature(): void
    {
        $result = $this->webhooks->verifyAndParse($this->payload, 'bad_sig', $this->secret);

        $this->assertNull($result);
    }

    public function testPaymentReceivedKeepsPaymentMethodAddedAfterThisSdkVersion(): void
    {
        $event = WebhookEvent::fromArray([
            'event' => 'payment.received',
            'timestamp' => '2026-01-01T00:00:00Z',
            'organizationId' => 'org_123',
            'mode' => 'live',
            'apiVersion' => '2026-08-27',
            'data' => [
                'invoiceId' => 'inv_123',
                'invoiceNumber' => 'INV-0001',
                'invoiceTotal' => 99.0,
                'customerId' => 'cus_123',
                'paymentMethod' => 'bank_transfer',
                'subPaymentMethod' => null,
                'paidAt' => '2026-01-01T00:00:00Z',
            ],
        ]);

        $payment = $event->asPaymentReceived();

        $this->assertSame('bank_transfer', $payment->paymentMethod);
    }

    public function testVerifyAndParseReturnsNullOnInvalidJson(): void
    {
        $badJson = 'not valid json {{{';
        $signature = hash_hmac('sha256', $badJson, $this->secret);

        $result = $this->webhooks->verifyAndParse($badJson, $signature, $this->secret);

        $this->assertNull($result);
    }
}
