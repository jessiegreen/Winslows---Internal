<?php

namespace Entities\Company\Supplier\Product\Instance;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Instance\InstanceAbstract") 
 * @Table(name="company_supplier_product_instance_instanceabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_supplier_product_configurable_instance" = "Company\Supplier\Product\Configurable\Instance",
 *			"company_supplier_product_simple_instance" = "Company\Supplier\Product\Simple\Instance",
 *		    })
 * @HasLifecycleCallbacks
 */
class InstanceAbstract
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;

    /** 
     * @Column(type="string", length=2000) 
     * @var string $note
     */
    private $note;
    
    /**
     * @ManyToOne(targetEntity="Company\Supplier\Product\ProductAbstract")
     * @var \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    protected $Product;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    private $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime
     */
    private $updated;

    public function __construct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$this->Product = $Product;
	$this->created = $this->updated = new \DateTime("now");
    }
           
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\ProductAbstract 
     */
    public function getProduct()
    {
	return $this->Product;
    }
    
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $note
     */
    public function setNote(string $note)
    {
	$this->note = $note;
    }
    
    /**
     * @return string
     */
    public function getNote(){
	return $this->note;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
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
}
