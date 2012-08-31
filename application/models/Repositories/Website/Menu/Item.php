<?php

namespace Repositories\Website\Menu;

use Doctrine\ORM\EntityRepository;

class Item extends EntityRepository
{  
    /**
     * Get a menuitem by name
     * @param string $name_index
     * @return \Entities\Company\Website\Menu\Item
     */
    public function getMenuItemByNameIndex($name_index)
    {
	$MenuItem = $this->findOneBy(array("name_index" => $name_index));
	return $MenuItem;
    }
    
    /**
     * Get a menuitem by id
     * @param string $id
     * @return \Entities\Company\Website\Menu\Item 
     */
    public function getMenuItemById($id)
    {
	$MenuItem = $this->findOneById($id);
	return $MenuItem;
    }
    
    /**
     * Get a menuitems by menu id
     * @param string $menu_id
     * @return  array
     */
    public function getMenuParentItemsByMenuId($menu_id)
    {
	$MenuItemsArray = $this->findBy(array("parent" => null, "Menu_id" => $menu_id), array("label" => "ASC"));
	return $MenuItemsArray;
    }
}