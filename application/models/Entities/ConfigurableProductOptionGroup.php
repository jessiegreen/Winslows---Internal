<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\ConfigurableProductOptionGroup") 
 * @Table(name="product_configurable_option_groups")
 * @HasLifecycleCallbacks
 */
class ConfigurableProductOptionGroup
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

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="ConfigurableProductOption", mappedBy="ConfigurableProductOptionGroup", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $ConfigurableProductOptions;
    
    /**
     * @ManytoMany(targetEntity="ConfigurableProduct", inversedBy="CbOptions", cascade={"persist", "remove"})
     * @JoinTable(name="product_configurable_product_configurable_option_groups")
     */
    private $ConfigurableProducts;
    
    private $length;
    
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
    
    public function addConfigurableProductOption(ConfigurableProductOption $ConfigurableProductOption)
    {
	$ConfigurableProductOption->setConfigurableProductOptionGroup($this);
        $this->ConfigurableProductOptions[] = $ConfigurableProductOption;
    }
    
    public function getConfigurableProductOptions(){
	return $this->ConfigurableProductOptions;
    }
    
    /**
     * Retrieve person's associated addresses.
     */
    public function getValues()
    {
      return $this->values;
    }
    
    /**
     * Retrieve length of values
     */
    public function getLength(){
	$this->_calculateLength();
	return $this->length;
    }
    
    /**
     * Calculate length of values
     */
    private function _calculateLength(){
	$length = 0;
	if(is_array($this->values)){
	    /* @var $value \Entities\CbValue */
	    foreach ($this->values as $value) {
		$length += (int) $value->getLength();
	    }
	}
	
	$this->length = $length;
    }

    /**
     * Retrieve supplier id
     */
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
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }    
    
    public function toArray(){
	$array			= array();
	$array['name']		= $this->getName();
	$array['code']		= $this->getCode();
	$array['description']	= $this->getDescription();
	return $array;
    }
}