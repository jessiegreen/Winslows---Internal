<?php
namespace Entities\Company;

use Doctrine\Common\Collections\ArrayCollection;

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
     * @ManytoMany(targetEntity="\Entities\Company\Catalog", inversedBy="Websites", cascade={"persist"})
     * @JoinTable(name="company_website_catalog_joins")
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Catalogs
     */
    protected $Catalogs;
    
    public function __construct()
    {
	$this->Catalogs = new ArrayCollection();
	
	parent::__construct();
    }
    
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
     * @param \Entities\Company\Website $Catalog
     */
    public function addCatalog(\Entities\Company\Catalog $Catalog)
    {
	if(!$this->Catalogs->contains($Catalog))
	    $this->Catalogs[] = $Catalog;
    }
    
    /**
     * @param \Entities\Company\Catalog $Catalog
     */
    public function removeCatalog(\Entities\Company\Catalog $Catalog)
    {
	$this->Catalogs->removeElement($Catalog);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCatalogs()
    {
	return $this->Catalogs;
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