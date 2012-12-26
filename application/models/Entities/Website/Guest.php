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
     * @OneToOne(targetEntity="\Entities\Website\Guest\Account", mappedBy="Guest", cascade={"persist"})
     * @var \Entities\Website\Guest\Account $Account
     */
    protected $Account;
    
    /**
     * @param Guest\Account $Account
     */
    public function setAccount(Guest\Account $Account)
    {
	$Account->setGuest($this);
	
        $this->Account = $Account;
    }

    /**
     * @return ArrayCollection
     */
    public function getAccount()
    {
	return $this->Account;
    }
}