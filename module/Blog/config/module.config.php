<?php

return array(
    'controllers' => array(
        'invokables' => array(
            // service name => controller name
            'Blog\Controller\Posts' => 'Blog\Controller\PostsController',
        ),
    ),
    'router' => array(
        'routes' => array(
            // blog是路由的名称
            'blog' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/blog[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Posts', // 对应上面的service name
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'blog' => __DIR__ . '/../view',
        ),
    ),
);