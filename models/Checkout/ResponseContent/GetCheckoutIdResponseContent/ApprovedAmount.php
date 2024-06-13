<?php

namespace Fiserv\Models;

class ApprovedAmount extends FiservObject
{
    public float $total;
    public string $currency;
    public Components $components;
}
