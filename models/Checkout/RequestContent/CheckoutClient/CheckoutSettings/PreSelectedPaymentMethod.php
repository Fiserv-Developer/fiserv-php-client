<?php

namespace Fiserv\Models;

enum PreSelectedPaymentMethod: string
{
    case CARDS = 'Cards';
    case PAYPAL = 'PayPal';
    case GPAY = 'Googlepay';
    case APPLE = 'Applepay';
}
