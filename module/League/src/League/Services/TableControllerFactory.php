<?php

namespace League\Services;

use League\Controller\TableController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class TableControllerFactory
 *
 * @package League\Services
 */
class TableControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $services
     *
     * @return TableController|mixed
     */
    public function createService(ServiceLocatorInterface $services)
    {

        $serviceManager = $services->getServiceLocator();


        $repository = $serviceManager->get('League\Services\RepositoryService');
        $standings  = $serviceManager->get('Nakade\Services\PlayersTableService');

        $controller = new TableController();
        $controller->setRepository($repository);
        $controller->setService($standings);

        return $controller;
    }
}
