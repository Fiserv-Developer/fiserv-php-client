<?php

namespace Fisrv\Models;

enum ScaExemptionType: string
{
    case LOW_VALUE_EXEMPTION = 'LOW_VALUE_EXEMPTION';
    case TRUSTED_MERCHANT_EXEMPTION = 'TRUSTED_MERCHANT_EXEMPTION';
}
