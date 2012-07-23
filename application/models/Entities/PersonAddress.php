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
 * @Table(name="person_addresses") 
 */

class PersonAddress extends Address
{
    private $person_id;
    /** 
     * @ManyToOne(targetEntity="Person", inversedBy="PersonAddresses")
     */     
    private $Person;
    
    
    /**
     * Add person to address.
     * @param Person $Person
     */
    public function setPerson(Person $Person)
    {
        $this->Person = $Person;
    }
    
    /**
     * Retrieve address's associated person.
     */
    public function getPerson()
    {
	return $this->Person;
    }
    
    /**
     * Get person Id
     */
    public function getPersonId() {
	return $this->person_id;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    echo "$key exists=".(property_exists($this, $key) ? "yes" : "no")."<br />";
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
