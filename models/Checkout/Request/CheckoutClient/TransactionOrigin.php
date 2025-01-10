<?php

namespace Fisrv\Models;

enum TransactionOrigin: string
{
    case ECOM = 'ECOM';
    case MAIL = 'MAIL';
    case PHONE = 'PHONE';
}
