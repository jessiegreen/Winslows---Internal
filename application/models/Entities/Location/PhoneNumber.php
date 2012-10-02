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
namespace Entities\Location;
/** 
 * @Entity (repositoryClass="Repositories\Location\PhoneNumber") 
 * @Table(name="location_phonenumbers")
 */
class PhoneNumber extends \Entities\PhoneNumber\PhoneNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Location\LocationAbstract", inversedBy="PhoneNumber")
     * @var \Entities\Location\LocationAbstract $Location
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