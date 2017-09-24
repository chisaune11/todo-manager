<?php
/**
 * インデックスコントローラー
 */
class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        // プラグインの設定
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Common_Model_Controller_Action());
        // $front->dispatch();
    }

    protected function setLayout()
    {

        // レイアウトのlayoutパスを指定
        $options = new Zend_Config_Ini(PATH_APPLICATION_CONFIG.'/application.ini', 'layout');

        // オプションに入れたレイアウトを渡してレイアウトを開始する
        Zend_Layout::startMvc($options);
    }

    public function indexAction()
    {
        session_start();
        $params = $this->getRequest()->getParams('phtml');

        // Todoリストを取得
        $list = new Default_Model_TodoList();

        // 追加したTodoリストを取得
        if(isset($_SESSION['message'])) {
            $newList = $list->getAddedTodoById($_SESSION['newId']);
            $this->view->newList = $newList;
            $this->view->message = $_SESSION['message'];
        // 一覧用のTodoリストを取得
        } else {
            $allListId = $list->getAllListId();
            // $allList = $list->getAllList();
            // $this->view->allList = $allList;

            // Todoリスト内のTodoを取得
            $todoData = $list->getTodoByIds($allListId);
            $yetData = $list->getYetTodoByIds($allListId);

            foreach($yetData as $yet) {
                foreach($todoData as $todo) {
                    if($yet['listId'] == $todo['listId']) {
                        $yet['listName'] = $todo['listName'];
                        $yet['allCnt'] = $todo['allCnt'];
                    }
                }
                $todoList[] = $yet;
            }
            $this->view->todoList = $todoList;
        }

        // フォームを設定
        // Todoリスト追加
        $listForm = new Default_Model_Form_Form();
        $listForm->setBaseForm('listForm', '/index/add/');
        $listForm->setListFormElement();
        $this->view->listForm = $listForm;

        $this->view->params = $params;

        $this->render('index');
    }

    public function addAction()
    {
        session_start();
        $params = $this->getRequest()->getParams();

        // POSTでなければLPトップ
        if(!$this->getRequest()->isPost()) $this->_redirect("/");

        // フォーム
        $listForm = new Default_Model_Form_Form();
        $listForm->setBaseForm('listForm', '/index/add/');
        $listForm->setListFormElement();

        // DB接続
        $list = new Default_Model_TodoList();

        // １文字もない時
        if(empty($params['name'])) {
            $isFalse = true;
            $this->view->errorMsg = 'ToDoリストの名称を入力してください';
        } elseif(!empty($params['name'])) {

            // ３０文字以上の時
            if(mb_strlen($params['name']) > 30) {
                $isFalse = true;
                $this->view->errorMsg = 'ToDoリストの名称は30文字以内にしてください';
            }

            // 同じ名前がないか
            if($check = $list->getSameName($params['name'])) {
                $isFalse = true;
                $this->view->errorMsg = '同じ名前のToDoリストがすでに存在しています';
            }
        }

        if(!$listForm->isValid($params) || $isFalse)
        {
            // $errorMsg = 'エラーが発生しました';
            // $this->view->errorMsg = $errorMsg;
            $this->view->listForm = $listForm;
            $this->render('index');
        }

        // DBに登録するデータ
        $data = array(
            'name' => $params['name'],
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        // DBに登録
        $id = $list->insert($data);
        $_SESSION['newId'] = $id;

        // メッセージ
        $message = '新しいToDoリストが作成されました';
        $_SESSION['message'] = $message;

        $this->_redirect('/');
    }

    // Todoリスト画面
    public function detailAction()
    {
        $params = $this->getRequest()->getParams();

        // Todoを取得
        $todo = new Default_Model_TodoDetail();
        $todoAll = $todo->getTodoAllById($params['listNum']);
        $list = new Default_Model_TodoList();
        $listName = $list->getListNameById($params['listNum']);

        $this->view->todoAll = $todoAll;
        $this->view->listName = $listName;

        // Todo追加
        $todoForm = new Default_Model_Form_Form();
        $todoForm->setBaseForm('todoForm', '/index/detailexecute/');
        $todoForm->setDetailFormElement($params);
        $todoForm->setDefaults($params);
        $this->view->todoForm = $todoForm;

        $this->view->params = $params;

        return $this->render('detail');
    }

    // Todo登録処理
    public function detailexecuteAction()
    {
        $params = $this->getRequest()->getParams();var_dump($params);

        // POSTでなければLPトップ
        if(!$this->getRequest()->isPost()) $this->_redirect("/");

        // フォーム
        $todoForm = new Default_Model_Form_Form();
        $todoForm->setBaseForm('todoForm', '/index/detailexecute/');
        $todoForm->setDetailFormElement($params);
        $todoForm->setDefaults($params);

        // DB接続
        $todo = new Default_Model_TodoDetail();

        // １文字もない時
        if(empty($params['name'])) {
            $isFalse = true;
            $this->view->errorMsg = 'ToDoの名称を入力してください';
        } elseif(!empty($params['name'])) {
            // ３０文字以上の時
            if(mb_strlen($params['name']) > 30) {
                $isFalse = true;
                $this->view->errorMsg = 'ToDoの名称は30文字以内にしてください';
            }

            // 同じ名前がないか
            if($check = $todo->getSameName($params['name'])) {
                $isFalse = true;
                $this->view->errorMsg = '同じ名前のToDoがすでに存在しています';
            }
        }

        if(!$todoForm->isValid($params) || $isFalse)
        {
            $this->view->todoForm = $todoForm;

            $this->render('detail');
        }

        // DBに登録するデータ
        $data = array(
            'name' => $params['name'],
            'listNum' => $params['listNum'],
            'period' => $params['period'],
            'created' => date('Y-m-d H:i:s'),
            'modified' => date('Y-m-d H:i:s'),
        );

        // DBに登録
        $todo->insert($data);

        $this->_redirect("/list/".$params['listNum']."/");

    }

    // ステータスの変更処理(AJAX)
    public function changestatusAction()
    {
        $params = $this->getRequest()->getParams();

        // IDからTodoのステータスを取得
        $todo = new Default_Model_TodoDetail();
        if(empty($params['id'])) {
            throw new Exception('処理に失敗しました');
        }
        $status = $todo->getStatusById($params['id']);

        if($status['status'] == '0')
        {
            $changeStatus = 1;
        }
        elseif($status['status'] == '1')
        {
            $changeStatus = 0;
        }

        // 変更するデータ
        $data = array(
            'status' => $changeStatus,
            'modified' => date('Y-m-d H:i:s')
        );
        $where = $todo->getAdapter()->quoteInto('id = ?', $params['id']);
        $todo->update($data, $where);

    }

    // Todoの削除処理(AJAX)
    public function deleteAction()
    {
        $params = $this->getRequest()->getParams();
        if(empty($params['id'])) {
            throw new Exception('処理に失敗しました');
        }

        // IDからTodoを削除
        $todo = new Default_Model_TodoDetail();
        $where = $todo->getAdapter()->quoteInto('id = ?', $params['id']);
        $todo->delete($where);
    }

    // 検索ページ
    public function searchAction()
    {
        $params = $this->getRequest()->getParams();

        // フォームを設定
        // 検索フォーム
        $searchForm = new Default_Model_Form_Form();
        $searchForm->setBaseForm('searchForm', '/index/searchexecute/');
        $searchForm->setSearchFormElement();
        $this->view->searchForm = $searchForm;

        return $this->render('search');
    }

    // 検索処理(AJAX)
    public function searchexecuteAction()
    {
        // VIEW表示をカット
        $this->_helper->viewRenderer->setNoRender();

        $params = $this->getRequest()->getParams();

        // DBから検索
        $list = new Default_Model_TodoList();
        $listData = $list->getTodoList($params);

        $todo = new Default_Model_TodoDetail();
        $todoData = $todo->getTodo($params);

        $string = '';
        if(!empty($todoData))
        {
            $todoCnt = count($todoData);
            $this->view->todoCnt = $todoCnt;
            $this->view->todoData = $todoData;

            $string .= '<p class="attention_txt">Todoが'.$todoCnt.'件見つかりました</p>';
            $todoView = '';
            foreach($todoData as $todo) {
                $todoView .= '
                <li class="list_box">
                    <dl>
                        <dt><a href="/list/'.$todo['listNum'].'/">'.$todo['name'].'</a></dt>
                        <dd>
                            リスト：'.$todo['listName'].'
                        </dd>
                        <dd>
                            期限：'.$todo['period'].'
                        </dd>
                        <dd>
                            作成日：'.$todo['created'].'
                        </dd>
                    </dl>
                </li>
                ';
            }
            $string .= '<ul id="list">'.$todoView.'</ul>';
        }
        else
        {
            $string .= '<p class="attention_txt">対象のTodoは見つかりません</p>';
        }

        if(!empty($listData))
        {
            $listCnt = count($listData);
            $this->view->listCnt = $listCnt;
            $this->view->listData = $listData;

            $string .= '<p class="attention_txt">Todoリストが'.$listCnt.'件見つかりました</p>';
            $listView = '';
            foreach((array)$listData as $list) {
                $listView .= '
                <li class="list_box">
                    <dl>
                        <dt><a href="/list/'.$list['listId'].'/">'.$list['listName'].'</a></dt>
                        <dd>
                            作成日：'.$list['listCreated'].'
                        </dd>
                    </dl>
                </li>
                ';
            }
            $string .= '<ul id="list2">'.$listView.'</ul>';
        }
        else
        {
            $string .= '<p class="attention_txt">対象のTodoリストは見つかりません</p>';
        }

        echo $string;
    }

}
