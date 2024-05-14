<?php

use Fiserv\models\FiservObject;

class components extends FiservObject
{
    public float $subtotal;
    public float $vatAmount;
    public float $shipping;
}
