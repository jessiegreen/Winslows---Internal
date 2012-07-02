<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\RoleResource") 
 * @Table(name="role_resource") 
 * @HasLifecycleCallbacks
 */
class RoleResource
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="integer") */
    private $role_id;
    
    /** @Column(type="integer") */
    private $resource_id;
    
    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

    public function __construct()
    {
	
    }

    /**
     * Retrieve Role id
     */
    public function getId()
    {
        return $this->id;
    }
      
    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

}
