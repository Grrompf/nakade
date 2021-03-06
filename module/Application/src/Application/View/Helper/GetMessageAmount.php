<?php
namespace Application\View\Helper;
use Message\Services\RepositoryService;

/**
 * Class GetMessageAmount
 *
 * @package Application\View\Helper
 */
class GetMessageAmount extends DefaultViewHelper
{

    /**
     * @return int
     */
    public function __invoke()
    {
        $uid = $this->getIdentity()->getId();
        return $this->getMapper()->getNumberOfNewMessages($uid);
    }

    /**
     * @return \Message\Mapper\MessageMapper
     */
    private function getMapper()
    {
        /* @var $repository \Message\Services\RepositoryService */
        $repository = $this->getService('Message\Services\RepositoryService');
        return $repository->getMapper(RepositoryService::MESSAGE_MAPPER);
    }

}
