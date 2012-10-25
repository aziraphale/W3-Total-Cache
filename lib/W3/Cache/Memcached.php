<?php

/**
 * PECL Memcached class
 */
if (!defined('W3TC')) {
    die();
}

require_once W3TC_LIB_W3_DIR . '/Cache/Base.php';

/**
 * Class W3_Cache_Memcached
 */
class W3_Cache_Memcached extends W3_Cache_Base {
    /**
     * Memcache object
     *
     * @var Memcache
     */
    var $_memcache = null;
    
    /**
     * Memcached object
     *
     * @var Memcached
     */
    var $_memcached = null;

    /**
     * PHP5 constructor
     *
     * @param array $config
     */
    function __construct($config) {
        if (class_exists('Memcached')) {
            @$this->_memcached = & new Memcached();
        } elseif (class_exists('Memcache')) {
            @$this->_memcache = & new Memcache();
        } else {
            return false;
        }

        if (!empty($config['servers'])) {
            $persistant = isset($config['persistant']) ? (boolean) $config['persistant'] : false;

            foreach ((array) $config['servers'] as $server) {
                list($ip, $port) = explode(':', $server);
                $ip = trim($ip);
                $port = (int) trim($port);
                
                if ($this->_memcached) {
                    $this->_memcached->addServer($ip, $port);
                } else {
                    $this->_memcache->addServer($ip, $port, $persistant);
                }
            }
        } else {
            return false;
        }

        if (!empty($config['compress_threshold'])) {
            if ($this->_memcache) {
                $this->_memcache->setCompressThreshold((integer) $config['compress_threshold']);
            }
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
        if ($this->_memcached) {
            return @$this->_memcached->add($key, $var, $expire);
        } else {
            return @$this->_memcache->add($key, $var, false, $expire);
        }
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
        if ($this->_memcached) {
            return @$this->_memcached->set($key, $var, $expire);
        } else {
            return @$this->_memcache->set($key, $var, false, $expire);
        }
    }

    /**
     * Returns data
     *
     * @param string $key
     * @return mixed
     */
    function get($key) {
        if ($this->_memcached) {
            return @$this->_memcached->get($key);
        } else {
            return @$this->_memcache->get($key);
        }
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
        if ($this->_memcached) {
            return @$this->_memcached->replace($key, $var, $expire);
        } else {
            return @$this->_memcache->replace($key, $var, false, $expire);
        }
    }

    /**
     * Deletes data
     *
     * @param string $key
     * @return boolean
     */
    function delete($key) {
        if ($this->_memcached) {
            return @$this->_memcached->delete($key);
        } else {
            return @$this->_memcache->delete($key);
        }
    }

    /**
     * Flushes all data
     *
     * @return boolean
     */
    function flush() {
        if ($this->_memcached) {
            return @$this->_memcached->flush();
        } else {
            return @$this->_memcache->flush();
        }
    }
}
