<?php

namespace Fiserv\Models;

class CheckoutSettings extends FiservObject
{
    public string $locale;
    public string $preSelectedPaymentMethod;
    public RedirectBackUrls $redirectBackUrls;
    public string $webHooksUrl;
    public Fraud $fraud;
}
