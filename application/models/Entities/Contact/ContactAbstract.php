<?php

namespace Entities\Contact;

/** 
 * @Entity (repositoryClass="Repositories\Contact\ContactAbstract") 
 * @Table(name="contact_contactabstracts") 
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({
 *			"phonenumberphone_call" = "\Entities\PhoneNumber\Call",
 *			"emailaddress_email" = "\Entities\EmailAddress\Email",
 *			"address_mail" = "\Entities\Address\Mail",
 *			"faxnumber_fax" = "\Entities\FaxNumber\Fax",
 *			"location_visit" = "\Entities\Location\Visit"
 *		    })
 * @HasLifecycleCallbacks
 */
abstract class ContactAbstract extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="string", length=1500) 
     * @var string $description
     */
    protected $description;
    
    /** 
     * @Column(type="datetime") 
     * @var \DateTime $updated
     */
    protected $datetime;

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
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    /**
     * @return \Dataservice\DateTime
     */
    public function getDateTime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $DateTime
     */
    public function setDateTime(\DateTime $DateTime)
    {
        $this->datetime = $DateTime;
    }
}