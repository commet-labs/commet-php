<?php

declare(strict_types=1);

namespace Commet\Enums;

enum FeatureType: string
{
    case Boolean = 'boolean';
    case Usage = 'usage';
    case Seats = 'seats';
}
