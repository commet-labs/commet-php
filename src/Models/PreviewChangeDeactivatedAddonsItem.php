<?php

declare(strict_types=1);

namespace Commet\Models;

class PreviewChangeDeactivatedAddonsItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $addonId,
        public readonly string $name,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["addonId"] = $this->addonId;
        $values["name"] = $this->name;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            addonId: $data["addon_id"],
            name: $data["name"],
        );
    }
}
