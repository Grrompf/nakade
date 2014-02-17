<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

// config/autoload/global.php:
return array(
    
   'db' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=bbc-blog;host=127.0.0.1',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'db_user' => array(
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=zf2tutorial;host=127.0.0.1',
        'username' => 'root',
        'password' => 'holger27',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
            'translator' 
                    => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
         'locale'   => 'de_DE',
         'fallback' => 'en_US',
    )

);