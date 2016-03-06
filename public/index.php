<?php
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Session\Adapter\Files as Session;
use Phalcon\Mvc\Router;

try {
    // Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(array(
                              '../app/controllers/',
                              '../app/models/',
                              '../app/plugins/',
                              '../app/library/'
                          ))->register();
    // Create a DI
    $di = new FactoryDefault();
    // Setup the database service
    $di->set('db', function () {

        return new DbAdapter(array(
                                 "host"     => "localhost",
                                 "username" => "root",
                                 "password" => "cxp123",
                                 "dbname"   => "courthack"
                             ));
    });
    // Setup the view component
    $di->set('view', function () {

        $view = new View();
        $view->setViewsDir('../app/views/');

        return $view;
    });
    $di->set('url', function () {

        $url = new UrlProvider();
        $url->setBaseUri('/');

        return $url;
    });
    $di->setShared('session', function () {

        $session = new Session();
        $session->start();

        return $session;

    });
    //Additional Routing
    $di->set('router', function () {

        $router = new Router();
        $router->add('/logout', 'Login::logout');
        $router->add("/payfine/protest/save/{ticket_id:[0-9]+}", "Payfine::save");

        return $router;

    });
    // More Routing
    $di->set('nav', function () {

        /* Set Nav Links for Di */
        $controllers = scandir('../app/controllers');
        $main_links  = array();
        foreach ($controllers as $value) {
            if (!is_dir($value)) {
                $pi    = pathinfo($value);
                $rc    = new ReflectionClass($pi['filename']);
                $props = !property_exists($pi['filename'], 'link_name') ? '' : $rc->getStaticPropertyValue('link_name');
                if (empty($props)) {
                    continue;
                }
                $name     = preg_replace('/Controller/', '', $pi['filename']);
                $nav_name = $name;
                $name     = strtolower($name);
                $name !== 'index' ? $main_links[$nav_name] = array('name' => !empty($props) ? $props : '', 'url' => '/' . $name) : null;
            }
        }

        return $main_links;
    });
    // Handle the request
    $application = new Application($di);
    echo $application->handle()->getContent();
}
catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}
