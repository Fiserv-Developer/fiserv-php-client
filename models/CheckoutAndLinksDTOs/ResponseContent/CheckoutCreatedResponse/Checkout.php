<?php
use Fiserv\models\FiservObject;

class checkout extends FiservObject
{
    public string $storeId;
    public string $checkoutId;
    public string $redirectionUrl;
}