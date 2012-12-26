<?php
namespace Services\Company\Website;

use \Entities\Website\Menu\Item as Item;

class Menu extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @param \Classes\Menu $Menu
     * @param string $menu_name_index
     * @return \Classes\Menu
     */
    public function getMenuHTMLObject(\Classes\Menu $MenuBuilder, \Entities\Website\Menu $Menu)
    {
	$parent_items	= $Menu->getParentItems();
	$AclService	= \Services\ACL::factory();
	
	/* @var $menu_item \Entities\Website\Menu\Item */
	foreach($parent_items as $MenuItem)
        {
	    $MenuBuilder = $this->GetMenuHTMLAdd($MenuItem, $MenuBuilder, $AclService);
	}
        
	return $MenuBuilder;
    }    
    
    /**
     * @param \Entities\Website\Menu\Item $menu_item 
     */
    private function GetMenuHTMLAdd(Item $MenuItem, \Classes\Menu $menu, \Services\ACL $AclService)
    {
	$children   = $MenuItem->getChildren();
	
	if($children)
	{
	    #-- create new list
	    $menu2 = \Classes\Menu::factory();
	    
	    /* @var $menu_item \Entities\Website\Menu\Item */
	    foreach($children as $MenuItem2)
	    {
		#--Add a children and/or child lists to the newly created list
		$menu2   = $this->GetMenuHTMLAdd($MenuItem2,$menu2, $AclService);
	    }	    
	    
	    #--Add current parent menu with the child menu
	    if($AclService->isUserAllowed($MenuItem->getUrlArray()))
		$menu = $menu->add($MenuItem->getLabel(), $MenuItem->getUrlString(), $menu2);
	    
	    return $menu;
	}
	else
	{
	    if($AclService->isUserAllowed($MenuItem->getUrlArray()))
		$menu = $menu->add($MenuItem->getLabel(), $MenuItem->getUrlString());
	    
	    return $menu;
	}
    }
    
    public function getAllMenus(){
	/* @var $MenuRepos \Repositories\Menu */
	$MenuRepos	= $this->_em->getRepository('Entities\Website\Menu');
	return $MenuRepos->findBy(array(), array("name" => "ASC"));
    }
    
    public function getAllMenuItems(){
	/* @var $MenuItemRepos \Repositories\MenuItem */
	$MenuItemRepos	= $this->_em->getRepository('Entities\Website\Menu\Item');
	return $MenuItemRepos->findBy(array(), array("label" => "ASC"));
    }
}