<?php
namespace Entities\Company\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Location\FaxNumber") 
 * @Crud\Entity\Url(value="location-fax-number")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_location_faxnumbers")
 */
class FaxNumber extends \Entities\Company\FaxNumber\FaxNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Location", inversedBy="FaxNumber")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Location $Location
     */     
    protected $Location;
    
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
	$Location = $this->_getEntityFromArray($array, "Entities\Company\Location", "location_id");
	
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