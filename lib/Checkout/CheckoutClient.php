<?php

namespace Fiserv\Checkout;

use Fiserv\HttpClient\HttpClient;
use Fiserv\HttpClient\RequestType;
use Fiserv\Models\CheckoutClientRequest;
use Fiserv\Models\CheckoutClientResponse;
use Fiserv\Models\Components;
use Fiserv\Models\GetCheckoutIdResponse;
use Fiserv\Tests\Fixtures;

final class CheckoutClient extends HttpClient
{
    public function __construct(array $config)
    {
        parent::__construct('/exp/v1/checkouts', $config);
    }

    /**
     * Create a checkout link to be used as checkout solution.
     * Pass an optional webhook to receive status events from fiserv server.
     * 
     * @param CheckoutClientRequest $req - Request body containing checkout options
     */
    public function createCheckout(CheckoutClientRequest $request): CheckoutClientResponse
    {
        /** Floor transaction amount in case it got deformed */
        $request->transactionAmount->total = floor($request->transactionAmount->total * 100) / 100;
        return $this->buildRequest(RequestType::POST, $this->endpointRoot, $request, CheckoutClientResponse::class);
    }


    /**
     * Create a checkout link that uses default parameters for SEPA payment.
     * 
     * @todo Currently, the request object is inaccessible in this kind of function call.
     * Possibly create a callback option or simply return an array containing the response (like now)
     * and request data, both. 
     * 
     * @see CheckoutClient::createCheckout
     * @param float $transactionTotal Total transaction amount (in EUR)
     * @param string $successUrl URL that directs to Thank You page from checkout
     * @param string $failureUrl URL that directs to failure notifaction if checkout failed
     */
    public function createBasicCheckout(float $transactionTotal, string $successUrl, string $failureUrl, Components | bool $components = false): CheckoutClientResponse
    {
        $request = new CheckoutClientRequest(Fixtures::paymentLinksRequestContent);
        $request->transactionAmount->total = $transactionTotal;

        if ($components) {
            $request->transactionAmount->components = $components;
        } else {
            unset($request->transactionAmount->components);
        }

        $request->checkoutSettings->redirectBackUrls->successUrl = $successUrl;
        $request->checkoutSettings->redirectBackUrls->failureUrl = $failureUrl;

        return $this->createCheckout($request);
    }

    public function createBasicCheckoutRequest(float $transactionTotal, string $successUrl, string $failureUrl): CheckoutClientRequest
    {
        $request = new CheckoutClientRequest(Fixtures::minimalCheckoutRequestContent);
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
        return $this->buildRequest(RequestType::GET, $this->endpointRoot . "/" . $checkoutId, null, GetCheckoutIdResponse::class);
    }
}
