<?php

namespace Entities\Company\Supplier\Product\Configurable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Option") 
 * @Table(name="company_supplier_product_configurable_options")
 * @HasLifecycleCallbacks
 */
class Option
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(type="string", length=255) */
    private $index_string;

    /** @Column(type="string", length=2) */
    private $code;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=1000) */
    private $description;
    
    /** @Column(type="integer", length=1000) */
    private $maxcount;
    
    /**
     * @ManyToOne(targetEntity="ConfigurableProductOptionCategory", inversedBy="ConfigurableProductOptionGroups")
     * @var ConfigurableProductOptionCategory $ConfigurableProductOptionCategory 
     */
    private $ConfigurableProductOptionCategory;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="ConfigurableProductOption", mappedBy="ConfigurableProductOptionGroup", cascade={"persist"}, orphanRemoval=true)
     */
    private $ConfigurableProductOptions;
    
    /**
     * @ManytoMany(targetEntity="ConfigurableProduct", inversedBy="ConfigurableProductOptionGroups", cascade={"persist"})
     * @JoinTable(name="product_configurable_product_configurable_option_groups")
     */
    private $ConfigurableProducts;
    
    private $_length;
    
    public function __construct()
    {
	$this->ConfigurableProducts	    = new ArrayCollection();
	$this->ConfigurableProductOptions   = new ArrayCollection();
    }
    
    public function addConfigurableProduct(ConfigurableProduct $ConfigurableProduct)
    {
        $this->ConfigurableProducts[] = $ConfigurableProduct;
    }
    
    public function removeConfigurableProduct(ConfigurableProduct $ConfigurableProduct){
	foreach ($this->ConfigurableProducts as $key => $ConfigurableProduct2) {
	    if($ConfigurableProduct->getId() == $ConfigurableProduct2->getId()){
		$removed = $this->ConfigurableProducts[$key];
		unset($this->ConfigurableProducts[$key]);
		return $removed;
	    }
	}
	return false;
    }
    
    public function getConfigurableProducts()
    {
	return $this->ConfigurableProducts;
    }
    
    public function setConfigurableProductOptionCategory(ConfigurableProductOptionCategory $ConfigurableProductOptionCategory){
	$this->ConfigurableProductOptionCategory = $ConfigurableProductOptionCategory;
    }
    
    public function getConfigurableProductOptionCategory(){
	return $this->ConfigurableProductOptionCategory;
    }
    
    public function addConfigurableProductOption(ConfigurableProductOption $ConfigurableProductOption)
    {
	$ConfigurableProductOption->setConfigurableProductOptionGroup($this);
        $this->ConfigurableProductOptions[] = $ConfigurableProductOption;
    }
    
    public function getConfigurableProductOptions(){
	return $this->ConfigurableProductOptions;
    }

    public function getLength(){
	$length = $this->_calculateLength();
	$this->_setLength($length);
	return $this->_length;
    }
    
    private function _setLength($length){
	$this->_length = $length;
    }
    
    private function _calculateLength(){
	$length = 0;
	
	if(count($this->ConfigurableProductOptions)>0){
	    /* @var $ConfigurableProductOption \Entities\ConfigurableProductOption */
	    foreach ($this->ConfigurableProductOptions as $ConfigurableProductOption) {
		$length += (int) $ConfigurableProductOption->getLength();
	    }
	}
	return $length;	
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getIndex()
    {
        return $this->index_string;
    }

    public function setIndex($index)
    {
        $this->index_string = $index;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }
    
    public function getMaxCount()
    {
        return $this->maxcount;
    }

    public function setMaxCount($max_count)
    {
        $this->maxcount = $max_count;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }    
    
    public function hasRequiredOption(){
	/* @var $Option \Entities\ConfigurableProductOption */
	foreach ($this->getConfigurableProductOptions() as $Option) {
	    if($Option->isRequired())return true;
	}
	return false;
    }
    
    public function getRequiredOptionIdsArray(){
	$ids = array();
	/* @var $Option \Entities\ConfigurableProductOption */
	foreach ($this->getConfigurableProductOptions() as $Option) {
	    if($Option->isRequired())$ids[] = $Option->getId();
	}
	return $ids;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
    
    public function toArray(){
	$array			= array();
	$array['name']		= $this->getName();
	$array['code']		= $this->getCode();
	$array['description']	= $this->getDescription();
	return $array;
    }
}