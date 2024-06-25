<?php

namespace Fisrv\Models;

class CurrencyConversion extends FisrvObject
{
    public bool $dccOffered;

    public string $exchangeRate;

    public string $marginRatePercentage;
}
