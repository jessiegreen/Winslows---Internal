<?php
namespace Services\Company\Website;

class Menu extends \Dataservice_Service_ServiceAbstract
{
    
    public function getAllMenus()
    {
	/* @var $MenuRepos \Repositories\Menu */
	$MenuRepos = $this->_em->getRepository('Entities\Website\Menu');
	
	return $MenuRepos->findBy(array(), array("name" => "ASC"));
    }
    
    public function getAllMenuItems()
    {
	/* @var $MenuItemRepos \Repositories\MenuItem */
	$MenuItemRepos = $this->_em->getRepository('Entities\Website\Menu\Item');
	
	return $MenuItemRepos->findBy(array(), array("label" => "ASC"));
    }
}