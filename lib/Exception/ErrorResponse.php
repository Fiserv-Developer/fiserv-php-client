<?php

namespace Fisrv\Exception;

use Exception;
use Fisrv\Models\CreateCheckoutResponse;
use Fisrv\Models\GetCheckoutIdResponse;
use Fisrv\Models\PaymentsClientResponse;
use Fisrv\Models\ResponseInterface;

class ErrorResponse extends Exception
{
    public ResponseInterface $response;

    public function __construct(ResponseInterface|string $response)
    {
        if (!is_string($response)) {
            $this->response = $response;
        }

        if ($response instanceof PaymentsClientResponse) {
            $this->message = (string) $response->error;

            return;
        }

        if (
            $response instanceof GetCheckoutIdResponse ||
            $response instanceof CreateCheckoutResponse
        ) {
            $this->message = (string) $response->errors[0]->detail;

            return;
        }

        $this->message = (string) $response;
    }
}
