<?php

declare(strict_types=1);

namespace Commet\Models;

class UsageQuota implements \JsonSerializable
{
    public function __construct(
        public readonly string $featureCode,
        public readonly float $current,
        public readonly float $included,
        public readonly float $billedQuantity,
        public readonly bool $unlimited,
        public readonly bool $overageEnabled,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?float $remaining = null,
        public readonly ?string $asOf = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["featureCode"] = $this->featureCode;
        $values["current"] = $this->current;
        $values["included"] = $this->included;
        $values["remaining"] = $this->remaining;
        $values["billedQuantity"] = $this->billedQuantity;
        $values["unlimited"] = $this->unlimited;
        $values["overageEnabled"] = $this->overageEnabled;
        $values["asOf"] = $this->asOf;
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
            featureCode: $data["feature_code"],
            current: $data["current"],
            included: $data["included"],
            billedQuantity: $data["billed_quantity"],
            unlimited: $data["unlimited"],
            overageEnabled: $data["overage_enabled"],
            object: $data["object"],
            livemode: $data["livemode"],
            remaining: $data["remaining"] ?? null,
            asOf: $data["as_of"] ?? null,
        );
    }
}
