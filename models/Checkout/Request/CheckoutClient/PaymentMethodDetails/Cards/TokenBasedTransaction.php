<?php

namespace Fisrv\Models;

class TokenBasedTransaction extends FisrvObject
{
    public string $value;

    public TransactionSequence $transactionSequence;

    public string $schemeTransactionId;
}
