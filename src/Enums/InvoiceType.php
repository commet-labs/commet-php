<?php

declare(strict_types=1);

namespace Commet\Enums;

enum InvoiceType: string
{
    case Recurring = "recurring";
    case Overage = "overage";
    case PlanChange = "plan_change";
    case Adjustment = "adjustment";
    case CreditPurchase = "credit_purchase";
    case BalanceTopup = "balance_topup";
    case AddonActivation = "addon_activation";
}
