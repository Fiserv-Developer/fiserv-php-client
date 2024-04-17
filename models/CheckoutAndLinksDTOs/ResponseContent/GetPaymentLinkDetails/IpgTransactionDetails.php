<?php
use Fiserv\models\FiservObject;

class ipgTransactionDetails extends FiservObject
{
    public string $ipgTransactionId;
    public string $transactionStatus;
    public string $approvalCode;
}