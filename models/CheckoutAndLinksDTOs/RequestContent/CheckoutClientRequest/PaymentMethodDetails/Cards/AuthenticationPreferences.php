<?php

use Fiserv\models\FiservObject;

class AuthenticationPreferences extends FiservObject
{
    public string $challengeIndicator;
    public bool $skipTra;
}
