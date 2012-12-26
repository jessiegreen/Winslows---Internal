<?php

namespace Entities\Website\Account;

/** 
 * @Entity (repositoryClass="Repositories\Website\Account\AccountAbstract") 
 * @Table(name="website_account_accountabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_employee_account" = "\Entities\Company\Employee\Account",
 * 			"company_lead_account" = "\Entities\Company\Lead\Account",
 *			"website_guest_account" = "\Entities\Website\Guest\Account"
 *		    })
 * @HasLifecycleCallbacks
 */
class AccountAbstract extends \Dataservice_Doctrine_Entity
{
    const TYPE_Employee	    = "Employee";
    const TYPE_Lead	    = "Lead";
    const TYPE_Guest	    = "Guest";
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $username
     */
    protected $username;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $password
     */
    protected $password;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $salt
     */
    protected $salt;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Website\WebsiteAbstract", inversedBy="Accounts")
     * @var \Entities\Website\WebsiteAbstract
     */
    protected $Website;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Website\Role", cascade={"persist"})
     * @JoinTable(name="website_account_role_joins")
     * @var ArrayCollection $Roles
     */
    protected $Roles;
    
    public function __construct()
    {
	$this->Roles = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Website\Guest\Role $Role
     */
    public function addRole(\Entities\Website\Role $Role)
    {
	if($Role->getWebsite() === $this->getWebsite())
	{
	    $Role->addAccount($this);
	    $this->Roles[] = $Role;
	}
	else throw new \Exception("Role does not belong to this website");
    }
    
    /**
     * @param \Entities\Website\Guest\Role $Role
     */
    public function removeRole(Guest\Role $Role)
    {
	$this->getRoles()->removeElement($Role);
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
	return $this->Roles;
    }
    
    /**
     * @param \Entities\Website\Guest\Role $Role
     * @return boolean
     */
    public function hasRole($Role)
    {
	if($this->getRoles()->contains($Role))
	    return true;
	
	return false;
    }
    
    /**
     * @param \Entities\Website\WebsiteAbstract $Website
     */
    public function setWebsite(\Entities\Website\WebsiteAbstract $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Website\WebsiteAbstract
     */
    public function getWebsite()
    {
	return $this->Website;
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
    private function _setSalt($salt)
    {
	$this->salt = $salt;
    }
    
    /**
     * @return string
     */
    public function getSalt()
    {
	return $this->salt;
    }
    
    /**
     * @return string
     */
    public function getDescriminator()
    {
	return null;
    }
}
