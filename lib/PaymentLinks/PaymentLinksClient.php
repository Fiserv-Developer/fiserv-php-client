<?php

namespace Fiserv\PaymentLinks;

use Fiserv\Config\ApiConfig;
use Fiserv\HttpClient\HttpClient;
use Fiserv\HttpClient\RequestType;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\GetPaymentLinkDetailsResponse;
use Fiserv\Models\PaymentsLinksCreatedResponse;

final class PaymentLinksClient extends HttpClient
{

    public function __construct(array $apiConfig)
    {
        parent::__construct('/exp/v1/payment-links', $apiConfig);
    }

    public function createPaymentLink(CheckoutClientRequest $request): PaymentsLinksCreatedResponse
    {
        return $this->buildRequest(RequestType::POST, parent::$endpointRoot, $request, PaymentsLinksCreatedResponse::class);
    }

    public function getPaymentLinkDetails($paymentLinkId): GetPaymentLinkDetailsResponse
    {
        return $this->buildRequest(RequestType::GET, parent::$endpointRoot . "/" . $paymentLinkId, null, PaymentsLinksCreatedResponse::class);
    }
}
