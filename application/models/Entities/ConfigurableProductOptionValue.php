<?php

namespace Entities;

/** 
 * @Entity (repositoryClass="Repositories\ConfigurableProductOptionValue") 
 * @Table(name="product_configurable_option_values") 
 * @HasLifecycleCallbacks
 */
class ConfigurableProductOptionValue
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $index_string;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=255) */
    private $code;
    
    /** @Column(type="string", length=1000) */
    private $description;
        
    /**
     * @ManyToOne(targetEntity="ConfigurableProductOption", inversedBy="ConfigurableProductOptionValues")
     * @var ConfigurableProductOption $ConfigurableProductOption
     */
    private $ConfigurableProductOption;
    
    /** @Column(type="integer") */
    private $ConfigurableProductOption_id;
    
    public function __construct()
    {
	
    }
    
    public function setConfigurableProductOption(ConfigurableProductOption $ConfigurableProductOption){
	$this->ConfigurableProductOption = $ConfigurableProductOption;
    }
    
    public function getConfigurableProductOption(){
	return $this->ConfigurableProductOption;
    }

    /**
     * Retrieve Option id
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
