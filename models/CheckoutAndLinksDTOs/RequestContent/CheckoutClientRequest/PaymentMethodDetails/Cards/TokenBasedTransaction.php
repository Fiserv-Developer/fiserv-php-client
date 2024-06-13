<?php

use Fiserv\models\FiservObject;

class TokenBasedTransaction extends FiservObject
{
    public string $value;
    public string $transactionSequence;
}
