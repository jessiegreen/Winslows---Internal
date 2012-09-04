<?php
namespace Entities\Person;
/** 
 * @Entity (repositoryClass="Repositories\Person\EmailAddress") 
 * @Table(name="person_emailaddresses") 
 */

class EmailAddress extends \Entities\EmailAddress\EmailAddressAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Person\PersonAbstract", inversedBy="EmailAddresses")
     * @var \Entities\Person\PersonAbstract
     */     
    protected $Person;
        
    /**
     * @param \Entities\Person\PersonAbstract $Person
     */
    public function setPerson(PersonAbstract $Person)
    {
        $this->Person = $Person;
    }
    
    /**
     * @return \Entities\Person\PersonAbstract
     */
    public function getPerson()
    {
	return $this->Person;
    }
}