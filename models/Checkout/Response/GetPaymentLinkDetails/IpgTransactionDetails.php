<?php

namespace Fisrv\Models;

class IpgTransactionDetails extends FisrvObject
{
    public string $ipgTransactionId;

    public TransactionStatus $transactionStatus;

    public string $approvalCode;

    public string $transactionResult;
}
