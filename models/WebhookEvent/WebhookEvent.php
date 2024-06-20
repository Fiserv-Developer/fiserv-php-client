<?php

namespace Fiserv\Models\WebhookEvent;

use Fiserv\Models\ApprovedAmount;
use Fiserv\Models\FiservObject;
use Fiserv\Models\IpgTransactionDetails;
use Fiserv\Models\PaymentMethodUsed;
use Fiserv\Models\TransactionStatus;

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

    /**
     * @param string | false | array<string, mixed> $json JSON string or array
     */
    public function __construct(string | false | array $json = false)
    {
        $this->receivedAt = date("Y-m-d H:i:s");
        parent::__construct($json, true);
    }
}
