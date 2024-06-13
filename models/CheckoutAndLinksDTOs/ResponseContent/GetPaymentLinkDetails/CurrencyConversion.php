<?php

use Fiserv\models\FiservObject;

class CurrencyConversion extends FiservObject
{
    public bool $dccOffered;
    public string $exchangeRate;
    public string $marginRatePercentage;
}
