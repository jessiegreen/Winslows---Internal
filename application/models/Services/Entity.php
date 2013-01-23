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
     * @return \Dataservice\Doctrine\ORM\Mapping\Crud\Permissions
     */
    public function getCollectionCrudPermissions($entity, $collection_property_name)
    {
	$propertyReflection = $this->_em->getClassMetadata($entity)->getReflectionProperty($collection_property_name);
	/* @var $Driver \Doctrine\ORM\Mapping\Driver\AnnotationDriver */
	$driver		    = $em->getConfiguration()->getMetadataDriverImpl();
	/* @var $reader \Doctrine\Common\Annotations\AnnotationReader */ 
	$reader		    = $driver->getReader();
	
	return $reader->getPropertyAnnotation($propertyReflection, "Dataservice\Doctrine\ORM\Mapping\Crud\Permissions\Collection");
    }
    
    /**
     * @param string $entity
     * @param string $collection_property_name
     * @param string $permission_name
     * @return array
     */
    public function getCollectionCrudPermission($entity, $collection_property_name, $permission_name)
    {
	return $this->getCollectionCrudPermissions($entity, $collection_property_name)->$permission_name;
    }
    
    /**
     * @param type $entity
     * @param type $association_property
     * @return type
     */
    public function getAssociationTargetClass($entity, $association_property)
    {
	return $this->_em->getClassMetadata($entity)->getAssociationTargetClass($association_property);
    }
}