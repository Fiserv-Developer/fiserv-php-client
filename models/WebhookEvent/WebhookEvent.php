<?php

namespace Fisrv\Models\WebhookEvent;

use Fisrv\Models\ApprovedAmount;
use Fisrv\Models\FisrvObject;
use Fisrv\Models\IpgTransactionDetails;
use Fisrv\Models\PaymentMethodUsed;
use Fisrv\Models\TokenDetails;
use Fisrv\Models\TransactionStatus;
use Fisrv\Models\TransactionType;

class WebhookEvent extends FisrvObject
{
    public int $retryNumber;

    public string $storeId;

    public string $checkoutId;

    public string $orderId;

    public TransactionType $transactionType;

    public ApprovedAmount $approvedAmount;

    public TransactionStatus $transactionStatus;

    public TokenDetails $tokenDetails;

    public PaymentMethodUsed $paymentMethodUsed;

    public IpgTransactionDetails $ipgTransactionDetails;

    public string $receivedAt;

    /**
     * @param string | false | array<string, mixed> $json JSON string or array
     */
    public function __construct(string|false|array $json = false)
    {
        $this->receivedAt = date("Y-m-d H:i:s");
        parent::__construct($json, true);
    }
}
