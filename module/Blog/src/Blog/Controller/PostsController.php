<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Blog\Model\Posts;      
use Blog\Form\PostsForm;    

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
        $form = new PostsForm();
        $form->get('submit')->setValue('添加');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = new Posts();
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $post->exchangeArray($form->getData());
                $this->getPostsTable()->savePosts($post);

                return $this->redirect()->toRoute('blog');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('blog', array(
                'action' => 'add'
            ));
        }

        try {
            $post = $this->getPostsTable()->getPosts($id);            
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('blog', array(
                'action' => 'index'
            ));
        }

        $form  = new PostsForm();
        $form->bind($post);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getPostsTable()->savePosts($post);

                return $this->redirect()->toRoute('blog');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('blog');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getPostsTable()->deletePosts($id);
            }

            return $this->redirect()->toRoute('blog');
        }

        return array(
            'id'    => $id,
            'post' => $this->getPostsTable()->getPosts($id)
        );
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