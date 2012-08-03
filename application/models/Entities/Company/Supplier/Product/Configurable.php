<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Company\Supplier\Product;
/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable") 
 * @Table(name="company_supplier_product_configurables") 
 */

class Configurable extends ProductAbstract
{
    /** @Column(type="string", length=255) */
    private $validator;
    
    /** @Column(type="string", length=255) */
    private $pricer;
    
    /**
     * @ManytoMany(targetEntity="ConfigurableProductOptionGroup", mappedBy="ConfigurableProducts", cascade={"ALL"})
     */
    private $ConfigurableProductOptionGroups;
    
    public function __construct()
    {
	$this->ConfigurableProductOptionGroups    = new ArrayCollection();
	parent::__construct();
    }
    
    public function getConfigurableProductOptionGroups(){
	return $this->ConfigurableProductOptionGroups;
    }
        
    public function addConfigurableProductOptionGroup(ConfigurableProductOptionGroup $ConfigurableProductOptionGroup){
	$ConfigurableProductOptionGroup->addConfigurableProduct($this);
	$this->ConfigurableProductOptionGroups[] = $ConfigurableProductOptionGroup;
    }
    
    public function removeConfigurableProductOptionGroup(ConfigurableProductOptionGroup $ConfigurableProductOptionGroup)
    {
	foreach ($this->ConfigurableProductOptionGroups as $key => $ConfigurableProductOptionGroup2) {
	    if($ConfigurableProductOptionGroup->getId() == $ConfigurableProductOptionGroup2->getId()){
		$removed = $this->ConfigurableProductOptionGroups[$key];
		unset($this->ConfigurableProductOptionGroups[$key]);
		$ConfigurableProductOptionGroup->removeConfigurableProduct($this);
		return $removed;
	    }
	}
	return false;
    }
    
    public function getValidator()
    {
        return $this->validator;
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }
    
    public function getPricer()
    {
        return $this->pricer;
    }

    public function setPricer($pricer)
    {
        $this->pricer = $pricer;
    }
    
    public function getDescriminator() {
	return parent::TYPE_Configurable;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}