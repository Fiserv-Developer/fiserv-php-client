<?php

use Fiserv\models\FiservObject;

abstract class ResponseInterface extends FiservObject
{
    public string $traceId;

    public function __construct($json = false)
    {
        FiservObject::__construct($json, true);
    }
}
