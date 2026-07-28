<?php

declare(strict_types=1);

namespace Commet\Models;

class CompletePayoutVerificationParamsIndividual
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $phone,
        public readonly string $dateOfBirth,
        public readonly CompletePayoutVerificationParamsIndividualAddress $address,
        public readonly ?string $ssnLast4 = null,
        public readonly ?string $idNumber = null,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            firstName: $data["first_name"],
            lastName: $data["last_name"],
            phone: $data["phone"],
            dateOfBirth: $data["date_of_birth"],
            address: CompletePayoutVerificationParamsIndividualAddress::fromArray($data["address"]),
            ssnLast4: $data["ssn_last4"] ?? null,
            idNumber: $data["id_number"] ?? null,
        );
    }
}
