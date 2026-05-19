<?php

declare(strict_types=1);

namespace Commet\Enums;

enum DiscountType: string
{
    case Percentage = 'percentage';
    case Amount = 'amount';
}
