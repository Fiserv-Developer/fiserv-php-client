<?php

namespace Fisrv\Models;

class TokenDetails extends FisrvObject
{
    public string $value;

    public bool $reusable;

    public bool $declineDuplicates;

    public string $cardNumber;

    public string $brand;

    public string $schemeTransactionId;
}
