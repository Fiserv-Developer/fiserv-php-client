<?php

namespace Fiserv\models;

class CardInfoLookupResponse extends FiservObject
{
    public string $type;
    public string $clientRequestId;
    public string $apiTraceId;
    public CardDetails $cardDetails;
    public string $requestStatus;

}

class CardDetails extends FiservObject
{
    public string $brand = "NOT SET";
    public string $brandProductId;
    public string $cardFunction;
    public string $commercialCard;
    public string $issuerCountry;
    public string $issuerName;
}