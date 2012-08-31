<?php

namespace Entities\Company\Supplier\Product\Instance;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Instance\InstanceAbstract") 
 * @Table(name="company_supplier_product_instance_instanceabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_supplier_product_configurable_instance" = "\Entities\Company\Supplier\Product\Configurable\Instance",
 *			"company_supplier_product_simple_instance" = "\Entities\Company\Supplier\Product\Simple\Instance",
 *		    })
 * @HasLifecycleCallbacks
 */
class InstanceAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;

    /** 
     * @Column(type="string", length=2000) 
     * @var string $note
     */
    protected $note;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract")
     * @var \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    protected $Product;

    public function __construct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$this->Product = $Product;
	
	parent::__construct();
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
    public function setNote($note)
    {
	$this->note = $note;
    }
    
    /**
     * @return string
     */
    public function getNote()
    {
	return $this->note;
    }
}
