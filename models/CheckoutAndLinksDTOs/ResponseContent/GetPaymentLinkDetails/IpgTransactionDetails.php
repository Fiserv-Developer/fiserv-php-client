<?php

use Fiserv\models\FiservObject;

class IpgTransactionDetails extends FiservObject
{
    public string $ipgTransactionId;
    public transactionStatus | string $transactionStatus;
    public string $approvalCode;
}
