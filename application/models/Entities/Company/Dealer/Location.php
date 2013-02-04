<?php
namespace Entities\Company\Dealer;

/**
 * @Entity (repositoryClass="Repositories\Company\Dealer\Location") 
 * @Table(name="company_dealer_locations")
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="dealer-location")
 * @Crud\Entity\Permissions(view={"Admin", "Manager"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Location extends \Entities\Company\Location\LocationAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Dealer", inversedBy="Locations")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Dealer
     */     
    protected $Dealer;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Dealer\Location\Address", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var Entities\Company\Dealer\Location\Address $Address
     */
    protected $Address;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Dealer\Location\PhoneNumber", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Dealer\Location\PhoneNumber $PhoneNumber
     */
    protected $PhoneNumber;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Dealer\Location\FaxNumber", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Entities\Company\Dealer\Location\FaxNumber $FaxNumber
     */
    protected $FaxNumber;
    
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
    
    /**
     * @param \Entities\Company\Dealer\Location\PhoneNumber $PhoneNumber
     */
    public function setPhoneNumber(\Entities\Company\Dealer\Location\PhoneNumber $PhoneNumber)
    {
	$PhoneNumber->setLocation($this);
	
        $this->PhoneNumber = $PhoneNumber;
    }
    
    /**
     * @return \Entities\Company\Dealer\Location\PhoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }
    
    /**
     * @param \Entities\Company\Dealer\Location\FaxNumber $FaxNumber
     */
    public function setFaxNumber(\Entities\Company\Dealer\Location\FaxNumber $FaxNumber)
    {
	$FaxNumber->setLocation($this);
	
        $this->FaxNumber = $FaxNumber;
    }
    
    /**
     * @return \Entities\Company\Dealer\Location\FaxNumber
     */
    public function getFaxNumber()
    {
        return $this->FaxNumber;
    }

    /**
     * @param \Entities\Company\Dealer\Location\Address $Address
     */
    public function setAddress(\Entities\Company\Dealer\Location\Address $Address)
    {
	$Address->setLocation($this);
	
        $this->Address = $Address;
    }
    
    /**
     * @return \Entities\Company\Dealer\Location\Address
     */
    public function getAddress()
    {
        return $this->Address;
    }
    
    public function populate(array $array)
    {
	$Dealer = $this->_getEntityFromArray($array, "Entities\Company\Dealer", "dealer_id");
	
	if($Dealer)$this->setDealer($Dealer);
	
	parent::populate($array);
    }
}