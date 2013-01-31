<?php
namespace Entities\Company\Person;

/** 
 * @Entity (repositoryClass="Repositories\Company\Person\Document") 
 * @Table(name="company_person_documents") 
 */

class Document extends \Entities\Company\Document\DocumentAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Person\PersonAbstract", inversedBy="Documents")
     * @var \Entities\Company\Person\PersonAbstract
     */     
    protected $Person;
    
    /**
     * @var array 
     */
    protected $type_options = array(
	"generic_person"    => "Generic Person"
    );    
    
    /**
     * @param \Entities\Company\Person\PersonAbstract $Person
     */
    public function setPerson(PersonAbstract $Person)
    {
        $this->Person = $Person;
    }
    
    /**
     * @return \Entities\Company\Person\PersonAbstract
     */
    public function getPerson()
    {
	return $this->Person;
    }
}