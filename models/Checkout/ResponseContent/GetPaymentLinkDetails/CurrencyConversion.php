<?php

namespace Fiserv\Models;

class CurrencyConversion extends FiservObject
{
    public bool $dccOffered;
    public string $exchangeRate;
    public string $marginRatePercentage;
}
