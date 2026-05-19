<?php

declare(strict_types=1);

namespace Commet\Enums;

enum SeatEventType: string
{
    case Add = 'add';
    case Remove = 'remove';
    case Set = 'set';
}
