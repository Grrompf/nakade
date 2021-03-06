<?php
namespace Season\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SeasonModel
 *
 * @package Season\Entity
 *
 * @ORM\MappedSuperclass
 */
class SeasonModel
{
  /**
   * Primary Identifier
   *
   * @ORM\Id
   * @ORM\Column(name="id", type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Season\Entity\Association", cascade={"persist"})
     * @ORM\JoinColumn(name="association", referencedColumnName="id", nullable=false)
     */
    protected $association;

  /**
   * @ORM\Column(name="number", type="integer", nullable=false)
   */
    protected $number=1;

  /**
   * @ORM\Column(name="startDate", type="date", nullable=false)
   */
    protected $startDate;

   /**
   * @ORM\Column(name="winPoints", type="integer", nullable=false)
   */
    protected $winPoints=2;

    /**
     * @ORM\ManyToOne(targetEntity="\Season\Entity\TieBreaker", cascade={"persist"})
     * @ORM\JoinColumn(name="tieBreaker1", referencedColumnName="id", nullable=false)
     */
    protected $tieBreaker1;

    /**
     * @ORM\ManyToOne(targetEntity="\Season\Entity\TieBreaker", cascade={"persist"})
     * @ORM\JoinColumn(name="tieBreaker2", referencedColumnName="id", nullable=false)
     */
    protected $tieBreaker2;

    /**
     * @ORM\ManyToOne(targetEntity="\Season\Entity\TieBreaker", cascade={"persist"})
     * @ORM\JoinColumn(name="tieBreaker3", referencedColumnName="id", nullable=false)
     */
    protected $tieBreaker3;

    /**
     * @ORM\ManyToOne(targetEntity="\Season\Entity\Time", cascade={"persist"})
     * @ORM\JoinColumn(name="time", referencedColumnName="id", nullable=false)
     */
    protected $time;

    /**
     * @ORM\Column(name="komi", type="string")
     */
    protected $komi=6.5;

    /**
     * @ORM\Column(name="isReady", type="boolean")
     */
    protected $isReady=false;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param \DateTime $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param TieBreaker $tieBreaker1
     */
    public function setTieBreaker1(TieBreaker $tieBreaker1)
    {
        $this->tieBreaker1 = $tieBreaker1;
    }

    /**
     * @return TieBreaker
     */
    public function getTieBreaker1()
    {
        return $this->tieBreaker1;
    }

    /**
     * @param TieBreaker $tieBreaker2
     */
    public function setTieBreaker2(TieBreaker $tieBreaker2)
    {
        $this->tieBreaker2 = $tieBreaker2;
    }

    /**
     * @return TieBreaker
     */
    public function getTieBreaker2()
    {
        return $this->tieBreaker2;
    }

    /**
     * @param TieBreaker $tieBreaker3
     */
    public function setTieBreaker3(TieBreaker $tieBreaker3)
    {
        $this->tieBreaker3 = $tieBreaker3;
    }

    /**
     * @return TieBreaker
     */
    public function getTieBreaker3()
    {
        return $this->tieBreaker3;
    }

    /**
     * @param Association $association
     */
    public function setAssociation(Association $association)
    {
        $this->association = $association;
    }

    /**
     * @return Association
     */
    public function getAssociation()
    {
        return $this->association;
    }

    /**
     * @param int $winPoints
     */
    public function setWinPoints($winPoints)
    {
        $this->winPoints = $winPoints;
    }

    /**
     * @return int
     */
    public function getWinPoints()
    {
        return $this->winPoints;
    }

    /**
     * @param string $komi
     */
    public function setKomi($komi)
    {
        $this->komi = $komi;
    }

    /**
     * @return null|string
     */
    public function getKomi()
    {
        return $this->komi;
    }

    /**
     * @return bool
     */
    public function hasKomi()
    {
        return !empty($this->komi);
    }

    /**
     * @param Time $time
     */
    public function setTime(Time $time)
    {
        $this->time = $time;
    }

    /**
     * @return Time
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param bool $isReady
     */
    public function setIsReady($isReady)
    {
        $this->isReady = $isReady;
    }

    /**
     * @return bool
     */
    public function isReady()
    {
        return $this->isReady;
    }

    /**
     * @return string
     */
    public function  getSeasonInfo()
    {
        return sprintf('%s. %s League',
            $this->getNumber(),
            $this->getAssociation()->getName()
        );
    }

}