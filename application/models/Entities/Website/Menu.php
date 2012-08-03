<?php

namespace Entities\Website;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\Website\Menu") 
 * @Table(name="website_menus") 
 * @HasLifecycleCallbacks
 */
class Menu
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    private $id;

    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    private $name;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $created
     */
    private $created;

    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    private $updated;

    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="Website\Menu\Item", mappedBy="Menu", cascade={"persist"}, orphanRemoval=true)
     * @var array $Items
     */
    private $Items;

    public function __construct()
    {

      $this->Items	= new ArrayCollection();
      $this->created	= $this->updated = new \DateTime("now");
    }
   
    /**
     * Add item to menu.
     * @param Website\Menu\Item $Item
     */
    public function addItem(Website\Menu\Item $Item)
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
     * @param \Entities\Website\Menu\Item $Item
     * @return boolean
     */
    public function removeItem(Website\Menu\Item $Item){
	foreach ($this->Items as $key => $Item2) {
	    if($Item->getId() == $Item2->getId()){
		$removed = $this->Items[$key];
		unset($this->Items[$key]);
		return $removed;
	    }
	}
	return false;
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
    public function setName(string $name)
    {
	$this->name = $name;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
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