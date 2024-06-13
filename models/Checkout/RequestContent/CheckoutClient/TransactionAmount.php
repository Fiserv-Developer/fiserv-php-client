<?php

namespace Fiserv\Models;

class TransactionAmount extends FiservObject
{
    public float $total;
    public string $currency;
    public Components $components;
}
