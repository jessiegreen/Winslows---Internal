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
     * @ManytoMany(targetEntity="Resource", inversedBy="roles", cascade={"persist", "remove"})
     * @JoinTable(name="role_resources",
     *      joinColumns={@JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="resource_id", referencedColumnName="id")}
     *      )
     */
    private $resources;
    
    /**
     * @ManytoMany(targetEntity="Webaccount", mappedBy="roles", cascade={"ALL"})
     */
    private $webaccounts;
    
    public function __construct()
    {
	$this->resources    = new ArrayCollection();
	$this->webaccounts  = new ArrayCollection();
    }
    
    /**
     * Associate Role with Privilege
     * @param Privilege $privilege
     */
    public function addPrivilege(Privilege $Privilege)
    {
	$Privilege->setRole($this);
        $this->privileges[] = $Privilege;
    }
    
    public function addWebaccount(Webaccount $WebAccount)
    {
//	$WebAccount->addRole($this);
        $this->webaccounts[] = $WebAccount;
    }
    
    public function removeWebAccount(Webaccount $Webaccount){
	foreach ($this->webaccounts as $key => $Webaccount2) {
	    if($Webaccount->getId() == $Webaccount2->getId()){
		$removed = $this->webaccounts[$key];
		unset($this->webaccounts[$key]);
		return $removed;
	    }
	}
    }

    public function getPrivileges(){
	return $this->privileges;
    }
    
    public function addResource(Resource $Resource)
    {
        $this->resources[] = $Resource;
    }
    
    public function removeResource(Resource $Resource){
	foreach ($this->resources as $key => $Resource2) {
	    if($Resource->getId() == $Resource2->getId()){
		$removed = $this->resources[$key];
		unset($this->resources[$key]);
		return $removed;
	    }
	}
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
