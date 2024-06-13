<?php

namespace Fiserv\models;

class CardDetails extends FiservObject
{
    public string $brand;
    public string $brandProductId;
    public string $cardFunction;
    public string $commercialCard;
    public string $issuerCountry;
    public string $issuerName;
}