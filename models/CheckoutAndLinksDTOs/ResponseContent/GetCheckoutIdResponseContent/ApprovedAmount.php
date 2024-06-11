<?php

use Fiserv\models\FiservObject;

class approvedAmount extends FiservObject
{
    public float $total;
    public string $currency;
    public components $components;
}
