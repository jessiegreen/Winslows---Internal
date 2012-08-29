<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\RtoProvider") 
 * @Table(name="rtoprovider")
 * @HasLifecycleCallbacks
 */
class RtoProvider extends \Dataservice_Doctrine_Entity
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
    private $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $dba
     */
    private $dba;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    private $name_index;
    
    /** 
     * @Column(type="string", length=50000)
     * @var string $description
     */
    private $description;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="RtoProviders", cascade={"ALL"})
     * @var array $Products
     */
    private $Products;
    
    public function __construct()
    {
	$this->Products = new ArrayCollection();
    }
    
    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
	return $this->Products;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function addProduct(Company\Supplier\Product\ProductAbstract $Product)
    {
	if(!$this->getProducts()->contains($Product))
	{
	    $Product->addRtoProvider($this);
	    $this->Products[] = $Product;
	}
    }
    
    public function removeProduct(Company\Supplier\Product\ProductAbstract $Product)
    {
	if($this->getProducts()->contains($Product))
	{
	    $Product->removeRtoProvider($this);
	    $this->getProducts()->removeElement ($Product);
	}
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
     * @param type $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @return string
     */
    public function getDba()
    {
        return $this->dba;
    }

    /**
     * @param string $dba
     */
    public function setDba($dba)
    {
        $this->dba = $dba;
    }
    
    /**
     * @return string
     */
    public function getNameIndex()
    {
        return $this->name_index;
    }

    /**
     * @param string $name_index
     */
    public function setNameIndex($name_index)
    {
        $this->name_index = $name_index;
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
     * @param array $array
     */
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