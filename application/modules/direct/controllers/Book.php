<?php
/**
 * GEMINI
 * Gemini_Book
 * Copyright (c) 2011 iii-planning.com
 */

use Gemini\Table\BookTable;
use Gemini\Table\BookIndexTable;
use Gemini\Table\SectionTable;
use Gemini\Table\LanguageTable;
use Gemini\Xml\Xml;
class Book
{
    public function getBookList($id, $page, $start, $size)
    {
        $results = BookTable::getBookList($id, $page, $start, $size);
        $total = BookTable::getBookListCount($id);

        return array(
            'total' => $total->cnt,
            'books' => $results
        );
    }



    /*
    * $request is stdClass
    * start    int
    * page     int
    * start    int
    * limit    int
    * filters  str
    */
    public function viewGrid($request)
    {
        $start   = isset($request->start)  ? $request->start  :  0;
        $limit   = isset($request->limit)  ? $request->limit  : 200;
        $sort    = isset($request->sort)   ? $request->sort   : '';
        $dir     = isset($request->dir)    ? $request->dir    : 'ASC';
        $filters = isset($request->filter) ? $request->filter : null;

        if (is_array($filters)) {
            $encoded = false;
        } else {
            $encoded = true;
            $filters = json_decode($filters);
        }

        $where = $this->fetchListQuery($filters);

        $results =  BookTable::fetchList($start, $limit, $where);
        $count   =  BookTable::fetchListCount($where)->row;

        $Books = array();
        $i = 0;
        foreach($results as $result) {
            $date = $result->created;
            $ar = explode(' ', $date);
            $result->created = $ar[0];
            // $result->id = $i;
            $Books[] = $result;
            $i++;
        }

        return array('data'=>$Books, 'totalCount'=>$count);
    }



    public function usedBookList($request)
    {
        if(!isset($request->section_id)) {
            return array();
        }

        $bookIndexes = BookIndexTable::fetchAllBySection_id($request->section_id);

        if(count($bookIndexes) > 0) {
            $books = array();
            $data = array();

            foreach($bookIndexes as $bi) {

                $book = BookTable::fetchById($bi->book_id);

                if(!in_array($book->name, $books)) {
                    $books[] = $book->name;
                    $data[] = array(
                        'text' => $book->name,
                        'leaf' => true
                    );
                }
            }
        } else {
            $data[] = array(
                'text' => 'Nothing!',
                'leaf' => true
            );
        }

        return $data;
    }



    /**
     * @role publisher
     */
    public function nameChecker($request)
    {
        $value = $request->value;
        $book = BookTable::fetchByName($value);

        if($book) {
            return array('success' => false);
        } else {
            return array('success' => true);
        }
    }



    /**
     * @role publisher
     */
    public function titleChecker($request)
    {
        $value = $request->value;
        $book = BookTable::fetchByTitle($value);

        if($book) {
            return array('success' => false);
        } else {
            return array('success' => true);
        }
    }



    /**
     * @formHandler
     * @role publisher
     */
    public function create($request)
    {
        try {
            $conn = Zend_Registry::get('conn');
            $conn->beginTransaction();

            $sql = '
                INSERT
                INTO book
                (name, title, language_id, book_type_id, single, is_active, created_at)
                VALUES (:name, :title, :lang_id, :type_id, :single, :active, :create)';

            $stmt = $conn->prepare($sql);
            $stmt->execute(
                array(
                    'name' => $request['bookName'],
                    'title' => $request['bookTitle'],
                    'lang_id' => $request['language'],
                    'type_id' => $request['indexGroup'],
                    'single' => true,
                    'active' => true,
                    'create' => date('Y-m-d H:i:s', time())
                )
            );

            $stmt->closeCursor();

            $book = BookTable::fetchById($conn->lastInsertId());
            $language = LanguageTable::fetchById($request['language']);

            $name = Xml::generateName();
            $name_full = $name . '-0' . $language->lang;

            $sql = 'INSERT
                INTO section
                (name, name_full, rev, title, language_id, maintenance, book, created_at)
                VALUES (:name, :full, :rev, :title, :lang, :main, :book, :create)';

            $stmt = $conn->prepare($sql);
            $stmt->execute(
                array(
                    'name' => $name,
                    'full' => $name_full,
                    'rev' => '0',
                    'title' => $request['rootName'],
                    'lang' => $request['language'],
                    'main' => true,
                    'book' => $book->id,
                    'create' => date('Y-m-d H:i:s', time())
                )
            );

            $stmt->closeCursor();

            $section = SectionTable::fetchById($conn->lastInsertId());

            $content = Xml::generateBlankSection($request['rootName'], $language->lang, $name_full);
            $content = '[' . $name_full . ']' . $content;

            $sql = 'INSERT
                INTO section_xml_content
                (section_id, content, created_at)
                VALUES (:id, :content, :create)';

            $stmt = $conn->prepare($sql);
            $stmt->execute(
                array(
                    'id' => $section->id,
                    'content' => $content,
                    'create' => date('Y-m-d H:i:s', time())
                )
            );

            $stmt->closeCursor();

            $sql = 'INSERT
                INTO book_index
                (book_id, section_id, lft, rgt, level, created_at)
                VALUES (:book, :sec, :lft, :rgt, :level, :create)';

            $stmt = $conn->prepare($sql);
            $stmt->execute(
                array(
                    'book' => $book->id,
                    'sec' => $section->id,
                    'lft' => 1,
                    'rgt' => 2,
                    'level' => 0,
                    'create' => date('Y-m-d H:i:s', time())
                )
            );

            $conn->commit();

        } catch (Exception $e) {

            $conn->rollBack();
            return array('success' => false, 'error' => $e->getMessage());

        }
        return array('success' => true, 'book_id' => $book->id, 'book_name' => $book->name);
    }



