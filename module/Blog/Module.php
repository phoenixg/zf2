<?php

namespace Blog;

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

}