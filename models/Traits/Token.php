<?php

namespace Fisrv\Models\Traits;

trait Token
{
    public bool $reusable;

    public bool $declineDuplicates;

    public string $brand;

    public string $type;
}
