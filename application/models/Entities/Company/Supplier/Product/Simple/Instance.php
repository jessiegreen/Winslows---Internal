<?php

namespace Entities\Company\Supplier\Product\Simple;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Simple\Instance") 
 * @Table(name="company_supplier_product_simple_instances") 
 */
class Instance extends \Entities\Company\Supplier\Product\Instance\InstanceAbstract
{    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="ConfigurableProductInstanceOptionValue", mappedBy="ConfigurableProductInstance", cascade={"persist"})
     */
    private $ConfigurableProductInstanceOptionValues;
    
    private $ConfigurableProductValidator;

    public function __construct(ConfigurableProduct $ConfigurableProduct)
    {
	$this->\Services\Factories\ConfigurableProductInstanceValidator($this->getProduct()->getValidator());
	$this->ConfigurableProductInstanceOptionValues  = new ArrayCollection();
	parent::__construct($ConfigurableProduct);
    }
    
    /**
     * @return ConfigurableProduct
     */
    public function getProduct() {
	parent::getProduct();
    }
    
    public function addConfigurableProductInstanceOptionValue(ConfigurableProductOptionValue $ConfigurableProductOptionValue)
    {
	$ConfigurableProductInstanceOptionValue = new ConfigurableProductInstanceOptionValue($ConfigurableProductOptionValue, $this);
        $this->ConfigurableProductInstanceOptionValues[] = $ConfigurableProductInstanceOptionValue;
    }
    
    public function getConfigurableProductInstanceOptionValues()
    {
	return $this->ConfigurableProductInstanceOptionValues;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
