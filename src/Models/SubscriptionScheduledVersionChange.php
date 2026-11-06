<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionScheduledVersionChange implements \JsonSerializable
{
    public function __construct(
        public readonly string $planVersionId,
        public readonly string $label,
        public readonly string $effectiveAt,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["planVersionId"] = $this->planVersionId;
        $values["label"] = $this->label;
        $values["effectiveAt"] = $this->effectiveAt;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            planVersionId: $data["plan_version_id"],
            label: $data["label"],
            effectiveAt: $data["effective_at"],
        );
    }
}
