<?php

namespace Fiserv\Models;

class CheckoutSettings extends FiservObject
{
    public Locale $locale;
    public PreSelectedPaymentMethod $preSelectedPaymentMethod;
    public RedirectBackUrls $redirectBackUrls;
    public string $webHooksUrl;
    public Fraud $fraud;
}
