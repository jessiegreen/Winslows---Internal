<?php

namespace Entities\EmailAddress;

/**
 * @Entity (repositoryClass="Repositories\EmailAddresst\Email")
 * @Table(name="emailaddress_emails")
 * @HasLifecycleCallbacks
 */
class Email extends \Entities\Contact\ContactAbstract
{   
    /** 
     * @ManyToOne(targetEntity="\Entities\EmailAddress\EmailAddressAbstract", inversedBy="Emails")
     * @var \Entities\EmailAddress\EmailAddressAbstract $EmailAddress
     */     
    protected $EmailAddress;
    
    /**
     * @param EmailAddressAbstract $EmailAddress
     */
    public function setEmailAddress(EmailAddressAbstract $EmailAddress)
    {
	$this->EmailAddress = $EmailAddress;
    }
    
    /**
     * @return EmailAddressAbstract
     */
    public function getEmailAddress()
    {
	return $this->EmailAddress;
    }
}