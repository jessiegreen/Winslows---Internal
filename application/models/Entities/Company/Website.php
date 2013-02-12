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
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="Websites", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var ArrayCollection $Products
     */
    protected $Products;
    
    public function __construct()
    {
	$this->Products = new ArrayCollection();
	
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
     * @return ArrayCollection
     */
    public function getProducts()
    {
	return $this->Products;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function addProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	if(!$this->getProducts()->contains($Product))
	{
	    $Product->addWebsite($this);
	    
	    $this->Products[] = $Product;
	}
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function removeProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$Product->removeWebsite($this);
	
	$this->getProducts()->removeElement($Product);
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