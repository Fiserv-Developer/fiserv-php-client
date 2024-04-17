<?php
use Fiserv\models\FiservObject;

class transactionAmount extends FiservObject
{
    public int $total;
    public string $currency;
}