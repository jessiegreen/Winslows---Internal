<?php
namespace Entities\Company;

/**
 * @Entity (repositoryClass="Repositories\Company\Inventory") 
 * @Table(name="company_inventories")
 * @HasLifecycleCallbacks
 */
class Inventory extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company", inversedBy="Inventory", cascade={"persist"})
     * @var \Entities\Company $Company
     */
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Inventory\Item", mappedBy="Inventory", cascade={"persist"})
     * @var \Doctrine\Common\Collections\ArrayCollection $Items
     */
    protected $Items;
    
    /**
     * @return integer
     */
    public function getId()
    {
	return $this->id;
    }
    
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
    
    public function addItem(Inventory\Item $Item)
    {
	$Item->setInventory($this);
	$this->Items->add($Item);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getItems()
    {
	return $this->Items;
    }
}