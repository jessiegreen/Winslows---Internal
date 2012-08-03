<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Website\Menu;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Website\Menu\Item") 
 * @Table(name="website_menu_items") 
 */

class Item
{
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;
    
    /** 
     * @Column(type="integer") 
     * @var integer $id
     */
    private $Menu_id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    private $name_index;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $label
     */
    private $label;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $icon
     */
    private $icon;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $link_module
     */
    private $link_module;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $link_controller
     */
    private $link_controller;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $link_action
     */
    private $link_action;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $link_params
     */
    private $link_params;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    private $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    private $updated;
    
    /** 
     * @ManyToOne(targetEntity="Website\Menu", inversedBy="Items")
     * @var \Entities\Website\Menu $Menu
     */     
    private $Menu;
    
    /**
     * @ManyToOne(targetEntity="Item", inversedBy="children")
     * @JoinColumn(name="parent", referencedColumnName="id")
     * @var $parent null | Item
     */
    private $parent;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Item", mappedBy="parent", cascade={"persist"}, orphanRemoval=true)
     * @var array $children
     */
    private $children;
    
    public function __construct()
    {
	$this->children = new ArrayCollection();
	$this->created	= $this->updated = new \DateTime("now");
    }
    
    /**
     * @param \Entities\Website\Menu\Item $parent
     */
    public function setParent(Item $parent){
	$this->parent = $parent;
    }
    
    /**
     * @return null | \Entities\Website\Menu\Item
     */
    public function getParent(){
	return $this->parent;
    }
    
    /**
     * @param \Entities\Website\Menu\Item $child
     */
    public function AddChild(Item $Item){
	$Item->setParent($this);
	$this->children[] = $Item;
    }
    
    /**
     * @return array
     */
    public function getChildren(){
	return $this->children;
    }
    
    /**
     * @param \Entities\Website\Menu $Menu
     */
    public function setMenu(\Entities\Website\Menu $Menu)
    {
        $this->Menu = $Menu;
    }
    
    /**
     * @return \Entities\Website\Menu
     */
    public function getMenu()
    {
	return $this->Menu;
    }
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
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
    public function getNameIndex()
    {
        return $this->name_index;
    }
    
    /**
     * @param string $name_index
     */
    public function setNameIndex(string $name_index)
    {
	$this->name_index = $name_index;
    }
    
    /**
     * @return integer
     */
    public function getMenuId()
    {
        return $this->Menu_id;
    }
    
    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * @param type $label
     */
    public function setLabel($label)
    {
	$this->label = $label;
    }
    
    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }
    
    /**
     * @param string $icon
     */
    public function setIcon(string $icon)
    {
	$this->icon = $icon;
    }
    
    /**
     * @return string
     */
    public function getLinkModule()
    {
        return $this->link_module;
    }
    
    /**
     * @param string $link_module
     */
    public function setLinkModule(string $link_module)
    {
	$this->link_module = $link_module;
    }
    
    /**
     * @return string
     */
    public function getLinkController()
    {
        return $this->link_controller;
    }
    
    /**
     * @param string $link_controller
     */
    public function setLinkController(string $link_controller)
    {
	$this->link_controller = $link_controller;
    }
    
    /**
     * @return string
     */
    public function getLinkAction()
    {
        return $this->link_action;
    }
    
    /**
     * @param string $link_action
     */
    public function setLinkAction(string $link_action)
    {
	$this->link_action = $link_action;
    }
    
    /**
     * @return string
     */
    public function getLinkParams()
    {
        return $this->link_params;
    }
    
    /**
     * @param string $link_params
     */
    public function setLinkParams(string $link_params)
    {
	$this->link_params = $link_params;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}