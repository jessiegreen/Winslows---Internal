<?php

namespace Proxies\__CG__\Entities\Company\Supplier\Product;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Category extends \Entities\Company\Supplier\Product\Category implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function addProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
        $this->__load();
        return parent::addProduct($Product);
    }

    public function getProducts()
    {
        $this->__load();
        return parent::getProducts();
    }

    public function removeProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
        $this->__load();
        return parent::removeProduct($Product);
    }

    public function addImage(\Entities\Company\Supplier\Product\Category\File\Image $Image)
    {
        $this->__load();
        return parent::addImage($Image);
    }

    public function removeImage(\Entities\Company\Supplier\Product\Category\File\Image $Image)
    {
        $this->__load();
        return parent::removeImage($Image);
    }

    public function getImages()
    {
        $this->__load();
        return parent::getImages();
    }

    public function setParent(\Entities\Company\Supplier\Product\Category $Category)
    {
        $this->__load();
        return parent::setParent($Category);
    }

    public function getParent()
    {
        $this->__load();
        return parent::getParent();
    }

    public function AddChild(\Entities\Company\Supplier\Product\Category $Category)
    {
        $this->__load();
        return parent::AddChild($Category);
    }

    public function getChildren()
    {
        $this->__load();
        return parent::getChildren();
    }

    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int) $this->_identifier["id"];
        }
        $this->__load();
        return parent::getId();
    }

    public function getIndex()
    {
        $this->__load();
        return parent::getIndex();
    }

    public function setIndex($index)
    {
        $this->__load();
        return parent::setIndex($index);
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

    public function getSortOrder()
    {
        $this->__load();
        return parent::getSortOrder();
    }

    public function setSortOrder($order)
    {
        $this->__load();
        return parent::setSortOrder($order);
    }

    public function getNameWithParentsString()
    {
        $this->__load();
        return parent::getNameWithParentsString();
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
        return array('__isInitialized__', 'id', 'index_string', 'name', 'sort_order', 'created', 'updated', 'parent', 'children', 'Products', 'Images');
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