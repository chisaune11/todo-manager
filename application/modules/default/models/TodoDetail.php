<?php
/**
 * todo_detailテーブルクラス
 */
class Default_Model_TodoDetail extends Zend_Db_Table_Abstract
{

    protected $_name = 'todo_detail';

    public function getTodoCntById($ids)
    {
        if(empty($ids))
        {
            return array();
        }

        $query = "
            SELECT
                COUNT(id) AS allCnt,
                listNum
            FROM
                $this->_name
            WHERE
            ";
        $query .= $this->_db->quoteInto('listNum IN (?)', $ids);
        $query .= ' GROUP BY listNum';

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getTodoAllById($id)
    {
        if(empty($id))
        {
            return array();
        }

        $query = "
            SELECT
                *
            FROM
                $this->_name
            WHERE
            ";
        $query .= $this->_db->quoteInto('listNum = ?', $id);
        $query .= ' ORDER BY created DESC';

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getStatusById($id)
    {
        if(empty($id))
        {
            return array();
        }

        $query = "
            SELECT
                status
            FROM
                $this->_name
            WHERE
            ";
        $query .= $this->_db->quoteInto('id = ?', $id);

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchcolumn();
    }

    public function getTodo($option = array())
    {
        if(empty($option))
        {
            return array();
        }

        // エスケープ処理
        if(!empty($option['name'])) {
            $str = str_replace(
                array('%', '_', '\\'),
                array('\%', '\_', '\\\\'),
                $option['name']
            );
        }

        $query = "
            SELECT
                detail.id,
                detail.name,
                detail.period,
                detail.created,
                list.name AS listName
            FROM
                $this->_name AS detail
            LEFT JOIN
                todo_list AS list
            ON
                detail.listNum = list.id
            WHERE
        ";
        if(!empty($option['name'])) {
            $query .= 'detail.name LIKE "%'.$str.'%"';
        }
        $query .= ' ORDER BY detail.created DESC';

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // 同じ名前のリストを検索
    public function getSameName($name)
    {
        $query = "
            SELECT
                id
            FROM
                $this->_name
            WHERE
            ";
        if(!empty($name)) {
            $query .= $this->_db->quoteInto('name = ?', $name);
        }
        $query .= ' LIMIT 1';

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchcolumn();
    }

}
