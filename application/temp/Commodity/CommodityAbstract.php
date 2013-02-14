<?php 
namespace Entities\Company\Commodity;

/** 
 * @Entity (repositoryClass="Repositories\Company\Commodity\CommodityAbstract") 
 * @MappedSuperclass
 * @HasLifecycleCallbacks
 * @Table(name="company_commodity_commodityabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_supplier_product_simple" = "\Entities\Company\Supplier\Product\Simple",
 * 			"company_supplier_product_configurable" = "\Entities\Company\Supplier\Product\Configurable",
 *			"company_supplier_product_instance_file_image" = "\Entities\Company\Supplier\Product\Instance\File\Image"
 *		    })
 */
abstract class CommodityAbstract extends \Dataservice_Doctrine_Entity
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
     * @Column(type="string", length=2000) 
     * @var string $part_number
     */
    protected $description;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company", inversedBy="Catalogs")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company $Company
     */     
    protected $Company;
    
    /**
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
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
