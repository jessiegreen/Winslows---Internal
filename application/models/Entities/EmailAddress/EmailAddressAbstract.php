<?php
namespace Entities\EmailAddress;

use Doctrine\Common\Collections\ArrayCollection;

/** 
 * @Entity (repositoryClass="Repositories\EmailAddress\EmailAddressAbstract") 
 * @Table(name="emailaddress_emailaddressabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"person_emailaddress" = "\Entities\Person\EmailAddress"})
 * @HasLifecycleCallbacks
 */
class EmailAddressAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer
     */
    protected $id;

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
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\EmailAddress\Email", mappedBy="EmailAddress", cascade={"persist"})
     * @var \Doctrine\Common\Collections\ArrayCollection $Emails
     */
    protected $Emails;
    
    public function __construct()
    {
	$this->Emails = new ArrayCollection();
	
	parent::__construct();
    }
    
    /**
     * @param Email $Email
     */
    public function addEmail(Email $Email)
    {
	$Email->setEmailAddress($this);
	
        $this->Emails->add($Email);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getEmails()
    {
	return $this->Emails;
    }

    /**
     * @var integer
     */
    public function getId()
    {
        return $this->id;
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
