<?php

namespace Repositories\Website;

use Doctrine\ORM\EntityRepository;

class Menu extends EntityRepository
{  
    /**
     * Get a menu by name
     * @param string $name
     * @return \Entities\Website\Menu 
     */
    public function getMenuByName($name)
    {
	$Menu = $this->findOneByName($name);
        
	return $Menu;
    }
    
    /**
     * Get a menu by name index
     * @param string $name_index
     * @return \Entities\Website\Menu 
     */
    public function getMenuByNameIndex($name_index)
    {
	$Menu = $this->findOneBy(array('name_index' => $name_index));
        
	return $Menu;
    }
    
    /**
     * Get a menu by id
     * @param string $id
     * @return \Entities\Website\Menu
     */
    public function getMenuById($id)
    {
	$Menu = $this->findOneById($id);
	return $Menu;
    }
}