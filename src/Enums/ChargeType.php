<?php

declare(strict_types=1);

namespace Commet\Enums;

enum ChargeType: string
{
    case Standard = 'standard';
    case Advance = 'advance';
    case TrueUp = 'true_up';
}
