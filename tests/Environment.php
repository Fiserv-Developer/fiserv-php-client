<?php

namespace Fisrv;

abstract class Environment
{
    /**
     * @return array<string, mixed>
     */
    public static function getClientConfig(
        bool $is_prod = null,
        string $api_key = null,
        string $api_secret = null,
        string $store_id = null,
    ): array {
        return [
            'is_prod' => $is_prod ?? false,
            'api_key' => $api_key ?? Environment::get('api_key'),
            'api_secret' => $api_secret ?? Environment::get('api_secret'),
            'store_id' => $store_id ?? Environment::get('store_id')
        ];
    }

    public static function get(string $key): string
    {
        $env = parse_ini_file('.env');

        if (!$env) {
            trigger_error("Could not read environment value $key", E_USER_NOTICE);
        }

        return $env[$key] ?? "";
    }
}
