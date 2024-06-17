<?php

namespace Fiserv\Models;

enum PreSelectedPaymentMethod: string
{
    case CARDS = 'Cards';
    case PAYPAL = 'Paypal';
}
