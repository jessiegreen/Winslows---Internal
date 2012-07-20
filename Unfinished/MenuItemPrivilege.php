<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\MenuItem") 
 * @Table(name="menuitems") 
 */

class MenuItemPrivilege
{
    /** 
     * @ManyToOne(targetEntity="MenuItem", inversedBy="privileges")
     */     
    private $menuitem;
    
    /**
     * @ManyToOne(targetEntity="Privilege", inversedBy="menuitems")
     */
    private $privilege;

    /** @Column(type="datetime") */
    private $created;

    /** @Column(type="datetime") */
    private $updated;
    
    public function __construct()
    {
	$this->created	= $this->updated = new \DateTime("now");
    }
    
    public function setMenuItem(MenuItem $MenuItem){
	$this->menuitem = $MenuItem;
    }
    
    /**
     * Assign Privilege to MenuItem.
     * @param Menu $menu
     */
    public function setPrivilege(Privilege $Privilege)
    {
        $this->privilege = $Privilege;
    }
    
    /**
     * @PreUpdate
     */
    public function updated()
    {
        $this->updated = new \DateTime("now");
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
}

?>
