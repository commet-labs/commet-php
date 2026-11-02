<?php

declare(strict_types=1);

namespace Commet\Models;

abstract class ManagedBy
{
    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        throw new \InvalidArgumentException("Unknown ManagedBy variant");
    }
}
