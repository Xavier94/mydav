<?php

define('APP_PATH', realpath('..') . '/');

require APP_PATH . 'vendor/autoload.php';

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Config\Adapter\Ini as ConfigIni;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Events\Manager as EventsManager;

try
{
    // Read the configuration
    $config = new ConfigIni(APP_PATH . 'app/config/config.ini');

    // Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(array(
        APP_PATH . $config->application->controllersDir,
        APP_PATH . $config->application->modelsDir,
        APP_PATH . $config->application->pluginsDir
    ))->register();

    // Create a DI
    $di = new FactoryDefault();

    // Database connection is created based on parameters defined in the configuration file
    $di->set('db', function () use ($config)
    {
        return new DbAdapter(
            array(
                "host"     => $config->database->host,
                "username" => $config->database->username,
                "password" => $config->database->password,
                "dbname"   => $config->database->name
            )
        );
    });

    // Setup the view component
    $di->set('view', function () use ($config)
    {
        $view = new View();
        $view->setViewsDir(APP_PATH . $config->application->viewsDir);
        return $view;
    });

    /**
     * MVC dispatcher
     */
    $di->set('dispatcher', function ()
    {
        // Create an events manager
        $eventsManager = new EventsManager();
        // Listen for events produced in the dispatcher using the Security plugin
        $eventsManager->attach('dispatch:beforeExecuteRoute', new SecurityPlugin);
        // Handle exceptions and not-found exceptions using NotFoundPlugin
        $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);

        $dispatcher = new Dispatcher();
        // Assign the events manager to the dispatcher
        $dispatcher->setEventsManager($eventsManager);
        return $dispatcher;
    });

    // Start the session the first time a component requests the session service
    $di->set('session', function ()
    {
        $session = new Session();
        $session->start();
        return $session;
    });

    // Setup a base URI so that all generated URIs include the "tutorial" folder
    $di->set('url', function () use ($config)
    {
        $url = new UrlProvider();
        $url->setBaseUri($config->application->baseUri);
        return $url;
    });

    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();
}
catch (\Exception $e)
{
    echo "PhalconException: ", $e->getMessage();
}
