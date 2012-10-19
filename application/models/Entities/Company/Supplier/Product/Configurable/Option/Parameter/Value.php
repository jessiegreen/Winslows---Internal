<?php

namespace Entities\Company\Supplier\Product\Configurable\Option\Parameter;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Option\Parameter\Value") 
 * @Table(name="company_supplier_product_configurable_option_parameter_values") 
 * @HasLifecycleCallbacks
 */
class Value extends \Dataservice_Doctrine_Entity
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
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $code
     */
    protected $code;
    
    /** 
     * @Column(type="string", length=1000) 
     * @var string $description
     */
    protected $description;
        
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option\Parameter", inversedBy="Values")
     * @var \Entities\Company\Supplier\Product\Configurable\Option\Parameter $Parameter
     */
    private $Parameter;
    
    /** 
     * @Column(type="integer") 
     * @var integer $Parameter_id
     */
    private $Parameter_id;
        
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option\Parameter $Parameter
     */
    public function setParameter(\Entities\Company\Supplier\Product\Configurable\Option\Parameter $Parameter)
    {
	$this->Parameter = $Parameter;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Configurable\Option\Parameter
     */
    public function getParameter()
    {
	return $this->Parameter;
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
}
