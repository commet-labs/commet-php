<?php

declare(strict_types=1);

namespace Commet\Models;

class ArchivePlanExperimentParamsChangesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $subscriptionId,
        public readonly mixed $keepOnVersion = null,
        public readonly ?string $billingInterval = null,
        public readonly mixed $seatLimit = null,
        /** @var string[]|null */
        public readonly ?array $removeAddonIds = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["subscriptionId"] = $this->subscriptionId;
        if ($this->keepOnVersion !== null) {
            $values["keepOnVersion"] = $this->keepOnVersion;
        }
        if ($this->billingInterval !== null) {
            $values["billingInterval"] = $this->billingInterval;
        }
        if ($this->seatLimit !== null) {
            $values["seatLimit"] = $this->seatLimit;
        }
        if ($this->removeAddonIds !== null) {
            $values["removeAddonIds"] = $this->removeAddonIds;
        }
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            subscriptionId: $data["subscription_id"],
            keepOnVersion: $data["keep_on_version"] ?? null,
            billingInterval: $data["billing_interval"] ?? null,
            seatLimit: $data["seat_limit"] ?? null,
            removeAddonIds: $data["remove_addon_ids"] ?? null,
        );
    }
}
