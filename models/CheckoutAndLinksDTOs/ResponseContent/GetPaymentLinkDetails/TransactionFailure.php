<?php
use Fiserv\models\FiservObject;

class transactionFailure extends FiservObject
{
    public string $code;
    public string $reason;
}