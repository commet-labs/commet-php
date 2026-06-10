<?php

declare(strict_types=1);

namespace Commet\Tests;

use Commet\Enums\FeatureType;
use Commet\HttpClient;
use Commet\Models\Feature;
use Commet\Resources\FeaturesResource;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class FeaturesTest extends TestCase
{
    /** @var list<array<string, mixed>> */
    private array $history = [];

    /**
     * @param list<Response> $responses
     */
    private function featuresWithResponses(array $responses): FeaturesResource
    {
        $stack = HandlerStack::create(new MockHandler($responses));
        $this->history = [];
        $stack->push(Middleware::history($this->history));
        $http = new HttpClient('ck_test_123', handler: $stack);
        return new FeaturesResource($http);
    }

    /** @return array<string, mixed> */
    private function sentBody(int $index = 0): array
    {
        return json_decode((string) $this->history[$index]['request']->getBody(), true);
    }

    private function response(mixed $data): Response
    {
        return new Response(200, ['Content-Type' => 'application/json'], json_encode([
            'success' => true,
            'data' => $data,
        ], JSON_THROW_ON_ERROR));
    }

    public function testCreateSerializesFeatureTypeEnumToWireString(): void
    {
        $features = $this->featuresWithResponses([
            $this->response([
                'id' => 'feat_1',
                'name' => 'API Calls',
                'code' => 'api_calls',
                'type' => 'usage',
                'created_at' => '2026-06-08T00:00:00Z',
                'updated_at' => '2026-06-08T00:00:00Z',
                'object' => 'feature',
                'livemode' => false,
                'unit_name' => 'call',
            ]),
        ]);

        $result = $features->create(
            name: 'API Calls',
            code: 'api_calls',
            type: FeatureType::Usage,
            unitName: 'call',
        );

        $body = $this->sentBody();
        // Required backed enum serialized to wire string.
        $this->assertSame('usage', $body['type']);
        $this->assertSame('api_calls', $body['code']);
        $this->assertSame('call', $body['unitName']);
        $this->assertArrayNotHasKey('unit_name', $body);
        $this->assertArrayNotHasKey('description', $body);

        $this->assertInstanceOf(Feature::class, $result->data);
        $this->assertSame(FeatureType::Usage, $result->data->type);
        $this->assertSame('call', $result->data->unitName);
    }

    public function testListHydratesFeatureCatalogWithoutParams(): void
    {
        $features = $this->featuresWithResponses([
            $this->response([
                [
                    'id' => 'feat_1',
                    'name' => 'API Calls',
                    'code' => 'api_calls',
                    'type' => 'usage',
                    'created_at' => '2026-06-08T00:00:00Z',
                    'updated_at' => '2026-06-08T00:00:00Z',
                    'object' => 'feature',
                    'livemode' => false,
                    'unit_name' => 'call',
                ],
            ]),
        ]);

        $result = $features->list();

        $query = $this->history[0]['request']->getUri()->getQuery();
        $this->assertSame('', $query);

        $this->assertIsArray($result->data);
        $feature = $result->data[0];
        $this->assertInstanceOf(Feature::class, $feature);
        $this->assertSame('api_calls', $feature->code);
        $this->assertSame(FeatureType::Usage, $feature->type);
        $this->assertSame('call', $feature->unitName);
    }

    public function testGetHydratesFeatureDefinition(): void
    {
        $features = $this->featuresWithResponses([
            $this->response([
                'id' => 'feat_1',
                'name' => 'API Calls',
                'code' => 'api_calls',
                'type' => 'usage',
                'created_at' => '2026-06-08T00:00:00Z',
                'updated_at' => '2026-06-08T00:00:00Z',
                'object' => 'feature',
                'livemode' => false,
            ]),
        ]);

        $result = $features->get(code: 'api_calls');

        $this->assertSame('/features/api_calls', $this->history[0]['request']->getUri()->getPath());
        $this->assertInstanceOf(Feature::class, $result->data);
        $this->assertSame('api_calls', $result->data->code);
        $this->assertSame(FeatureType::Usage, $result->data->type);
    }
}
