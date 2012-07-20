<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities;
/** 
 * @Entity (repositoryClass="Repositories\PersonEmailAddress") 
 * @Table(name="person_phonenumbers") 
 */

class PersonPhoneNumber extends PhoneNumber
{
    /** 
     * @ManyToOne(targetEntity="Person", inversedBy="PersonPhoneNumbers")
     */     
    private $Person;
    
    
    /**
     * Add person to email address.
     * @param Person $person
     */
    public function setPerson(Person $Person)
    {
        $this->Person = $Person;
    }
    
    /**
     * Retrieve email address's associated person.
     */
    public function getPerson()
    {
	return $this->Person;
    }
}