<?php

namespace Entities\Company\Supplier\Product\Instance;

use Doctrine\Common\Collections\ArrayCollection;

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
    
    /**
     * @OnetoMany(targetEntity="\Entities\Company\Supplier\Product\Instance\File\Image", cascade={"persist", "remove"}, mappedBy="Instance", orphanRemoval=true)
     * @var ArrayCollection $Images
     */
    private $Images;

    public function __construct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$this->Product	= $Product;
	$this->Images	= new ArrayCollection();
	
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
     * @param File\Image $Image
     */
    public function addImage(File\Image $Image)
    {
	$Image->setProduct($this);
	
	$this->Images[] = $Image;
    }
    
    /**
     * @param File\Image $Image
     */
    public function removeImage(File\Image $Image)
    {
	$this->Images->removeElement($Image);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getImages()
    {
	return $this->Images;
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
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getDeliveryTypes()
    {
	return $this->getProduct()->getDeliveryTypes();
    }
}
