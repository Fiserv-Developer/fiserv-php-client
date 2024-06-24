<?php

namespace Fisrv\Models;

class ApprovedAmount extends fisrvObject
{
    public float $total;
    public Currency $currency;
    public Components $components;
}
