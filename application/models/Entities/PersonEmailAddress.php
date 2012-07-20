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
 * @Table(name="person_emailaddresses") 
 */

class PersonEmailAddress extends EmailAddress
{
    /** 
     * @ManyToOne(targetEntity="Person", inversedBy="PersonEmailAddresses")
     */     
    private $Person;
    
    
    /**
     * Set person for email address.
     * @param Person $Person
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
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}