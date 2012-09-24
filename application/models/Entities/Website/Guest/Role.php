<?php
namespace Entities\Website\Guest;

/** 
 * @Entity (repositoryClass="Repositories\Website\Guest\Role") 
 * @Table(name="website_guest_roles") 
 */
class Role extends \Entities\Role\RoleAbstract
{
    /**
     * @ManytoMany(targetEntity="\Entities\Website\Guest", mappedBy="Roles", cascade={"persist"})
     * @var ArrayCollection $Guests
     */
    protected $Guests;
    
    public function __construct()
    {
	$this->Guests = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param \Entities\Website\Guest $Guest
     */
    public function addGuest(\Entities\Website\Guest $Guest)
    {
        $this->Guests[] = $Guest;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getGuests()
    {
	return $this->Guests;
    }
    
    /**
     * @param \Entities\Website\Guest $Guest
     */
    public function removeEmployee(\Entities\Website\Guest $Guest)
    {
	$Guest->removeRole($this);
	$this->Guests->removeElement($Guest);
    }
}
