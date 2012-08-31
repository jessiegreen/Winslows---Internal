<?php
namespace Entities\Company\Supplier\Product;

use Doctrine\Common\Collections\ArrayCollection;

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
class ProductAbstract extends \Dataservice_Doctrine_Entity
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
     * @ManyToOne(targetEntity="\Entities\Company\Supplier", inversedBy="Products")
     * @var \Entities\Company\Supplier $Supplier
     */     
    private $Supplier;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\RtoProvider", inversedBy="Products", cascade={"persist"})
     * @JoinTable(name="company_supplier_product_rtoprovider_joins")
     * @var ArrayCollection $RtoProviders
     */
    private $RtoProviders;

    public function __construct()
    {
	$this->RtoProviders = new ArrayCollection();
	
	parent::__construct();
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
     * @param \Entities\Company\RtoProvider $RtoProvider
     */
    public function addRtoProvider(\Entities\Company\RtoProvider $RtoProvider)
    {
	if(!$this->RtoProviders->contains($RtoProvider))
	    $this->RtoProviders[] = $RtoProvider;
    }
    
    /**
     * @param \Entities\Company\RtoProvider $RtoProvider
     */
    public function removeRtoProvider(\Entities\Company\RtoProvider $RtoProvider)
    {
	$this->RtoProviders->removeElement($RtoProvider);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRtoProviders()
    {
	return $this->RtoProviders;
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
     * @return string
     */
    public function getDescriminator()
    {
	return static::TYPE_Base;
    }
}
