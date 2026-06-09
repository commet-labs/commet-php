<?php

declare(strict_types=1);

namespace Commet\Enums;

enum BillingInterval: string
{
    case Weekly = "weekly";
    case Monthly = "monthly";
    case Quarterly = "quarterly";
    case Yearly = "yearly";
    case OneTime = "one_time";
}
