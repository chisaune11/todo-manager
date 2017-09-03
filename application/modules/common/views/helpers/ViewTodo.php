<?php
/**
 *
 */
class Common_View_Helper_ViewTodo extends Zend_View_Helper_Abstract
{

    /**
     * テーブルから取得したデータを表示する
     *
     * @param unknown_type $row
     * @param unknown_type $key
     */
    public function viewTodo($row, $key = '', $options=array())
    {
        $re = '';
        switch ($key) {
            case 'todoName':
                $re = $row['name'];
                break;

            case 'period':
            case 'created':
                $re = date('Y年m月d日', strtotime($row[$key]));
                break;

            case 'status':
                if($row[$key] === '0')
                {
                    $re = '未完了';
                }
                elseif($row[$key] === '1')
                {
                    $re = '完了';
                }
                break;

            default:
                $re = $row[$key];
                break;
        }
        return $re;
    }
}
