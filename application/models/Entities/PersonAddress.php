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
 * @Entity (repositoryClass="Repositories\PersonAddress") 
 * @Table(name="personaddress") 
 */

class PersonAddress extends Address
{
    private $person_id;
    /** 
     * @ManyToOne(targetEntity="Person", inversedBy="personaddresses")
     */     
    private $person;
    
    
    /**
     * Add person to address.
     * @param Person $person
     */
    public function setPerson(Person $person)
    {
        $this->person = $person;
    }
    
    /**
     * Retrieve address's associated person.
     */
    public function getPerson()
    {
	return $this->person;
    }
    
    /**
     * Get person Id
     */
    public function getPersonId() {
	return $this->person_id;
    }
}

?>
