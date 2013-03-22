<?php

namespace Authentication\Services;

use Traversable;
use Authentication\Form\AuthFilter;
use Authentication\Form\AuthForm;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;

class AuthFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $services)
    {
      
        $config  = $services->get('config');
        if ($config instanceof Traversable) {
            $config = ArrayUtils::iteratorToArray($config);
        }
        
        
        $captcha = $services->get('AuthCaptcha');
        $translator = $services->get('translator');
        $filter  = new AuthFilter();
       
        $form    = new AuthForm($captcha, $translator);
        $form->setInputFilter($filter);
      
        return $form;
    }
}
