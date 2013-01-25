<?php
namespace Entities\Contact;

/** 
 * @Entity (repositoryClass="Repositories\Contact\Medium") 
 * @Table(name="contact_mediums") 
 */
class Medium
{
    /**
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @Column(type="string")
     * @var string $entity_class
     */
    protected $entity_class;
    
    /**
     * @Column(type="integer")
     * @var int $entity_id
     */
    protected $entity_id;
    
    /**
     * @param string $entity_class
     */
    public function setEntityClass($entity_class)
    {
	$this->entity_class = $entity_class;
    }
    
    /**
     * @return string
     */
    public function getEntityClass()
    {
	return $this->entity_class;
    }
        
    /**
     * @param int $entity_id
     */
    public function setEntityId($entity_id)
    {
	$this->entity_id = $entity_id;
    }
    
    /**
     * @return int
     */
    public function getEntityId()
    {
	return $this->entity_id;
    }
}