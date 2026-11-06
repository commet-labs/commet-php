<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanDraftPublication implements \JsonSerializable
{
    public function __construct(
        public readonly bool $preview,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?PlanDraftPublicationVersion $version = null,
        public readonly ?string $moveId = null,
        public readonly ?PlanDraftPublicationSubscribers $subscribers = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["preview"] = $this->preview;
        $values["version"] = $this->version;
        $values["moveId"] = $this->moveId;
        $values["subscribers"] = $this->subscribers;
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
            preview: $data["preview"],
            object: $data["object"],
            livemode: $data["livemode"],
            version: isset($data["version"]) ? PlanDraftPublicationVersion::fromArray($data["version"]) : null,
            moveId: $data["move_id"] ?? null,
            subscribers: isset($data["subscribers"]) ? PlanDraftPublicationSubscribers::fromArray($data["subscribers"]) : null,
        );
    }
}
