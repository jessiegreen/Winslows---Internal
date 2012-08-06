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
     * @var \Entities\Company\Location $Location
     */     
    private $Location;
    
    /**
     * @param \Entities\Company\Location $Location
     */
    public function setLocation(\Entities\Company\Location $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * @return \Entities\Company\Location
     */
    public function getLocation()
    {
	return $this->Location;
    }
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}