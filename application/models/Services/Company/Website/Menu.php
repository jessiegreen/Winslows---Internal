<?php
namespace Services\Company\Website;

use \Entities\Company\Website\Menu\Item as Item;

class Menu 
{
    /**
     * @param type $menu_name 
     * @return \Classes\Menu
     */
    public function getMenuHTML($menu_name)
    {
	$parent_items	= $this->getMenuParentItems($menu_name);
	$AclService	= \Services\ACL::factory();
	$Menu		= \Classes\Menu::factory();
	
	/* @var $menu_item \Entities\Company\Website\Menu\Item */
	foreach($parent_items as $MenuItem)
	{
	    $Menu   = $this->GetMenuHTMLAdd($MenuItem, $Menu, $AclService);
	}
	return $Menu;
    }    
    
    /**
     * @param \Entities\Company\Website\Menu\Item $menu_item 
     */
    private function GetMenuHTMLAdd(Item $MenuItem, \Classes\Menu $menu, \Services\ACL $AclService)
    {
	$children   = $MenuItem->getChildren();
	
	if($children)
	{
	    #-- create new list
	    $menu2 = \Classes\Menu::factory();
	    
	    /* @var $menu_item \Entities\Company\Website\Menu\Item */
	    foreach($children as $MenuItem2)
	    {
		#--Add a children and/or child lists to the newly created list
		$menu2   = $this->GetMenuHTMLAdd($MenuItem2,$menu2, $AclService);
	    }	    
	    
	    #--Add current parent menu with the child menu
	    if($AclService->isUserAllowed($this->getUrlArray($MenuItem)))
		$menu = $menu->add($MenuItem->getLabel(), $this->getUrlString($MenuItem), $menu2);
	    
	    return $menu;
	}
	else
	{
	    if($AclService->isUserAllowed($this->getUrlArray($MenuItem)))
		$menu = $menu->add($MenuItem->getLabel(), $this->getUrlString($MenuItem));
	    return $menu;
	}
    }
    
    /**
     * Gets url parts from MenuItem and puts them into array
     * @param \Entities\Company\Website\Menu\Item $MenuItem
     * @return array 
     */
    public function getUrlArray(\Entities\Company\Website\Menu\Item $MenuItem)
    {	
	return array(
	    "module"	    => $MenuItem->getLinkModule(),
	    "controller"    => $MenuItem->getLinkController(),
	    "action"	    => $MenuItem->getLinkAction(),
	    "params"	    => $this->decodeLinkParams($MenuItem)
	);
    }
    
    /**
     * Assembles URL string from array
     * @param \Entities\Company\Website\Menu\Item $MenuItem
     * @return string
     */
    public function getUrlString(\Entities\Company\Website\Menu\Item $MenuItem)
    {
	$url_array  = $this->getUrlArray($MenuItem);
	$url_helper = new \Zend_Controller_Action_Helper_Url;
	
	return $url_helper->simple(
		$url_array["action"],
		$url_array["controller"],
		$url_array["module"],
		$url_array["params"]
		);
    }
    
    /**
     * Get menus parent items
     * @param string $menu_name
     * @return array 
     */
    public function getMenuParentItems($menu_name)
    {
	/* @var $MenuRepos \Repositories\Menu */
	$MenuRepos	= $this->_em->getRepository('Entities\Company\Website\Menu');
	/* @var $MenuItemRepos \Repositories\MenuItem */
	$MenuItemRepos	= $this->_em->getRepository('Entities\Company\Website\Menu\Item');	
	$menu_id	= $MenuRepos->getMenuByName($menu_name)->getId();
	$parent_items	= $MenuItemRepos->getMenuParentItemsByMenuId($menu_id);
	
	return $parent_items;
    }
    
    /**
     * @param string $menu_name
     * @return \Entities\Company\Website\Menu  
     */
    public function getMenuByName($menu_name){
	/* @var $MenuRepos \Repositories\Menu */
	$MenuRepos	= $this->_em->getRepository('Entities\Company\Website\Menu');
	return $MenuRepos->findOneBy(array("name" => $menu_name));
    }
    
    /**
     *
     * @param \Entities\Company\Website\Menu\Item $MenuItem
     * @return type 
     */
    public function decodeLinkParams(\Entities\Company\Website\Menu\Item $MenuItem){
	$params			= array();
	$link_params		= trim($MenuItem->getLinkParams());
	if($link_params)$params =  (array) json_decode ($link_params);
	return $params;
    }
    
    public function getAllMenus(){
	/* @var $MenuRepos \Repositories\Menu */
	$MenuRepos	= $this->_em->getRepository('Entities\Company\Website\Menu');
	return $MenuRepos->findBy(array(), array("name" => "ASC"));
    }
    
    public function getAllMenuItems(){
	/* @var $MenuItemRepos \Repositories\MenuItem */
	$MenuItemRepos	= $this->_em->getRepository('Entities\Company\Website\Menu\Item');
	return $MenuItemRepos->findBy(array(), array("label" => "ASC"));
    }
}

?>
