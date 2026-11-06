<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanDraftPublicationVersionExperiment implements \JsonSerializable
{
    public function __construct(
        public readonly string $code,
        public readonly int $version,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["code"] = $this->code;
        $values["version"] = $this->version;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            code: $data["code"],
            version: $data["version"],
        );
    }
}
