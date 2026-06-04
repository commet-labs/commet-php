<?php

declare(strict_types=1);

namespace Commet\Enums;

enum InvoiceLineType: string
{
    case PlanBase = 'plan_base';
    case FeatureOverage = 'feature_overage';
    case FeatureSeats = 'feature_seats';
    case FeatureQuota = 'feature_quota';
    case Discount = 'discount';
    case Credit = 'credit';
    case AddonBase = 'addon_base';
}
