<?php

declare(strict_types=1);

namespace Commet\Enums;

enum Timezone: string
{
    case Utc = "UTC";
    case AmericaNewYork = "America/New_York";
    case AmericaChicago = "America/Chicago";
    case AmericaDenver = "America/Denver";
    case AmericaLosAngeles = "America/Los_Angeles";
    case AmericaSaoPaulo = "America/Sao_Paulo";
    case AmericaMexicoCity = "America/Mexico_City";
    case AmericaBuenosAires = "America/Buenos_Aires";
    case AmericaSantiago = "America/Santiago";
    case AmericaBogota = "America/Bogota";
    case AmericaLima = "America/Lima";
    case AmericaAsuncion = "America/Asuncion";
    case EuropeLondon = "Europe/London";
    case EuropeParis = "Europe/Paris";
    case EuropeBerlin = "Europe/Berlin";
    case EuropeMadrid = "Europe/Madrid";
    case AsiaTokyo = "Asia/Tokyo";
    case AsiaShanghai = "Asia/Shanghai";
    case AsiaSingapore = "Asia/Singapore";
    case AsiaDubai = "Asia/Dubai";
    case AustraliaSydney = "Australia/Sydney";
}
