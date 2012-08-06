<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Company\Location;
/** 
 * @Entity (repositoryClass="Repositories\Company\Location\Address") 
 * @Table(name="company_location_addresses") 
 */
class Address extends \Entities\Address\AddressAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Location", inversedBy="Address")
     * @var \Entities\Company\Location $Location 
     */     
    private $Location;
    
    /**
     * Add Location to address.
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