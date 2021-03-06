<?php

namespace Support\Services;

use Nakade\Abstracts\AbstractFormFactory;
use Support\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class FormService
 *
 * @package Support\Services
 */
class FormService extends AbstractFormFactory
{

    const MANAGER_FORM = 'manager';
    const SUPPORT_FORM = 'support';
    const MAIL_FORM = 'mail';
    const REFEREE_FORM = 'referee';
    const FEATURE_FORM = 'feature';

    private $services;

    /**
     * @param ServiceLocatorInterface $services
     *
     * @return $this
     *
     * @throws \RuntimeException
     */
    public function createService(ServiceLocatorInterface $services)
    {

        $this->services = $services;
        $config  = $services->get('config');

        //text domain
        $textDomain = isset($config['Support']['text_domain']) ?
            $config['Support']['text_domain'] : null;

        $translator = $services->get('translator');
        $this->setTranslator($translator, $textDomain);

        return $this;
    }

    /**
     * @param string $typ
     *
     * @return \Zend\Form\Form
     *
     * @throws \RuntimeException
     */
    public function getForm($typ)
    {
        switch (strtolower($typ)) {

            case self::MANAGER_FORM:
                $form = new Form\LeagueManagerForm($this->getServices());
                $form->setTranslator($this->getTranslator(), $this->getTranslatorTextDomain());
                break;

            case self::SUPPORT_FORM:
                $form = new Form\SupportForm($this->getServices());
                $form->setTranslator($this->getTranslator(), $this->getTranslatorTextDomain());
                break;

            case self::MAIL_FORM:
                $form = new Form\MailForm($this->getServices());
                $form->setTranslator($this->getTranslator(), $this->getTranslatorTextDomain());
                break;

            case self::REFEREE_FORM:
                $form = new Form\RefereeForm($this->getServices());
                $form->setTranslator($this->getTranslator(), $this->getTranslatorTextDomain());
                break;

            case self::FEATURE_FORM:
                $form = new Form\FeatureForm($this->getServices());
                $form->setTranslator($this->getTranslator(), $this->getTranslatorTextDomain());
                break;

            default:
                throw new \RuntimeException(
                    sprintf('An unknown form type was provided.')
                );
        }
        $form->setTranslator($this->translator, $this->textDomain);
        return $form;
    }

    /**
     * @return ServiceLocatorInterface
     */
    public function getServices()
    {
        return $this->services;
    }

}
