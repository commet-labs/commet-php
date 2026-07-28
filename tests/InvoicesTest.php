<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Enums\InvoiceType;
use Commet\HttpClient;
use Commet\Models\Invoice;
use Commet\Models\InvoiceLineItemsItem;
use Commet\Models\InvoiceDownload;
use Commet\Resources\InvoicesResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class InvoicesTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function invoicesWithResponses(array $responses): InvoicesResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new InvoicesResource($http);
    }

    /** @return array<string, mixed> */
    private function sentBody(int $index = 0): array
    {
        return json_decode((string) $this->history[$index]['request']->getBody(), true);
    }

    private function response(mixed $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode($data, JSON_THROW_ON_ERROR));
    }

    private function invoiceWire(array $overrides = []): array
    {
        return array_merge([
            'id' => 'inv_1',
            'customer_id' => 'cus_1',
            'invoice_number' => 'INV-001',
            'status' => 'paid',
            'invoice_type' => 'recurring',
            'currency' => 'USD',
            'subtotal' => 9000,
            'discount_amount' => 0,
            'credit_applied' => 0,
            'tax_amount' => 1000,
            'total' => 10000,
            'period_start' => '2026-06-01T00:00:00Z',
            'period_end' => '2026-07-01T00:00:00Z',
            'issue_date' => '2026-06-01T00:00:00Z',
            'due_date' => '2026-06-15T00:00:00Z',
            'metadata' => [],
            'created_at' => '2026-06-01T00:00:00Z',
            'updated_at' => '2026-06-01T00:00:00Z',
            'line_items' => [],
            'object' => 'invoice',
            'livemode' => false,
        ], $overrides);
    }

    public function testGetHydratesInvoiceTypeEnumAndNullableOptionalFields(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response($this->invoiceWire([
                'invoice_type' => 'overage',
                'subscription_id' => 'sub_1',
                'credit_applied' => 500,
                'line_items' => [
                    [
                        'line_type' => 'feature_overage',
                        'description' => 'API overage',
                        'quantity' => 1,
                        'unit_amount' => 9000,
                        'amount' => 9000,
                        'charge_type' => 'usage',
                    ],
                ],
            ])),
        ]);

        $result = $invoices->get('inv_1');

        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertSame(InvoiceType::Overage, $result->invoiceType);
        $this->assertSame('sub_1', $result->subscriptionId);
        $this->assertSame(500, $result->creditApplied);
        $this->assertInstanceOf(InvoiceLineItemsItem::class, $result->lineItems[0]);
        $this->assertSame('API overage', $result->lineItems[0]->description);
    }

    public function testGetOmittedOptionalFieldsAreNull(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response($this->invoiceWire()),
        ]);

        $result = $invoices->get('inv_1');

        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertSame(InvoiceType::Recurring, $result->invoiceType);
        $this->assertNull($result->subscriptionId);
        $this->assertSame(0, $result->creditApplied);
        $this->assertSame([], $result->lineItems);
        $this->assertNull($result->memo);
    }

    public function testCreateAdjustmentSendsNegativeAmountAndCamelCaseCustomerId(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response([
                'id' => 'inv_adj',
                'customer_id' => 'cus_1',
                'invoice_number' => 'INV-ADJ',
                'status' => 'open',
                'invoice_type' => 'adjustment',
                'currency' => 'USD',
                'subtotal' => -2500,
                'discount_amount' => 0,
                'credit_applied' => 0,
                'tax_amount' => 0,
                'total' => -2500,
                'period_start' => '2026-06-08T00:00:00Z',
                'period_end' => '2026-06-08T00:00:00Z',
                'issue_date' => '2026-06-08T00:00:00Z',
                'due_date' => '2026-06-08T00:00:00Z',
                'metadata' => ['reason' => 'goodwill'],
                'created_at' => '2026-06-08T00:00:00Z',
                'updated_at' => '2026-06-08T00:00:00Z',
                'line_items' => [],
                'object' => 'invoice',
                'livemode' => false,
            ]),
        ]);

        $result = $invoices->createAdjustment(
            customerId: 'cus_1',
            amount: -2500,
            description: 'Goodwill credit',
            metadata: ['reason' => 'goodwill'],
        );

        $body = $this->sentBody();
        $this->assertSame('cus_1', $body['customerId']);
        $this->assertSame(-2500, $body['amount']);
        $this->assertSame('Goodwill credit', $body['description']);
        $this->assertSame('goodwill', $body['metadata']['reason']);
        $this->assertArrayNotHasKey('customer_id', $body);

        $this->assertInstanceOf(Invoice::class, $result);
        $this->assertSame(InvoiceType::Adjustment, $result->invoiceType);
        $this->assertSame(-2500, $result->total);
    }

    public function testListSendsFilterParamsAsCamelCaseQuery(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response([
                'object' => 'list',
                'data' => [$this->invoiceWire()],
                'has_more' => false,
            ]),
        ]);

        $invoices->list(customerId: 'cus_1', subscriptionId: 'sub_9', limit: 25);

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertStringContainsString('customerId=cus_1', $query);
        $this->assertStringContainsString('subscriptionId=sub_9', $query);
        $this->assertStringContainsString('limit=25', $query);
        $this->assertStringNotContainsString('customer_id', $query);
        // Omitted null filters never reach the query string.
        $this->assertStringNotContainsString('status', $query);
        $this->assertStringNotContainsString('cursor', $query);
    }

    public function testGetDownloadUrlHydratesExpiresAt(): void
    {
        $invoices = $this->invoicesWithResponses([
            $this->response([
                'url' => 'https://files.commet.co/inv_1.pdf?sig=abc',
                'expires_at' => '2026-06-15T00:00:00Z',
                'object' => 'invoice_download',
                'livemode' => false,
            ]),
        ]);

        $result = $invoices->getDownloadUrl('inv_1');

        $this->assertInstanceOf(InvoiceDownload::class, $result);
        $this->assertSame('https://files.commet.co/inv_1.pdf?sig=abc', $result->url);
        $this->assertSame('2026-06-15T00:00:00Z', $result->expiresAt);
    }
}
