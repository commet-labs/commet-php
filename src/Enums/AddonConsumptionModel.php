<?php

declare(strict_types=1);

namespace Commet\Enums;

enum AddonConsumptionModel: string
{
    case Boolean = 'boolean';
    case Metered = 'metered';
    case Credits = 'credits';
    case Balance = 'balance';
}
