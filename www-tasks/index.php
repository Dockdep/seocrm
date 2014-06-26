#!/usr/bin/php
<?php

///////////////////////////////////////////////////////////////////////////////

define( 'START_TIME',           microtime(true) );
define( 'ROOT_PATH',            realpath(__DIR__.'/../src').'/' );

///////////////////////////////////////////////////////////////////////////////

# IS_PRODUCTION
define( 'IS_PRODUCTION',        false );

///////////////////////////////////////////////////////////////////////////////

try
{
    ///////////////////////////////////////////////////////////////////////////

    if( IS_PRODUCTION )
    {
        error_reporting(0);

        // blank P-functions
        if( function_exists('p')===false ) { function p($var = '', $die_color = 2) {} }
        if( function_exists('z')===false ) { function z($var = '', $die_color = 2, $get_param = 'z') {} }
        if( function_exists('j')===false ) { function j($var = '', $label = '') {} }
        if( function_exists('b')===false ) { function b($label = 1, $use_p = true, $p_color = 2) {} }
        if( function_exists('info')===false ) { function info($return = false, $with_html = true) {} }
        if( function_exists('f')===false ) { function f( $var = '', $type = 2, $label = null ) {} }
        if( function_exists('fpe')===false ) { function fpe( $str, $color = 2, $append_newline = true ) {} }
    }
    else
    {
        error_reporting(-1);
        ini_set('display_errors', 1);

        // P-functions
        require( ROOT_PATH.'lib/p.php' );
    }

    ///////////////////////////////////////////////////////////////////////////

    require( ROOT_PATH.'lib/config.php' );

    config::setApp( 'tasks' );

    ///////////////////////////////////////////////////////////////////////////

    $loader = new \Phalcon\Loader();

    $loader->registerDirs([
        ROOT_PATH.config::get( 'dirs/controllersDir' ),
        ROOT_PATH.config::get( 'dirs/librariesDir' ),
        ROOT_PATH.config::get( 'dirs/modelsDir' ),
    ])->register();

    $loader->registerNamespaces([
        'lib'               => ROOT_PATH.config::get( 'dirs/librariesDir' ),
        'models'            => ROOT_PATH.config::get( 'dirs/modelsDir' ),
    ])->register();

    ///////////////////////////////////////////////////////////////////////////

    // Using the CLI factory default services container
    $di = new \Phalcon\DI\FactoryDefault\CLI();



    ///////////////////////////////////////////////////////////////////////////

    // cache

    $di->set( 'cache', function()
    {
        $cache = new \Phalcon\Cache\Frontend\Data([
            'lifetime' => 60,
        ]);

        return new \Phalcon\Cache\Backend\Memcache(
            $cache,
            [
                'host'  => '127.0.0.1',
                'port'  => 11211,
            ]
        );
    }, true );
    ///////////////////////////////////////////////////////////////////////////

    // i18n

    $di->set( 'i18n', function()
    {
        return new \Phalcon\Translate\Adapter\NativeArray([
            'content' => require( ROOT_PATH.config::get( 'dirs/messagesDir' ).'ru.php' )
        ]);
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // database

    $di->set( 'db', function()
    {
        $config =
            [
                'host'      => config::get('global#database/server'),
                'username'  => config::get('global#database/user'),
                'password'  => config::get('global#database/passwd'),
                'dbname'    => config::get('global#database/db'),
                'schema'    => 'public',
            ];

        $database       = new \Phalcon\Db\Adapter\Pdo\Postgresql( $config );

        return $database;

    }, true );

    ///////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////////////////////////////////////////

    //Set a models manager
    $di->set('modelsManager', function() {
        return new \Phalcon\Mvc\Model\Manager();
    });


    //Use the memory meta-data adapter or other
    $di->set('modelsMetadata', new \Phalcon\Mvc\Model\MetaData\Memory());
    ///////////////////////////////////////////////////////////////////////////
    // common

    $di->set( 'common', function()
    {
        return new \common();
    }, true );
//rds
    $di->set( 'rds', function()
    {
        return new \rds();
    }, true );
    // session

    $di->set('session', function() {
        $session = new Phalcon\Session\Adapter\Files();
        $session->start();
        return $session;
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // flash

    $di->set( 'flash', function()
    {
        return new \Phalcon\Flash\Session();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // cookies

    $di->set( 'cookies', function ()
    {
        $cookies = new \Phalcon\Http\Response\Cookies();
        $cookies->useEncryption(false);

        return $cookies;
    });



    // Create a console application
    $console = new \Phalcon\CLI\Console();
    $console->setDI($di);

    ///////////////////////////////////////////////////////////////////////////

    // Process the console arguments
    $arguments          =
    [
        'task'          => null,
        'action'        => null,
        'params'        => null,
    ];

    if( count($argv)>1 )
    {
        foreach( $argv as $k => $arg )
        {
            if( strlen($arg)>0 )
            {
                if( $k == 1 )
                {
                    $current_task       = null;
                    $current_action     = null;

                    list( $current_task, $current_action, ) = explode( ':', $arg );

                    $arguments['task']   = trim( $current_task );
                    $arguments['action'] = trim( $current_action );
                }
                elseif( $k >= 2 && substr($arg, 0, 2)=='--' )
                {
                    $temp_arg = ltrim( trim( $arg ), '-' );

                    list( $temp_arg_key, $temp_arg_value ) = explode( '=', $temp_arg );

                    $arguments['params'][ trim($temp_arg_key) ] = trim( $temp_arg_value );
                }
            }
        }

        define( 'CURRENT_TASK',     $arguments['task'] );
        define( 'CURRENT_ACTION',   $arguments['action'] );
    }
    else
    {
        throw new \Phalcon\Exception( 'Use "php ./www-tasks/index.php <taskName>:<taskAction>"' );
    }

    ///////////////////////////////////////////////////////////////////////////

    // handle incoming arguments
    $console->handle( $arguments );

    ///////////////////////////////////////////////////////////////////////////
}
catch (\Phalcon\Exception $e)
{
    echo( '[ERROR] '.$e->getMessage(). "\n\n" );
    exit( 255 );
}
catch (\PDOException $e)
{
    echo( '[ERROR] '.$e->getMessage(). "\n\n" );
    exit( 255 );
}
catch (\Exception $e)
{
    echo( '[ERROR] '.$e->getMessage(). "\n\n" );
    exit( 255 );
}
