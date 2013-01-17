<?php

namespace Entities\Address;

/**
 * @Entity (repositoryClass="Repositories\Address\Mail") 
 * @Table(name="address_mail")
 * @HasLifecycleCallbacks
 */
class Mail extends \Entities\Contact\ContactAbstract
{   
    /** 
     * @ManyToOne(targetEntity="\Entities\Address\AddressAbstract", inversedBy="Mail")
     * @var \Entities\Address\AddressAbstract
     */     
    protected $Address;
    
    /**
     * @param \Entities\Address\AddressAbstract $Address
     */
    public function setAddress(AddressAbstract $Address)
    {
	$this->Address = $Address;
    }
    
    /**
     * @return AddressAbstract
     */
    public function getAddress()
    {
	return $this->Address;
    }
}