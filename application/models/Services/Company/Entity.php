<?php
namespace Services\Company;

class Entity extends \Dataservice_Service_ServiceAbstract
{   
    private $_doctrine_annotation_prefix = "Doctrine\ORM\Mapping";
    
    private $_doctrine_relationship_types = array(
	"OneToOne" => "Doctrine\ORM\Mapping\OneToOne", 
	"ManyToOne" => "Doctrine\ORM\Mapping\ManyToOne", 
	"OneToMany" => "Doctrine\ORM\Mapping\OneToMany", 
	"ManyToMany" => "Doctrine\ORM\Mapping\ManyToMany"
    );

    /**
     * @return Entity
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    /**
     * @param string $entityClass
     * @param string $related_property_name
     * @return string
     */
    public function getRelationshipTypeName($entityClass, $related_property_name)
    {
	return array_search(
		$this->getRelationshipTypeAnnotationClass($entityClass, $related_property_name), 
		$this->_doctrine_relationship_types);
    }
    
    /**
     * @param string $entityClass
     * @param string $related_property_name
     * @return string
     */
    public function getRelationshipTypeAnnotationClass($entityClass, $related_property_name)
    {
	return get_class($this->getRelationshipTypeAnnotation($entityClass, $related_property_name));
    }
    
    /**
     * @param string $entityClass
     * @param string $related_property_name
     * @return \Doctrine\ORM\Mapping\Annotation
     */
    public function getRelationshipTypeAnnotation($entityClass, $related_property_name)
    {
	$propertyReflection = $this->_em->getClassMetadata($entityClass)->getReflectionProperty($related_property_name);
	$reader		    = $this->_getAnnotationReader();
	$annotations	    = $reader->getPropertyAnnotations($propertyReflection);
	
	foreach ($annotations as $annotation)
	{
	    if(in_array(get_class($annotation), $this->_doctrine_relationship_types))
		    return $annotation;
	}
	
	return null;
    }
    
    /**
     * @param string $entityClass
     * @param string $collection_property_name
     * @return Dataservice\Doctrine\ORM\Mapping\Crud\Relationship\Permissions
     */
    public function getRelationshipCrudPermissions($entityClass, $collection_property_name)
    {
	$propertyReflection = $this->_em->getClassMetadata($entityClass)->getReflectionProperty($collection_property_name);
	$reader		    = $this->_getAnnotationReader();
	
	return $reader->getPropertyAnnotation($propertyReflection, "Dataservice\Doctrine\ORM\Mapping\Crud\Relationship\Permissions");
    }
    
    /**
     * @param string $entityClass
     * @param string $collection_property_name
     * @param string $permission_name
     * @return $mixed
     */
    public function getCollectionCrudPermission($entityClass, $collection_property_name, $permission_name)
    {
	return $this->getCollectionCrudPermissions($entityClass, $collection_property_name)->$permission_name;
    }
    
    /**
     * @param string $entityClass
     * @param string $association_property
     * @return string
     */
    public function getRelationshipTargetClass($entityClass, $association_property)
    {
	return $this->_em->getClassMetadata($entityClass)->getAssociationTargetClass($association_property);
    }
    
    /**
     * @param string $entityClass
     * @return \Dataservice\Doctrine\ORM\Mapping\Crud\Entity\Permissions
     */
    public function getEntityCrudPermissions($entityClass)
    {
	return $this->getClassAnnotation($entityClass, "Dataservice\Doctrine\ORM\Mapping\Crud\Entity\Permissions");
    }
    
    /**
     * @param string $entityClass
     * @param string $permission_name
     * @return mixed
     */
    public function getEntityCrudPermission($entityClass, $permission_name)
    {
	return $this->getEntityCrudPermissions($entityClass)->$permission_name;
    }
    
    /**
     * @param string $entityClass
     * @return string
     */
    public function getEntityCrudUrl($entityClass)
    {
	$urlAnnotation	    = "Dataservice\Doctrine\ORM\Mapping\Crud\Entity\Url";
	$annotationObject   = $this->getClassAnnotation($entityClass, $urlAnnotation);
	
	if(!$annotationObject)
	    throw new \Exception($entityClass." does not have an annotation of ".$urlAnnotation);
	
	return $annotationObject->value;
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
    
    private function getClassAnnotation($entityClass, $annotation)
    {
	$classReflection    = $this->_em->getClassMetadata($entityClass)->getReflectionClass();
	$reader		    = $this->_getAnnotationReader();
	
	return $reader->getClassAnnotation($classReflection, $annotation);
    }
}