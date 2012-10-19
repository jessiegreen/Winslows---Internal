<?php

namespace Entities\Company\Supplier\Product;

/**
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Purpose") 
 * @Table(name="company_supplier_product_purposes")
 * @HasLifecycleCallbacks
 */
class Purpose extends \Dataservice_Doctrine_Entity
{
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
    protected $name;
    
    /** 
     * @ManyToOne(targetEntity="ProductAbstract", inversedBy="Purposes")
     * @var ProductAbstract
     */     
    protected $Product;
    
    /**
     * @return ProductAbstract
     */
    public function getProduct()
    {
	return $this->Product;
    }
    
    /**
     * @param ProductAbstract $Product
     */
    public function setProduct(ProductAbstract $Product)
    {
	$this->Product = $Product;
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
}