<?php
/**
 *
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    // ルーターの設定
    protected function _initRoute()
    {
        // ルータオブジェクトを取得
        $this->bootstrap('frontController');
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();

        // ルーティング設定
        // トップ（Todoリスト）
        $route = new Zend_Controller_Router_Route_Static(
            '/',
            array(
                'module'     => 'default',
                'controller' => 'index',
                'action'     => 'index'
            )
        );

        // 設定追加
        $router->addRoute('top', $route);

        // Todoリスト詳細
        $route = new Zend_Controller_Router_Route_Regex(
            'list/([0-9]+)',
            array(
                'module'     => 'default',
                'controller' => 'index',
                'action'     => 'detail'
            ),
            array(
                1 => 'listNum'
            )
        );

        $router->addRoute('detail', $route);

        // 検索
        $route = new Zend_Controller_Router_Route_Static(
            'search',
            array(
                'module'     => 'default',
                'controller' => 'index',
                'action'     => 'search'
            )
        );

        // 設定追加
        $router->addRoute('search', $route);

        // モジュールの設定
        $front->addModuleDirectory(PATH_APPLICATION.'/modules');
        // 共通モジュールへのパスを通す
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath'  => PATH_APPLICATION_MODULE.'/common',
            'namespace' => 'Common',
        ));
        $resourceLoader->addResourceType('Model', 'models', 'Model');

        // カレントモジュールへのパスを通す
        $req = $router->route(new Zend_Controller_Request_Http());
        $moduleName = $req->getModuleName();
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath' => PATH_APPLICATION_MODULE.'/'.$moduleName,
            'namespace' => ucfirst($moduleName),
        ));
        $resourceLoader->addResourceType('Model', 'models', 'Model');

        // $front->dispatch();

        return $router;
    }

    // レイアウトの設定
    protected function _initView()
    {
        // ビューを初期化
        $view = new Zend_View();
        $view->doctype('HTML5');
        $view->headMeta()
                ->setIndent(8)
                ->setCharset('UTF-8')
                ->appendHttpEquiv('X-UA-Compatible', 'IE=edge,chrome=1')
                ->appendName('viewport', 'width=device-width');
        $view->headTitle()
                ->setIndent(8)
                ->setSeparator('｜')
                ->append('ToDoリスト');
        $view->headLink()
                ->setIndent(8)
                // ->headLink(
                //     array('rel'  => 'favicon',
                //           'href' => $view->baseUrl('favicon.ico'),
                //           'type' => 'image/x-icon'),
                //           'PREPEND')
                // ->appendStylesheet(
                //     array('rel'  => 'stylesheet',
                //           'href' => $view->baseUrl('css/normalize.min.css'),
                //           'type' => 'text/css'))
                ->appendStylesheet(
                    array('rel'  => 'stylesheet',
                          'href' => $view->baseUrl('css/index.css'),
                          'type' => 'text/css'));
        // $view->headScript()
        //         ->setIndent(8)
        //         ->appendFile(
        //             $view->baseUrl('js/vendor/modernizr-2.6.2-respond-1.1.0.min.js'));

        // 共通ビューパス設定
        $view->addScriptPath(PATH_APPLICATION_MODULE.'/common/views/scripts');//コモンパス
        // $view->addScriptPath(PATH_APPLICATION_MODULE);//VIEW
        // $view->addScriptPath($_SERVER['DOCUMENT_ROOT']);//ドキュメントルート
        $view->addHelperPath(PATH_ZEND_LIBRARY.'/Zend/View/Helper/', 'Zend_View_Helper');//ヘルパーパス
        $view->addHelperPath(PATH_APPLICATION_MODULE.'/common/views/helpers/', 'Common_View_Helper');//ヘルパーパス

        // ViewRendererに追加
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        // ブートストラップで保存できるように返す
        return $view;

    }

    // データベース接続の設定
    protected function _initDb()
    {
        try{
            $options = new Zend_Config_Ini(PATH_APPLICATION_CONFIG.'/application.ini', 'todo_manager');
            // $options = new Zend_Config($this->getOptions());
            $dbConfig = $options->db;
            $dbConect = Zend_Db::factory($dbConfig->adapter, $dbConfig->params);
            Zend_Registry::set('db', $dbConect);
            Zend_Db_Table::setDefaultAdapter($dbConect);
        }catch(Exception $e){
            // エラー時
            echo '<html><head><meta http-equiv="content-type" content="text/html; charset=utf-8" />';
            echo '<title>エラー</title></head><body>';
            if ('production' == APPLICATION_ENV){
                echo '<h1>エラーです。</h1>';
            }else{
                echo '<h1>データベースに接続できません。</h1>';
                echo '<h3>Message</h3>';
                echo $e->getMessage();
                echo '<h3>File</h3>';
                echo $e->getFile();
                echo '<h3>Line</h3>';
                echo $e->getLine();
                echo '<h3>Trace</h3>';
                echo '<pre>';
                echo $e->getTraceAsString();
                echo '</pre>';
            }
            echo '</body></html>';
            exit;
        }
    }
}
