<?php
use Fiserv\models\FiservObject;

class tokenBasedTransaction extends FiservObject
{
    public string $value;
    public string $transactionSequence;
}