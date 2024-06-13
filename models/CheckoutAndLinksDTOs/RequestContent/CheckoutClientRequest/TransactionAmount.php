<?php

use Fiserv\models\FiservObject;

class TransactionAmount extends FiservObject
{
    public float $total;
    public string $currency;
    public Components $components;
}
