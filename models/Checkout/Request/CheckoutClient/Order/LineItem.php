<?php

namespace Fisrv\Models;

class LineItem extends fisrvObject
{
    public string $itemIdentifier;
    public string $name;
    public float $price;
    public int $quantity;
    public float $total;
}
