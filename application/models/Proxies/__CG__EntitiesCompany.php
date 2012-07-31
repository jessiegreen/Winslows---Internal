<?php

namespace Proxies\__CG__\Entities;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Company extends \Entities\Company implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function addLocation(\Entities\Location $Location)
    {
        $this->__load();
        return parent::addLocation($Location);
    }

    public function getLocations()
    {
        $this->__load();
        return parent::getLocations();
    }

    public function getSuppliers()
    {
        $this->__load();
        return parent::getSuppliers();
    }

    public function addSupplier(\Entities\Supplier $Supplier)
    {
        $this->__load();
        return parent::addSupplier($Supplier);
    }

    public function removeSupplier(\Entities\Supplier $Supplier)
    {
        $this->__load();
        return parent::removeSupplier($Supplier);
    }

    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function getName()
    {
        $this->__load();
        return parent::getName();
    }

    public function setName($name)
    {
        $this->__load();
        return parent::setName($name);
    }

    public function getDba()
    {
        $this->__load();
        return parent::getDba();
    }

    public function setDba($dba)
    {
        $this->__load();
        return parent::setDba($dba);
    }

    public function getNameIndex()
    {
        $this->__load();
        return parent::getNameIndex();
    }

    public function setNameIndex($name_index)
    {
        $this->__load();
        return parent::setNameIndex($name_index);
    }

    public function getDescription()
    {
        $this->__load();
        return parent::getDescription();
    }

    public function setDescription($description)
    {
        $this->__load();
        return parent::setDescription($description);
    }

    public function populate(array $array)
    {
        $this->__load();
        return parent::populate($array);
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'name', 'dba', 'name_index', 'description', 'Locations', 'Suppliers');
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
            foreach ($class->reflFields AS $field => $reflProperty) {
                $reflProperty->setValue($this, $reflProperty->getValue($original));
            }
            unset($this->_entityPersister, $this->_identifier);
        }
        
    }
}