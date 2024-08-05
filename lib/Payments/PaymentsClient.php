<?php

namespace Fisrv\Payments;

use Exception;
use Fisrv\Checkout\CheckoutClient;
use Fisrv\HttpClient\HttpClient;
use Fisrv\HttpClient\RequestType;
use Fisrv\Models\PaymentsClientRequest;
use Fisrv\Models\PaymentsClientResponse;

final class PaymentsClient extends HttpClient
{
    /**
     * Checkout client constructor
     *
     * @param array<string, string | bool> $config Config paramter as key value array
     */
    public function __construct(array $config)
    {
        parent::__construct('/ipp/payments-gateway/v2/payments', $config);
    }

    /**
     * Create a primary credit card transaction
     *
     * @param \Fisrv\Models\PaymentsClientRequest $request
     * @throws \Exception
     * @return \Fisrv\Models\PaymentsClientResponse
     */
    public function createPaymentCardSaleTransaction(PaymentsClientRequest $request): PaymentsClientResponse
    {
        $request->requestType = 'PaymentCardSaleTransaction';
        $response = $this->buildRequest(RequestType::POST, $this->endpointRoot, $request, PaymentsClientResponse::class);

        if (!$response instanceof PaymentsClientResponse) {
            throw new Exception('Response is of malformed type');
        }

        return $response;
    }

    /**
     * Return a transaction by ID
     *
     * @param \Fisrv\Models\PaymentsClientRequest $request
     * @param string $transactionId
     * @throws \Exception
     * @return \Fisrv\Models\PaymentsClientResponse
     */
    public function returnTransaction(PaymentsClientRequest $request, string $transactionId): PaymentsClientResponse
    {
        $request->requestType = 'ReturnTransaction';
        $response = $this->buildRequest(RequestType::POST, $this->endpointRoot . '/' . $transactionId, $request, PaymentsClientResponse::class);

        if (!$response instanceof PaymentsClientResponse) {
            throw new Exception('Response is of malformed type');
        }

        return $response;
    }

    /**
     * Refund a transaction by given checkout ID. First fetch checkout details to retrieve transaction ID
     * and finally return transaction
     *
     * @param \Fisrv\Models\PaymentsClientRequest $request
     * @param string $checkoutId
     * @return \Fisrv\Models\PaymentsClientResponse
     */
    public function refundByCheckoutId(PaymentsClientRequest $request, string $checkoutId): PaymentsClientResponse
    {
        $checkoutClient = new CheckoutClient(parent::$config);
        $checkoutDetails = $checkoutClient->getCheckoutById($checkoutId);
        $transactionId = $checkoutDetails->ipgTransactionDetails->ipgTransactionId;

        return $this->returnTransaction($request, $transactionId);
    }
}
