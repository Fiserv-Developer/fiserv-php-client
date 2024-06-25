<?php

namespace Fisrv\Models;

class ApprovedAmount extends FisrvObject
{
    public float $total;

    public Currency $currency;

    public Components $components;
}
