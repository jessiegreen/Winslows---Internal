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
 * @Entity (repositoryClass="Repositories\PersonDocument") 
 * @Table(name="person_documents") 
 */

class PersonDocument extends Document
{
    /** 
     * @ManyToOne(targetEntity="Person", inversedBy="PersonDocuments")
     */     
    private $Person;
    
    protected $type_options = array(
	"generic_person"    => "Generic Person"
    );
    
    
    /**
     * Add person to document.
     * @param Person $person
     */
    public function setPerson(Person $Person)
    {
        $this->Person = $Person;
    }
    
    /**
     * Retrieve document's associated person.
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