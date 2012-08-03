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
 * @Entity (repositoryClass="Repositories\Person\PhoneNumber") 
 * @Table(name="person_phonenumbers") 
 */

class PhoneNumber extends \Entities\PhoneNumber\PhoneNumberAbstract
{
    /** 
     * @ManyToOne(targetEntity="Person\PersonAbstract", inversedBy="PhoneNumbers")
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
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}