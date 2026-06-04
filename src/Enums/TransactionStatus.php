<?php

declare(strict_types=1);

namespace Commet\Enums;

enum TransactionStatus: string
{
    case Pending = 'pending';
    case Succeeded = 'succeeded';
    case Failed = 'failed';
    case Refunded = 'refunded';
    case Disputed = 'disputed';
}
