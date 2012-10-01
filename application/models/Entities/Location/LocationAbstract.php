<?php

namespace Entities\Location;

/** 
 * @Entity (repositoryClass="Repositories\Location\LocationAbstract") 
 * @Table(name="location_locationabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"company_location" = "\Entities\Company\Location", 
 *			"company_dealer_location" = "\Entities\Company\Dealer\Location"
 *		    })
 * @HasLifecycleCallbacks
 */
class LocationAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $name
     */
    protected $name;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $type
     */
    protected $type;

    /**
     * @OneToOne(targetEntity="\Entities\Company\Location\Address", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     * @var Entities\Company\Location\Address $Address
     */
    protected $Address;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company\Location\PhoneNumber", mappedBy="Location", cascade={"persist"}, orphanRemoval=true)
     * @var \Entities\Company\Location\PhoneNumber $PhoneNumber
     */
    protected $PhoneNumber;

    

    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * @param \Entities\Company\Location\PhoneNumber $PhoneNumber
     */
    public function setPhoneNumber(Location\PhoneNumber $PhoneNumber)
    {
	$PhoneNumber->setLocation($this);
        $this->PhoneNumber = $PhoneNumber;
    }
    
    /**
     * @return \Entities\Company\Location\PhoneNumber
     */
    public function getPhoneNumber()
    {
        return $this->PhoneNumber;
    }

    /**
     * @param \Entities\Company\Location\Address $Address
     */
    public function setAddress(Location\Address $Address)
    {
	$Address->setLocation($this);
        $this->Address = $Address;
    }
    
    /**
     * @return \Entities\Company\Location\Address
     */
    public function getAddress()
    {
        return $this->Address;
    }
    
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @throws \Exception
     */
    public function setType($type)
    {
	if(!key_exists($type, $this->getTypeOptions()))
	    throw new \Exception("Type option of ".htmlspecialchars ($type)." does not exist");
	
        $this->type = $type;
    }
    
    /**
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function getTypeDisplay($type = null)
    {
	if($type === null)
	{
	    $type = $this->type; 
	}
	
	if(!$type)return "";
	
	$array = $this->getTypeOptions();
	
	if(!key_exists($type, $array))
	    throw new \Exception("Could not get Type Display. Key '".$type."' does not exist");
	
	return $array[$type];
    }
    
    /**
     * @return array
     */
    public function getTypeOptions()
    {
	return array(
	    "sales" => "Sales",
	);
    }
}