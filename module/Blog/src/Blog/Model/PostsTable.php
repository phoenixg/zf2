<?php
namespace Blog\Model;

use Zend\Db\TableGateway\TableGateway;

class PostsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getPosts($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function savePosts(Posts $posts)
    {
        $data = array(
            'title'   => $posts->title,
            'content' => $posts->content,
            'addtime' => $posts->addtime,
        );

        $id = (int)$posts->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getPosts($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Post id does not exist');
            }
        }
    }

    public function deletePosts($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}