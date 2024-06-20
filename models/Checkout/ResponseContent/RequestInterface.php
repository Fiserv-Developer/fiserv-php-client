<?php

namespace Fiserv\Models;

abstract class RequestInterface extends FiservObject
{
    public string $storeId;

    public function __construct(array | string | false $json = false)
    {
        FiservObject::__construct($json, false);
    }
}
