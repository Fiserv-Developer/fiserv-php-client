<?php

namespace Fiserv\Models;

enum ToBeUsedFor: string
{
    case UNSCHEDULED = 'UNSCHEDULED';
    case RECURRING = 'RECURRING';
    case INSTALLMENT = 'INSTALLMENT';
}
