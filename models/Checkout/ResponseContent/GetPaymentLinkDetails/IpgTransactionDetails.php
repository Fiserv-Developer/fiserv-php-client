<?php

namespace Fiserv\Models;

class IpgTransactionDetails extends FiservObject
{
    public string $ipgTransactionId;
    public TransactionStatus $transactionStatus;
    public string $approvalCode;
}
