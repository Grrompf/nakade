<?php
/**
 * Module Blog
 *
 * Content site showing imprint and contacte data.
 * laguage file set in bootstrap
 *
 * @author  Dr. Holger Maerz <holger@spandaugo.de>
 *
 */

// module/Blog/Module.php
namespace Blog;

// Add these import statements:
use Blog\Model\Blog;
use Blog\Model\BlogTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Blog\Model\BlogTable' =>  function($serviceManager) {
                    $tableGateway = $serviceManager->get('BlogTableGateway');
                    $table = new BlogTable($tableGateway);
                    return $table;
                },
                'BlogTableGateway' => function ($serviceManager) {
                    $dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Blog());
                    return new TableGateway(
                        'wp_posts', $dbAdapter, null, $resultSetPrototype
                    );
                },
            ),
        );
    }


}

