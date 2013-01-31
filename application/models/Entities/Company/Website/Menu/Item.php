<?php

namespace Entities\Company\Website\Menu;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Menu\Item") 
 * @Table(name="company_website_menu_items") 
 * @Crud\Entity\Url(value="website-menu-item")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */

class Item extends \Dataservice_Doctrine_Entity
{
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="integer") 
     * @var integer $id
     */
    protected $Menu_id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name_index
     */
    protected $name_index;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $label
     */
    protected $label;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $icon
     */
    protected $icon;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $link_module
     */
    protected $link_module;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $link_controller
     */
    protected $link_controller;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $link_action
     */
    protected $link_action;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $link_params
     */
    protected $link_params;
    
    /** 
     * @Column(type="integer", length=10) 
     * @var string $sort_order
     */
    protected $sort_order;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Website\Menu", inversedBy="Items")
     * @var \Entities\Company\Website\Menu $Menu
     */     
    protected $Menu;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Website\Menu\Item", inversedBy="children")
     * @JoinColumn(name="parent", referencedColumnName="id")
     * @var $parent null | Item
     */
    protected $parent;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Item", mappedBy="parent", cascade={"persist"}, orphanRemoval=true)
     * @var ArrayCollection $children
     */
    private $children;
    
    public function __construct()
    {
	$this->children = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Website\Menu\Item $parent
     */
    public function setParent(Item $parent)
    {
	$this->parent = $parent;
    }
    
    /**
     * @return null | \Entities\Company\Website\Menu\Item
     */
    public function getParent()
    {
	return $this->parent;
    }
    
    /**
     * @param \Entities\Company\Website\Menu\Item $child
     */
    public function AddChild(Item $Item)
    {
	$Item->setParent($this);
	$this->children[] = $Item;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
	return $this->children;
    }
    
    /**
     * @param \Entities\Company\Website\Menu $Menu
     */
    public function setMenu(\Entities\Company\Website\Menu $Menu)
    {
        $this->Menu = $Menu;
    }
    
    /**
     * @return \Entities\Company\Website\Menu
     */
    public function getMenu()
    {
	return $this->Menu;
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
    public function setNameIndex($name_index)
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
    public function setIcon($icon)
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
    public function setLinkModule($link_module)
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
    public function setLinkController($link_controller)
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
    public function setLinkAction($link_action)
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
    public function setLinkParams($link_params)
    {
	$this->link_params = $link_params;
    }
    
    /**
     * @return string
     */
    public function getOrder()
    {
        return $this->sort_order;
    }

    /**
     * @param integer $order
     */
    public function setOrder($order)
    {
        $this->sort_order = $order;
    }
    
    /**
     * @return array 
     */
    public function getUrlArray()
    {	
	$route_array = array(
	    "module"	    => $this->getLinkModule(),
	    "controller"    => $this->getLinkController(),
	    "action"	    => $this->getLinkAction()
	);
	
	$params_array = $this->getLinkParamsAsArray();
	
	return array_merge($route_array, $params_array);
    }
    
    /**
     * Assembles URL string from array using \Zend_Controller_Action_Helper_Url
     * @return string
     */
    public function getUrlString()
    {
	$url_array  = $this->getUrlArray();
	$url_helper = new \Zend_Controller_Action_Helper_Url;
	
	unset($url_array["module"]);
	
	return $url_helper->url(
		$url_array,	
		$this->getLinkModule(),
		true
		);
    }
    
    /**
     * @return array 
     */
    public function getLinkParamsAsArray()
    {
	$params			= array();
	$link_params		= trim($this->getLinkParams());
	
	if($link_params)$params = (array) json_decode ($link_params);
	
	return $params;
    }
}