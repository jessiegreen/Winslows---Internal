<?php
namespace Entities\Website;

use Doctrine\Common\Collections\ArrayCollection;
use Entities\Person\PersonAbstract as PersonAbstract;

/** 
 * @Entity (repositoryClass="Repositories\Website\Guest") 
 * @Table(name="website_guests") 
 */
class Guest extends PersonAbstract
{
    /**
     * @ManytoMany(targetEntity="\Entities\Website\Guest\Role", cascade={"persist"})
     * @JoinTable(name="website_guest_role_joins")
     * @var ArrayCollection $Roles
     */
    protected $Roles;
    
    /**
     * @OneToMany(targetEntity="\Entities\Website\Guest\Account", mappedBy="Guest", cascade={"persist"})
     * @var ArrayCollection $Contacts
     */
    protected $Accounts;
    
    public function __construct()
    {
	$this->Roles	= new ArrayCollection();
	$this->Accounts	= new ArrayCollection();
	
	parent::__construct();
    }    
    
    /**
     * @param \Entities\Website\Guest\Role $Role
     */
    public function addRole(Guest\Role $Role)
    {
	$Role->addGuest($this);
        $this->Roles[] = $Role;
    }
    
    /**
     * @param \Entities\Website\Guest\Role $Role
     */
    public function removeRole(Guest\Role $Role)
    {
	$this->getRoles()->removeElement($Role);
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles()
    {
	return $this->Roles;
    }
    
    /**
     * @param \Entities\Website\Guest\Role $Role
     * @return boolean
     */
    public function hasRole($Role)
    {
	if($this->getRoles()->contains($Role))
	    return true;
	
	return false;
    }
    
    /**
     * @param Guest\Account $Account
     */
    public function addAccount(Guest\Account $Account)
    {
	$Account->setGuest($this);
        $this->Accounts[] = $Account;
    }
    
    /**
     * @param Guest\Account $Account
     */
    public function removeAccount(Guest\Account $Account)
    {
	$this->getAccounts()->removeElement($Account);
    }

    /**
     * @return ArrayCollection
     */
    public function getAccounts()
    {
	return $this->Accounts;
    }
}