<?php

namespace Fisrv\Models;

class TokenBasedTransaction extends FisrvObject
{
    public string $value;
    public string $transactionSequence;
}
