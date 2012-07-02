<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Role") 
 * @Table(name="roles") 
 * @HasLifecycleCallbacks
 */
class Role
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=2000) */
    private $description;
    
    /**
     * @OneToMany(targetEntity="Privilege", mappedBy="role", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $privileges;
    
    /**
     * @ManytoMany(targetEntity="Resource")
     * @JoinTable(name="role_resources",
     *      joinColumns={@JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="resource_id", referencedColumnName="id")}
     *      )
     */
    private $resources;
    
    public function __construct()
    {
	$this->resources = new ArrayCollection();
    }
    
    /**
     * Associate Role with Webaccount
     * @param Role $role
     */
    public function addPrivilege(Privilege $privilege)
    {
	$privilege->setRole($this);
        $this->privileges[] = $privilege;
    }

    public function getPrivileges(){
	return $this->privileges;
    }
    
    public function getResources()
    {
	return $this->resources;
    }

    /**
     * Retrieve Role id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

}
