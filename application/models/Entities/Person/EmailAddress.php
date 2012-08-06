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
 * @Entity (repositoryClass="Repositories\Person\EmailAddress") 
 * @Table(name="person_emailaddresses") 
 */

class EmailAddress extends \Entities\EmailAddress\EmailAddressAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Person\PersonAbstract", inversedBy="EmailAddresses")
     * @var \Entities\Person\PersonAbstract
     */     
    private $Person;
        
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
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}