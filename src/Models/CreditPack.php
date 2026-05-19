<?php

declare(strict_types=1);

namespace Commet\Models;

use Commet\Enums\Currency;

class CreditPack
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly int $credits,
        public readonly int $price,
        public readonly Currency $currency,
        public readonly ?string $description = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'],
            credits: $data['credits'],
            price: $data['price'],
            currency: Currency::from($data['currency']),
            description: $data['description'] ?? null,
        );
    }
}
