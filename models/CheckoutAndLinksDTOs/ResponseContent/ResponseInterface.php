<?php
use Fiserv\models\FiservObject;

abstract class ResponseInterface extends FiservObject
{
    public function __construct($json = false)
    {
        FiservObject::__construct($json, true);
    }
}