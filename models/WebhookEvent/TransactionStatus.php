<?php

namespace Fiserv\Models;

enum TransactionStatus: string
{
    case APPROVED = 'APPROVED';
    case WAITING = 'WAITING';
    case PARTIAL = 'PARTIAL';
    case VALIDATION_FAILED = 'VALIDATION_FAILED';
    case PROCESSING_FAILED = 'PROCESSING_FAILED';
    case DECLINED = 'DECLINED';
    case FRAUD = 'FRAUD';
    case FAILED = 'FAILED';
}
