<?php

namespace Entities\Company\Supplier\Product\Configurable\Option;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Option\Parameter") 
 * @Table(name="company_supplier_product_configurable_option_parameters") 
 * @HasLifecycleCallbacks
 */
class Parameter extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $id
     */
    protected $index_string;
    
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
     * @Column(type="boolean") 
     * @var boolean $required
     */
    protected $required;
    
    /** 
     * @Column(type="integer", length=10) 
     * @var integer $length
     */
    protected $length;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option", inversedBy="Parameters")
     * @var \Entities\Company\Supplier\Product\Configurable\Option $Option 
     */
    private $Option;
    
    /** 
     * @Column(type="integer") 
     * @var integer $Option_id
     */
    private $Option_id; 
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value", mappedBy="Parameter", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var ArrayCollection $Values
     */
    private $Values;
    
    public function __construct()
    {
	$this->Values = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option $Option
     */
    public function setOption(\Entities\Company\Supplier\Product\Configurable\Option $Option)
    {
	$this->Option = $Option;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable\Option
     */
    public function getOption()
    {
	return $this->Option;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter\Value $Value
     */
    public function AddValue(Parameter\Value $Value)
    {
	$Value->setParameter($this);
	$this->Values[] = $Value;
    }
    
    /**
     * @return array
     */
    public function getValues()
    {
	return $this->Values;
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
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param integer $length
     */
    public function setLength($length)
    {
        $this->length = $length;
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
}
