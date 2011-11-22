<?php

namespace Lunch\Cmd\Base;

abstract class CmdAbstract
{
    abstract function run(array $paramas);

    abstract function help();

    public function __construct()
    {
        //$config = new \Zend_Config_Ini(APPLICATION_PATH . '/configs/database.ini', 'database');
        //$dsn = $config->db->dsn;
        //$user = $config->db->username;
        //$pass = $config->db->password;

        //$conn = new Db($dsn, $user, $pass);
        //$conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
        //$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        //\Zend_Registry::set('conn', $conn);
    }

    public function log($msg, $title = null)
    {
        if (is_null($title)) {

            $txt = '  ' .  pack('c',0x1B) . "[1m" . $msg . pack('c',0x1B) . "[0m" . "\n";
            
        } else {

            $txt = '  ' .  pack('c',0x1B) . "[1;32m" . $title . ':' . pack('c',0x1B) . "[0m" . '  ';
            $txt .= pack('c',0x1B) . "[1m" . $msg . pack('c',0x1B) . "[0m" . "\n";
            
        }
        echo $txt;
    }

    public function logError($msg)
    {
        $txt = '  ' .  pack('c',0x1B) . "[1;31m" . $msg . pack('c',0x1B) . "[0m" . "\n";
        echo $txt;
    }
}
