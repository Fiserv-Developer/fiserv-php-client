<?php

namespace Fisrv\PaymentLinks;

use Fisrv\Exception\ResponseMalformedException;
use Fisrv\HttpClient\HttpClient;
use Fisrv\HttpClient\RequestType;
use Fisrv\Models\CheckoutClientRequest;
use Fisrv\Models\GetPaymentLinkDetailsResponse;
use Fisrv\Models\PaymentsLinksCreatedResponse;

final class PaymentLinksClient extends HttpClient
{
    /**
     * Constructor
     *
     * @param array<string, mixed> $apiConfig
     */
    public function __construct(array $apiConfig)
    {
        parent::__construct('/exp/v1/payment-links', $apiConfig);
    }

    /**
     * Create payment link
     *
     * @param CheckoutClientRequest $request Request object
     */
    public function createPaymentLink(CheckoutClientRequest $request): PaymentsLinksCreatedResponse
    {
        $repsonse = $this->buildRequest(RequestType::POST, $this->endpointRoot, $request, PaymentsLinksCreatedResponse::class);

        if (!$repsonse instanceof PaymentsLinksCreatedResponse) {
            throw new ResponseMalformedException();
        }

        return $repsonse;
    }

    public function getPaymentLinkDetails(string $paymentLinkId): GetPaymentLinkDetailsResponse
    {
        $repsonse = $this->buildRequest(RequestType::GET, $this->endpointRoot . "/" . $paymentLinkId, null, GetPaymentLinkDetailsResponse::class);

        if (!$repsonse instanceof GetPaymentLinkDetailsResponse) {
            throw new ResponseMalformedException();
        }

        return $repsonse;
    }
}
