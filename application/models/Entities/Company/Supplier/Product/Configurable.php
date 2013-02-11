<?php
namespace Entities\Company\Supplier\Product;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable") 
 * @Table(name="company_supplier_product_configurables") 
 * @Crud\Entity\Url(value="supplier-product-configurable")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Configurable extends ProductAbstract
{
    /** 
     * @Column(type="string", length=255) 
     * @var string $configurator_class_name
     */
    protected $configurator_class_name;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option", mappedBy="ConfigurableProducts", cascade={"ALL"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var array $Options
     */
    protected $Options;
    
    public function __construct()
    {
	$this->Options = new \Doctrine\Common\Collections\ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOptions()
    {
	return $this->Options;
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOptionsOrderedByCategory()
    {
	$arr = $this->getOptions()->toArray();
	
	usort($arr, function($a, $b)
	{
	    $name_a = $a->getCategory()->getOrder();
	    $name_b = $b->getCategory()->getOrder();

	    return $name_a == $name_b ? 0 : $name_a > $name_b ? 1 : - 1;

	});
	
	return $arr;
    }
        
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option $Option
     */
    public function addOption(Configurable\Option $Option)
    {
	$Option->addConfigurableProduct($this);
	
	$this->Options[] = $Option;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option $Option
     * @return boolean
     */
    public function removeOption(Configurable\Option $Option)
    {
	$Option->removeConfigurableProduct($this);
	
	$this->getOptions()->removeElement($Option);
    }
    
    
    /**
     * @param string $option_index
     * @return ArrayCollection
     */
    public function getRequiredOptions()
    {
	return $this->getOptions()->filter(
	    /* @var $Option \Entities\Company\Supplier\Product\Configurable\Option */
	    function($Option)
	    {
		if($Option->isRequired())
		    return true;
		else return false;
	    }
	);
    }
    
    /**
     * @return string
     */
    public function getConfiguratorClassName()
    {
        return $this->configurator_class_name;
    }

    /**
     * @param string $configurator_class_name
     */
    public function setConfiguratorClassName($configurator_class_name)
    {
        $this->configurator_class_name = $configurator_class_name;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable\Instance
     */
    public function createInstance()
    {
	$Instance = new Configurable\Instance($this);
	
	$Instance->setNote("Created by Product");
	
	return $Instance;
    }
    
    /**
     * @return string
     */
    public function getDescriminator() 
    {
	return parent::TYPE_Configurable;
    }
}