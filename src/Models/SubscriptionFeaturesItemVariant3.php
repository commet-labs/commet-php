<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionFeaturesItemVariant3 extends SubscriptionFeaturesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly string $type,
        public readonly SubscriptionFeaturesItemVariant3Usage $usage,
        public readonly ?SubscriptionFeaturesItemVariant3BaseAccess $baseAccess = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["code"] = $this->code;
        $values["name"] = $this->name;
        $values["type"] = $this->type;
        $values["usage"] = $this->usage;
        if ($this->baseAccess !== null) {
            $values["baseAccess"] = $this->baseAccess;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data["code"],
            name: $data["name"],
            type: $data["type"],
            usage: SubscriptionFeaturesItemVariant3Usage::fromArray($data["usage"]),
            baseAccess: isset($data["base_access"]) ? SubscriptionFeaturesItemVariant3BaseAccess::fromArray($data["base_access"]) : null,
        );
    }
}
