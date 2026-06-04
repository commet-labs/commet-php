<?php

declare(strict_types=1);

namespace Commet\Enums;

enum InvoiceStatus: string
{
    case Draft = 'draft';
    case Upcoming = 'upcoming';
    case Outstanding = 'outstanding';
    case Paid = 'paid';
    case Void = 'void';
    case Uncollectible = 'uncollectible';
}
