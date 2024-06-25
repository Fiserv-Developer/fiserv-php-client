<?php

namespace Fisrv\Models;

use Fisrv\Exception\ValidationException;

class RedirectBackUrls extends FisrvObject implements ValidationInterface
{
    public string $successUrl;

    public string $failureUrl;

    /**
     * Constructor
     *
     * @param array<string, mixed> | string | false $json
     */
    public function __construct(array | string | false $json = false, bool $isReponseContent = false)
    {
        $this->pattern = '/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&\/=]*)/m';
        parent::__construct($json, $isReponseContent);
    }

    /**
     * When implemented this should be used to check
     * fields of current object for validity (e.g. string pattern check on
     * URLs) as per API specification.
     */
    public function validate(): void
    {
        $this->checkPatternMatch('successUrl', $this->successUrl);
        $this->checkPatternMatch('failureUrl', $this->failureUrl);
    }

    private function checkPatternMatch(string $field, string $value): void
    {
        if (!$this->pattern) {
            return;
        }

        $match = preg_match($this->pattern, $value);
        if (!$match) {
            throw new ValidationException($value, $field);
        }
    }
}
