<?php

namespace Fisrv\Models;

enum PreSelectedPaymentMethod: string
{
    case CARDS = 'Cards';
    case PAYPAL = 'PayPal';
    case GOOGLEPAY = 'Googlepay';
    case APPLE = 'Applepay';
}
