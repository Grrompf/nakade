<?php
namespace League\Statistics\Tiebreaker;

use League\Statistics\Results as RESULT;
use League\Statistics\AbstractGameStats;

/**
 * Calculating Hahn-Points. The Hahn points are referred by Prof. Hahn from
 * the Myongji University, Seoul - Korea.
 * A counted result below the offset consequently ends in points for both
 * players. While the looser will get the difference, the winner will receive
 * the board point added to the offset.
 * Results exceeding the offset, as well as resignation, forfeit will provide
 * the winner the maximum points.
 * The benefit of this tiebreaker are the advantage of close games for the
 * looser, while a total defeat will give a bonus to the winner.
 *
 * @author Dr.Holger Maerz <holger@nakade.de>
 */
class HahnPoints extends AbstractGameStats implements TiebreakerInterface
{

    const MAX_POINTS=40;
    const OFFSET_POINTS=20;

    /**
    * @var AbstractGameStats
    */
    private static $instance =null;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->setName('Hahn');
        $this->setDescription('Hahn Points');
    }

   /**
    * Singleton Pattern for preventing object inflation.
    * @return AbstractGameStats
    */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new HahnPoints();
        }

        return self::$instance;
    }

    /**
     * calculating the points
     *
     * @param int $playerId
     *
     * @return int
     */
    public function getTieBreaker($playerId)
    {

        $count=0;
        foreach ($this->getMatches() as $match) {


            if (null === $match->getResultId() ||
               $match->getResultId() == RESULT::SUSPENDED ||
               $match->getResultId() == RESULT::DRAW) {
               continue;
            }

            if ($match->getResultId()==RESULT::BYPOINTS   &&
               $match->getWinnerId()==$playerId ) {

               $count += $match->getPoints()+self::OFFSET_POINTS;

               continue;
            }

            if ($match->getResultId() == RESULT::BYPOINTS &&
               $match->getPoints() < self::OFFSET_POINTS  &&
               ($match->getBlackId() == $playerId ||
                $match->getWhiteId() == $playerId )) {

               $count += self::OFFSET_POINTS - $match->getPoints();
               continue;
            }

            if ($match->getWinnerId() == $playerId ) {
               $count +=self::MAX_POINTS;
            }
        }
        return $count;
    }
}