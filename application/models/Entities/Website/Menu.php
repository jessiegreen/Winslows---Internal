<?php

namespace Entities\Website;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Website\Menu") 
 * @Table(name="website_menus") 
 * @HasLifecycleCallbacks
 */
class Menu extends \Dataservice_Doctrine_Entity
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
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Website\Menu\Item", mappedBy="Menu", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $Items
     */
    private $Items;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Website", inversedBy="Menus")
     * @var \Entities\Website
     */
    private $Website;

    public function __construct()
    {
	$this->Items	= new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Website $Website
     */
    public function setWebsite(\Entities\Website $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Website
     */
    public function getWebsite()
    {
	return $this->Website;
    }
   
    /**
     * Add item to menu.
     * @param \Entities\Website\Menu\Item $Item
     */
    public function addItem(Menu\Item $Item)
    {
	$Item->setMenu($this);
        $this->Items[] = $Item;
    }
    
    /**
     * Retrieve menu's items.
     * @return array
     */
    public function getItems()
    {
	return $this->Items;
    }
    
    /**
     * @param \Entities\Company\Website\Menu\Item $Item
     * @return boolean
     */
    public function removeItem(Menu\Item $Item)
    {
	$this->getItems()->removeElement($Item);
    }

    /**
     * Retrieve person id
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