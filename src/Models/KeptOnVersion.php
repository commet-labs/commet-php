<?php

declare(strict_types=1);

namespace Commet\Models;

class KeptOnVersion implements \JsonSerializable
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly mixed $keptOnVersion,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["subscriptionId"] = $this->subscriptionId;
        $values["keptOnVersion"] = $this->keptOnVersion;
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
            keptOnVersion: $data["kept_on_version"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
