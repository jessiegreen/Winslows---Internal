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
namespace Entities\Company\Location;
/** 
 * @Entity (repositoryClass="Repositories\Company\Location\PhoneNumber") 
 * @Table(name="company_location_phonenumbers")
 */

class PhoneNumber extends \Entities\PhoneNumber\PhoneNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="Company\Location", inversedBy="PhoneNumber")
     */     
    private $Location;
    
    /**
     * Set location for phone number.
     * @param Location $Location
     */
    public function setLocation(Location $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * Retrieve Location associated to phone number.
     */
    public function getLocation()
    {
	return $this->Location;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}