<?php
use Fiserv\models\FiservObject;

class checkoutSettings extends FiservObject
{
    public string $locale;
    public redirectBackUrls $redirectBackUrls;
    public string $webHooksUrl;

}
