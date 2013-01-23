<?php
namespace Services;

class Entity extends \Dataservice_Service_ServiceAbstract
{   
    /**
     * @return Entity
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    /**
     * @param string $entity
     * @param string $collection_property_name
     * @return Dataservice\Doctrine\ORM\Mapping\Crud\Collection\Permissions
     */
    public function getCollectionCrudPermissions($entity, $collection_property_name)
    {
	$propertyReflection = $this->_em->getClassMetadata($entity)->getReflectionProperty($collection_property_name);
	$reader		    = $this->_getAnnotationReader();
	
	return $reader->getPropertyAnnotation($propertyReflection, "Dataservice\Doctrine\ORM\Mapping\Crud\Collection\Permissions");
    }
    
    /**
     * @param string $entity
     * @param string $collection_property_name
     * @param string $permission_name
     * @return $mixed
     */
    public function getCollectionCrudPermission($entity, $collection_property_name, $permission_name)
    {
	return $this->getCollectionCrudPermissions($entity, $collection_property_name)->$permission_name;
    }
    
    /**
     * @param string $entity
     * @param string $association_property
     * @return string
     */
    public function getAssociationTargetClass($entity, $association_property)
    {
	return $this->_em->getClassMetadata($entity)->getAssociationTargetClass($association_property);
    }
    
    /**
     * @param string $entity
     * @return \Dataservice\Doctrine\ORM\Mapping\Crud\Entity\Permissions
     */
    public function getEntityCrudPermissions($entity)
    {
	return $this->getClassAnnotation($entity, "Dataservice\Doctrine\ORM\Mapping\Crud\Entity\Permissions");
    }
    
    /**
     * @param string $entity
     * @param string $permission_name
     * @return mixed
     */
    public function getEntityCrudPermission($entity, $permission_name)
    {
	return $this->getEntityCrudPermissions($entity)->$permission_name;
    }
    
    /**
     * @param string $entity
     * @return string
     */
    public function getEntityUrl($entity)
    {
	return $this->getClassAnnotation($entity, "Dataservice\Doctrine\ORM\Mapping\Crud\Entity\Url")->value;
    }
    
    /**
     * @return \Doctrine\Common\Annotations\AnnotationReader
     */
    private function _getAnnotationReader()
    {
	/* @var $Driver \Doctrine\ORM\Mapping\Driver\AnnotationDriver */
	$driver		    = $this->_em->getConfiguration()->getMetadataDriverImpl();
	
	return  $driver->getReader();
    }
    
    private function getClassAnnotation($entity, $annotation)
    {
	$classReflection    = $this->_em->getClassMetadata($entity)->getReflectionClass();
	$reader		    = $this->_getAnnotationReader();
	
	return $reader->getClassAnnotation($classReflection, $annotation);
    }
}