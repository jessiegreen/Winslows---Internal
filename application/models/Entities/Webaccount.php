<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\WebAccount") 
 * @Table(name="webaccounts") 
 * @HasLifecycleCallbacks
 */
class WebAccount
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $username;
    
    /** @Column(type="string", length=255) */
    private $password;
    
    /** @Column(type="string", length=255) */
    private $salt;
    
    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

    /**
     * @OneToOne(targetEntity="Person", inversedBy="WebAccount", cascade={"ALL"})
     * @JoinColumn(name="person_id", referencedColumnName="id")
     * @var $Person null | Person
     */
    private $Person;
    
    /**
     * @ManytoMany(targetEntity="Role", cascade={"persist", "remove"})
     * @JoinTable(name="webaccounts_roles",
     *      joinColumns={@JoinColumn(name="webaccount_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    private $Roles;

    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
	$this->Roles = new ArrayCollection();
    }
    
    /**
     * Associate Role with WebAccount
     * @param Role $Role
     */
    public function addRole(Role $Role)
    {
	$Role->addWebAccount($this);
        $this->Roles[] = $Role;
    }
    
    public function removeRole($role_id)
    {
	foreach ($this->Roles as $key => $Role) {
	    if($Role->getId() == $role_id){
		$Role->removeWebAccount($this);
		$removed = $this->Roles[$key];
		unset($this->Roles[$key]);
		return $removed;
	    }
	}
	return false;
    }

    public function getRoles(){
	return $this->Roles;
    }
    
    public function hasRole($role){
	/* @var $Role Role */
	foreach ($this->getRoles() as $Role) {
	    if($Role->getName() == $role)return true;
	}
	return false;
    }
    
    /**
     * Retrieve address's associated people.
     * 
     * @return \Entities\Person
     */
    public function getPerson()
    {
	return $this->Person;
    }
    
    public function setPerson(Person $Person) {
	$this->Person = $Person;
    }

    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Retrieve WebAccount id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
	$this->_setSalt(sha1(rand(5, 20000)));
        $this->password = sha1($password.$this->salt);
    }
    
    private function _setSalt($salt){
	$this->salt = $salt;
    }
    
    public function getSalt(){
	return $this->salt;
    }
        
    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
