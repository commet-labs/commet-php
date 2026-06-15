<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookEvent
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        public readonly string $event,
        public readonly string $timestamp,
        public readonly string $organizationId,
        public readonly string $mode,
        public readonly string $apiVersion,
        public readonly array $data,
    ) {}

    /**
     * @param array<string, mixed> $payload
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            event: $payload["event"],
            timestamp: $payload["timestamp"],
            organizationId: $payload["organizationId"],
            mode: $payload["mode"],
            apiVersion: $payload["apiVersion"],
            data: $payload["data"] ?? [],
        );
    }

    public function asSubscriptionCreated(): SubscriptionCreatedData
    {
        return SubscriptionCreatedData::fromArray($this->data);
    }

    public function asSubscriptionActivated(): SubscriptionActivatedData
    {
        return SubscriptionActivatedData::fromArray($this->data);
    }

    public function asSubscriptionCanceled(): SubscriptionCanceledData
    {
        return SubscriptionCanceledData::fromArray($this->data);
    }

    public function asSubscriptionUpdated(): SubscriptionUpdatedData
    {
        return SubscriptionUpdatedData::fromArray($this->data);
    }

    public function asSubscriptionPlanChanged(): SubscriptionPlanChangedData
    {
        return SubscriptionPlanChangedData::fromArray($this->data);
    }

    public function asSubscriptionCancellationScheduled(): SubscriptionCancellationScheduledData
    {
        return SubscriptionCancellationScheduledData::fromArray($this->data);
    }

    public function asSubscriptionCancellationRevoked(): SubscriptionCancellationRevokedData
    {
        return SubscriptionCancellationRevokedData::fromArray($this->data);
    }

    public function asSubscriptionPlanChangeScheduled(): SubscriptionPlanChangeScheduledData
    {
        return SubscriptionPlanChangeScheduledData::fromArray($this->data);
    }

    public function asSubscriptionPlanChangeRevoked(): SubscriptionPlanChangeRevokedData
    {
        return SubscriptionPlanChangeRevokedData::fromArray($this->data);
    }

    public function asSubscriptionPastDue(): SubscriptionPastDueData
    {
        return SubscriptionPastDueData::fromArray($this->data);
    }

    public function asTrialStarted(): TrialStartedData
    {
        return TrialStartedData::fromArray($this->data);
    }

    public function asTrialConverted(): TrialConvertedData
    {
        return TrialConvertedData::fromArray($this->data);
    }

    public function asTrialExpired(): TrialExpiredData
    {
        return TrialExpiredData::fromArray($this->data);
    }

    public function asTrialWillEnd(): TrialWillEndData
    {
        return TrialWillEndData::fromArray($this->data);
    }

    public function asTrialCheckoutReady(): TrialCheckoutReadyData
    {
        return TrialCheckoutReadyData::fromArray($this->data);
    }

    public function asCheckoutReady(): CheckoutReadyData
    {
        return CheckoutReadyData::fromArray($this->data);
    }

    public function asPaymentReceived(): PaymentReceivedData
    {
        return PaymentReceivedData::fromArray($this->data);
    }

    public function asPaymentFailed(): PaymentFailedData
    {
        return PaymentFailedData::fromArray($this->data);
    }

    public function asPaymentRecovered(): PaymentRecoveredData
    {
        return PaymentRecoveredData::fromArray($this->data);
    }

    public function asPaymentRefunded(): PaymentRefundedData
    {
        return PaymentRefundedData::fromArray($this->data);
    }

    public function asPaymentDisputed(): PaymentDisputedData
    {
        return PaymentDisputedData::fromArray($this->data);
    }

    public function asPaymentDisputeResolved(): PaymentDisputeResolvedData
    {
        return PaymentDisputeResolvedData::fromArray($this->data);
    }

    public function asInvoiceCreated(): InvoiceCreatedData
    {
        return InvoiceCreatedData::fromArray($this->data);
    }

    public function asInvoiceUpcoming(): InvoiceUpcomingData
    {
        return InvoiceUpcomingData::fromArray($this->data);
    }

    public function asInvoiceOverdue(): InvoiceOverdueData
    {
        return InvoiceOverdueData::fromArray($this->data);
    }

    public function asInvoiceVoided(): InvoiceVoidedData
    {
        return InvoiceVoidedData::fromArray($this->data);
    }

    public function asPaymentMethodAttached(): PaymentMethodAttachedData
    {
        return PaymentMethodAttachedData::fromArray($this->data);
    }

    public function asPaymentMethodUpdated(): PaymentMethodUpdatedData
    {
        return PaymentMethodUpdatedData::fromArray($this->data);
    }

    public function asCustomerCreated(): CustomerCreatedData
    {
        return CustomerCreatedData::fromArray($this->data);
    }

    public function asCustomerUpdated(): CustomerUpdatedData
    {
        return CustomerUpdatedData::fromArray($this->data);
    }

    public function asCustomerStateChanged(): CustomerStateChangedData
    {
        return CustomerStateChangedData::fromArray($this->data);
    }

    public function asCreditsGranted(): CreditsGrantedData
    {
        return CreditsGrantedData::fromArray($this->data);
    }

    public function asCreditsPurchased(): CreditsPurchasedData
    {
        return CreditsPurchasedData::fromArray($this->data);
    }

    public function asCreditsLow(): CreditsLowData
    {
        return CreditsLowData::fromArray($this->data);
    }

    public function asCreditsDepleted(): CreditsDepletedData
    {
        return CreditsDepletedData::fromArray($this->data);
    }

    public function asCreditsExpired(): CreditsExpiredData
    {
        return CreditsExpiredData::fromArray($this->data);
    }

    public function asBalanceToppedUp(): BalanceToppedUpData
    {
        return BalanceToppedUpData::fromArray($this->data);
    }

    public function asBalanceLow(): BalanceLowData
    {
        return BalanceLowData::fromArray($this->data);
    }

    public function asBalanceDepleted(): BalanceDepletedData
    {
        return BalanceDepletedData::fromArray($this->data);
    }

    public function asQuotaThresholdReached(): QuotaThresholdReachedData
    {
        return QuotaThresholdReachedData::fromArray($this->data);
    }

    public function asQuotaExceeded(): QuotaExceededData
    {
        return QuotaExceededData::fromArray($this->data);
    }

    public function asUsageRecorded(): UsageRecordedData
    {
        return UsageRecordedData::fromArray($this->data);
    }

    public function asSeatsUpdated(): SeatsUpdatedData
    {
        return SeatsUpdatedData::fromArray($this->data);
    }

    public function asSeatsLimitReached(): SeatsLimitReachedData
    {
        return SeatsLimitReachedData::fromArray($this->data);
    }

    public function asAddonActivated(): AddonActivatedData
    {
        return AddonActivatedData::fromArray($this->data);
    }

    public function asAddonDeactivated(): AddonDeactivatedData
    {
        return AddonDeactivatedData::fromArray($this->data);
    }

    public function asPayoutAvailable(): PayoutAvailableData
    {
        return PayoutAvailableData::fromArray($this->data);
    }

    public function asPayoutCreated(): PayoutCreatedData
    {
        return PayoutCreatedData::fromArray($this->data);
    }

    public function asPayoutPaid(): PayoutPaidData
    {
        return PayoutPaidData::fromArray($this->data);
    }

    public function asPayoutFailed(): PayoutFailedData
    {
        return PayoutFailedData::fromArray($this->data);
    }
}
