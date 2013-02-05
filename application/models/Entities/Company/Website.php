<?php
namespace Entities\Company;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website") 
 * @Crud\Entity\Url(value="website")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_websites") 
 */
class Website extends \Entities\Company\Website\WebsiteAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Websites")
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company
     */     
    protected $Company;
    
    /**
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
    
    /**
     * @return string
     */
    public function toString()
    {
	return $this->getName();
    }
    
    public function populate(array $array)
    {
	$Company = $this->_getEntityFromArray($array, "Entities\Company", "company_id");
	
	if($Company)$this->setCompany($Company);
	
	parent::populate($array);
    }
}