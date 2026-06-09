<?php

declare(strict_types=1);

namespace Commet\Enums;

enum SubscriptionStatus: string
{
    case Draft = "draft";
    case PendingPayment = "pending_payment";
    case Trialing = "trialing";
    case Active = "active";
    case PastDue = "past_due";
    case Canceled = "canceled";
}
