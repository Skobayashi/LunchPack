<?php

namespace Lunch;

class Cmd
{
    private static $instance = null;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function run ($argv)
    {
        try {

            $params = array();
            $class = $argv[1];
            $length = count($argv);

            for ($i = 2; $i < $length; $i++) {
                $params[] = $argv[$i];
            }

            require_once dirname(__FILE__) . '/Cmd/' . $class . '.php';

            $c_name = 'Lunch\Cmd\\' . $class;
            $c = new $c_name;

            $result = $c->run($params);

        } catch (\Exception $e) {
            echo "\n" . pack('c',0x1B) . "[1;31m" . $e->getMessage() . pack('c',0x1B) . "[0m" . "\n\n";
        }
    }

    public function cmdList()
    {
        $path = dirname(__FILE__) . '/Cmd';
        echo "\n" . pack('c',0x1B) . "[1m" . '-- lunch commands list --' . pack('c',0x1B) . "[0m" . "\n";

        if ($dh = opendir($path)) {
            while ($entry = readdir($dh)) {
                if ($entry != '.' && $entry != '..' && preg_match('/.*\.php/', $entry)) {
                    require_once ($path . '/' . $entry);
                    $count = 30;
                    $c_name = 'Lunch\Cmd\\' . str_replace('.php', '', $entry);

                    $task = new $c_name;
                    $class = str_replace('.php', '', $entry);
                    $string = $task->help();

                    $c = mb_strlen($class);
                    $count = $count - $c;
                    $txt = '';

                    for ($i = 0; $i < $count; $i++) {
                        $txt .= ' ';
                    }

                    echo '  ' . pack('c',0x1B) . "[1;33m" . $class . ':' . pack('c',0x1B) . "[0m" . $txt . $string . "\n";
                }
            }
            closedir($dh);
        }

        echo "\n";
    }
}
