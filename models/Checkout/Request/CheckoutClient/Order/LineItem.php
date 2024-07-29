<?php

namespace Fisrv\Models;

class LineItem extends FisrvObject
{
    public string $itemIdentifier;

    public string $name;

    public float $price = 0;

    public int $quantity;

    public int $shippingCost = 0;

    public int $valueAddedTax = 0;

    public int $miscellaneousFee = 0;

    public float $total = 0;
}