    /**
     * @formHandler
     * @role publisher
     */
    public function update($request)
    {
        var_dump($request);exit();
    }



    /**
     * @role publisher
     */
    public function getData($request)
    {
        $book_id = $request->book;
        $book = BookTable::fetchById($book_id);

        return array(
            'success' => true,
            'data' => $book
        );
    }



    /**
     * @role publisher
     */
    public function getModel($book)
    {
        try {
            $sql = 'SELECT b_mn.model_name_id AS id
                FROM b_mn
                WHERE b_mn.book_id = ?
                ORDER BY b_mn.rank_order ASC';

            $conn = \Zend_Registry::get('conn');
            $stmt = $conn->prepare($sql);
            $stmt->execute(array($book));

            $results = $stmt->fetchAll();
            $models = array();

            foreach($results as $r) {
                $models[] = $r->id;
            }

        } catch (Exception $e) {
            throw $e;
        }

        return $models;
    }



    public function setModel($book, $val)
    {
        $val  = urldecode(substr($val, strpos($val, '=') + 1));
        $vals = explode(',', $val);

        $this->modelClear($book);

        $sql = '
            INSERT INTO `b_mn` (book_id, destination_id, rank_order)
            VALUES (?, ?, ?)
        ';
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare($sql);
            $i = 0;
            foreach($vals as $val) {
                $stmt->execute(array($book, $val, $i));
                $i++;
            }

            $this->pdo->commit();
        } catch(Exception $e) {
            $this->pdo->rollback();
            return $e;

        }


        return array('success'=>true);
    }



    private function modelClear($book)
    {
        $sql = '
            DELETE FROM `b_mn` WHERE book_id = ?
        ';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array($book));
    }



    public function getDest($book)
    {
        $sql = '
            SELECT
            d.id
            FROM book b
            INNER JOIN b_d ON b.id = b_d.book_id
            INNER JOIN destination d ON b_d.destination_id = d.id
            WHERE b_d.book_id = ?
        ';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array($book));
        $rets = $stmt->fetchAll(PDO::FETCH_OBJ);
        $model = array();
        foreach($rets as $ret) {
            $model[] = $ret->id;
        }

        return $model;
    }



    public function setDest($book, $val)
    {
        $val  = urldecode(substr($val, strpos($val, '=') + 1));
        $vals = explode(',', $val);

        $this->destClear($book);

        $sql = '
            INSERT INTO `b_d` (book_id, destination_id)
            VALUES (?, ?)
        ';
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare($sql);
            foreach($vals as $val) {
                $stmt->execute(array($book, $val));
            }

            $this->pdo->commit();
        } catch(Exception $e) {
            $this->pdo->rollback();
            return $e;

        }


        return array('success'=>true);
    }



    private function destClear($book)
    {
        $sql = '
            DELETE FROM `b_d` WHERE book_id = ?
        ';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(array($book));
    }



    public function getLang($book)
    {
        $results = $this->row(
            array(
                'query' => $this->retrieveBooksDest(),
                'bind'  => array(':book' => $book)
            )
        );
        foreach($results as $result) {
            $model[] = $result['id'];

        }

        return $model;
    }



    private function fetchListQuery($filters)
    {
        $f = array(
            'book_id'=>'b.name',
            'title'=>'b.title',
            'model_name'=>'model_name.name',
            'dest'=>'dest.name',
            'language'=>'l.lang'
        );
        $where = '';
        $qs    = '';
        // loop through filters sent by client
        if (is_array($filters)) {
            for ($i=0; $i<count($filters); $i++) {
                $filter = $filters[$i];

                $field      = $f[$filter->field];
                $value      = $filter->value;
                $compare    = isset($filter->comparison) ? $filter->comparison : null;
                $filterType = $filter->type;

                switch ($filterType) {
                    case 'string' : $qs .= " AND ".$field." LIKE '%".$value."%'"; Break;
                    case 'list' :
                        if (strstr($value,',')){
                            $fi = explode(',',$value);
                            for ($q=0;$q<count($fi);$q++){
                                $fi[$q] = "'".$fi[$q]."'";
                            }
                            $value = implode(',',$fi);
                            $qs .= " AND ".$field." IN (".$value.")";
                        } else {
                            $qs .= " AND ".$field." = '".$value."'";
                        }
                    Break;
                    case 'boolean' : $qs .= " AND ".$field." = ".($value); Break;
                    case 'numeric' :
                        switch ($compare) {
                            case 'eq' : $qs .= " AND ".$field." = ".$value; Break;
                            case 'lt' : $qs .= " AND ".$field." < ".$value; Break;
                            case 'gt' : $qs .= " AND ".$field." > ".$value; Break;
                        }
                    Break;
                    case 'date' :
                        switch ($compare) {
                            case 'eq' : $qs .= " AND ".$field." = '".date('Y-m-d',strtotime($value))."'"; Break;
                            case 'lt' : $qs .= " AND ".$field." < '".date('Y-m-d',strtotime($value))."'"; Break;
                            case 'gt' : $qs .= " AND ".$field." > '".date('Y-m-d',strtotime($value))."'"; Break;
                        }
                    Break;
                }
            }
            $where .= $qs;

            return $where;
        }
    }


///////  書き出し系

    // {{{ makeBook($book)

    public function makeBook()
    // public function makeBook($book)
    {
$a = new BaseXml;


    }

    // }}}
}
