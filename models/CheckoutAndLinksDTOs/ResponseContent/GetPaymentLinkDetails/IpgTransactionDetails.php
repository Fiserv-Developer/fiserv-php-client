<?php

use Fiserv\models\FiservObject;

class ipgTransactionDetails extends FiservObject
{
    public string $ipgTransactionId;
    public TransactionStatus $transactionStatus;
    public string $approvalCode;
}
