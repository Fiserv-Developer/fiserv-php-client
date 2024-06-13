<?php

use Fiserv\models\FiservObject;

class RedirectBackUrls extends FiservObject implements ValidationInterface
{
    use ValidationTrait;

    public string $successUrl;
    public string $failureUrl;

    public function __construct($json = false, $isReponseContent = false)
    {
        $this->pattern = '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/=]*)/m';
        parent::__construct($json, $isReponseContent);
    }

    public function validate()
    {
        $this->checkString($this);
    }
}
