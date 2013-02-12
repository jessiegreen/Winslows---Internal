<?php
namespace Entities\Company;

/**
 * @Entity (repositoryClass="Repositories\Company\Catalog") 
 * @Crud\Entity\Url(value="catalog")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_catalog")
 * @HasLifecycleCallbacks
 */
class Catalog extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company", inversedBy="Inventory", cascade={"persist"})
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company $Company
     */
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\Inventory\Item", mappedBy="Inventory", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
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
    
    public function getItemsByProduct()
    {
	$items = array();
	
	foreach ($this->getItems() as $Item)
	{
	    $items[$Item->getInstance()->getProduct()->getId()][] = $Item;
	}
	
	return $items;
    }
    
    /**
     * @return string
     */
    public function toString()
    {
	return $this->getCompany()->getName()." Inventory";
    }
    
    public function populate(array $array) 
    {
	$Company = $this->_getEntityFromArray($array, "Entities\Company", "company_id");
	
	if($Company && $Company->getId())
	    $this->setCompany($Company);
	
	parent::populate($array);
    }
}