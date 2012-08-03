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
     */
    private $id;

    /** @Column(type="string", length=2000) */
    private $note;
    
    /**
     * @ManyToOne(targetEntity="Product")
     * @var $Product Product
     */
    private $Product;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

    public function __construct(Product $Product)
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
     * @return Product
     */
    public function getProduct()
    {
	return $this->Product;
    }
    
    /**
     * Retrieve Option id
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setNote($note){
	$this->note = $note;
    }
    
    public function getNote(){
	return $this->note;
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
