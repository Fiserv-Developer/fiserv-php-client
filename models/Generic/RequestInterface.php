<?php

namespace Fisrv\Models;

abstract class RequestInterface extends FisrvObject
{
    public string $storeId;

    public function __construct(array|string|false $json = false)
    {
        FisrvObject::__construct($json, false);
    }
}
