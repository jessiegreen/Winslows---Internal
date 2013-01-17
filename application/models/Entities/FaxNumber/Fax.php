<?php

namespace Entities\FaxNumber;

/**
 * @Entity (repositoryClass="Repositories\FaxNumber\Fax") 
 * @Table(name="faxnumber_faxes")
 * @HasLifecycleCallbacks
 */
class Fax extends \Entities\Contact\ContactAbstract
{   
    /** 
     * @ManyToOne(targetEntity="\Entities\FaxNumber\FaxNumberAbstract", inversedBy="Faxes")
     * @var \Entities\FaxNumber\FaxNumberAbstract $FaxNumber
     */     
    protected $FaxNumber;
    
    /**
     * @param FaxNumberAbstract $FaxNumber
     */
    public function setFaxNumber(FaxNumberAbstract $FaxNumber)
    {
	$this->FaxNumber = $FaxNumber;
    }
    
    /**
     * @return FaxNumberAbstract
     */
    public function getFaxNumber()
    {
	return $this->FaxNumber;
    }
}