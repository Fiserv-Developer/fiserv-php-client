<?php

namespace Fiserv\HttpClient;

/**
 * Enum for request types. 
 * API currently only supports GET, POST and PATCH
 */
enum RequestType
{
    case GET;
    case POST;
    case PATCH;
}
