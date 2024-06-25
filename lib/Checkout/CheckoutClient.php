<?php

namespace Fisrv\Checkout;

use Exception;
use Fisrv\HttpClient\HttpClient;
use Fisrv\HttpClient\RequestType;
use Fisrv\Models\CheckoutClientRequest;
use Fisrv\Models\CheckoutClientResponse;
use Fisrv\Models\GetCheckoutIdResponse;

final class CheckoutClient extends HttpClient
{
    public const minimalCheckoutRequestContent = [
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
    public function createCheckout(CheckoutClientRequest $request): CheckoutClientResponse
    {
        /** Floor transaction amount in case it got deformed */
        $request->transactionAmount->total = floor($request->transactionAmount->total * 100) / 100;
        $response = $this->buildRequest(RequestType::POST, $this->endpointRoot, $request, CheckoutClientResponse::class);

        if (!$response instanceof CheckoutClientResponse) {
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
    public static function createBasicCheckoutRequest(float $transactionTotal, string $successUrl, string $failureUrl): CheckoutClientRequest
    {
        $request = new CheckoutClientRequest(self::minimalCheckoutRequestContent);
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
    public function getCheckoutId(string $checkoutId): GetCheckoutIdResponse
    {
        $response = $this->buildRequest(RequestType::GET, $this->endpointRoot . "/" . $checkoutId, null, GetCheckoutIdResponse::class);

        if (!$response instanceof GetCheckoutIdResponse) {
            throw new Exception('Response is of malformed type');
        }

        return $response;
    }
}
