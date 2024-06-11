<?php

abstract class transactionStatus
{
    const APPROVED = 'APPROVED';
    const WAITING = 'WAITING';
    const PARTIAL = 'PARTIAL';
    const VALIDATION_FAILED = 'VALIDATION_FAILED';
    const PROCESSING_FAILED = 'PROCESSING_FAILED';
    const DECLINED = 'DECLINED';
    const FRAUD = 'FRAUD';
    const FAILED  = 'FAILED';
}
