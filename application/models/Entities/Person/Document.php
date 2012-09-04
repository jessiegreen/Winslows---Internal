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
 * @Entity (repositoryClass="Repositories\Person\Document") 
 * @Table(name="person_documents") 
 */

class Document extends \Entities\Document\DocumentAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Person\PersonAbstract", inversedBy="Documents")
     * @var \Entities\Person\PersonAbstract
     */     
    protected $Person;
    
    /**
     * @var array 
     */
    protected $type_options = array(
	"generic_person"    => "Generic Person"
    );    
    
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
}