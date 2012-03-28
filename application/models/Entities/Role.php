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
    
    public function __construct()
    {
	
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
