<?php

namespace Blog\Model;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
class Posts implements InputFilterAwareInterface
{
	// table gateway模式: 每一条数据就是一个album对象
	// 对象的属性值就是数据表的字段
    public $id;
    public $title;
    public $content;
    public $addtime;

    protected $inputFilter;

    // exchangeArray方法用于结合table gateway使用
    public function exchangeArray($data)
    {
        $this->id       = (!empty($data['id'])) ? $data['id'] : null;
        $this->title    = (!empty($data['title'])) ? $data['title'] : null;
        $this->content  = (!empty($data['content'])) ? $data['content'] : null;
        $this->addtime  = (!empty($data['addtime'])) ? $data['addtime'] : time();
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'content',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'addtime',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));


            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}