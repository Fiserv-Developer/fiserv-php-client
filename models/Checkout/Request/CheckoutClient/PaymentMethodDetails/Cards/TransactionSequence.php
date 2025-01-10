<?php

namespace Fisrv\Models;

enum TransactionSequence: string
{
    case FIRST = 'FIRST';
    case SUBSEQUENT = 'SUBSEQUENT';
}
