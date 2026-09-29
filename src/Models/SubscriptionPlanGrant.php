<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriptionPlanGrant implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly SubscriptionPlanGrantPlan $plan,
        public readonly ?string $expiresAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["plan"] = $this->plan;
        $values["expiresAt"] = $this->expiresAt;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            plan: SubscriptionPlanGrantPlan::fromArray($data["plan"]),
            expiresAt: $data["expires_at"] ?? null,
        );
    }
}
