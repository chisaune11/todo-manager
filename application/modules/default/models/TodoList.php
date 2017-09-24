<?php
/**
 * todo_listテーブルクラス
 */
class Default_Model_TodoList extends Zend_Db_Table_Abstract
{

    protected $_name = 'todo_list';

    // TodoリストのIDを全件取得
    public function getAllListId()
    {
        $query = "
            SELECT
                id
            FROM
                $this->_name
                ";
        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // IDからTodoリストを１件取得
    public function getAddedTodoById($id)
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
        $query .= $this->_db->quoteInto('id = ?', $id);

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetch();
    }

    // TodoリストのIDからリスト名取得
    public function getListNameByIds($ids)
    {
        if(empty($ids))
        {
            return array();
        }

        $query = "
            SELECT
                name
            FROM
                $this->_name
            WHERE
                ";
        $query .= $this->_db->quoteInto('id IN (?)', $ids);

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // TodoリストのIDからリスト名取得
    public function getListNameById($id)
    {
        if(empty($id))
        {
            return array();
        }

        $query = "
            SELECT
                name
            FROM
                $this->_name
            WHERE
                ";
        $query .= $this->_db->quoteInto('id = ?', $id);

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchcolumn();
    }

    // TodoリストIDからTodoのデータを取得
    public function getTodoByIds($ids)
    {
        if(empty($ids))
        {
            return array();
        }

        $query = "
            SELECT
                list.id AS listId,
                list.name AS listName,
                COUNT(detail.id) AS allCnt
            FROM
                $this->_name AS list
            LEFT OUTER JOIN
                todo_detail AS detail
            ON
                list.id = detail.listNum
            WHERE
            ";
        $query .= $this->_db->quoteInto('list.id IN (?)', $ids);

        $query .= 'GROUP BY list.id';

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // リストIDから未完了のTodoと期限を取得
    public function getYetTodoByIds($ids)
    {
        if(empty($ids))
        {
            return array();
        }

        $query = "
            SELECT
                list.id AS listId,
                count(detail.id) AS yetCnt,
                detail.period
            FROM
                $this->_name AS list
            LEFT JOIN
                todo_detail AS detail
            ON
                list.id = detail.listNum AND detail.period >= now()
            WHERE
                detail.status = '0'
            ";
        $query .= $this->_db->quoteInto(' AND list.id IN (?)', $ids);
        $query .= ' GROUP BY list.id';
        $query .= ' ORDER BY detail.created DESC';

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // 検索
    public function getTodoList($option = array())
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
                id AS listId,
                name AS listName,
                created AS listCreated
            FROM
                $this->_name
            WHERE
        ";
        if(!empty($option['name'])) {
            $query .= 'name LIKE "%'.$str.'%"';
        }
        $query .= ' ORDER BY created DESC';

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
            $query .= $this->_db->quoteInto('name = "?"', $name);
        }
        $query .= ' LIMIT 1';

        $stmt = $this->_db->prepare($query);
        $stmt->execute();

        return $stmt->fetchcolumn();
    }
}
