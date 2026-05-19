<?php

declare(strict_types=1);

namespace Commet\Enums;

enum Currency: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case GBP = 'GBP';
    case CAD = 'CAD';
    case AUD = 'AUD';
    case JPY = 'JPY';
    case ARS = 'ARS';
    case BRL = 'BRL';
    case MXN = 'MXN';
    case CLP = 'CLP';
}
