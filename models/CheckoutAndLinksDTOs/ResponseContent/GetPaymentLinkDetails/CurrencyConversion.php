<?php
use Fiserv\models\FiservObject;

class currencyConversion extends FiservObject
{
    public bool $dccOffered;
    public string $exchangeRate;
    public string $marginRatePercentage;
}