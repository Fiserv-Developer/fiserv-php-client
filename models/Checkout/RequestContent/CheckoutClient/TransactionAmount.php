<?php

namespace Fiserv\Models;

class TransactionAmount extends FiservObject
{
    public float $total;
    public Currency $currency;
    public Components $components;
}
