<?php

namespace Fiserv\Models;

enum TransactionType: string
{
    case SALE = 'SALE';
    case PRE_AUTH = 'PRE-AUTH';
    case ZERO_AUTH = 'ZERO-AUTH';
}
