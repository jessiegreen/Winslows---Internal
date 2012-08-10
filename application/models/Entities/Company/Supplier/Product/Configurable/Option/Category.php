<?php

namespace Entities\Company\Supplier\Product\Configurable\Option;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Option\Category") 
 * @Table(name="company_supplier_product_configurable_option_categories")
 * @HasLifecycleCallbacks
 */
class Category
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $index_string
     */
    private $index_string;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    private $name;
    
    /** 
     * @Column(type="integer", length=11) 
     * @var integer $order
     */
    private $order;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option", mappedBy="Category", cascade={"persist"}, orphanRemoval=true)
     * @var array $Options
     */
    private $Options;
    
    public function __construct()
    {
	$this->ConfigurableProducts = new ArrayCollection();
	$this->ConfigurableOptions  = new ArrayCollection();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option $Option
     */
    public function addOptions(\Entities\Company\Supplier\Product\Configurable\Option $Option)
    {
	$Option->setCategory($this);
        $this->Options[] = $Option;
    }
    
    /**
     * @return array
     */
    public function getOptions()
    {
	return $this->Options;
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getIndex()
    {
        return $this->index_string;
    }

    /**
     * @param string $index
     */
    public function setIndex($index)
    {
        $this->index_string = $index;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param integer $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
    
    /** 
     * @return type
     */
    public function toArray()
    {
	$array			= array();
	$array['name']		= $this->getName();
	return $array;
    }
}