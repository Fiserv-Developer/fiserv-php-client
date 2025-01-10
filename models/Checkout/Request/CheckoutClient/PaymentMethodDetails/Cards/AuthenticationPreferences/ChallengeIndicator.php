<?php

namespace Fisrv\Models;

enum ChallengeIndicator: string
{
    case NO_PREFERENCE = '01';
    case NO_CHALLENGE = '02';
    case CHALLENGE_REQUESTED_3D = '03';
    case CHALLENGE_REQUESTED_MANDATE = '04';
}
