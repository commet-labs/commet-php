<?php

declare(strict_types=1);

namespace Commet\Models;

class CustomerBatchSuccessfulItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $id,
        public readonly string $email,
        public readonly ?string $externalId = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["id"] = $this->id;
        $values["externalId"] = $this->externalId;
        $values["email"] = $this->email;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data["id"],
            email: $data["email"],
            externalId: $data["external_id"] ?? null,
        );
    }
}
