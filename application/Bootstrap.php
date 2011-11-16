<?php

use Project\Db;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public static $currentUser;

    /**
     * 基本設定
     *
     */
    protected function _initBase()
    {
        define('DS', DIRECTORY_SEPARATOR);
        define('TEMP', '/tmp/');
    }

    protected function _initView()
    {
        $view = new Zend_View();

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
    }

    protected function _initDatabase()
    {
        //$config   = new \Zend_Config_Ini(APPLICATION_PATH . '/configs/database.ini', 'database');
        //$dsn      = $config->db->dsn;
        //$user     = $config->db->username;
        //$password = $config->db->password;

        //$conn = new Db($dsn, $user, $password);
        //$conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        //$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //\Zend_Registry::set('conn', $conn);
    }

    protected function _initCache()
    {
        //$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/core.ini', APPLICATION_ENV);
        //$options = $config->cache->options;

        //$frontendOptions = array(
            //'lifetime' => $options->lifetime,
            //'automatic_serialization' => $options->serializable,
            //'cache_id_prefix' => $options->prefix
        //);

        //$cache = Zend_Cache::factory('Core', 'Memcached', $frontendOptions);
        //Zend_Registry::set('cache', $cache);
    }

}
