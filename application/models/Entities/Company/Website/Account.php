<?php

namespace Entities\Company\Website;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Account") 
 * @Table(name="company_website_accounts") 
 * @HasLifecycleCallbacks
 */
class Account
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $username
     */
    private $username;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $password
     */
    private $password;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $salt
     */
    private $salt;
    
    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    private $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    private $updated;

    /**
     * @OneToOne(targetEntity="\Entities\Person\PersonAbstract", inversedBy="Account", cascade={"ALL"})
     * @JoinColumn(name="person_id", referencedColumnName="id")
     * @var \Entities\Person\PersonAbstract $Person
     */
    private $Person;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Website\Account\Role", cascade={"persist", "remove"})
     * @JoinTable(name="company_website_account_role_joins",
     *      joinColumns={@JoinColumn(name="webaccount_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     * @var array $Roles
     */
    private $Roles;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Website", inversedBy="Accounts")
     * @var \Entities\Company\Website
     */
    private $Website;

    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
	$this->Roles	= new ArrayCollection();
    }
    
    /**
     * @param \Entities\Company\Website $Website
     */
    public function setWebsite(\Entities\Company\Website $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Company\Website
     */
    public function getWebsite()
    {
	return $this->Website;
    }
    
    /**
     * @param \Entities\Company\Website\Account\Role $Role
     */
    public function addRole(Account\Role $Role)
    {
	$Role->addAccount($this);
        $this->Roles[] = $Role;
    }
    
    /**
     * @param \Entities\Company\Website\Account\Role $Role
     * @return boolean
     */
    public function removeRole(Account\Role $Role)
    {
	foreach ($this->Roles as $key => $Role2) {
	    if($Role->getId() == $Role2->getId){
		$Role->removeWebAccount($this);
		$removed = $this->Roles[$key];
		unset($this->Roles[$key]);
		return $removed;
	    }
	}
	return false;
    }

    /**
     * @return array
     */
    public function getRoles(){
	return $this->Roles;
    }
    
    /**
     * @param string $role_name
     * @return boolean
     */
    public function hasRole($role_name){
	/* @var $Role Role */
	foreach ($this->getRoles() as $Role) {
	    if($Role->getName() == $role_name)return true;
	}
	return false;
    }
    
    /**
     * Retrieve address's associated people.
     * 
     * @return \Entities\Person\PersonAbstract
     */
    public function getPerson()
    {
	return $this->Person;
    }
    
    /**
     * @param \Entities\Person\PersonAbstract $Person
     */
    public function setPerson(\Entities\Person\PersonAbstract $Person) {
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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }
    
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
	$this->_setSalt(sha1(rand(5, 20000)));
        $this->password = sha1($password.$this->salt);
    }
    
    /**
     * @param string $salt
     */
    private function _setSalt($salt){
	$this->salt = $salt;
    }
    
    /**
     * @return string
     */
    public function getSalt(){
	return $this->salt;
    }
        
    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}
