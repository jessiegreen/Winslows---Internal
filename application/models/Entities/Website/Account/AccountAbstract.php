<?php

namespace Entities\Website\Account;

/** 
 * @Entity (repositoryClass="Repositories\Website\Account\AccountAbstracts") 
 * @Table(name="website_account_accountabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"company_employee_account" = "\Entities\Company\Employee\Account"})
 * @HasLifecycleCallbacks
 */
class AccountAbstract extends \Dataservice_Doctrine_Entity
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
     * @ManyToOne(targetEntity="\Entities\Website", inversedBy="Accounts")
     * @var \Entities\Website
     */
    private $Website;
    
    /**
     * @param \Entities\Website $Website
     */
    public function setWebsite(\Entities\Website $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Website
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
