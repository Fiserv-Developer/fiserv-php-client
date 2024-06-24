<?php

namespace Fisrv\Models;

enum PreSelectedPaymentMethod: string
{
    case CARDS = 'Cards';
    case PAYPAL = 'PayPal';
    case GPAY = 'Googlepay';
    case APPLE = 'Applepay';
}
