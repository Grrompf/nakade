<?php
namespace Season\Form;

use Season\Form\Hydrator\MatchDayConfigHydrator;
use Season\Schedule\DateHelper;
use Season\Services\SeasonFieldsetService;
use \Zend\InputFilter\InputFilter;

class MatchDayConfigForm extends BaseForm
{
    private $dateHelper;
    private $minDate;

    /**
     * @param SeasonFieldsetService $service
     * @param DateHelper            $dateHelper
     */
    public function __construct(SeasonFieldsetService $service, DateHelper $dateHelper)
    {
        parent::__construct('MatchDayConfigForm');

        $this->setFieldSetService($service);
        $this->setDateHelper($dateHelper);

        $this->setMinDate(\date('Y-m-d'));
        $hydration = new MatchDayConfigHydrator();
        $this->setHydrator($hydration);
        $this->setInputFilter($this->getFilter());
    }

    /**
     * @param \Season\Entity\Schedule $object
     */
    public function bindEntity($object)
    {
        $this->setMinDate($object->getDate()->format('Y-m-d'));
        $this->init();
        $this->setInputFilter($this->getFilter());
        $this->bind($object);
    }

    /**
     * init the form. It is neccessary to call this function
     * before using the form.
     */
    public function init()
    {

        //association
        $this->add(
            array(
                'name' => 'seasonInfo',
                'type' => 'Zend\Form\Element\Text',
                'options' => array('label' =>  $this->translate('Season') . ':'),
                'attributes' => array(
                    'readonly' => 'readonly',
                )
            )
        );

        //rounds
        $this->add(
            array(
                'name' => 'noOfMatchDays',
                'type' => 'Zend\Form\Element\Text',
                'options' => array(
                    'label' => $this->translate('No of rounds') . ':',
                ),
                'attributes' => array(
                    'readonly' => 'readonly',
                ),
            )
        );

        $this->add(
            array(
                'name' => 'cycle',
                'type' => 'Zend\Form\Element\Select',
                'options' => array(
                    'label' =>  $this->translate('Cycle') . ':',
                    'value_options' => $this->getDateHelper()->getCycles()
                ),
                'attributes' => array(
                    'size' => 1,
                )
            )
        );

        //match Day
        $this->add(
            array(
                'type' => 'Zend\Form\Element\Select',
                'name' => 'day',
                'options' => array(
                    'label' => $this->translate('Match day') . ':',
                    'value_options' => $this->getDateHelper()->getWeekdays()
                ),
                'attributes' => array(
                    'size' => 1
                ),
            )
        );

        //start date
        $this->add(
            array(
                'name' => 'startDate',
                'type' => 'Zend\Form\Element\Date',
                'options' => array(
                    'label' => $this->translate('Start date'),
                    'format' => 'Y-m-d',
                ),
                'attributes' => array(
                     'min'   => $this->getMinDate(),
                     'step'  => '1',
                ),
            )
        );

        //time
        $this->add(
            array(
                'type' => 'Zend\Form\Element\Time',
                'name' => 'time',
                'options' => array('label' => $this->translate('Time') . ':'),
                'attributes' => array(
                     'step'  => '900'
                )
            )
        );

        $this->add($this->getButtonFieldSet());
    }


    /**
     * @return \Zend\InputFilter\InputFilter
     */
    public function getFilter()
    {
        $filter = new InputFilter();
        return $filter;
    }

    /**
     * @param DateHelper $dateHelper
     */
    public function setDateHelper(DateHelper $dateHelper)
    {
        $this->dateHelper = $dateHelper;
    }

    /**
     * @return DateHelper
     */
    public function getDateHelper()
    {
        return $this->dateHelper;
    }

    /**
     * @return \DateTime
     */
    public function getMinDate()
    {
        return $this->minDate;
    }

    /**
     * @param string $minDate
     */
    public function setMinDate($minDate)
    {
        $this->minDate = $minDate;
    }


}

