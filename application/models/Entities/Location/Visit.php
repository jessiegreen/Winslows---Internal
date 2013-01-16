<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Location;
/** 
 * @Entity (repositoryClass="Repositories\Location\Visit") 
 * @Table(name="location_visits") 
 */
class Visit extends \Entities\Contact\ContactAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Location\LocationAbstract", inversedBy="Visits")
     * @var LocationAbstract $Location
     */     
    protected $Location;
    
    /**
     * @param \Entities\Location\LocationAbstract $Location
     */
    public function setLocation(\Entities\Location\LocationAbstract $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * @return \Entities\Location\LocationAbstract
     */
    public function getLocation()
    {
	return $this->Location;
    }
}