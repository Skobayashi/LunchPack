<?php

class DirectController extends Gemini_Controller_Action
{
    private $Modules = null;

    public function init()
    {
        $config  = new Zend_Config_Ini(APPLICATION_PATH . '/configs/direct.ini', 'production');
        $config  = $config->toArray();
        $modules = $config['modules'];
        $actions = array();
        foreach($modules as $module) {
            $methods = get_class_methods($module);
            $actions[$module] = array();
            foreach ($methods as $method) {

                $ref = new ReflectionMethod($module, $method);
                $count   = count($ref->getParameters());
                $actions[$module]['methods'][$method] = array('len' => $count);

                if ($ref->isPublic() && strlen($ref->getDocComment()) > 0) {
                    
                    $doc     = $ref->getDocComment();

                    if (!!preg_match('/@formHandler/', $doc)) {

                        //$actions[$module]['methods'][$method]['formHandler'] = true;
                        $methods['formHandler'] = true;
                    }
                }
            }
        }
        $this->Modules = $actions;
    }

    public function indexAction()
    {
        $isForm = false;
        $isUpload = false;
        $rawPostData = file_get_contents('php://input');
        $data = json_decode($rawPostData);

        if (! is_null($data)) {

            header('Content-Type: text/javascript');

        } elseif (isset($_POST['extAction'])) { // form post

            $isForm = true;
            $isUpload = $_POST['extUpload'] == 'true';
            $data = new stdClass();
            $data->action = $_POST['extAction'];
            $data->method = $_POST['extMethod'];
            $data->tid = isset($_POST['extTID']) ? $_POST['extTID'] : null; // not set for upload
            $data->data = array($_POST, $_FILES);
        } else {

            die('Invalid request.');
        }

        $response = null;
        if (is_array($data)) {
            $response = array();
            foreach($data as $d){
                $response[] = $this->doRpc($d);
            }
        } else {
            $response = $this->doRpc($data);
        }
        if ($isForm && $isUpload) {
            echo '<html><body><textarea>';
            echo json_encode($response);
            echo '</textarea></body></html>';
        } else {
            echo json_encode($response);
        }
        exit();
    }

    /*
     *
     */
    private function doRpc($cdata)
    {
        $API = $this->Modules;
        try {
            if (!isset($API[$cdata->action])) {
                throw new Exception('Call to undefined action: ' . $cdata->action);
            }

            $action = $cdata->action;
            $a = $API[$action];

            $this->doAroundCalls($a['before'], $cdata);

            $method = $cdata->method;
            $mdef = $a['methods'][$method];
            if (!$mdef) {
                throw new Exception("Call to undefined method: $method on action $action");
            }
            $this->doAroundCalls($mdef['before'], $cdata);

            $r = array(
                'type'=>'rpc',
                'tid'=>$cdata->tid,
                'action'=>$action,
                'method'=>$method
            );

            // require_once("classes/$action.php");





            $o = new $action();
            if (isset($mdef['len'])) {
                $params = isset($cdata->data) && is_array($cdata->data) ? $cdata->data : array();
            } else {
                $params = array($cdata->data);
            }

            $r['result'] = call_user_func_array(array($o, $method), $params);

            $this->doAroundCalls($mdef['after'], $cdata, $r);
            $this->doAroundCalls($a['after'], $cdata, $r);
        }
        catch (Exception $e) {
            $r['type']    = 'exception';
            $r['message'] = $e->getMessage();
            $r['where']   = $e->getTraceAsString();
        }
        return $r;
    }


    private function doAroundCalls(&$fns, &$cdata, &$returnData=null)
    {
        if (!$fns) {
            return;
        }
        if (is_array($fns)) {

            foreach($fns as $f) {

                $f($cdata, $returnData);
            }
        }else{

            $fns($cdata, $returnData);
        }
    }

}
