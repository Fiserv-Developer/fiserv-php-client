<?php

namespace Fisrv\Models;

enum Currency: string
{
    case EUR = 'EUR';
    case USD = 'USD';
    case PLN = 'PLN';
    case GBP = 'GBP';
}
