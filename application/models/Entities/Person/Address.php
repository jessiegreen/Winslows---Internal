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
namespace Entities\Person;
/** 
 * @Entity (repositoryClass="Repositories\Person\Address") 
 * @Table(name="person_addresses") 
 */

class Address extends \Entities\Address\AddressAbstract
{
    /**
     * @var integer 
     */
    private $person_id;
    
    /** 
     * @ManyToOne(targetEntity="Person\PersonAbstract", inversedBy="Addresses")
     * @var \Enrtities\Person\PersonAbstract
     */     
    private $Person;
    
    /**
     * Add person to address.
     * @param \Enrtities\Person\PersonAbstract $Person
     */
    public function setPerson(PersonAbstract $Person)
    {
        $this->Person = $Person;
    }
    
    /**
     * @return \Enrtities\Person\PersonAbstract 
     */
    public function getPerson()
    {
	return $this->Person;
    }
    
    /**
     * @var integer
     */
    public function getPersonId()
    {
	return $this->person_id;
    }
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value)
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}
