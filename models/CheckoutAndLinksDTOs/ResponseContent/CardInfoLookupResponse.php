<?php

namespace Fiserv\models;

use ResponseInterface;

class CardInfoLookupResponse extends ResponseInterface
{
    public string $type;
    public string $clientRequestId;
    public string $apiTraceId;
    public cardDetails $cardDetails;
    public string $requestStatus;
}