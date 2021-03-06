<?php
namespace Season\Mapper;

use Nakade\Abstracts\AbstractMapper;
use Doctrine\ORM\Query\Expr\Join;
use \Doctrine\ORM\Query;

/**
 * Class LeagueMapper
 *
 * @package Season\Mapper
 */
class LeagueMapper extends AbstractMapper
{

    /**
     * @param int $leagueId
     *
     * @return \Season\Entity\League
     */
    public function getLeagueById($leagueId)
    {
        return $this->getEntityManager()
            ->getRepository('Season\Entity\League')
            ->find($leagueId);
    }

    /**
     * @param int $seasonId
     *
     * @return array
     */
    public function getLeaguesBySeason($seasonId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('l')
            ->from('Season\Entity\League', 'l')
            ->leftJoin('Season\Entity\Season', 's', Join::WITH, 'l.season = s')
            ->where('s.id = :seasonId')
            ->setParameter('seasonId', $seasonId);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $seasonId
     *
     * @return int
     */
    public function getNewLeagueNoBySeason($seasonId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('League');
        $qb->select('max(l.number)')
            ->from('Season\Entity\League', 'l')
            ->leftJoin('Season\Entity\Season', 's', Join::WITH, 'l.season = s')
            ->where('s.id = :seasonId')
            ->addOrderBy('l.number', 'DESC')
            ->setParameter('seasonId', $seasonId);

        return intval($qb->getQuery()->getResult(Query::HYDRATE_SINGLE_SCALAR)) +1;
    }

    /**
     * @param int $seasonId
     *
     * @return array
     */
    public function getAssignedLeaguesBySeason($seasonId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('League');
        $qb->select('l.id')
            ->from('Season\Entity\Participant', 'p')
            ->innerJoin('p.league', 'l')
            ->innerJoin('l.season', 's')
            ->where('s.id = :seasonId')
            ->groupBy('l.id')
            ->setParameter('seasonId', $seasonId);

        $result = $qb->getQuery()->getResult();
        return $this->getIdArray($result);
    }

    /**
     * @param int $seasonId
     *
     * @return array
     */
    public function getEmptyLeaguesBySeason($seasonId)
    {
        $notIn = $this->getAssignedLeaguesBySeason($seasonId);

        $qb = $this->getEntityManager()->createQueryBuilder('League');
        $qb->select('l')
            ->from('Season\Entity\League', 'l')
            ->innerJoin('l.season', 'season')
            ->where($qb->expr()->notIn('l.id', $notIn))
            ->andWhere('season.id = :seasonId')
            ->setParameter('seasonId', $seasonId);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $leagueId
     *
     * @return array
     */
    public function getAssignedPlayersByLeague($leagueId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('League');
        $qb->select('p')
            ->from('Season\Entity\Participant', 'p')
            ->leftJoin('Season\Entity\League', 'l', Join::WITH, 'p.league = l')
            ->where('l.id = :leagueId')
            ->setParameter('leagueId', $leagueId);

        return $qb->getQuery()->getResult();


    }

    /**
     * @param int $leagueId
     *
     * @return int
     */
    public function getNoPlayersByLeague($leagueId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder('League');
        $qb->select('count(p)')
            ->from('Season\Entity\Participant', 'p')
            ->leftJoin('Season\Entity\League', 'l', Join::WITH, 'p.league = l')
            ->where('l.id = :leagueId')
            ->setParameter('leagueId', $leagueId);

        return intval($qb->getQuery()->getResult(Query::HYDRATE_SINGLE_SCALAR));
    }

    /**
     * leagues and number of assigned players
     *
     * @param int $seasonId
     *
     * @return array
     */
    public function getLeagueInfoBySeason($seasonId)
    {
        $leagues = $this->getLeaguesBySeason($seasonId);

        /* @var $league \Season\Entity\League */
        foreach ($leagues as $league) {
            $noPlayers = $this->getNoPlayersByLeague($league->getId());
            $league->setNoPlayers($noPlayers);
        }

        return $leagues;
    }

    /**
     * @param int $leagueId
     * @param int $uid
     *
     * @return array
     */
    public function getPlayerScheduleByLeague($leagueId, $uid)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder('Match')
            ->select('m')
            ->from('Season\Entity\Match', 'm')
            ->innerJoin('m.league', 'League')
            ->innerJoin('m.white', 'White')
            ->innerJoin('m.black', 'Black')
            ->where('(League.id = :leagueId)')
            ->andWhere('(White.id = :uid OR Black.id = :uid)')
            ->setParameter('leagueId', $leagueId)
            ->setParameter('uid', $uid)
            ->orderBy('m.date', 'ASC');

        return $qb->getQuery()->getResult();

    }

    /**
     * @param array $result
     *
     * @return array
     */
    private function getIdArray(array $result) {

        $idArray = array();
        foreach ($result as $item) {
            $idArray[] = $item['id'];
        }
        if (empty($idArray)) {
            $idArray[]=0;
        }

        return array_unique($idArray);
    }
}