<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\ConfigurableProductOption") 
 * @Table(name="product_configurable_options") 
 * @HasLifecycleCallbacks
 */
class ConfigurableProductOption
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
    
    /** @Column(type="string", length=1000) */
    private $description;
    
    /** @Column(type="boolean") */
    private $required;
    
    /** @Column(type="integer", length=10) */
    private $length;
    
    /**
     * @ManyToOne(targetEntity="ConfigurableProductOptionGroup", inversedBy="ConfigurableProductOptions")
     * @var ConfigurableProductOptionGroup $ConfigurableProductOptionGroup 
     */
    private $ConfigurableProductOptionGroup;
    
    /** @Column(type="integer") */
    private $ConfigurableProductOptionGroup_id; 
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="ConfigurableProductOptionValue", mappedBy="ConfigurableProductOption", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $ConfigurableProductOptionValues;
    
    public function __construct()
    {
	$this->ConfigurableProductOptionValues = new ArrayCollection();
    }
    
    public function setConfigurableProductOptionGroup(ConfigurableProductOptionGroup $ConfigurableProductOptionGroup){
	$this->ConfigurableProductOptionGroup = $ConfigurableProductOptionGroup;
    }
    
    public function getConfigurableProductOptionGroup(){
	return $this->ConfigurableProductOptionGroup;
    }
    
    public function AddConfigurableProductOptionValue(ConfigurableProductOptionValue $ConfigurableProductOptionValue){
	$ConfigurableProductOptionValue->setConfigurableProductOptionValue($this);
	$this->ConfigurableProductOptionValues[] = $ConfigurableProductOptionValue;
    }
    
    public function getConfigurableProductOptionValues(){
	return $this->ConfigurableProductOptionValues;
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
    
    public function getLength()
    {
        return $this->length;
    }

    public function setLength($length)
    {
        $this->length = $length;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function setRequired(bool $required){
	$this->required = $required;
    }
    
    public function isRequired(){
	return $this->required;
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
	$array['description']	= $this->getDescription();
	return $array;
    }
}
