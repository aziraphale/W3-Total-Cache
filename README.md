W3 Total Cache
==============

This is a fork of the W3 Total Cache Wordpress plugin (http://wordpress.org/extend/plugins/w3-total-cache/).  

This fork is itself a fork of rickoman's fork, intended to be a spiritual successor with support for the latest version of W3 Total Cache. Rickoman's fork added support for PHP's [Memcached](http://us.php.net/memcached) extension to version 0.9.2.3 of the W3 Total Cache plugin by essentially adding Memcached as a cache option alongside the existing [Memcache](http://us.php.net/memcache) extension support. This fork adds support to version 0.9.2.4 and does so completely transparently by silently using either Memcached (preferred) or Memcache inside the main plugin cache class.
