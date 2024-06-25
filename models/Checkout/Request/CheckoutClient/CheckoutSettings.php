<?php

namespace Fisrv\Models;

class CheckoutSettings extends FisrvObject
{
    public Locale $locale;

    public PreSelectedPaymentMethod $preSelectedPaymentMethod;

    public RedirectBackUrls $redirectBackUrls;

    public string $webHooksUrl;

    public Fraud $fraud;
}
