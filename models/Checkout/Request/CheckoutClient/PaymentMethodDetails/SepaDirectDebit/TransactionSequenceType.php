<?php

namespace Fisrv\Models;

enum TransactionSequenceType: string
{
    case SINGLE = 'SINGLE';
    case FIRST_COLLECTION = 'FIRST_COLLECTION';
    case RECURRING_COLLECTION = 'RECURRING_COLLECTION';
    case FINAL_COLLECTION = 'FINAL_COLLECTION';
}
