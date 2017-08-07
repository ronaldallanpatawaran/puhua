<?php
// URL
define('URL', $_SERVER['HTTP_HOST'] . str_replace('/admin', '', dirname($_SERVER['PHP_SELF'])));

// HTTP
define('HTTP_SERVER', 'http://' . URL . '/admin/');
define('HTTP_CATALOG', 'http://' . URL . '/');

// HTTPS
define('HTTPS_SERVER', 'http://' . URL . '/admin/');
define('HTTPS_CATALOG', 'http://' . URL . '/');

// DIR
define('BASE_DIR', str_replace(DIRECTORY_SEPARATOR . 'admin', '', realpath(dirname(__FILE__))) . '/');
define('DIR_APPLICATION', BASE_DIR . '/admin/');
define('DIR_SYSTEM', BASE_DIR . '/system/');
define('DIR_LANGUAGE', BASE_DIR . '/admin/language/');
define('DIR_TEMPLATE', BASE_DIR . '/admin/view/template/');
define('DIR_CONFIG', BASE_DIR . '/system/config/');
define('DIR_IMAGE', BASE_DIR . '/image/');
define('DIR_CACHE', BASE_DIR . '/system/cache/');
define('DIR_DOWNLOAD', BASE_DIR . '/system/download/');
define('DIR_UPLOAD', BASE_DIR . '/system/upload/');
define('DIR_LOGS', BASE_DIR . '/system/logs/');
define('DIR_MODIFICATION', BASE_DIR . '/system/modification/');
define('DIR_CATALOG', BASE_DIR . '/catalog/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'ecommerce_puhua');
// define('DB_USERNAME', 'puhua_ronald');
// define('DB_PASSWORD', '4*#)owEDqE^us%');
// define('DB_DATABASE', 'puhua_database');
define('DB_PORT', '3306');
define('DB_PREFIX', '');
