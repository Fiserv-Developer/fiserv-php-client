<?php

namespace Fiserv\models;

class CardInfoLookupResponse extends FiservObject
{
    public string $type;
    public string $clientRequestId;
    public string $apiTraceId;
    public cardDetails $cardDetails;
    public string $requestStatus;
}