<?php

use Fiserv\models\FiservObject;

class Checkout extends FiservObject
{
    public string $storeId;
    public string $checkoutId;
    public string $redirectionUrl;
}
