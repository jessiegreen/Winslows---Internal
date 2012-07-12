<?php

namespace Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity (repositoryClass="Repositories\Location") 
 * @Table(name="locations")
 * @HasLifecycleCallbacks
 */
class Location
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @Column(type="string", length=255) */
    private $name;
    
    /** @Column(type="string", length=255) */
    private $type;

    /**
     * @OneToOne(targetEntity="LocationAddress", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     */
    protected $locationaddress;
    
    /** 
     * @ManyToOne(targetEntity="Company", inversedBy="locations")
     */     
    private $company;
    
    public function __construct()
    {
	parent::__construct();
    }
    
    public function getCompany(){
	return $this->company;
    }
    
    public function setCompany(Company $Company){
	$this->company = $Company;
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getLocationAddress()
    {
        return $this->locationaddress;
    }
    
    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
	if(!key_exists($type, $this->getTypeOptions()))
	    throw new Exception("Type option of ".htmlspecialchars ($type)." does not exist");
        $this->type = $type;
    }

    public function setAddress(LocationAddress $LocationAddress)
    {
	$LocationAddress->setLocationAddress($this);
        $this->locationaddress = $LocationAddress;
    }
    
    public function getTypeOptions(){
	return array(
	    "sales" => "Sales",
	);
    }
}