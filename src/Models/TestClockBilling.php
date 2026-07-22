<?php

declare(strict_types=1);

namespace Commet\Models;

class TestClockBilling
{
    public function __construct(
        public readonly int $customersFound,
        public readonly int $enqueued,
        public readonly int $failed,
        public readonly int $dunningRetried,
        public readonly int $dunningFailed,
        public readonly string $object,
        public readonly bool $livemode,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            customersFound: $data["customers_found"],
            enqueued: $data["enqueued"],
            failed: $data["failed"],
            dunningRetried: $data["dunning_retried"],
            dunningFailed: $data["dunning_failed"],
            object: $data["object"],
            livemode: $data["livemode"],
        );
    }
}
