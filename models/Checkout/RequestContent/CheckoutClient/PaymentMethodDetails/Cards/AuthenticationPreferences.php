<?php

namespace Fiserv\Models;

class AuthenticationPreferences extends FiservObject
{
    public string $challengeIndicator;
    public bool $skipTra;
}
