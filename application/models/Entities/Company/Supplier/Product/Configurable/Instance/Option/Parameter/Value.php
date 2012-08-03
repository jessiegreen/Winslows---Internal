<?php

namespace Entities\Company\Supplier\Product\Configurable\Instance\Option\Parameter;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable\Instance\Option\Parameter\Value") 
 * @Table(name="company_supplier_product_configurable_instance_option_parameter_values") 
 * @HasLifecycleCallbacks
 */
class Value
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ManyToOne(targetEntity="ConfigurableProductInstance", inversedBy="ConfigurableProductInstanceOptionValues")
     * @var $ConfigurableProductInstance ConfigurableProductInstance
     */
    private $ConfigurableProductInstance;
    
    /** 
     * @ManyToOne(targetEntity="ConfigurableProductOptionValue")
     */     
    private $ConfigurableProductOptionValue;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

    public function __construct(
	    ConfigurableProductOptionValue $ConfigurableProductOptionValue,
	     ConfigurableProductInstance $ConfigurableProductInstance
    )
    {
	$this->ConfigurableProductInstance	= $ConfigurableProductInstance;
	$this->ConfigurableProductOptionValue	= $ConfigurableProductOptionValue;
	$this->created = $this->updated		= new \DateTime("now");
    }
           
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
    
    public function getConfigurableProductInstance(){
	return $this->ConfigurableProductInstance;
    }
    
    public function getConfigurableProductOptionValue(){
	return $this->ConfigurableProductOptionValue;
    }
    
    /**
     * Retrieve Option id
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
