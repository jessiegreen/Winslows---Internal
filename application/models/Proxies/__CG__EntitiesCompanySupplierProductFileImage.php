<?php

namespace Proxies\__CG__\Entities\Company\Supplier\Product\File;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class Image extends \Entities\Company\Supplier\Product\File\Image implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function setProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
        $this->__load();
        return parent::setProduct($Product);
    }

    public function getProduct()
    {
        $this->__load();
        return parent::getProduct();
    }

    public function populate(array $array)
    {
        $this->__load();
        return parent::populate($array);
    }

    public function addResizedClone(\Entities\Company\File\Image\ResizedClone $ResizedClone)
    {
        $this->__load();
        return parent::addResizedClone($ResizedClone);
    }

    public function getResizedClones()
    {
        $this->__load();
        return parent::getResizedClones();
    }

    public function getSize($width, $height)
    {
        $this->__load();
        return parent::getSize($width, $height);
    }

    public function getThumb()
    {
        $this->__load();
        return parent::getThumb();
    }

    public function setWidth($width)
    {
        $this->__load();
        return parent::setWidth($width);
    }

    public function getWidth()
    {
        $this->__load();
        return parent::getWidth();
    }

    public function setHeight($height)
    {
        $this->__load();
        return parent::setHeight($height);
    }

    public function getHeight()
    {
        $this->__load();
        return parent::getHeight();
    }

    public function getHtmlImage()
    {
        $this->__load();
        return parent::getHtmlImage();
    }

    public function getHtml()
    {
        $this->__load();
        return parent::getHtml();
    }

    public function render()
    {
        $this->__load();
        return parent::render();
    }

    public function uploadFile($temp_full_path)
    {
        $this->__load();
        return parent::uploadFile($temp_full_path);
    }

    public function toString()
    {
        $this->__load();
        return parent::toString();
    }

    public function getId()
    {
        $this->__load();
        return parent::getId();
    }

    public function getFileType()
    {
        $this->__load();
        return parent::getFileType();
    }

    public function setFileType($file_type)
    {
        $this->__load();
        return parent::setFileType($file_type);
    }

    public function getFileSize()
    {
        $this->__load();
        return parent::getFileSize();
    }

    public function setFileSize($file_size)
    {
        $this->__load();
        return parent::setFileSize($file_size);
    }

    public function getOriginalFileName()
    {
        $this->__load();
        return parent::getOriginalFileName();
    }

    public function setOriginalFileName($original_file_name)
    {
        $this->__load();
        return parent::setOriginalFileName($original_file_name);
    }

    public function getExtension()
    {
        $this->__load();
        return parent::getExtension();
    }

    public function setExtension($extension)
    {
        $this->__load();
        return parent::setExtension($extension);
    }

    public function getFullPath()
    {
        $this->__load();
        return parent::getFullPath();
    }

    public function getFullRealPath()
    {
        $this->__load();
        return parent::getFullRealPath();
    }

    public function setName($name)
    {
        $this->__load();
        return parent::setName($name);
    }

    public function getName()
    {
        $this->__load();
        return parent::getName();
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

    public function setIsPublic($is_public)
    {
        $this->__load();
        return parent::setIsPublic($is_public);
    }

    public function getIsPublic()
    {
        $this->__load();
        return parent::getIsPublic();
    }

    public function isPublic()
    {
        $this->__load();
        return parent::isPublic();
    }

    public function getDirectory()
    {
        $this->__load();
        return parent::getDirectory();
    }

    public function getDirectoryRealPath()
    {
        $this->__load();
        return parent::getDirectoryRealPath();
    }

    public function getSourceUrl()
    {
        $this->__load();
        return parent::getSourceUrl();
    }

    public function getSourceUrlPrivateFromConfig()
    {
        $this->__load();
        return parent::getSourceUrlPrivateFromConfig();
    }

    public function getSourceUrlPublicFromConfig()
    {
        $this->__load();
        return parent::getSourceUrlPublicFromConfig();
    }

    public function setFileParamsFromArray($file_info_array)
    {
        $this->__load();
        return parent::setFileParamsFromArray($file_info_array);
    }

    public function validateUpload()
    {
        $this->__load();
        return parent::validateUpload();
    }

    public function validateType()
    {
        $this->__load();
        return parent::validateType();
    }

    public function validateSize()
    {
        $this->__load();
        return parent::validateSize();
    }

    public function prePersistValidate()
    {
        $this->__load();
        return parent::prePersistValidate();
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

    public function filterCollectionByfield(\Doctrine\Common\Collections\ArrayCollection $ArrayCollection, $field, $value)
    {
        $this->__load();
        return parent::filterCollectionByfield($ArrayCollection, $field, $value);
    }

    public function getCrudPermissions()
    {
        $this->__load();
        return parent::getCrudPermissions();
    }

    public function getCrudPermission($permission_name)
    {
        $this->__load();
        return parent::getCrudPermission($permission_name);
    }

    public function getRelationshipCrudPermissions($collection_property_name)
    {
        $this->__load();
        return parent::getRelationshipCrudPermissions($collection_property_name);
    }

    public function getRelationshipTypeName($related_property_name)
    {
        $this->__load();
        return parent::getRelationshipTypeName($related_property_name);
    }

    public function getRelationshipClass($related_property_name)
    {
        $this->__load();
        return parent::getRelationshipClass($related_property_name);
    }

    public function getRelationshipClassCrudPermissions($related_property_name)
    {
        $this->__load();
        return parent::getRelationshipClassCrudPermissions($related_property_name);
    }

    public function getCrudUrl()
    {
        $this->__load();
        return parent::getCrudUrl();
    }

    public function getRelationshipCrudUrl($related_property_name)
    {
        $this->__load();
        return parent::getRelationshipCrudUrl($related_property_name);
    }

    public function toArray()
    {
        $this->__load();
        return parent::toArray();
    }

    public function getClassName()
    {
        $this->__load();
        return parent::getClassName();
    }

    public function getClass()
    {
        $this->__load();
        return parent::getClass();
    }

    public function getEditForm()
    {
        $this->__load();
        return parent::getEditForm();
    }

    public function getEditFormClass()
    {
        $this->__load();
        return parent::getEditFormClass();
    }

    public function getEditSubform()
    {
        $this->__load();
        return parent::getEditSubform();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'original_file_name', 'extension', 'file_type', 'file_size', 'name', 'description', 'is_public', 'created', 'updated', 'width', 'height', 'ResizedClones', 'Product');
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