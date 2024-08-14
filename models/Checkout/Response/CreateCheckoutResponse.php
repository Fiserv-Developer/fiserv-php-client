<?php

namespace Fisrv\Models;

class CreateCheckoutResponse extends ResponseInterface
{
    public Checkout $checkout;

    /** @var array<Error> $errors */
    public array $errors;
}
