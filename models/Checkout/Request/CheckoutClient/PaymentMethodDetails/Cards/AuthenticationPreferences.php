<?php

namespace Fisrv\Models;

class AuthenticationPreferences extends fisrvObject
{
    public ChallengeIndicator $challengeIndicator;
    public ScaExemptionType $scaExemptionType;
    public bool $skipTra;
}
