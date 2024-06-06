<?php

use Fiserv\models\FiservObject;

class checkoutSettings extends FiservObject
{
    public string $locale;
    public string $preSelectedPaymentMethod;
    public redirectBackUrls $redirectBackUrls;
    public string $webHooksUrl;
    public fraud $fraud;
}
