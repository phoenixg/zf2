<?php
// 配置表单
namespace Blog\Form;

use Zend\Form\Form;

class PostsForm extends Form
{
    public function __construct()
    {
        parent::__construct('blog-posts');

        $this->add(array(
            'name' => 'id',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'title',
            'type' => 'Text',
            'options' => array(
                'label' => '标题',
            ),
        ));
        $this->add(array(
            'name' => 'content',
            'type' => 'Textarea',
            'options' => array(
                'label' => '内容',
            ),
        ));
        $this->add(array(
            'name' => 'addtime',
            'type' => 'Text',
            'options' => array(
                'label' => '发布日期',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '发布',
                'id' => 'submitbutton',
            ),
        ));
    }
}