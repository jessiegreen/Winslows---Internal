<?php
namespace Entities\Company;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website") 
 * @Table(name="company_websites") 
 */
class Website extends \Entities\Website\WebsiteAbstract
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
}