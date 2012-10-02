<?php

namespace Entities\Company\Dealer;

/**
 * @Entity (repositoryClass="Repositories\Company\Dealer\Location") 
 * @Table(name="company_dealer_locations")
 * @HasLifecycleCallbacks
 */
class Location extends \Entities\Location\LocationAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Dealer", inversedBy="Locations")
     * @var \Entities\Company\Dealer
     */     
    protected $Dealer;
    
    /**
     * @return \Entities\Company\Dealer
     */
    public function getDealer()
    {
	return $this->Dealer;
    }
    
    /**
     * @param \Entities\Company\Dealer $Dealer
     */
    public function setDealer(\Entities\Company\Dealer $Dealer)
    {
	$this->Dealer = $Dealer;
    }
}