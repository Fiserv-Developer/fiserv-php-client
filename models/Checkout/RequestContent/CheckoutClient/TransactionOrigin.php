<?php

namespace Fiserv\Models;

enum TransactionOrigin: string
{
    case ECOM = 'ECOM';
    case MAIL = 'MAIL';
    case PHONE = 'PHONE';
}
