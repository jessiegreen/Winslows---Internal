<?php

namespace Entities\Company\Website\Account;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Account\AccountAbstracts") 
 * @Table(name="company_website_account_accountabstracts") 
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
     * @ManyToOne(targetEntity="\Entities\Company\Website", inversedBy="Accounts")
     * @var \Entities\Company\Website
     */
    private $Website;

    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
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
