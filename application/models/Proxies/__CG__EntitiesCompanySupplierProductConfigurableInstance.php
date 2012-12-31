<?php

namespace Proxies\__CG__\Entities\Company\Supplier\Product\Configurable;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Instance extends \Entities\Company\Supplier\Product\Configurable\Instance implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function getProduct()
    {
        $this->__load();
        return parent::getProduct();
    }

    public function addOption(\Entities\Company\Supplier\Product\Configurable\Instance\Option $Option)
    {
        $this->__load();
        return parent::addOption($Option);
    }

    public function getOptions()
    {
        $this->__load();
        return parent::getOptions();
    }

    public function getOptionsDisplay($list_class = '', $item_class = '')
    {
        $this->__load();
        return parent::getOptionsDisplay($list_class, $item_class);
    }

    public function getCode()
    {
        $this->__load();
        return parent::getCode();
    }

    public function hasProductOption(\Entities\Company\Supplier\Product\Configurable\Option $ProductOption)
    {
        $this->__load();
        return parent::hasProductOption($ProductOption);
    }

    public function removeAllOptions()
    {
        $this->__load();
        return parent::removeAllOptions();
    }

    public function validate()
    {
        $this->__load();
        return parent::validate();
    }

    public function getPrice()
    {
        $this->__load();
        return parent::getPrice();
    }

    public function getPriceSafe()
    {
        $this->__load();
        return parent::getPriceSafe();
    }

    public function getFirstValueFromIndexes($option_index, $parameter_index)
    {
        $this->__load();
        return parent::getFirstValueFromIndexes($option_index, $parameter_index);
    }

    public function getOptionsFromOptionIndex($option_index)
    {
        $this->__load();
        return parent::getOptionsFromOptionIndex($option_index);
    }

    public function getDisplayArray()
    {
        $this->__load();
        return parent::getDisplayArray();
    }

    public function cloneInstance()
    {
        $this->__load();
        return parent::cloneInstance();
    }

    public function addImage(\Entities\Company\Supplier\Product\Instance\File\Image $Image)
    {
        $this->__load();
        return parent::addImage($Image);
    }

    public function removeImage(\Entities\Company\Supplier\Product\Instance\File\Image $Image)
    {
        $this->__load();
        return parent::removeImage($Image);
    }

    public function getImages()
    {
        $this->__load();
        return parent::getImages();
    }

    public function getId()
    {
        $this->__load();
        return parent::getId();
    }

    public function setNote($note)
    {
        $this->__load();
        return parent::setNote($note);
    }

    public function getNote()
    {
        $this->__load();
        return parent::getNote();
    }

    public function getDeliveryTypes()
    {
        $this->__load();
        return parent::getDeliveryTypes();
    }

    public function updated()
    {
        $this->__load();
        return parent::updated();
    }

    public function getCreated()
    {
        $this->__load();
        return parent::getCreated();
    }

    public function setCreated(\DateTime $created)
    {
        $this->__load();
        return parent::setCreated($created);
    }

    public function getUpdated()
    {
        $this->__load();
        return parent::getUpdated();
    }

    public function populate(array $array)
    {
        $this->__load();
        return parent::populate($array);
    }

    public function toArray()
    {
        $this->__load();
        return parent::toArray();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'note', 'created', 'updated', 'Product', 'Images', 'Options');
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