<?php

namespace Fisrv\HttpClient;

/**
 * Enum for request types.
 * API currently only supports GET, POST and PATCH
 */
enum RequestType: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PATCH = 'PATCH';
    case PUT = 'PUT';
}
