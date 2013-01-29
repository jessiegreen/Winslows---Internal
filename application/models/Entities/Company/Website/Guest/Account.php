<?php
namespace Entities\Company\Website\Guest;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Guest\Account") 
 * @Table(name="company_website_guest_accounts") 
 */
class Account extends \Entities\Company\Website\Account\AccountAbstract
{
    /** 
     * @Column(type="string", length=255) 
     * @var string $session_id
     */
    protected $session_id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $ip_address
     */
    protected $ip_address;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Website\Guest", inversedBy="Accounts")
     * @var \Entities\Company\Website\Guest $Guest
     */
    protected $Guest;
    
    public function getDescriminator()
    {
	return self::TYPE_Guest;
    }
    
    /**
     * @param \Entities\Company\Website\Guest $Guest
     */
    public function setGuest($Guest)
    {
	$this->Guest = $Guest;
    }
    
    /**
     * @return \Entities\Company\Website\Guest
     */
    public function getGuest()
    {
	return $this->Guest;
    }
    
    /**
     * @param string $session_id
     */
    public function setSessionID($session_id)
    {
	$this->session_id = $session_id;
    }
    
    /**
     * @return string
     */
    public function getSessionID()
    {
	return $this->session_id;
    }
    
    /**
     * @param string $ip_address
     */
    public function setIpAddress($ip_address)
    {
	$this->ip_address = $ip_address;
    }
    
    /**
     * @return string
     */
    public function getIpAddress()
    {
	return $this->ip_address;
    }
    
    /**
     * @return \Entities\Company\Website\Guest
     */
    public function getPerson()
    {
	return $this->getGuest();
    }
}
