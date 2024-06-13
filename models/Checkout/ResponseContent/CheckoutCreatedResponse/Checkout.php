<?php

namespace Fiserv\Models;

class Checkout extends FiservObject
{
    public string $storeId;
    public string $checkoutId;
    public string $redirectionUrl;
}
