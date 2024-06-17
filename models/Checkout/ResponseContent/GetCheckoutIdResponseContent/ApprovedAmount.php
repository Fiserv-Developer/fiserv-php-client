<?php

namespace Fiserv\Models;

class ApprovedAmount extends FiservObject
{
    public float $total;
    public Currency $currency;
    public Components $components;
}
