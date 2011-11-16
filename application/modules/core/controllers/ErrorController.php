<?php

class ErrorController extends Zend_Controller_Action
{
    /**
     * errorアクション
     * デフォルトコントローラへリダイレクトする
     */
    public function errorAction()
    {
        // デフォルトコントローラへリダイレクトする
        // return $this->_redirect('/');
        $errors = $this->getRequest()->getParam('error_handler');
        $this->view->errors = $errors;
        $this->view->exception = $errors->exception;
    }
}

