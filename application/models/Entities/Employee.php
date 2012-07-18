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
/** 
 * @Entity (repositoryClass="Repositories\Employee") 
 * @Table(name="employees") 
 */

use Entities\Person as Person;

class Employee extends Person
{
    /** @Column(type="string", length=255) */
    private $title;
    
    /**
     * @ManyToOne(targetEntity="Location", inversedBy="employees")
     * @JoinColumn(name="location_id", referencedColumnName="id")
     * @var Location $Location
     */
    private $Location;
    
    public function getLocation(){
	return $this->Location;
    }
    
    public function setLocation(Location $Location){
	$this->Location = $Location;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }  
}

?>
