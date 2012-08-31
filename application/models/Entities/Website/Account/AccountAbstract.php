<?php

namespace Entities\Website\Account;

/** 
 * @Entity (repositoryClass="Repositories\Website\Account\AccountAbstracts") 
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
}
