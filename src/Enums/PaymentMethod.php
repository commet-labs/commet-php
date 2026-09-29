<?php

declare(strict_types=1);

namespace Commet\Enums;

enum PaymentMethod: string
{
    case Card = "card";
    case Oxxo = "oxxo";
    case MercadoPago = "mercado_pago";
}
