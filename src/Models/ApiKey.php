<?php

declare(strict_types=1);

namespace Commet\Models;

class ApiKey implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $prefix,
        public readonly string $createdAt,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $expiresAt = null,
        public readonly ?string $lastUsedAt = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["name"] = $this->name;
        $values["prefix"] = $this->prefix;
        $values["expiresAt"] = $this->expiresAt;
        $values["lastUsedAt"] = $this->lastUsedAt;
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
            prefix: $data["prefix"],
            createdAt: $data["created_at"],
            object: $data["object"],
            livemode: $data["livemode"],
            expiresAt: $data["expires_at"] ?? null,
            lastUsedAt: $data["last_used_at"] ?? null,
        );
    }
}
