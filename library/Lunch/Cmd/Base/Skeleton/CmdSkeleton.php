<?php

namespace Gemini\Cmd;
require_once dirname(__FILE__) . '/Base/CmdAbstract.php';

class {$class} extends Base\CmdAbstract
{
    public function run (array $params)
    {
        try {

            /* write command action */
        
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function help ()
    {
        /* write help message */
        $msg = '';

        return $msg;
    }
}
