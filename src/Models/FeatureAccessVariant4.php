<?php

declare(strict_types=1);

namespace Commet\Models;

class FeatureAccessVariant4 extends FeatureAccess implements \JsonSerializable
{
    public function __construct(
        public readonly string $code,
        public readonly string $name,
        public readonly bool $allowed,
        public readonly string $type,
        public readonly FeatureAccessVariant4Usage $usage,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $unitName = null,
        public readonly ?FeatureAccessVariant4BaseAccess $baseAccess = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["code"] = $this->code;
        $values["name"] = $this->name;
        $values["unitName"] = $this->unitName;
        $values["allowed"] = $this->allowed;
        $values["type"] = $this->type;
        $values["usage"] = $this->usage;
        if ($this->baseAccess !== null) {
            $values["baseAccess"] = $this->baseAccess;
        }
        $values["object"] = $this->object;
        $values["livemode"] = $this->livemode;
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
            allowed: $data["allowed"],
            type: $data["type"],
            usage: FeatureAccessVariant4Usage::fromArray($data["usage"]),
            object: $data["object"],
            livemode: $data["livemode"],
            unitName: $data["unit_name"] ?? null,
            baseAccess: isset($data["base_access"]) ? FeatureAccessVariant4BaseAccess::fromArray($data["base_access"]) : null,
        );
    }
}
