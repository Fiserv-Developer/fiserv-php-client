<?php

namespace Fiserv\Models;

class Address extends FiservObject
{
    public string $address1;
    public string $address2;
    public string $city;
    public string $company;
    public string $country;
    public string $postalCode;
    public string $region;
}
