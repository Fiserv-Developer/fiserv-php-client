<?php
use Fiserv\models\FiservObject;

class ApprovedAmount extends FiservObject
{
    public string $total;
    public string $currency;
    public components $components;
}