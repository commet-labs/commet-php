<?php

declare(strict_types=1);

namespace Commet\Models;

class ActivateAddonResult
{
    public function __construct(
        public readonly string $addonId,
        public readonly string $status,
        public readonly int $proratedCharge,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            addonId: $data['addon_id'],
            status: $data['status'],
            proratedCharge: $data['prorated_charge'],
        );
    }
}
