<?php

declare(strict_types=1);

namespace Commet\Models;

class TestClock
{
    public function __construct(
        public readonly bool $isActive,
        public readonly string $now,
        public readonly string $object,
        public readonly bool $livemode,
        public readonly ?string $simulatedTime = null,
        public readonly ?TestClockLatestRun $latestRun = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            isActive: $data["is_active"],
            now: $data["now"],
            object: $data["object"],
            livemode: $data["livemode"],
            simulatedTime: $data["simulated_time"] ?? null,
            latestRun: isset($data["latest_run"]) ? TestClockLatestRun::fromArray($data["latest_run"]) : null,
        );
    }
}
