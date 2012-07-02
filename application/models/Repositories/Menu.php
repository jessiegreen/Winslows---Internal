<?php

namespace Repositories;

use Doctrine\ORM\EntityRepository;

class Menu extends EntityRepository
{  
    /**
     * Get a menu by name
     * @param string $name
     * @return \Entities\Menu 
     */
    public function getMenuByName($name){
	$Menu = $this->findOneByName($name);
	return $Menu;
    }
    
    /**
     * Get a menu by id
     * @param string $id
     * @return \Entities\Menu 
     */
    public function getMenuById($id){
	$Menu = $this->findOneById($id);
	return $Menu;
    }
}