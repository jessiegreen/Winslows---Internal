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
     * @var integer $id
     */
    private $id;
    
    /** 
     * @Column(type="string", length=255)
     * @var string $index_string 
     */
    private $index_string;

    /**
     * @Column(type="string", length=2) 
     * @var string $code
     */
    private $code;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    private $name;
    
    /** 
     * @Column(type="string", length=1000) 
     * @var string $description
     */
    private $description;
    
    /** 
     * @Column(type="integer", length=1000) 
     * @var integer $maxcount
     */
    private $maxcount;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option\Category", inversedBy="Options")
     * @var Option\Category $Category 
     */
    private $Category;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option\Parameter", mappedBy="Option", cascade={"persist"}, orphanRemoval=true)
     * @var array $Parameters
     */
    private $Parameters;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\Configurable", inversedBy="Options", cascade={"persist"})
     * @JoinTable(name="company_supplier_product_configurable_option_joins")
     * @var array $ConfigurableProducts
     */
    private $ConfigurableProducts;
    
    /**
     * @var integer 
     */
    private $_length;
    
    public function __construct()
    {
	$this->ConfigurableProducts = new ArrayCollection();
	$this->Parameters	    = new ArrayCollection();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable $ConfigurableProduct
     */
    public function addConfigurableProduct(\Entities\Company\Supplier\Product\Configurable $ConfigurableProduct)
    {
        $this->ConfigurableProducts[] = $ConfigurableProduct;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable $ConfigurableProduct
     * @return boolean
     */
    public function removeConfigurableProduct(\Entities\Company\Supplier\Product\Configurable $ConfigurableProduct)
    {
	foreach ($this->ConfigurableProducts as $key => $ConfigurableProduct2) 
	{
	    if($ConfigurableProduct->getId() == $ConfigurableProduct2->getId())
	    {
		$this->ConfigurableProducts[$key];
		
		unset($this->ConfigurableProducts[$key]);
		
		return true;
	    }
	}
	return false;
    }
    
    /**
     * @return array
     */
    public function getConfigurableProducts()
    {
	return $this->ConfigurableProducts;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Category $Category
     */
    public function setCategory(Option\Category $Category)
    {
	$this->Category = $Category;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable\Option\Category
     */
    public function getCategory()
    {
	return $this->Category;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter $Parameter
     */
    public function addParameter(Option\Parameter $Parameter)
    {
	$Parameter->setOption($this);
        $this->Parameters[] = $Parameter;
    }
    
    /**
     * @return array
     */
    public function getParameters()
    {
	return $this->Parameters;
    }

    /**
     * @return integer
     */
    public function getLength()
    {
	$length = $this->_calculateLength();
	
	$this->_setLength($length);
	
	return $this->_length;
    }
    
    /**
     * @param integer $length
     */
    private function _setLength(integer $length)
    {
	$this->_length = $length;
    }
    
    /**
     * @return integer
     */
    private function _calculateLength()
    {
	$length = 0;
	
	if(count($this->Parameters)>0)
	{
	    /* @var $Parameter Option\Parameter */
	    foreach ($this->Parameters as $Parameter) 
	    {
		$length += (int) $Parameter->getLength();
	    }
	}
	return $length;	
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
    public function setIndex(string $index)
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
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }
    
    /**
     * @return integer
     */
    public function getMaxCount()
    {
        return $this->maxcount;
    }

    /**
     * @param integer $max_count
     */
    public function setMaxCount(integer $max_count)
    {
        $this->maxcount = $max_count;
    }
    
    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }    
    
    /**
     * @return boolean
     */
    public function hasRequiredOption()
    {
	/* @var $Parameter Option\Parameter */
	foreach ($this->getParameters() as $Parameter) 
	{
	    if($Parameter->isRequired())return true;
	}
	return false;
    }
    
    /**
     * @return array
     */
    public function getRequiredOptionIdsArray()
    {
	$ids = array();
	/* @var $Parameter Option\Parameter */
	foreach ($this->getParameters() as $Parameter) 
	{
	    if($Parameter->isRequired())$ids[] = $Parameter->getId();
	}
	return $ids;
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
     * @return array
     */
    public function toArray(){
	$array			= array();
	$array['name']		= $this->getName();
	$array['code']		= $this->getCode();
	$array['description']	= $this->getDescription();
	return $array;
    }
}