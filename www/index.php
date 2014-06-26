<?php
///////////////////////////////////////////////////////////////////////////////

define( 'START_TIME',           microtime(true) );
define( 'ROOT_PATH',            realpath(__DIR__.'/../src').'/' );
define( 'STORAGE_PATH',         realpath(__DIR__.'/../storage').'/' );

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

    config::setApp( 'frontend' );

    ///////////////////////////////////////////////////////////////////////////

    $loader = new \Phalcon\Loader();

    $loader->registerDirs([
        ROOT_PATH.config::get( 'dirs/controllersDir' ),
        ROOT_PATH.config::get( 'dirs/appLibrariesDir' ),
        ROOT_PATH.config::get( 'dirs/librariesDir' ),
        ROOT_PATH.config::get( 'dirs/modelsDir' ),
    ])->register();

    $loader->registerNamespaces([
        'controllers'       => ROOT_PATH.config::get( 'dirs/controllersDir' ),
        'frontend\lib'      => ROOT_PATH.config::get( 'dirs/appLibrariesDir' ),
        'lib'               => ROOT_PATH.config::get( 'dirs/librariesDir' ),
        'models'            => ROOT_PATH.config::get( 'dirs/modelsDir' ),
    ])->register();

    ///////////////////////////////////////////////////////////////////////////
    $di = new \Phalcon\DI\FactoryDefault();

    ///////////////////////////////////////////////////////////////////////////

    // request

    $di->set( 'request', function()
    {
        return new \Phalcon\Http\Request();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // response

    $di->set( 'response', function()
    {
        return new \Phalcon\Http\Response();
    }, true );

    ///////////////////////////////////////////////////////////////////////////

    // router

    $di->set( 'router', function()
    {
        //////////////////////////////////////////////////////////////////////	

        $router = new \Phalcon\Mvc\Router();

        //////////////////////////////////////////////////////////////////////        

        $router->removeExtraSlashes( true );

        //////////////////////////////////////////////////////////////////////



        $router->add
            (
                '/',
                [
                    'controller'    => 'index',
                    'action'        => 'index',
                ]
            )
            ->setName( 'homepage' );

        $router->add
            (
                '/user_registration',
                [
                    'controller'    => 'users',
                    'action'        => 'registration',
                ]
            )
            ->setName( 'registration' );

        $router->add
            (
                '/user_login',
                [
                    'controller'    => 'users',
                    'action'        => 'login',
                ]
            )
            ->setName( 'login' );

        $router->add
            (
                '/user_logout',
                [
                    'controller'    => 'users',
                    'action'        => 'logout',
                ]
            )
            ->setName( 'logout' );

        $router->add
            (
                '/check_user',
                [
                    'controller'    => 'users',
                    'action'        => 'check',
                ]
            )
            ->setName( 'check' );
        ///////////////////////////////////////////////////////////////////////


        return $router;
    }, true );

    ///////////////////////////////////////////////////////////////////////////	

    // url

    $di->set( 'url', function()
    {
        $url = new \Phalcon\Mvc\Url();

        $url->setBaseUri('/');

        return $url;
    }, true );

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

    ///////////////////////////////////////////////////////////////////////////

    // view 

    $di->set( 'view', function()
    {
        $view = new \Phalcon\Mvc\View();

        $view->setViewsDir( ROOT_PATH.config::get( 'dirs/viewsDir' ) );

        $view->registerEngines([
            '.php' => '\Phalcon\Mvc\View\Engine\Php'
        ]);

        return $view;
    }, true );

    ///////////////////////////////////////////////////////////////////////////


    $di->set( 'dispatcher', function()
    {
        // Create/Get an EventManager
        $eventsManager = new \Phalcon\Events\Manager();

        // Attach a listener
        $eventsManager->attach( 'dispatch', function($event, $dispatcher, $exception)
        {
            if ($event->getType() == 'beforeExecuteRoute')
            {
                $role = new \security();
                if(!$role->check($dispatcher)) {
                    $dispatcher->forward([
                        'controller'    => 'index',
                        'action'        => 'index'
                    ]);
                }
            }
            // The controller exists but the action not
            if ($event->getType() == 'beforeNotFoundAction')
            {
                $dispatcher->forward([
                    'controller'    => 'page',
                    'action'        => 'error404'
                ]);

                return false;
            }

            // Alternative way, controller or action doesn't exist
            if ($event->getType() == 'beforeException')
            {
                switch ($exception->getCode())
                {
                    case \Phalcon\Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case \Phalcon\Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward([
                            'controller'    => 'page',
                            'action'        => 'error404'
                        ]);

                        return false;
                }
            }
        });

        $dispatcher = new \Phalcon\Mvc\Dispatcher();

        $dispatcher->setDefaultNamespace('controllers');

        // Bind the EventsManager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;

    }, true );

    ///////////////////////////////////////////////////////////////////////////

    $application = new \Phalcon\Mvc\Application();
    $application->setDI($di);
    die( $application->handle()->getContent() );

    ///////////////////////////////////////////////////////////////////////////

}
catch (Phalcon\Exception $e)
{
    if( IS_PRODUCTION )
    {
        // TODO
    }
    else
    {
        echo( ob_get_flush() );

        if( class_exists('exceptions') )
        {
            $z = new \exceptions();
            return $z->handle($e);
        }
        else
        {
            die( '[Phalcon\Exception] '.$e->getMessage() );
        }
    }
}
catch (PDOException $e)
{
    if( IS_PRODUCTION )
    {
        // TODO
    }
    else
    {
        echo( ob_get_flush() );

        if( class_exists('exceptions') )
        {
            $z = new \exceptions();
            return $z->handle($e);
        }
        else
        {
            die( '[PDOException] '.$e->getMessage() );
        }
    }
}
catch (Exception $e)
{
    if( IS_PRODUCTION )
    {
        // TODO
    }
    else
    {
        echo( ob_get_flush() );

        if( class_exists('exceptions') )
        {
            $z = new \exceptions();
            return $z->handle($e);
        }
        else
        {
            die( '[Exception] '.$e->getMessage() );
        }
    }
}

///////////////////////////////////////////////////////////////////////////////