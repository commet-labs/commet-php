<?php

declare(strict_types=1);

namespace Commet\Enums;

enum OverageModel: string
{
    case PerUnit = 'per_unit';
    case Tiered = 'tiered';
}
