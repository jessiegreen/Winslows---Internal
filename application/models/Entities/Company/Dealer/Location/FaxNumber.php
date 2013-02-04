<?php
namespace Entities\Company\Dealer\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Dealer\Location\FaxNumber") 
 * @Crud\Entity\Url(value="dealer-location-fax-number")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_dealer_location_faxnumbers")
 */
class FaxNumber extends \Entities\Company\FaxNumber\FaxNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Dealer\Location", inversedBy="FaxNumber")
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
	
	if(isset($array["fax_number"]))
	{
	    if(isset($array["fax_number"]["area"]))
		$this->setAreaCode($array["fax_number"]["area"]);
	    
	    if(isset($array["fax_number"]["prefix"]))
		$this->setNum1($array["fax_number"]["prefix"]);
	    
	    if(isset($array["fax_number"]["line"]))
		$this->setNum2($array["fax_number"]["line"]);
	}
	
	parent::populate($array);
    }
}