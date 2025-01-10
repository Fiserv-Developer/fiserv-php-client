<?php

namespace Fisrv\Checkout;

use Exception;
use Fisrv\HttpClient\HttpClient;
use Fisrv\HttpClient\RequestType;
use Fisrv\Models\CheckoutClientRequest;
use Fisrv\Models\CreateCheckoutResponse;
use Fisrv\Models\GetCheckoutIdResponse;
use Fisrv\Models\PaymentsClientRequest;
use Fisrv\Models\PaymentsClientResponse;
use Fisrv\Models\TransactionStatus;
use Fisrv\Payments\PaymentsClient;

final class CheckoutClient extends HttpClient
{
    private const CHECKOUT_REQUEST_TEMPLATE = [
        'transactionOrigin' => 'ECOM',
        'transactionType' => 'SALE',
        'transactionAmount' => [
            'total' => 0,
            'currency' => 'EUR',
            'components' => []
        ],
        'checkoutSettings' => [
            'locale' => 'en_GB',
            'webHooksUrl' => 'https://nonce.com',
            'redirectBackUrls' => [
                'successUrl' => 'https://nonce.com',
                'failureUrl' => 'https://nonce.com'
            ]
        ],
        'paymentMethodDetails' => [
            'cards' => [
                'createToken' => [
                    'toBeUsedFor' => 'UNSCHEDULED',
                ],
            ],
        ],
        'storeId' => 'NULL',
        'order' => [
            'orderDetails' => [
                'purchaseOrderNumber' => 0,
            ],
            'billing' => [
                'person' => [],
                'contact' => [],
                'address' => [],
            ],
            'basket' => []
        ]
    ];

    /**
     * Checkout client constructor
     *
     * @param array<string, string | bool> $config Config paramter as key value array
     */
    public function __construct(array $config)
    {
        parent::__construct('/exp/v1/checkouts', $config);
    }

    /**
     * Create a checkout link to be used as checkout solution.
     * Pass an optional webhook to receive status events from fisrv server.
     *
     * @param CheckoutClientRequest $request - Request body containing checkout options
     */
    public function createCheckout(CheckoutClientRequest $request): CreateCheckoutResponse
    {
        $response = $this->buildRequest(RequestType::POST, $this->endpointRoot, $request, CreateCheckoutResponse::class);

        if (!$response instanceof CreateCheckoutResponse) {
            throw new Exception('Response is of malformed type');
        }

        return $response;
    }

    /**
     * Create a checkout link that uses default parameters for SEPA payment.
     *
     * @see CheckoutClient::createCheckout
     * @param float $transactionTotal Total transaction amount (in EUR)
     * @param string $successUrl URL that directs to Thank You page from checkout
     * @param string $failureUrl URL that directs to failure notifaction if checkout failed
     */
    public static function createBasicCheckoutRequest(float $transactionTotal = 0, string $successUrl = '', string $failureUrl = ''): CheckoutClientRequest
    {
        $request = new CheckoutClientRequest(self::CHECKOUT_REQUEST_TEMPLATE);
        $request->checkoutSettings->redirectBackUrls->successUrl = $successUrl;
        $request->checkoutSettings->redirectBackUrls->failureUrl = $failureUrl;
        $request->transactionAmount->total = $transactionTotal;

        return $request;
    }

    /**
     * Query an existing checkout link object by given ID.
     * Responds with verbose list about checkout configuration.
     *
     * @param string $checkoutId - String checkout ID to be queried
     */
    public function getCheckoutById(string $checkoutId): GetCheckoutIdResponse
    {
        $response = $this->buildRequest(RequestType::GET, $this->endpointRoot . "/" . $checkoutId, null, GetCheckoutIdResponse::class);

        if (!$response instanceof GetCheckoutIdResponse) {
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
     * @throws Exception Generic exception if transaction is non-refundable
     * @return \Fisrv\Models\PaymentsClientResponse
     */
    public function refundCheckout(PaymentsClientRequest $request, string $checkoutId): PaymentsClientResponse
    {
        $paymentsClient = new PaymentsClient($this->config);
        $checkoutDetails = $this->getCheckoutById($checkoutId);
        if ($checkoutDetails->transactionStatus !== TransactionStatus::APPROVED) {
            throw new Exception('Transaction is non-refundable because status is not APPROVED.');
        }

        $transactionId = $checkoutDetails->ipgTransactionDetails->ipgTransactionId;

        return $paymentsClient->returnTransaction($request, $transactionId);
    }
}
