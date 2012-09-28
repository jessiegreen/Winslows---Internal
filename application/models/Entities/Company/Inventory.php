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
     * @OneToMany(targetEntity="\Entities\Company\Inventory\Item\ItemAbstract", mappedBy="Inventory", cascade={"persist"})
     * @var array $Items
     */
    protected $Items;
    
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
    public function setLead(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
}