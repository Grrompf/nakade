<?php

namespace PhlyContact\Service;

use Traversable;
use PhlyContact\Form\ContactFilter;
use PhlyContact\Form\ContactForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

class ContactFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
        $config  = $services->get('config');
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        
        $textDomain=$config['translator']['translation_file_patterns']
             ['text_domain'];
        
     
        $name    = $config['phly_contact']['form']['name'];
        $captcha = $services->get('PhlyContactCaptcha');
        $translator = $services->get('translator');
        $filter  = new ContactFilter();
        $form    = new ContactForm(
                $name, 
                $captcha, 
                $translator, 
                $textDomain="Contact"
                );
        $form->setInputFilter($filter);
        return $form;
    }
}