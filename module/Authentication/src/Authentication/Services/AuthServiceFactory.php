<?php
//module/Authentication/src/Authentication/Services/AuthServiceFactory.php
namespace Authentication\Services;

use Authentication\Services\AuthAdapter;
use Authentication\Services\AuthStorage;
use Zend\Authentication\AuthenticationService;
use DoctrineModule\Options\Authentication as AuthOptions;

/*
 * Factory for creating the Zend Authentication Service. Using customized
 * Adapter and Storage instances. 
 */
class AuthServiceFactory  {
   
    
    protected $_entityManager;
    protected $_options;

    /**
     * The constructor is setting the options from the service manager
     * configuration and the Doctrine Entity Manager.
     * 
     * @param array $sm serviceManager
     */
    public function __construct($servMan) {
        
        $this->_entityManager = $servMan->get('Doctrine\ORM\EntityManager');
        $this->setOptions($servMan->get('config'));
        
    }
    
    /**
     * Sets options from configuration based on given keys "doctrine", 
     * "authentication" and "orm_default".
     * This configuration has to exist in the module.config file
     *
     * @param  array                        $config
     * @throws \RuntimeException
     */
    protected function setOptions($config){
        
        $key  = 'authentication';
        $name = 'orm_default';
        
        $options = isset($config['doctrine'][$key][$name]) ? 
            $config['doctrine'][$key][$name] : null;

        if (null === $options) {
            throw new RuntimeException(sprintf(
                'Options with name "%s" could not be found in "doctrine.%s".',
                $name,
                $key
            ));
        }
        
        $this->_options=$options;
    }
    
    /**
     * returns an instance of the zend authenticaion service. This service is
     * setup with doctrine adapters.
     * 
     * @return \Zend\Authentication\AuthenticationService
     */
    public function createService()
    {
        $options = $this->getOptions();
       
        $adapter = new AuthAdapter($options);
        $storage = new AuthStorage($options);
        
        return new AuthenticationService($storage,$adapter );
    }
    
    
    /**
     * Gets options from configuration creating an Doctrine
     * options object.
     *
     * @return \Zend\Stdlib\AbstractOptions
     */
    protected function getOptions()
    {
        
        $options = new AuthOptions($this->_options);
        
        //usually the object manager option is a string from the configuration
        if (is_string($options->getObjectManager())) {
           
            $options->setObjectManager($this->_entityManager);
        }
        
        return $options;
       
    }
    
    
}

