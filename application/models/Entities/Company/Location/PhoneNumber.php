<?php
namespace Entities\Company\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Location\PhoneNumber") 
 * @Table(name="company_location_phonenumbers")
 */
class PhoneNumber extends \Entities\Company\PhoneNumber\PhoneNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Location\LocationAbstract", inversedBy="PhoneNumber")
     * @var \Entities\Company\Location\LocationAbstract $Location
     */     
    protected $Location;
    
    /**
     * @param \Entities\Company\Location\LocationAbstract $Location
     */
    public function setLocation(\Entities\Company\Location\LocationAbstract $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * @return \Entities\Company\Location\LocationAbstract
     */
    public function getLocation()
    {
	return $this->Location;
    }
}