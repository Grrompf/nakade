<?php

namespace League\Services;

use League\Controller\ResultController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class ResultControllerFactory
 *
 * @package League\Services
 */
class ResultControllerFactory implements FactoryInterface
{

    /**
     * @param ServiceLocatorInterface $services
     *
     * @return ResultController|mixed
     */
    public function createService(ServiceLocatorInterface $services)
    {
        $serviceManager = $services->getServiceLocator();

        $repository = $serviceManager->get('League\Services\RepositoryService');
        $factory = $serviceManager->get('League\Services\LeagueFormService');
        $mail = $serviceManager->get('League\Services\MailService');
        $voter = $serviceManager->get('League\Services\MatchVoterService');
        $resultService = $serviceManager->get('League\Services\ResultService');
        $pagination = $serviceManager->get('League\Services\PaginationService');


        $controller = new ResultController();

        $controller->setFormFactory($factory);
        $controller->setRepository($repository);
        $controller->setMailService($mail);
        $controller->setService($voter);
        $controller->setResultService($resultService);
        $controller->setPaginationService($pagination);

        return $controller;
    }
}
