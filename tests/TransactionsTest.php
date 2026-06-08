<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Enums\TransactionStatus;
use Commet\HttpClient;
use Commet\Models\Transaction;
use Commet\Models\TransactionRefund;
use Commet\Models\TransactionRetry;
use Commet\Resources\TransactionsResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TransactionsTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function transactionsWithResponses(array $responses): TransactionsResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new TransactionsResource($http);
    }

    private function response(mixed $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => $data,
        ], JSON_THROW_ON_ERROR));
    }

    public function testListSerializesStatusEnumToWireStringInQuery(): void
    {
        $transactions = $this->transactionsWithResponses([
            $this->response([]),
        ]);

        $transactions->list(
            status: TransactionStatus::Refunded,
            customerEmail: 'a@b.com',
            limit: 10,
        );

        $query = $this->history[0]['request']->getUri()->getQuery();
        // Backed enum serialized to its wire string value.
        $this->assertStringContainsString('status=refunded', $query);
        $this->assertStringContainsString('customerEmail=', $query);
        $this->assertStringNotContainsString('customer_email', $query);
        $this->assertStringNotContainsString('cursor', $query);
    }

    public function testGetHydratesStatusEnumAndNullablePaidAt(): void
    {
        $transactions = $this->transactionsWithResponses([
            $this->response([
                'id' => 'txn_1',
                'gross_amount' => 10000,
                'subtotal' => 9000,
                'tax_amount' => 1000,
                'currency' => 'USD',
                'status' => 'pending',
                'created_at' => '2026-06-08T00:00:00Z',
                'updated_at' => '2026-06-08T00:00:00Z',
                'object' => 'transaction',
                'livemode' => false,
                'customer_email' => 'a@b.com',
            ]),
        ]);

        $result = $transactions->get('txn_1');

        $this->assertInstanceOf(Transaction::class, $result->data);
        $this->assertSame(TransactionStatus::Pending, $result->data->status);
        $this->assertSame('a@b.com', $result->data->customerEmail);
        // Omitted optional timestamps map to null, not empty string.
        $this->assertNull($result->data->paidAt);
        $this->assertNull($result->data->availableAt);
        $this->assertNull($result->data->invoiceId);
    }

    public function testRefundPostsNoBodyAndHydratesRefund(): void
    {
        $transactions = $this->transactionsWithResponses([
            $this->response([
                'id' => 're_1',
                'status' => 'succeeded',
                'object' => 'transaction_refund',
                'livemode' => false,
            ]),
        ]);

        $result = $transactions->refund('txn_1');

        $request = $this->history[0]['request'];
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('', (string) $request->getBody());

        $this->assertInstanceOf(TransactionRefund::class, $result->data);
        $this->assertSame('re_1', $result->data->id);
        $this->assertSame('succeeded', $result->data->status);
    }

    public function testRetryHydratesRetryInvoiceNumber(): void
    {
        $transactions = $this->transactionsWithResponses([
            $this->response([
                'id' => 'txn_2',
                'status' => 'pending',
                'retry_invoice_number' => 'INV-RETRY-9',
                'object' => 'transaction_retry',
                'livemode' => false,
            ]),
        ]);

        $result = $transactions->retry('txn_1');

        $this->assertInstanceOf(TransactionRetry::class, $result->data);
        $this->assertSame('INV-RETRY-9', $result->data->retryInvoiceNumber);
    }
}
