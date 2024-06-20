<?php

namespace Fiserv\Models;

class Basket extends FiservObject
{
    /** @var array<LineItem> */
    public array $lineItems = [];
}
