<?php

/**
 * Gemini_Common Class
 * Copyright (c) 2011 iii-planning.com
 */
class Gemini_AbstractScreen extends Gemini_Base_Model
{
    // {{{ props

    /**
     * 契約者情報
     */
    protected $_cinfo = null;

    /**
     * ユーザー情報
     */
    protected $_uinfo = null;

    /**
     * ユーザーセッションキー
     */
    protected $_sessKey = 'GeminiUser';

    // }}}
    // {{{ constructor

    /**
     * コンストラクタ
     */
    public function __construct($conf, $controller)
    {
        // スーパークラスメソッドコール
        parent::__construct($conf, $controller);

        // 契約アカウント名取得
        $cname = $this->controller->Session->read('GEMINI_CONTRACTOR_NAME');

        // セッションから契約者情報を取得
        $this->_cinfo = $this->controller->Session->read('GEMINI_CONTRACTORINFO_' . $cname);

        // ユーザーセッションキー変更
        $this->_sessKey .= $cname;

        // セッションからユーザー情報を取得
        $this->_uinfo = $this->controller->Session->read($this->_sessKey);

    }

    // }}}

}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
