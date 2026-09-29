<?php

declare(strict_types=1);

namespace Commet\Models;

class PortalAccess implements \JsonSerializable
{
    public function __construct(
        public readonly string $portalUrl,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["portalUrl"] = $this->portalUrl;
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
            portalUrl: $data["portal_url"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
