<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.ims@gmail.com>
 * @copyright  2012 Research Associates Labratory.
 * @version    Release: @package_version@
 */
namespace Entities\Location;
/** 
 * @Entity (repositoryClass="Repositories\Location\FaxNumber") 
 * @Table(name="location_faxnumbers")
 */
class FaxNumber extends \Entities\FaxNumber\FaxNumberAbstract
{
    /** 
     * @OneToOne(targetEntity="\Entities\Location\LocationAbstract", inversedBy="FaxNumber")
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