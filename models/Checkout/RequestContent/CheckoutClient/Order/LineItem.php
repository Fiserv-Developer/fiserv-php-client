<?php

namespace Fiserv\Models;

class LineItem extends FiservObject
{
    public string $itemIdentifier;
    public string $name;
    public float $price;
    public int $quantity;
    public float $total;
}
