<?php

declare(strict_types=1);

namespace Commet\Models;

class PlanDraftChangesItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $key,
        public readonly string $section,
        public readonly string $label,
        public readonly ?string $country = null,
        public readonly ?string $before = null,
        public readonly ?string $after = null,
    ) {}

    public function jsonSerialize(): object
    {
        $values = [];
        $values["key"] = $this->key;
        $values["section"] = $this->section;
        $values["country"] = $this->country;
        $values["label"] = $this->label;
        $values["before"] = $this->before;
        $values["after"] = $this->after;
        return (object) $values;
    }

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            key: $data["key"],
            section: $data["section"],
            label: $data["label"],
            country: $data["country"] ?? null,
            before: $data["before"] ?? null,
            after: $data["after"] ?? null,
        );
    }
}
