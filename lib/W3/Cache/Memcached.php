<?php

/**
 * PECL Memcache class
 */
require_once W3TC_LIB_W3_DIR . '/Cache/Base.php';

/**
 * Class W3_Cache_Memcached
 */
class W3_Cache_Memcached extends W3_Cache_Base {
    /**
     * Memcached object
     *
     * @var Memcache
     */
    var $_memcache = null;

    /**
     * PHP5 constructor
     *
     * @param array $config
     */
    function __construct($config) {
        
        $persistant = isset($config['persistant']) && (boolean)$config['persistant'] == false ? NULL : $config['persistant'];
        
        $this->_memcache = & new Memcached($persistant);

        if (!empty($config['servers']) && count($this->_memcache->getServerList()) == 0 ) {

            foreach ((array) $config['servers'] as $server) {
                list($ip, $port) = explode(':', $server);
                $this->_memcache->addServer(trim($ip), (integer) trim($port));
            }

        } else {
            return false;
        }


        return true;
    }

    /**
     * PHP4 constructor
     *
     * @param array $config
     */
    function W3_Cache_Memcached($config) {
        $this->__construct($config);
    }

    /**
     * Adds data
     *
     * @param string $key
     * @param mixed $var
     * @param integer $expire
     * @return boolean
     */
    function add($key, &$var, $expire = 0) {
        return @$this->_memcache->add($key, $var, $expire);
    }

    /**
     * Sets data
     *
     * @param string $key
     * @param mixed $var
     * @param integer $expire
     * @return boolean
     */
    function set($key, &$var, $expire = 0) {
        return @$this->_memcache->set($key, $var, $expire);
    }

    /**
     * Returns data
     *
     * @param string $key
     * @return mixed
     */
    function get($key) {
        return @$this->_memcache->get($key);
    }

    /**
     * Replaces data
     *
     * @param string $key
     * @param mixed $var
     * @param integer $expire
     * @return boolean
     */
    function replace($key, &$var, $expire = 0) {
        return @$this->_memcache->replace($key, $var, $expire);
    }

    /**
     * Deletes data
     *
     * @param string $key
     * @return boolean
     */
    function delete($key) {
        return @$this->_memcache->delete($key);
    }

    /**
     * Flushes all data
     *
     * @return boolean
     */
    function flush() {
        return @$this->_memcache->flush();
    }
}
