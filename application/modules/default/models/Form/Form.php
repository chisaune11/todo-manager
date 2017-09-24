<?php
/**
 * Todoリストフォーム
 */
class Default_Model_Form_Form extends Zend_Form
{
    /**
     * フォームの設定条件
     * @param string $name  フォーム名
     * @param string $action アクション名
     */
    public function setBaseForm($name = '', $action = '')
    {
        // フォームの名前、アクション、メソッド、送信ボタンを設定
        $this->setName($name)
        ->setAction($action)
        ->setMethod('POST')
        ->addElement('submit', 'submitButton', array('label' => ''));
    }

    public function setListFormElement()
    {
        // Todoリスト名
        $element = $this->createElement('text', 'name');
        $element->setLabel('Todoリスト名');
        $element->setAttrib('placeholder','プロジェクトA');
        $element->addValidator('NotEmpty');
        $element->setAttrib('class','hissu');
        $element->setAttrib('style', 'width: 700px; height: 40px; font-size: 1.6rem; border: 1px solid #888888; border-radius: 3px; padding: 3px; margin-bottom: 5px;');
        $element->addValidator('stringLength', true, array(1, 30));
        $element->setRequired(true);
        $this->addElement($element);
    }

    public function setDetailFormElement($option = array())
    {
        // TodoリストID
        $element = $this->createElement('hidden', 'listNum');
        $element->setLabel('TodoリストID');
        $element->addValidator('NotEmpty');
        $element->addValidator('StringLength', true, array(1, 30, mb_detect_encoding($option['listNum'])));
        $element->setRequired(true);
        $this->addElement($element);

        // Todo名
        $element = $this->createElement('text', 'name');
        $element->setLabel('Todo名');
        $element->setAttrib('placeholder','企画書の作成');
        $element->addValidator('NotEmpty');
        $element->setAttrib('class','hissu');
        $element->setAttrib('style', 'width: 700px; height: 40px; font-size: 1.6rem; border: 1px solid #888888; border-radius: 3px; padding: 3px; margin-bottom: 5px;');
        $element->addValidator('stringLength', true, array(1, 30));
        $element->setRequired(true);
        $this->addElement($element);

        // 期限
        $element = $this->createElement('text', 'period');
        $element->setLabel('期限');
        $element->setAttrib('placeholder','20YY-MM-DD');
        $element->addValidator('NotEmpty');
        $element->setAttrib('class','hissu');
        $element->setAttrib('style', 'width: 200px; height: 40px; font-size: 1.6rem; border: 1px solid #888888; border-radius: 3px; padding: 3px; margin-bottom: 5px;');
        $element->setRequired(true);
        $this->addElement($element);
    }

    public function setSearchFormElement()
    {
        // Todo名
        $element = $this->createElement('text', 'name');
        $element->setLabel('Todo、Todoリストの検索');
        $element->setAttrib('style', 'width: 700px; height: 40px; font-size: 1.6rem; border: 1px solid #888888; border-radius: 3px; padding: 3px; margin-bottom: 5px;');
        $element->addValidator('stringLength', true, array(0, 30));
        $this->addElement($element);

    }

    // public function isValid($option = array())
    // {
    //
    //     $isValid = true;
    //
    //     if($options['action'] == 'index' || $option['action'] == 'action') {
    //         if (!empty($option['name'])) {
    //             if($option['name'] > 30) {
    //                 $this->_error = 'ToDoリストの名称は30文字以内にしてください';
    //                 $isValid = false;
    //             }
    //
    //             if($option['name'] < 1) {
    //                 $this->_error = 'ToDoリストの名称を入力してください';
    //                 $isValid = false;
    //             }
    //
    //             if($option['name'] > 0 && $option['name'] < 31) {
    //                 $list = new Default_Model_TodoList();
    //                 $sameList = $list->getSameName($option['name']);
    //
    //                 if(!empty($sameList)) {
    //                     $this->_error = '同じ名前のToDoリストがすでに存在しています';
    //                     $isValid = false;
    //                 }
    //             }
    //         }
    //     } elseif($option['action'] == 'detail') {
    //         if (!empty($option['name'])) {
    //             if($option['name'] > 30) {
    //                 $this->_error = 'ToDoの名称は30文字以内にしてください';
    //                 $isValid = false;
    //             }
    //
    //             if($option['name'] < 1) {
    //                 $this->_error = 'ToDoの名称を入力してください';
    //                 $isValid = false;
    //             }
    //
    //             if($option['name'] > 0 && $option['name'] < 31) {
    //                 $todo = new Default_Model_TodoDetail();
    //                 $sameTodo = $todo->getSameName($option['name']);
    //
    //                 if(!empty($sameTodo)) {
    //                     $this->_error = '同じ名前のToDoがすでに存在しています';
    //                     $isValid = false;
    //                 }
    //             }
    //         }
    //     }
    //
    //     return $isValid;
    // }
}
