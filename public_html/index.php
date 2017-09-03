<?php
// 環境のディレクトリ区切り文字をコンパクトに定義
define("DS", DIRECTORY_SEPARATOR);

// パス定数定義
define("PATH_ZEND_LIBRARY", realpath("../library"));
define("PATH_APPLICATION" , realpath("../application"));
define("PATH_APPLICATION_CONFIG" , realpath("../application/configs"));
define("PATH_APPLICATION_MODULE" , realpath("../application/modules"));

define("PATH_CONTROLLERS", PATH_APPLICATION . DS . "controllers");
define("PATH_VIEWS" , PATH_APPLICATION . DS . "views");
define("PATH_MODELS" , PATH_APPLICATION . DS . "models");

// エンビューロメントの定義（環境切り替え用 .htaccessに記述）
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// define("PATH_UTIL" , PATH_APPLICATION . DS . "util");
// define("PATH_SYS" , PATH_APPLICATION . DS . "sys");

// 自動呼び出しクラス置き場のパスを通す
$path = implode(PATH_SEPARATOR, array(
    PATH_ZEND_LIBRARY,
    PATH_APPLICATION,
    PATH_MODELS,
));
set_include_path($path);

// PHPエラー出力レベル
error_reporting(E_ALL ^E_NOTICE ^E_DEPRECATED ^E_STRICT);
// レイアウトの設定
// require_once 'Zend/Layout.php';
// Zend_Layout::startMvc(array('layoutPath' => PATH_APPLICATION . '/layouts/scripts/'));

// オートローダー設定
require_once 'Zend/Loader/Autoloader.php';
$instance = Zend_Loader_Autoloader::getInstance();
$instance->setFallbackAutoloader(true);

// アプリケーション及びブートストラップを作成して、実行
$application = new Zend_Application(
    APPLICATION_ENV,
    PATH_APPLICATION . '/configs/application.ini'
);
$application->bootstrap()
            ->run();

// // コントローラーの定義
// $front = Zend_Controller_Front::getInstance();
// // レイアウトの設定
// Zend_Layout::startMvc(array('layoutPath' => PATH_APPLICATION . '/layouts/scripts/'));
// // echo 'It Works!!!!!';
// $front->setControllerDirectory(PATH_CONTROLLERS);
// $front->setDefaultControllerName('index');
// $front->setDefaultAction('index');
// $front->setParam('useDefaultControllerAlways', true);
// $front->dispatch();


// クラス呼び出し自動化関数定義
// function __autoload($class) {
//   include str_replace('_', DS, $class) . '.php';
// }

?>
