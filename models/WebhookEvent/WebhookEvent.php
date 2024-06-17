<?php

namespace Fiserv\Models\WebhookEvent;

use Fiserv\Models\ApprovedAmount;
use Fiserv\Models\FiservObject;
use Fiserv\Models\IpgTransactionDetails;
use Fiserv\Models\PaymentMethodUsed;

class WebhookEvent extends FiservObject
{
    public int $retryNumber;
    public string $storeId;
    public string $checkoutId;
    public string $orderId;
    public string $transactionType;
    public ApprovedAmount $approvedAmount;
    public TransactionStatus $transactionStatus;
    public PaymentMethodUsed $paymentMethodUsed;
    public IpgTransactionDetails $ipgTransactionDetails;
    public string $receivedAt;

    public function __construct($json = false, $isReponseContent = true)
    {
        $this->receivedAt = date("Y-m-d H:i:s");
        parent::__construct($json, $isReponseContent);
    }
}
