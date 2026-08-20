<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\HttpClient;
use Commet\Models\Payout;
use Commet\Models\PayoutBankAccount;
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
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($data, JSON_THROW_ON_ERROR));
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

        $this->assertInstanceOf(Payout::class, $result);
        $this->assertSame('po_123', $result->id);
        $this->assertSame(5000, $result->netAmount);
        $this->assertSame('tr_abc', $result->providerTransferId);
        $this->assertNull($result->description);
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
        $this->assertInstanceOf(PayoutBankAccount::class, $result);
        $this->assertSame('Jane Doe', $result->holderName);
        $this->assertSame('6789', $result->last4);
        $this->assertTrue($result->isDefault);
        $this->assertSame('Chase', $result->bankName);
        $this->assertSame('checking', $result->accountType);
        $this->assertNull($result->providerExternalAccountId);
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
