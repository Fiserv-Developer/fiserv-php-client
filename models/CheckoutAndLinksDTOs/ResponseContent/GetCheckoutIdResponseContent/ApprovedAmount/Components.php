<?php
use Fiserv\models\FiservObject;

class components extends FiservObject
{
    public string $subtotal;
    public string $vatAmount;
    public string $shipping;
}