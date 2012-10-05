<?php

namespace Entities\Company\RtoProvider;

/**
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Program") 
 * @Table(name="company_rtoprovider_programs")
 * @HasLifecycleCallbacks
 */
class Program extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    protected $name_index;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\RtoProvider", inversedBy="Programs")
     * @var \Entities\Company\RtoProvider
     */  
    protected $RtoProvider;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\ProductAbstract", mappedBy="Programs", cascade={"ALL"})
     * @var ArrayCollection $Products
     */
    protected $Products;
    
    /**
     * @return \Entities\Company\RtoProvider
     */
    public function getRtoProvider()
    {
	return $this->RtoProvider;
    }
    
    /**
     * @param \Entities\Company\RtoProvider $RtoProvider
     */
    public function setRtoProvider(\Entities\Company\RtoProvider $RtoProvider)
    {
	$this->RtoProvider = $RtoProvider;
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
    public function addProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	if(!$this->getProducts()->contains($Product))
	{
	    $Product->addProgram($this);
	    $this->Products[] = $Product;
	}
    }
    
    public function removeProduct(\Entities\Company\Supplier\Product\ProductAbstract $Product)
    {
	$Product->removeProgram($this);
	$this->getProducts()->removeElement($Product);
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
}