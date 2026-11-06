<?php

declare(strict_types=1);

namespace Commet\Models;

class SubscriberNeedingAChange implements \JsonSerializable
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly string $fromVersionId,
        public readonly string $toVersionId,
        public readonly string $code,
        public readonly string $message,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $moveId = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["subscriptionId"] = $this->subscriptionId;
        $values["moveId"] = $this->moveId;
        $values["fromVersionId"] = $this->fromVersionId;
        $values["toVersionId"] = $this->toVersionId;
        $values["code"] = $this->code;
        $values["message"] = $this->message;
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
            subscriptionId: $data["subscription_id"],
            fromVersionId: $data["from_version_id"],
            toVersionId: $data["to_version_id"],
            code: $data["code"],
            message: $data["message"],
            object: $data["object"],
            livemode: $data["livemode"],
            moveId: $data["move_id"] ?? null,
        );
    }
}
