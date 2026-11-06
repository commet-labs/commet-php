<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanDraftPublicationSubscribersLeftOutItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $code,
        public readonly string $message,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["subscriptionId"] = $this->subscriptionId;
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
            code: $data["code"],
            message: $data["message"],
        );
    }
}
