<?php
use Fiserv\models\FiservObject;

class approvedAmount extends FiservObject
{
    public string $total;
    public string $currency;
    public components $components;
}