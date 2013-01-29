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
}