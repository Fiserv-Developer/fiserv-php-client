<?php

namespace Fisrv\Models;

class PaymentCard extends FisrvObject
{
    public string $number;

    public string $bin;

    public string $last4;

    public string $brand;

    public string $securityCode;

    public ExpiryDate $expiryDate;
}
