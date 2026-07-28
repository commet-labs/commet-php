<?php

declare(strict_types=1);

namespace Commet\Models;

class CompletePayoutVerificationParamsCompany
{
    public function __construct(
        public readonly string $name,
        public readonly string $taxId,
        public readonly CompletePayoutVerificationParamsCompanyAddress $address,
        public readonly CompletePayoutVerificationParamsCompanyRepresentative $representative,
    ) {}

    /**
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data["name"],
            taxId: $data["tax_id"],
            address: CompletePayoutVerificationParamsCompanyAddress::fromArray($data["address"]),
            representative: CompletePayoutVerificationParamsCompanyRepresentative::fromArray($data["representative"]),
        );
    }
}
