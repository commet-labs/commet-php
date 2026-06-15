<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookPlanRef
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            name: $data["name"],
        );
    }
}
