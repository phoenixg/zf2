<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PostsController extends AbstractActionController
{
    protected $postsTable;

    public function indexAction()
    {
        // 因为是对象，所以里面的数据dump不出来
        \Zend\Debug\Debug::dump($this->getPostsTable()->fetchAll());

        // 因此可以用迭代器来显示出来
        \Zend\Debug\Debug::dump(iterator_to_array($this->getPostsTable()->fetchAll()));

        return new ViewModel(array(
            'posts' => $this->getPostsTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function getPostsTable()
    {
        if (!$this->postsTable) {
            // 获取service manager
            $sm = $this->getServiceLocator();
            // 通过service manager 获取 service ，这个service name是在Module.php 里配置了的
            $this->postsTable = $sm->get('Blog\Model\PostsTable');
        }
        return $this->postsTable;
    }
}