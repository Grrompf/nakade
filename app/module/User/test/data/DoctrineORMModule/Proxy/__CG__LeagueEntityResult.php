<?php

namespace DoctrineORMModule\Proxy\__CG__\League\Entity;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Result extends \League\Entity\Result implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    /** @private */
    public function __load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;

            if (method_exists($this, "__wakeup")) {
                // call this after __isInitialized__to avoid infinite recursion
                // but before loading to emulate what ClassMetadata::newInstance()
                // provides.
                $this->__wakeup();
            }

            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    /** @private */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    
    public function setId($uid)
    {
        $this->__load();
        return parent::setId($uid);
    }

    public function getId()
    {
        $this->__load();
        return parent::getId();
    }

    public function setResult($result)
    {
        $this->__load();
        return parent::setResult($result);
    }

    public function getResult()
    {
        $this->__load();
        return parent::getResult();
    }

    public function __get($property)
    {
        $this->__load();
        return parent::__get($property);
    }

    public function __set($property, $value)
    {
        $this->__load();
        return parent::__set($property, $value);
    }

    public function getArrayCopy()
    {
        $this->__load();
        return parent::getArrayCopy();
    }


    public function __sleep()
    {
        return array('__isInitialized__', '_id', '_result');
    }

    public function __clone()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            $class = $this->_entityPersister->getClassMetadata();
            $original = $this->_entityPersister->load($this->_identifier);
            if ($original === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            foreach ($class->reflFields as $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}