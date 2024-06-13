<?php

namespace Fiserv\models;

use ResponseInterface;

class CardInfoLookupResponse extends ResponseInterface
{
    public string $type;
    public string $clientRequestId;
    public string $apiTraceId;
    public CardDetails $cardDetails;
    public string $requestStatus;
}