<?php

namespace Fiserv\Models;

class TransactionFailure extends FiservObject
{
    public string $code;
    public string $reason;
}
