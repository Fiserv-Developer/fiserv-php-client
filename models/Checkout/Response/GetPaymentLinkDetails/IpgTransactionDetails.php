<?php

namespace Fisrv\Models;

class IpgTransactionDetails extends fisrvObject
{
    public string $ipgTransactionId;
    public TransactionStatus $transactionStatus;
    public string $approvalCode;
}
