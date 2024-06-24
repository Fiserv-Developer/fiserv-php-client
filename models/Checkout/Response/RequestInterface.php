<?php

namespace Fisrv\Models;

abstract class RequestInterface extends fisrvObject
{
    public string $storeId;

    public function __construct(array | string | false $json = false)
    {
        fisrvObject::__construct($json, false);
    }
}
