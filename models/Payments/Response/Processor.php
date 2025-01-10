<?php

namespace Fisrv\Models;

class Processor extends FisrvObject
{
    public string $referenceNumber;

    public string $authorizationCode;

    public string $securityCodeResponse;

    public string $responseCode;

    public string $responseMessage;

    public string $merchantAdviceCodeIndicator;

    public AvsResponse $avsResponse;

    public string $taxRefundData;
}
