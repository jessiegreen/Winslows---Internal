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
namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\MenuItem") 
 * @Table(name="menuitems") 
 */

class MenuItem
{
    /** 
     * @ManyToOne(targetEntity="Menu", inversedBy="menuitems")
     */     
    private $menu;
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(type="integer") */
    private $menu_id;
    
    /** @Column(type="string", length=255) */
    private $name_index;
    
    /** @Column(type="string", length=255) */
    private $label;
    
    /** @Column(type="string", length=255) */
    private $icon;
    
    /** @Column(type="string", length=255) */
    private $link_module;
    
    /** @Column(type="string", length=255) */
    private $link_controller;
    
    /** @Column(type="string", length=255) */
    private $link_action;
    
    /** @Column(type="string", length=255) */
    private $link_params;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;
    
    /**
     * @ManyToOne(targetEntity="MenuItem", inversedBy="children")
     * @JoinColumn(name="parent", referencedColumnName="id")
     * @var $parent null | MenuItem
     */
    private $parent;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="MenuItem", mappedBy="parent", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $children;
    
    public function __construct()
    {
	$this->children = new ArrayCollection();
	$this->created	= $this->updated = new \DateTime("now");
    }
    
    public function setParent(MenuItem $parent){
	$this->parent = $parent;
    }
    
    public function getParent(){
	return $this->parent;
    }
    
    public function AddChild(MenuItem $child){
	$child->setParent($this);
	$this->children[] = $child;
    }
    
    public function getChildren(){
	return $this->children;
    }
    
    /**
     * Assign Menu to MenuItem.
     * @param Menu $menu
     */
    public function setMenu(Menu $menu)
    {
        $this->menu = $menu;
	$this->menu_id = $menu->getId();
    }
    
    /**
     * Retrieve menuitem's associated menu.
     */
    public function getMenu()
    {
	return $this->menu;
    }
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
    }

    /**
     * Retrieve person id
     */
    public function getId()
    {
        return $this->id;
    }

    public function getNameIndex()
    {
        return $this->name_index;
    }
    
    public function setNameIndex($name_index)
    {
	$this->name_index = $name_index;
    }
    
    public function getMenuId()
    {
        return $this->menu_id;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function setLabel($label)
    {
	$this->label = $label;
    }
    
    public function getIcon()
    {
        return $this->icon;
    }
    
    public function setIcon($icon)
    {
	$this->icon = $icon;
    }
    
    public function getLinkModule()
    {
        return $this->link_module;
    }
    
    public function setLinkModule($link_module)
    {
	$this->link_module = $link_module;
    }
    
    public function getLinkController()
    {
        return $this->link_controller;
    }
    
    public function setLinkController($link_controller)
    {
	$this->link_controller = $link_controller;
    }
    
    public function getLinkAction()
    {
        return $this->link_action;
    }
    
    public function setLinkAction($link_action)
    {
	$this->link_action = $link_action;
    }
    
    public function getLinkParams()
    {
        return $this->link_params;
    }
    
    public function setLinkParams($link_params)
    {
	$this->link_params = $link_params;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }
}

?>
