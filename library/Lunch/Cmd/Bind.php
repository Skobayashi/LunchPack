<?php

namespace Lunch\Cmd;
require_once dirname(__FILE__) . '/Base/CmdAbstract.php';

class Bind extends Base\CmdAbstract
{
    public function run (array $params)
    {
        try {
            $path = APPLICATION_PATH . DS . '../library/tools';
            $cmd = 'node ./build.js';

            chdir($path);
            exec($cmd, $output);

            if (count($output) > 0) {
                $this->render($output);
            }
        
        } catch (\RuntimeException $e) {
            throw $e;
        }
    }

    public function help ()
    {
        /* write help message */
        $msg = 'bind javascript files';

        return $msg;
    }

    protected function render($output)
    {
        foreach ($output as $p) {
            $this->log($p);
        }
    }
}
