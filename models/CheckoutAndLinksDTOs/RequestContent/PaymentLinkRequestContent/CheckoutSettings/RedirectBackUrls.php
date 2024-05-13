<?php

use Fiserv\models\FiservObject;

class redirectBackUrls extends FiservObject
{
    use PatternValidatable;

    public string $successUrl;
    public string $failureUrl;

    public function __construct($json = false, $isReponseContent = false)
    {
        $pattern = '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/=]*)/m';
        FiservObject::__construct($json, $isReponseContent);

        $this->validate($this, $pattern);
    }
}
