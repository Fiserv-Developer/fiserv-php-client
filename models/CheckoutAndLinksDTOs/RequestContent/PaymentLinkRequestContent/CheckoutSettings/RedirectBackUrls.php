<?php
use Fiserv\models\FiservObject;

class redirectBackUrls extends FiservObject
{
    public string $successUrl;
    public string $failureUrl;
}