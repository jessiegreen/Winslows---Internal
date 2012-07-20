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
     * @OneToMany(targetEntity="Privilege", mappedBy="Role", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $Privileges;
    
    /**
     * @ManytoMany(targetEntity="Resource", inversedBy="Roles", cascade={"persist", "remove"})
     * @JoinTable(name="role_resources",
     *      joinColumns={@JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="resource_id", referencedColumnName="id")}
     *      )
     */
    private $Resources;
    
    /**
     * @ManytoMany(targetEntity="WebAccount", mappedBy="Roles", cascade={"ALL"})
     */
    private $WebAccounts;
    
    public function __construct()
    {
	$this->Resources    = new ArrayCollection();
	$this->WebAccounts  = new ArrayCollection();
    }
    
    /**
     * Associate Role with Privilege
     * @param Privilege $Privilege
     */
    public function addPrivilege(Privilege $Privilege)
    {
	$Privilege->setRole($this);
        $this->Privileges[] = $Privilege;
    }
    
    public function addWebAccount(WebAccount $WebAccount)
    {
//	$WebAccount->addRole($this);
        $this->WebAccounts[] = $WebAccount;
    }
    
    public function removeWebAccount(WebAccount $WebAccount){
	foreach ($this->WebAccounts as $key => $WebAccount2) {
	    if($WebAccount->getId() == $WebAccount2->getId()){
		$removed = $this->WebAccounts[$key];
		unset($this->WebAccounts[$key]);
		return $removed;
	    }
	}
    }

    public function getPrivileges(){
	return $this->Privileges;
    }
    
    public function addResource(Resource $Resource)
    {
        $this->Resources[] = $Resource;
    }
    
    public function removeResource(Resource $Resource){
	foreach ($this->Resources as $key => $Resource2) {
	    if($Resource->getId() == $Resource2->getId()){
		$removed = $this->Resources[$key];
		unset($this->Resources[$key]);
		return $removed;
	    }
	}
    }
    
    public function getResources()
    {
	return $this->Resources;
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

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
