<?php

use Fiserv\models\FiservObject;

class TransactionFailure extends FiservObject
{
    public string $code;
    public string $reason;
}
