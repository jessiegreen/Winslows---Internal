<?php

namespace Entities\Company\Supplier\Product;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\ProductAbstract") 
 * @Table(name="company_supplier_product_productabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"supplier_product_configurable" = "\Entities\Company\Supplier\Product\Configurable", 
 *			"supplier_product_simple" = "\Entities\Company\Supplier\Product\Simple"
 *			})
 * @HasLifecycleCallbacks
 */
class ProductAbstract
{
    const TYPE_Configurable = "Configurable";
    const TYPE_Simple	    = "Simple";
    const TYPE_Base	    = "Base";

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    private $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $part_number
     */
    private $part_number;
    
    /** 
     * @Column(type="string", length=2000) 
     * @var string $part_number
     */
    private $description;
    
    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    private $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    private $updated;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Supplier", inversedBy="Products")
     * @var \Entities\Company\Supplier $Supplier
     */     
    private $Supplier;

    public function __construct()
    {
	$this->created	    = $this->updated = new \DateTime("now");
    }
    
    /**
     * @param \Entities\Company\Supplier $Supplier
     */
    public function setSupplier(\Entities\Company\Supplier $Supplier)
    {
        $this->Supplier = $Supplier;
    }
    
    /**
     * @return \Entities\Company\Supplier
     */
    public function getSupplier()
    {
	return $this->Supplier;
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
    public function getPartNumber()
    {
        return $this->part_number;
    }

    /**
     * @param string $partnumber
     */
    public function setPartNumber($partnumber)
    {
        $this->part_number = $partnumber;
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
    
    /**
     * @return string
     */
    public function getDescriminator(){
	return static::TYPE_Base;
    }
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
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
