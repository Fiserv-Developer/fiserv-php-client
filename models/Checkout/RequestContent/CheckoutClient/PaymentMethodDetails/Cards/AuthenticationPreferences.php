<?php

namespace Fiserv\Models;

class AuthenticationPreferences extends FiservObject
{
    public ChallengeIndicator $challengeIndicator;
    public ScaExemptionType $scaExemptionType;
    public bool $skipTra;
}
