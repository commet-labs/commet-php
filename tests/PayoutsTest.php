<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Models\Payout;
use Commet\Models\PayoutBankAccount;
use Commet\Models\PayoutVerification;
use Commet\Resources\PayoutsResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class PayoutsTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function payoutsWithResponses(array $responses): PayoutsResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new PayoutsResource($http);
    }

    /** @return array<string, mixed> */
    private function sentBody(int $index = 0): array
    {
        return json_decode((string) $this->history[$index]['request']->getBody(), true);
    }

    private function response(array $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => $data,
        ], JSON_THROW_ON_ERROR));
    }

    public function testRequestSendsAmountAndOmitsNullDescription(): void
    {
        $payouts = $this->payoutsWithResponses([
            $this->response([
                'id' => 'po_123',
                'status' => 'pending',
                'amount' => 5000,
                'fee' => 0,
                'net_amount' => 5000,
                'currency' => 'USD',
                'provider_transfer_id' => 'tr_abc',
                'created_at' => '2026-06-08T00:00:00Z',
                'object' => 'payout',
                'livemode' => false,
            ]),
        ]);

        $result = $payouts->request(amount: 5000);

        $body = $this->sentBody();
        $this->assertSame(5000, $body['amount']);
        $this->assertArrayNotHasKey('description', $body);

        $this->assertInstanceOf(Payout::class, $result->data);
        $this->assertSame('po_123', $result->data->id);
        $this->assertSame(5000, $result->data->netAmount);
        $this->assertSame('tr_abc', $result->data->providerTransferId);
        $this->assertNull($result->data->description);
    }

    public function testAddBankAccountSerializesSnakeCaseFieldsAsCamelCaseWire(): void
    {
        $payouts = $this->payoutsWithResponses([
            $this->response([
                'id' => 'ba_1',
                'holder_name' => 'Jane Doe',
                'last4' => '6789',
                'country' => 'US',
                'currency' => 'USD',
                'is_default' => true,
                'status' => 'verified',
                'created_at' => '2026-06-08T00:00:00Z',
                'object' => 'payout_bank_account',
                'livemode' => false,
                'bank_name' => 'Chase',
                'account_type' => 'checking',
            ]),
        ]);

        $result = $payouts->addBankAccount(
            accountNumber: '000123456789',
            accountHolderName: 'Jane Doe',
            routingNumber: '110000000',
            accountType: 'checking',
            setDefault: true,
        );

        $body = $this->sentBody();
        // Request keys must travel as camelCase, never snake_case.
        $this->assertSame('000123456789', $body['accountNumber']);
        $this->assertSame('Jane Doe', $body['accountHolderName']);
        $this->assertSame('110000000', $body['routingNumber']);
        $this->assertSame('checking', $body['accountType']);
        $this->assertTrue($body['setDefault']);
        $this->assertArrayNotHasKey('account_number', $body);
        $this->assertArrayNotHasKey('set_default', $body);

        // camelCase response hydrates the typed model from snake_case wire.
        $this->assertInstanceOf(PayoutBankAccount::class, $result->data);
        $this->assertSame('Jane Doe', $result->data->holderName);
        $this->assertSame('6789', $result->data->last4);
        $this->assertTrue($result->data->isDefault);
        $this->assertSame('Chase', $result->data->bankName);
        $this->assertSame('checking', $result->data->accountType);
        $this->assertNull($result->data->providerExternalAccountId);
    }

    public function testAddBankAccountOmitsNullOptionalFields(): void
    {
        $payouts = $this->payoutsWithResponses([
            $this->response([
                'id' => 'ba_2',
                'holder_name' => 'Jane Doe',
                'last4' => '6789',
                'country' => 'US',
                'currency' => 'USD',
                'is_default' => false,
                'status' => 'pending',
                'created_at' => '2026-06-08T00:00:00Z',
                'object' => 'payout_bank_account',
                'livemode' => false,
            ]),
        ]);

        $payouts->addBankAccount(
            accountNumber: '000123456789',
            accountHolderName: 'Jane Doe',
        );

        $body = $this->sentBody();
        $this->assertArrayHasKey('accountNumber', $body);
        $this->assertArrayHasKey('accountHolderName', $body);
        $this->assertArrayNotHasKey('routingNumber', $body);
        $this->assertArrayNotHasKey('accountType', $body);
        $this->assertArrayNotHasKey('setDefault', $body);
    }

    public function testCompleteVerificationSendsNestedBankObjectAsCamelCase(): void
    {
        $payouts = $this->payoutsWithResponses([
            $this->response([
                'provider_account_id' => 'acct_xyz',
                'status' => 'pending_verification',
                'transfers_enabled' => false,
                'object' => 'payout_verification',
                'livemode' => false,
                'already_exists' => false,
                'business_type' => 'individual',
                'country' => 'US',
            ]),
        ]);

        $result = $payouts->completeVerification(
            email: 'owner@acme.com',
            businessType: 'individual',
            businessUrl: 'https://acme.com',
            documentUrl: 'https://files.commet.co/doc.pdf',
            bank: [
                'account_number' => '000999888777',
                'routing_number' => '021000021',
                'account_holder_name' => 'Acme LLC',
            ],
            individual: [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
            ],
        );

        $body = $this->sentBody();
        // Top-level snake->camel.
        $this->assertSame('individual', $body['businessType']);
        $this->assertSame('https://acme.com', $body['businessUrl']);
        $this->assertSame('https://files.commet.co/doc.pdf', $body['documentUrl']);
        $this->assertArrayNotHasKey('business_type', $body);

        // Nested bank object keys must also be converted recursively.
        $this->assertSame('000999888777', $body['bank']['accountNumber']);
        $this->assertSame('021000021', $body['bank']['routingNumber']);
        $this->assertSame('Acme LLC', $body['bank']['accountHolderName']);
        $this->assertArrayNotHasKey('account_number', $body['bank']);

        // Nested individual object.
        $this->assertSame('Jane', $body['individual']['firstName']);
        $this->assertSame('Doe', $body['individual']['lastName']);

        // company omitted when null.
        $this->assertArrayNotHasKey('company', $body);

        $this->assertInstanceOf(PayoutVerification::class, $result->data);
        $this->assertSame('acct_xyz', $result->data->providerAccountId);
        $this->assertFalse($result->data->transfersEnabled);
        $this->assertFalse($result->data->alreadyExists);
        $this->assertSame('individual', $result->data->businessType);
    }

    public function testPayoutFromArrayHydratesNumericFields(): void
    {
        $payout = Payout::fromArray([
            'id' => 'po_9',
            'status' => 'paid',
            'amount' => 12000,
            'fee' => 250,
            'net_amount' => 11750,
            'currency' => 'EUR',
            'provider_transfer_id' => 'tr_eu',
            'created_at' => '2026-06-08T00:00:00Z',
            'object' => 'payout',
            'livemode' => true,
            'description' => 'June payout',
        ]);

        $this->assertSame(12000, $payout->amount);
        $this->assertSame(250, $payout->fee);
        $this->assertSame(11750, $payout->netAmount);
        $this->assertSame('June payout', $payout->description);
        $this->assertTrue($payout->livemode);
    }
}
