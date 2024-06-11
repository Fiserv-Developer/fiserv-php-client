<?php

namespace Fiserv;

use components;
use Config;
use PostCheckoutsResponse;
use Fiserv\HttpClient;
use GetCheckoutIdResponse;
use CreateCheckoutRequest;

class CheckoutSolution
{
    const endpointRoot = '/exp/v1/checkouts';

    /**
     * Create a checkout link to be used as checkout solution.
     * Pass an optional webhook to receive status events from fiserv server.
     * 
     * @param CreateCheckoutRequest $req - Request body containing checkout options
     */
    public static function postCheckouts(CreateCheckoutRequest $req): PostCheckoutsResponse
    {
        $req->storeId = Config::$STORE_ID;
        $endpoint = self::endpointRoot;

        /** Floor transaction amount in case it got deformed */
        $req->transactionAmount->total = floor($req->transactionAmount->total * 100) / 100;
        $res = HttpClient::buildRequest(RequestType::POST, $endpoint, $req);

        $data = new PostCheckoutsResponse($res['data']);
        $data->traceId = $res['traceId'];

        return $data;
    }

    /**
     * This version forwards to node server. Node sends mocked webhook events (approved sample data).
     * 
     * @param CreateCheckoutRequest $req - Request body containing checkout options
     */
    public static function postCheckoutsWithSimulatedMock(CreateCheckoutRequest $req): PostCheckoutsResponse
    {
        $req->storeId = Config::$STORE_ID;
        $endpoint = self::endpointRoot;
        $res = HttpClient::buildRequest(RequestType::POST, $endpoint, $req);
        $data = new PostCheckoutsResponse($res['data']);

        return $data;
    }


    /**
     * Create a checkout link that uses default parameters for SEPA payment.
     * 
     * @todo Currently, the request object is inaccessible in this kind of function call.
     * Possibly create a callback option or simply return an array containing the response (like now)
     * and request data, both. 
     * 
     * @see CheckoutSolution::postCheckouts
     * @param float $transactionTotal Total transaction amount (in EUR)
     * @param string $successUrl URL that directs to Thank You page from checkout
     * @param string $failureUrl URL that directs to failure notifaction if checkout failed
     */
    public static function createSEPACheckout(float $transactionTotal, string $successUrl, string $failureUrl, components | bool $components = false): PostCheckoutsResponse
    {
        $req = new CreateCheckoutRequest(Fixtures::paymentLinksRequestContent);
        $req->transactionAmount->total = $transactionTotal;

        if ($components) {
            $req->transactionAmount->components = $components;
        } else {
            unset($req->transactionAmount->components);
        }

        $req->checkoutSettings->redirectBackUrls->successUrl = $successUrl;
        $req->checkoutSettings->redirectBackUrls->failureUrl = $failureUrl;

        return self::postCheckouts($req);
    }


    /**
     * Query an existing checkout link object by given ID. 
     * Responds with verbose list about checkout configuration.
     * 
     * @param string $checkoutId - String checkout ID to be queried  
     */
    public static function getCheckoutId(string $checkoutId): GetCheckoutIdResponse
    {
        $endpoint = self::endpointRoot . "/" . $checkoutId;
        $res = HttpClient::buildRequest(RequestType::GET, $endpoint);
        $data = new GetCheckoutIdResponse($res['data']);

        return $data;
    }
}
