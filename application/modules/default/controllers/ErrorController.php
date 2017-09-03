<?php
/**
 * エラーコントローラー
 */
class ErrorController extends Zend_Controller_Action
{

    public function init()
    {
        // プラグインの設定
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Common_Model_Controller_Action());
    }

    public function errorAction()
    {
        $this->view->setEncoding("sjis");

        $errors = $this->_getParam('error_handler');var_dump($errors);
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
                $errmsg = 'コントローラが見つかりません。';
                break;
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->_redirect('/');
                $errmsg = 'アクションが見つかりません。';
                break;
            default:
                $errmsg = 'その他の例外が発生しました。';
                break;
        }

        $this->view->errmsg = $errmsg;

      }
}
