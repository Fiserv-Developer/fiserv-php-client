<?php

namespace Fisrv\Models;

class Error extends FisrvObject
{
    public string $code;

    public string $message;

    public string $title;

    public string $detail;

    public string $source;
}
