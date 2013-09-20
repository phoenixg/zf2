<?php

namespace Blog;
use Blog\Model\Posts;
use Blog\Model\PostsTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module{
	// autoload config
    public function getAutoloaderConfig()
    {
        return array(
        	// class map autoload
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            // spl autoload
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    // module config
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    // service config
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Blog\Model\PostsTable' =>  function($sm) {
                    $tableGateway = $sm->get('PostsTableGateway');
                    $table = new PostsTable($tableGateway);
                    return $table;
                },
                'PostsTableGateway' => function ($sm) {
                    // 适配器模式
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    // 原型模式
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Posts());
                    // 第一个参数是表名
                    return new TableGateway('blog_posts', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }

}