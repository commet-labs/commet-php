<?php

declare(strict_types=1);

namespace Commet\Models;

class CompletePayoutVerificationParamsCompanyRepresentative
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly ?string $phone = null,
        public readonly ?string $email = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data["first_name"],
            lastName: $data["last_name"],
            phone: $data["phone"] ?? null,
            email: $data["email"] ?? null,
        );
    }
}
