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
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Website\Menu\Item", mappedBy="Menu", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $Items
     */
    protected $Items;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Website\WebsiteAbstract", inversedBy="Menus")
     * @var \Entities\Website\WebsiteAbstract
     */
    protected $Website;

    public function __construct()
    {
	$this->Items	= new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Website\WebsiteAbstract $Website
     */
    public function setWebsite(\Entities\Website\WebsiteAbstract $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Website\WebsiteAbstract
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
     * Get menus parent items
     * @return array 
     */
    public function getParentItems()
    {
	$parent_items	= $this->getItems()->filter(
		    function($MenuItem){
			if(!$MenuItem->getParent())
			    return true;
		    }
		);
	
	return $parent_items;
    }
    
    /**
     * @param \Entities\Website\Menu\Item $Item
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
    
    public function buildHtmlMenuFromItems(\Dataservice\Html\Menu $HtmlMenu)
    {
	
    }
}