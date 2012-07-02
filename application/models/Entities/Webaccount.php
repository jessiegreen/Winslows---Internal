<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Webaccount") 
 * @Table(name="webaccounts") 
 * @HasLifecycleCallbacks
 */
class Webaccount
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
     * @OneToOne(targetEntity="Person", inversedBy="webaccount")
     * @JoinColumn(name="person_id", referencedColumnName="id")
     * @var $person null | Person
     */
    private $person;
    
    /**
     * @ManytoMany(targetEntity="Role")
     * @JoinTable(name="webaccounts_roles",
     *      joinColumns={@JoinColumn(name="webaccount_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    private $roles;

    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
	$this->roles = new ArrayCollection();
    }
    
    /**
     * Associate Role with Webaccount
     * @param Role $role
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;
    }

    public function getRoles(){
	return $this->roles;
    }
    
    /**
     * Retrieve address's associated people.
     * 
     * @return \Entities\Person
     */
    public function getPerson()
    {
	return $this->person;
    }
    
    public function setPerson(Person $person) {
	$this->person = $person;
    }

    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Retrieve Webaccount id
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

}
