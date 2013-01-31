<?php
namespace Entities\Company\Location;

/** 
 * @Entity (repositoryClass="Repositories\Company\Location\FaxNumber") 
 * @Crud\Entity\Url(value="location-address")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 * @Table(name="company_location_faxnumbers")
 */
class FaxNumber extends \Entities\Company\FaxNumber\FaxNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Company\Location\LocationAbstract", inversedBy="FaxNumber")
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