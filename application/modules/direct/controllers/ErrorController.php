<?php
/**
 *
 */

// コンポーネントをロードする
require_once 'Zend/Controller/Action.php';

class ErrorController extends Zend_Controller_Action
{
    /**
     * errorアクション
     * デフォルトコントローラへリダイレクトする
     */
    public function errorAction()
    {

        $errors = $this->_getParam('error_handler');
        var_dump($errors);
        // デフォルトコントローラへリダイレクトする
        // return $this->_redirect('/');
        echo ' something wrong...';
    }
}

