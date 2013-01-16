<?php

namespace Entities\PhoneNumber;

/**
 * @Entity (repositoryClass="Repositories\PhoneNumber\Call") 
 * @Table(name="phonenumber_calls")
 * @HasLifecycleCallbacks
 */
class Call extends \Entities\Contact\ContactAbstract
{   
    /** 
     * @ManyToOne(targetEntity="\Entities\PhoneNumber\PhoneNumberAbstract", inversedBy="Calls")
     * @var \Entities\PhoneNumber\PhoneNumberAbstract $PhoneNumber
     */     
    protected $PhoneNumber;
    
    /**
     * @param PhoneNumberAbstract $PhoneNumber
     */
    public function setPhoneNumber(PhoneNumberAbstract $PhoneNumber)
    {
	$this->PhoneNumber = $PhoneNumber;
    }
    
    /**
     * @return PhoneNumberAbstract
     */
    public function getPhoneNumber()
    {
	return $this->PhoneNumber;
    }
}