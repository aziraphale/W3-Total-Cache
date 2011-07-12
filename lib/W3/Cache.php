<?php

/**
 * W3 Cache class
 */

/**
 * W3 Cache engine types
 */
if (!defined('W3TC_CACHE_MEMCACHE')) {
    define('W3TC_CACHE_MEMCACHE', 'memcache');
}

if (!defined('W3TC_CACHE_MEMCACHED')) {
    define('W3TC_CACHE_MEMCACHED', 'memcached');
}

if (!defined('W3TC_CACHE_APC')) {
    define('W3TC_CACHE_APC', 'apc');
}

if (!defined('W3TC_CACHE_EACCELERATOR')) {
    define('W3TC_CACHE_EACCELERATOR', 'eaccelerator');
}

if (!defined('W3TC_CACHE_XCACHE')) {
    define('W3TC_CACHE_XCACHE', 'xcache');
}

if (!defined('W3TC_CACHE_WINCACHE')) {
    define('W3TC_CACHE_WINCACHE', 'wincache');
}

if (!defined('W3TC_CACHE_FILE')) {
    define('W3TC_CACHE_FILE', 'file');
}

if (!defined('W3TC_CACHE_FILE_GENERIC')) {
    define('W3TC_CACHE_FILE_GENERIC', 'file_generic');
}

/**
 * Class W3_Cache
 */
class W3_Cache {
    /**
     * Returns cache engine instance
     *
     * @param string $engine
     * @param array $config
     * @return W3_Cache_Base
     */
    function &instance($engine, $config = array()) {
        static $instances = array();

        $instance_key = sprintf('%s_%s', $engine, md5(implode('', $config)));

        if (!isset($instances[$instance_key])) {
            switch ($engine) {
                case W3TC_CACHE_MEMCACHE:
                    require_once W3TC_LIB_W3_DIR . '/Cache/Memcache.php';
                    $instances[$instance_key] = & new W3_Cache_Memcache($config);
                    break;

                case W3TC_CACHE_MEMCACHED:
                    require_once W3TC_LIB_W3_DIR . '/Cache/Memcached.php';
                    $instances[$instance_key] = & new W3_Cache_Memcached($config);
                    break;

                case W3TC_CACHE_APC:
                    require_once W3TC_LIB_W3_DIR . '/Cache/Apc.php';
                    $instances[$instance_key] = & new W3_Cache_Apc();
                    break;

                case W3TC_CACHE_EACCELERATOR:
                    require_once W3TC_LIB_W3_DIR . '/Cache/Eaccelerator.php';
                    $instances[$instance_key] = & new W3_Cache_Eaccelerator();
                    break;

                case W3TC_CACHE_XCACHE:
                    require_once W3TC_LIB_W3_DIR . '/Cache/Xcache.php';
                    $instances[$instance_key] = & new W3_Cache_Xcache();
                    break;

                case W3TC_CACHE_WINCACHE:
                    require_once W3TC_LIB_W3_DIR . '/Cache/Wincache.php';
                    $instances[$instance_key] = & new W3_Cache_Wincache();
                    break;

                case W3TC_CACHE_FILE:
                    require_once W3TC_LIB_W3_DIR . '/Cache/File.php';
                    $instances[$instance_key] = & new W3_Cache_File($config);
                    break;

                case W3TC_CACHE_FILE_GENERIC:
                    require_once W3TC_LIB_W3_DIR . '/Cache/File/Generic.php';
                    $instances[$instance_key] = & new W3_Cache_File_Generic($config);
                    break;

                default:
                    trigger_error('Incorrect cache engine', E_USER_WARNING);
                    require_once W3TC_LIB_W3_DIR . '/Cache/Base.php';
                    $instances[$instance_key] = & new W3_Cache_Base();
                    break;
            }
        }

        return $instances[$instance_key];
    }
}
