<?php

class URI
{
    public string $scheme;
    public string $host;
    public string $port;
    public string $fragment;

    public static function build(string $scheme, string $host, string $path, string $port = null, string $queryString = null, string $fragment = null)
    {
        $uri = $scheme . '://' . $host;
        if ($port) {
            $uri .= ':' . $port;
        }
        $uri .= $path;
        if ($queryString) {
            $uri .= '?' . $queryString;
        }
        if ($fragment) {
            $uri .= '#' . $fragment;
        }
    }
}