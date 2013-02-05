<?php
namespace Entities\Company\Website;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Menu") 
 * @Table(name="company_website_menus") 
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="website-menu")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
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
     * @OneToMany(targetEntity="\Entities\Company\Website\Menu\Item", mappedBy="Menu", cascade={"persist"}, orphanRemoval=true)
     * @OrderBy({"sort_order" = "ASC"})
     * @var ArrayCollection $Items
     */
    protected $Items;
    
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Website\WebsiteAbstract", inversedBy="Menus")
     * @var \Entities\Company\Website\WebsiteAbstract
     */
    protected $Website;

    public function __construct()
    {
	$this->Items	= new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Company\Website\WebsiteAbstract $Website
     */
    public function setWebsite(\Entities\Company\Website\WebsiteAbstract $Website)
    {
	$this->Website = $Website;
    }
    
    /**
     * @return \Entities\Company\Website\WebsiteAbstract
     */
    public function getWebsite()
    {
	return $this->Website;
    }
   
    /**
     * Add item to menu.
     * @param \Entities\Company\Website\Menu\Item $Item
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
     * @param \Dataservice\Html\Menu $HtmlMenu
     * @param \Zend_Auth $Auth
     * @param \Zend_Acl $Acl
     * @return \Dataservice\Html\Menu
     */
    public function buildHtmlMenu(\Dataservice\Html\Menu $HtmlMenu, \Zend_Auth $Auth, \Zend_Acl $Acl)
    {
	$ParentItems	= $this->getParentItems();
	$Account	= $this->getWebsite()->getCurrentUserAccount($Auth);
	
	/* @var $menu_item \Entities\Company\Website\Menu\Item */
	foreach($ParentItems as $MenuItem)
        {
	    $MenuBuilder = $this->_addMenuHTMLChild($MenuItem, $HtmlMenu, $Account, $Acl);
	}
        
	return $MenuBuilder;
    }  
    
    /**
     * 
     * @param \Entities\Company\Website\Item $MenuItem
     * @param \Dataservice\Html\Menu $HtmlMenu
     * @param \Entities\Company\Website\Account\AccountAbstract $Account
     * @param \Zend_ACL $Acl
     * @return \Dataservice\Html\Menu
     */
    private function _addMenuHTMLChild(
			Menu\Item $MenuItem, 
			\Dataservice\Html\Menu $HtmlMenu, 
			\Entities\Company\Website\Account\AccountAbstract $Account, 
			\Zend_ACL $Acl
    )
    {
	$Children = $MenuItem->getChildren();
	
	if($Children)
	{
	    #-- create new list
	    $HtmlMenu2 = $HtmlMenu->factory();
	    
	    /* @var $menu_item \Entities\Company\Website\Menu\Item */
	    foreach($Children as $MenuItem2)
	    {
		#--Add a children and/or child lists to the newly created list
		$HtmlMenu2   = $this->_addMenuHTMLChild($MenuItem2, $HtmlMenu2, $Account, $Acl);
	    }	    
	    
	    #--Add current parent menu with the child menu
	    if($Account->isAllowedToAccessRouteArray($MenuItem->getUrlArray(), $Acl))
		$HtmlMenu = $HtmlMenu->add($MenuItem->getLabel(), $MenuItem->getUrlString(), $HtmlMenu2);
	    
	    return $HtmlMenu;
	}
	else
	{
	    if($Account->isAllowedToAccessRouteArray($MenuItem->getUrlArray()))
		$HtmlMenu = $HtmlMenu->add($MenuItem->getLabel(), $MenuItem->getUrlString());
	    
	    return $HtmlMenu;
	}
    }
    
    public function toString()
    {
	return $this->getName();
    }
}