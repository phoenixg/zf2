<?php

namespace Blog\Model;

class Posts
{
	// table gateway模式: 每一条数据就是一个album对象
	// 对象的属性值就是数据表的字段
    public $id;
    public $title;
    public $content;
    public $addtime;

    public function exchangeArray($data)
    {
        $this->id       = (!empty($data['id'])) ? $data['id'] : null;
        $this->title    = (!empty($data['title'])) ? $data['title'] : null;
        $this->content  = (!empty($data['content'])) ? $data['content'] : null;
        $this->addtime  = (!empty($data['addtime'])) ? $data['addtime'] : null;
    }
}