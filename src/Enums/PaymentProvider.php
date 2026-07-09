<?php

declare(strict_types=1);

namespace Commet\Enums;

enum PaymentProvider: string
{
    case Stripe = "stripe";
    case Commet = "commet";
    case Dlocal = "dlocal";
}
