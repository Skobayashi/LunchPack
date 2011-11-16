<?php

set_include_path('../library' . PATH_SEPARATOR . get_include_path());

require_once 'Zend/Application.php';
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->unregisterNamespace(array('Zend_', 'ZendX_'))
           ->setFallbackAutoloader(true);

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));


$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/core.ini'
);


try {

    $application->bootstrap();
    $front = $application->getBootstrap()->getResource('FrontController');
    $front->addControllerDirectory(APPLICATION_PATH.'/modules/core/controllers');
    $application->run();

} catch (Exception $e) {

    var_dump($e->getMessage());
    exit();
    exit();
}

