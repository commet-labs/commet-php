<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanMoveSubscriptionsItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $status,
        public readonly ?string $code = null,
        public readonly ?string $message = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["subscriptionId"] = $this->subscriptionId;
        $values["status"] = $this->status;
        $values["code"] = $this->code;
        $values["message"] = $this->message;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscription_id"],
            status: $data["status"],
            code: $data["code"] ?? null,
            message: $data["message"] ?? null,
        );
    }
}
