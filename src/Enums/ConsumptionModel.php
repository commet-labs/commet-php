<?php

declare(strict_types=1);

namespace Commet\Enums;

enum ConsumptionModel: string
{
    case Metered = "metered";
    case Credits = "credits";
    case Balance = "balance";
}
