<?php
namespace Entities\Company\Dealer\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Dealer\Location\PhoneNumber") 
 * @Crud\Entity\Url(value="dealer-location-phone-number")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_dealer_location_phonenumbers")
 */
class PhoneNumber extends \Entities\Company\PhoneNumber\PhoneNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Dealer\Location", inversedBy="PhoneNumber")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Dealer\Location $Location
     */     
    protected $Location;
    
    /**
     * @param \Entities\Company\Dealer\Location $Location
     */
    public function setLocation(\Entities\Company\Dealer\Location $Location)
    {
        $this->Location = $Location;
    }
    
    /**
     * @return \Entities\Company\Dealer\Location
     */
    public function getLocation()
    {
	return $this->Location;
    }
    
    public function populate(array $array)
    {
	$Location = $this->_getEntityFromArray($array, "Entities\Company\Dealer\Location", "location_id");
	
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