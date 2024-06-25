<?php

namespace Fisrv\Models;

class AuthenticationPreferences extends FisrvObject
{
    public ChallengeIndicator $challengeIndicator;

    public ScaExemptionType $scaExemptionType;

    public bool $skipTra;
}
