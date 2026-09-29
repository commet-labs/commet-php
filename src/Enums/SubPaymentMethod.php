<?php

declare(strict_types=1);

namespace Commet\Enums;

enum SubPaymentMethod: string
{
    case CreditCard = "credit_card";
    case DebitCard = "debit_card";
    case PrepaidCard = "prepaid_card";
    case BankTransfer = "bank_transfer";
    case AccountMoney = "account_money";
}
