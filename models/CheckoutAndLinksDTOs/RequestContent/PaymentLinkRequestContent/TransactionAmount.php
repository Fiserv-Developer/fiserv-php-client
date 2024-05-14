<?php

use Fiserv\models\FiservObject;

class transactionAmount extends FiservObject
{
    public float $total;
    public string $currency;
    public components $components;
}
