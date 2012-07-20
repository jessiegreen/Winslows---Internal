<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Menu") 
 * @Table(name="menus") 
 * @HasLifecycleCallbacks
 */
class Menu
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string", length=255) */
    private $name;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="MenuItem", mappedBy="Menu", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $MenuItems;

    public function __construct()
    {

      $this->MenuItems	= new ArrayCollection();
      $this->created	= $this->updated = new \DateTime("now");
    }
   
    /**
     * Add menuitem to menu.
     * @param MenuItem $menuitem
     */
    public function addMenuItem(MenuItem $MenuItem)
    {
	$MenuItem->setMenu($this);
        $this->MenuItems[] = $MenuItem;
    }
    
    /**
     * Retrieve menu's menuitems.
     */
    public function getMenuItems()
    {
      return $this->MenuItems;
    }
    
    public function removeMenuItem(MenuItem $MenuItem){
	foreach ($this->MenuItems as $key => $MenuItem2) {
	    if($MenuItem->getId() == $MenuItem2->getId()){
		$removed = $this->MenuItems[$key];
		unset($this->MenuItems[$key]);
		return $removed;
	    }
	}
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

    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
	$this->name = $name;
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

    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}