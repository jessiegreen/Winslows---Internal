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
 * @Table(name="persondocuments") 
 */

class PersonDocument extends Document
{
    /** 
     * @ManyToOne(targetEntity="Person", inversedBy="persondocuments")
     */     
    private $person;
    
    protected $type_options = array(
	"generic_person"    => "Generic Person"
    );
    
    
    /**
     * Add person to document.
     * @param Person $person
     */
    public function setPerson(Person $person)
    {
        $this->person = $person;
    }
    
    /**
     * Retrieve document's associated person.
     */
    public function getPerson()
    {
	return $this->person;
    }
    
    
}

?>
