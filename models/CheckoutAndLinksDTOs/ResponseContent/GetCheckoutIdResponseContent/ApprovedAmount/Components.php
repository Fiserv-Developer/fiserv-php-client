<?php

use Fiserv\models\FiservObject;

class Components extends FiservObject
{
    public float $subtotal;
    public float $vatAmount;
    public float $shipping;
}
