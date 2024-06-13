<?php

use Fiserv\models\FiservObject;

class ApprovedAmount extends FiservObject
{
    public float $total;
    public string $currency;
    public Components $components;
}
