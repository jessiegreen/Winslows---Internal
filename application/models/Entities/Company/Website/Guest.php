<?php
namespace Entities\Company\Website;

use Doctrine\Common\Collections\ArrayCollection;
use Entities\Company\Person\PersonAbstract as PersonAbstract;

/** 
 * @Entity (repositoryClass="Repositories\Company\Website\Guest") 
 * @Table(name="company_website_guests") 
 */
class Guest extends PersonAbstract
{
    /**
     * @OneToOne(targetEntity="\Entities\Company\Website\Guest\Account", mappedBy="Guest", cascade={"persist"})
     * @var \Entities\Company\Website\Guest\Account $Account
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