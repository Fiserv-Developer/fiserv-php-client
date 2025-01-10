<?php

namespace Fisrv\Models;

enum TransactionType: string
{
    case SALE = 'SALE';
    case PRE_AUTH = 'PRE-AUTH';
    case ZERO_AUTH = 'ZERO-AUTH';
    case RETURN = 'RETURN';
}
