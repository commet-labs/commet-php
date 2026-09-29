<?php

declare(strict_types=1);

namespace Commet\Models;

class CreatedApiKey implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $apiKey,
        public readonly string $prefix,
        public readonly string $expiresAt,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["name"] = $this->name;
        $values["apiKey"] = $this->apiKey;
        $values["prefix"] = $this->prefix;
        $values["expiresAt"] = $this->expiresAt;
        $values["createdAt"] = $this->createdAt;
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
            id: $data["id"],
            name: $data["name"],
            apiKey: $data["api_key"],
            prefix: $data["prefix"],
            expiresAt: $data["expires_at"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
