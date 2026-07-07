<?php

declare(strict_types=1);

namespace Commet\Webhooks;

final class WebhookEventType
{
    public const SUBSCRIPTION_CREATED = "subscription.created";
    public const SUBSCRIPTION_ACTIVATED = "subscription.activated";
    public const SUBSCRIPTION_REACTIVATED = "subscription.reactivated";
    public const SUBSCRIPTION_CANCELED = "subscription.canceled";
    public const SUBSCRIPTION_UPDATED = "subscription.updated";
    public const SUBSCRIPTION_PLAN_CHANGED = "subscription.plan_changed";
    public const SUBSCRIPTION_CANCELLATION_SCHEDULED = "subscription.cancellation_scheduled";
    public const SUBSCRIPTION_CANCELLATION_REVOKED = "subscription.cancellation_revoked";
    public const SUBSCRIPTION_PLAN_CHANGE_SCHEDULED = "subscription.plan_change_scheduled";
    public const SUBSCRIPTION_PLAN_CHANGE_REVOKED = "subscription.plan_change_revoked";
    public const SUBSCRIPTION_PAST_DUE = "subscription.past_due";
    public const TRIAL_STARTED = "trial.started";
    public const TRIAL_CONVERTED = "trial.converted";
    public const TRIAL_EXPIRED = "trial.expired";
    public const TRIAL_WILL_END = "trial.will_end";
    public const TRIAL_CHECKOUT_READY = "trial.checkout_ready";
    public const CHECKOUT_READY = "checkout.ready";
    public const PAYMENT_RECEIVED = "payment.received";
    public const PAYMENT_FAILED = "payment.failed";
    public const PAYMENT_RECOVERED = "payment.recovered";
    public const PAYMENT_RETRY_FAILED = "payment.retry_failed";
    public const PAYMENT_REFUNDED = "payment.refunded";
    public const PAYMENT_DISPUTED = "payment.disputed";
    public const PAYMENT_DISPUTE_RESOLVED = "payment.dispute_resolved";
    public const PAYMENT_LINK_CREATED = "payment_link.created";
    public const PAYMENT_LINK_COMPLETED = "payment_link.completed";
    public const PAYMENT_LINK_FAILED = "payment_link.failed";
    public const PAYMENT_LINK_CANCELED = "payment_link.canceled";
    public const INVOICE_CREATED = "invoice.created";
    public const INVOICE_VOIDED = "invoice.voided";
    public const INVOICE_OVERDUE = "invoice.overdue";
    public const INVOICE_UPCOMING = "invoice.upcoming";
    public const PAYMENT_METHOD_ATTACHED = "payment_method.attached";
    public const PAYMENT_METHOD_UPDATED = "payment_method.updated";
    public const CUSTOMER_CREATED = "customer.created";
    public const CUSTOMER_UPDATED = "customer.updated";
    public const CUSTOMER_STATE_CHANGED = "customer.state_changed";
    public const CREDITS_GRANTED = "credits.granted";
    public const CREDITS_PURCHASED = "credits.purchased";
    public const CREDITS_LOW = "credits.low";
    public const CREDITS_DEPLETED = "credits.depleted";
    public const CREDITS_EXPIRED = "credits.expired";
    public const BALANCE_TOPPED_UP = "balance.topped_up";
    public const BALANCE_LOW = "balance.low";
    public const BALANCE_DEPLETED = "balance.depleted";
    public const QUOTA_THRESHOLD_REACHED = "quota.threshold_reached";
    public const QUOTA_EXCEEDED = "quota.exceeded";
    public const SEATS_UPDATED = "seats.updated";
    public const SEATS_LIMIT_REACHED = "seats.limit_reached";
    public const ADDON_ACTIVATED = "addon.activated";
    public const ADDON_DEACTIVATED = "addon.deactivated";
    public const USAGE_RECORDED = "usage.recorded";
    public const PAYOUT_AVAILABLE = "payout.available";
    public const PAYOUT_CREATED = "payout.created";
    public const PAYOUT_PAID = "payout.paid";
    public const PAYOUT_FAILED = "payout.failed";
}
