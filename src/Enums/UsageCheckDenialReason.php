<?php

declare(strict_types=1);

namespace Commet\Enums;

enum UsageCheckDenialReason: string
{
    case IncludedLimitReached = 'included_limit_reached';
    case InsufficientCredits = 'insufficient_credits';
    case InsufficientBalance = 'insufficient_balance';
}
