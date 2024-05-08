<?php

namespace Fiserv\Util;

/**
 * Class for utility stuff.
 */
abstract class Util
{
    /**
     * Create a Version 4 Unique User Identifier. This is used
     * to create a message signature.
     * 
     * @return string UUID 
     */
    public static function uuid_create(): string
    {
        $out = bin2hex(random_bytes(18));

        $out[8] = "-";
        $out[13] = "-";
        $out[18] = "-";
        $out[23] = "-";
        $out[14] = "4";

        $out[19] = ["8", "9", "a", "b"][random_int(0, 3)];

        return $out;
    }

    /**
     * Shorthand for converting associative arrays into PHP objects
     * by using JSON decode and encoder.
     * 
     * @var $arr Associatve array to be converted
     * @return object Converted PHP object
     */
    public static function array_to_object(array $arr): object
    {
        return json_decode(json_encode($arr), 1);
    }
}
