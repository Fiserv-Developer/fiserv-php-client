<?php

namespace Fiserv\Config;

class ApiConfig
{
    /**
     * Origin is set in header to trace platform of 
     */
    public static ?string $ORIGIN = null;

    /**
     * Flag whether Sandbox endpoints should be used (mocked calls for testing purposes)
     * or production endpoints (for live transactions). 
     */
    const IS_PROD = false;

    /**
     * API Key that is used for authorization. If you do not have one, create a key 
     * on the developer portal.
     * 
     * @see https://portal.fiserv.dev/
     */
    public static ?string $API_KEY = null;

    /**
     * API Secret that is used for message encoding. If you do not have one, create a key 
     * on the developer portal.
     * 
     * @see https://portal.fiserv.dev/
     */
    public static ?string $API_SECRET = null;

    /**
     * Store ID of merchant.
     */
    public static ?string $STORE_ID = null;

    /**
     * Flag to check whether the config parameter have been set or not.
     */
    public static bool $IS_SET = false;

    /**
     * Singleton instance. 
     */
    private static ApiConfig | null $instance = null;

    private function __construct(
        $API_KEY,
        $API_SECRET,
        $STORE_ID,
    ) {
        $this->API_KEY = $API_KEY;
        $this->API_SECRET = $API_SECRET;
        $this->STORE_ID = $STORE_ID;

        $this->IS_SET = true;
    }

    public function getOrigin()
    {
        return $this->ORIGIN;
    }

    /**
     * Config is a singleton. Create method ensures
     * the constructor is not used directly. A new instance
     * 
     * @param $API_KEY API key
     * @param $API_SECRET API secret
     * @param $STORE_ID Store ID
     */
    public function create(
        $API_KEY,
        $API_SECRET,
        $STORE_ID
    ) {
        if (self::$instance === null) {
            self::$instance = new self(
                $API_KEY,
                $API_SECRET,
                $STORE_ID
            );
        }

        return self::$instance;
    }
}
