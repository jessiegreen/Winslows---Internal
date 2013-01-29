<?php
namespace Entities\Company\EmailAddress;

/** 
 * @Entity (repositoryClass="Repositories\Company\EmailAddress\EmailAddressAbstract") 
 * @Table(name="company_emailaddress_emailaddressabstracts") 
 */
abstract class EmailAddressAbstract extends \Entities\Company\Contact\MediumAbstract
{
    /** 
     * @Column(type="string", length=255) 
     * @var string $address
     */
    protected $address;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $type
     */
    protected $type;
    
    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
    
    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    
    public function toString()
    {
	return \Dataservice\Inflector::humanize($this->getType())." - ".strtolower($this->getAddress());
    }
    
    /**
     * @return array
     */
    public function getTypeOptions()
    {
	return array(
	    "personal"	=> "Personal",
	    "work"	=> "Work"
	);
    }
}
