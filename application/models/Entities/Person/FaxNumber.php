<?php
namespace Entities\Person;

/** 
 * @Entity (repositoryClass="Repositories\Person\FaxNumber") 
 * @Table(name="person_faxnumbers") 
 */
class FaxNumber extends \Entities\FaxNumber\FaxNumberAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Person\PersonAbstract", inversedBy="FaxNumbers")
     * @var \Entities\Person\PersonAbstract $Person
     */     
    private $Person;    
    
    /**
     * Add person to email address.
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