<?php

namespace Fisrv\Models;

class Basket extends FisrvObject
{
    /** @var array<LineItem> */
    public array $lineItems = [];
}
