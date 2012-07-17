<?php
namespace Services\Menu;

use Doctrine\ORM\EntityManager;

class Menu {
    private $_em;

    public function __construct()
    {
        $front			= \Zend_Controller_Front::getInstance();
	$bootstrap		= $front->getParam("bootstrap");
	$this->_em		= $bootstrap->getResource('entityManager');
    }
    
    /**
     * @param type $menu_name 
     * @return \Classes\Menu
     */
    public function getMenuHTML($menu_name)
    {
	$AclService = new \Services\ACL\ACL;
	
	$parent_items = $this->getMenuParentItems($menu_name);
	/* @var  $menu \Classes\Menu */
	$menu		= \Classes\Menu::factory();
	
	/* @var $menu_item \Entities\MenuItem */
	foreach($parent_items as $MenuItem){
	    $menu   = $this->GetMenuHTMLAdd($MenuItem, $menu, $AclService);
	}
	return $menu;
    }    
    
    /**
     *
     * @param \Entities\MenuItem $menu_item 
     */
    private function GetMenuHTMLAdd(\Entities\MenuItem $MenuItem, \Classes\Menu $menu, \Services\ACL\ACL $AclService)
    {
	$children   = $MenuItem->getChildren();
	
	if($children){
	    #-- create new list
	    $menu2 = \Classes\Menu::factory();
	    /* @var $menu_item \Entities\MenuItem */
	    foreach($children as $MenuItem2){
		#--Add a children and/or child lists to the newly created list
		$menu2   = $this->GetMenuHTMLAdd($MenuItem2,$menu2, $AclService);
	    }	    
	    #--Add current parent menu with the child menu
	    if($AclService->isUserAllowed($this->getUrlArray($MenuItem)))
		$menu = $menu->add($MenuItem->getLabel(), $this->getUrlString($MenuItem), $menu2);
	    return $menu;
	}
	else{
	    if($AclService->isUserAllowed($this->getUrlArray($MenuItem)))
		$menu = $menu->add($MenuItem->getLabel(), $this->getUrlString($MenuItem));
	    return $menu;
	}
    }
    
    /**
     * Gets url parts from MenuItem and puts them into array
     * @param \Entities\MenuItem $MenuItem
     * @return array 
     */
    public function getUrlArray(\Entities\MenuItem $MenuItem)
    {	
	return array(
	    "module"	    => $MenuItem->getLinkModule(),
	    "controller"    => $MenuItem->getLinkController(),
	    "action"	    => $MenuItem->getLinkAction(),
	    "params"	    => $MenuItem->getLinkParams()
	);
    }
    
    /**
     * Assembles URL string from array
     * @param \Entities\MenuItem $MenuItem
     * @return string
     */
    public function getUrlString(\Entities\MenuItem $MenuItem)
    {
	$url_array  = $this->getUrlArray($MenuItem);
	$url_helper = new \Zend_Controller_Action_Helper_Url;
	return $url_helper->url($url_array);
    }
    
    /**
     * Get menus parent items
     * @param string $menu_name
     * @return array 
     */
    public function getMenuParentItems($menu_name)
    {
	/* @var $MenuRepos \Repositories\Menu */
	$MenuRepos	= $this->_em->getRepository('Entities\Menu');
	/* @var $MenuItemRepos \Repositories\MenuItem */
	$MenuItemRepos	= $this->_em->getRepository('Entities\MenuItem');	
	$menu_id	= $MenuRepos->getMenuByName($menu_name)->getId();
	$parent_items	= $MenuItemRepos->getMenuParentItemsByMenuId($menu_id);
	
	return $parent_items;
    }
    
    /**
     * @param string $menu_name
     * @return \Entities\Menu  
     */
    public function getMenuByName($menu_name){
	/* @var $MenuRepos \Repositories\Menu */
	$MenuRepos	= $this->_em->getRepository('Entities\Menu');
	return $MenuRepos->findOneBy(array("name" => $menu_name));
    }
}

?>