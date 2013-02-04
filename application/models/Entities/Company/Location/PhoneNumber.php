<?php
namespace Entities\Company\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Location\PhoneNumber") 
 * @Crud\Entity\Url(value="location-phone-number")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_location_phonenumbers")
 */
class PhoneNumber extends \Entities\Company\PhoneNumber\PhoneNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Location", inversedBy="PhoneNumber")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Location $Location
     */     
    protected $Location;
    
    /**
     * @param \Entities\Company\Location\LocationAbstract $Location
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
	$Location = $this->_getEntityFromArray($array, "Entities\Company\Location", "location_id");
	
	if($Location)$this->setLocation($Location);
	
	if(isset($array["phone_number"]))
	{
	    if(isset($array["phone_number"]["area"]))
		$this->setAreaCode($array["phone_number"]["area"]);
	    
	    if(isset($array["phone_number"]["prefix"]))
		$this->setNum1($array["phone_number"]["prefix"]);
	    
	    if(isset($array["phone_number"]["line"]))
		$this->setNum2($array["phone_number"]["line"]);
	}
	
	parent::populate($array);
    }
}