<?php

namespace Fiserv\Models;

class TokenBasedTransaction extends FiservObject
{
    public string $value;
    public string $transactionSequence;
}
