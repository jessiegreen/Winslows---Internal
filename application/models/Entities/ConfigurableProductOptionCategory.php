<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\ConfigurableProductOptionCategory") 
 * @Table(name="product_configurable_option_categories")
 * @HasLifecycleCallbacks
 */
class ConfigurableProductOptionCategory
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
    
    /** @Column(type="integer", length=11) */
    private $order;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="ConfigurableProductOptionGroup", mappedBy="ConfigurableProductOptionCategory", cascade={"persist"}, orphanRemoval=true)
     */
    private $ConfigurableProductOptionGroups;
    
    public function __construct()
    {
	$this->ConfigurableProducts	    = new ArrayCollection();
	$this->ConfigurableProductOptions   = new ArrayCollection();
    }
    
    public function addConfigurableProductOptionGroups(ConfigurableProductOptionGroup $ConfigurableProductOptionGroup)
    {
	$ConfigurableProductOptionGroup->setConfigurableProductOptionCategory($this);
        $this->ConfigurableProductOptionGroups[] = $ConfigurableProductOptionGroup;
    }
    
    public function getConfigurableProductOptionGroups(){
	return $this->ConfigurableProductOptionGroups;
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
    
    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;
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
	return $array;
    }
}