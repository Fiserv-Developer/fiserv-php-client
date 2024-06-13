<?php

namespace Fiserv\Models\WebhookEvent;

use Fiserv\Models\Checkout\ResponseContent\GetCheckoutIdResponseContent\ApprovedAmount;
use Fiserv\Models\Checkout\ResponseContent\GetPaymentLinkDetails\IpgTransactionDetails;
use Fiserv\Models\Checkout\ResponseContent\GetPaymentLinkDetails\PaymentMethodUsed;
use Fiserv\Models\FiservObject;

class WebhookEvent extends FiservObject
{
    public int $retryNumber;
    public string $storeId;
    public string $checkoutId;
    public string $orderId;
    public string $transactionType;
    public ApprovedAmount $approvedAmount;
    public transactionStatus | string $transactionStatus;
    public PaymentMethodUsed $paymentMethodUsed;
    public IpgTransactionDetails $ipgTransactionDetails;
    public string $receivedAt;

    public function __construct($json = false, $isReponseContent = true)
    {
        $this->receivedAt = date("Y-m-d H:i:s");
        parent::__construct($json, $isReponseContent);
    }
}
