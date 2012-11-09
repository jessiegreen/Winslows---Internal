<?php

namespace Entities\Company\Supplier\Product\Configurable;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Option") 
 * @Table(name="company_supplier_product_configurable_options")
 * @HasLifecycleCallbacks
 */
class Option extends \Dataservice_Doctrine_Entity
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
    protected $index_string;

    /**
     * @Column(type="string", length=2) 
     * @var string $code
     */
    protected $code;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="string", length=1000) 
     * @var string $description
     */
    protected $description;
    
    /** 
     * @Column(type="integer", length=1000) 
     * @var integer $maxcount
     */
    protected $maxcount;
    
    /** 
     * @Column(type="boolean") 
     * @var boolean $required
     */
    protected $required;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option\Category", inversedBy="Options")
     * @var Option\Category $Category 
     */
    private $Category;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option\Parameter", mappedBy="Option", cascade={"persist"}, orphanRemoval=true)
     * @OrderBy({"sort_order" = "ASC", "name" = "ASC"})
     * @var ArrayCollection $Parameters
     */
    private $Parameters;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\Configurable", inversedBy="Options", cascade={"persist"})
     * @JoinTable(name="company_supplier_product_configurable_option_joins")
     * @var ArrayCollection $ConfigurableProducts
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
	
	parent::__construct();
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
	$this->getConfigurableProducts()->removeElement($ConfigurableProduct);
    }
    
    /**
     * @return ArrayCollection
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
    private function _setLength($length)
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
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
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
    public function setMaxCount($max_count)
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
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * @param bool $required
     */
    public function setRequired($required)
    {
	$this->required = $required;
    }
    
    /**
     * @return bool
     */
    public function isRequired()
    {
	return $this->required;
    }
    
    /**
     * @return string
     */
    public function isRequiredString()
    {
	return $this->required ? "yes" : "no";
    }
    
    /**
     * @return array
     */
    public function getRequiredParameters()
    {
	$return = array();
	/* @var $Parameter Option\Parameter */
	foreach ($this->getParameters() as $Parameter) 
	{
	    if($Parameter->isRequired())$return[] = $Parameter;
	}
	return $return;
    }
}