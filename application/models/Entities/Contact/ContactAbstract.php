<?php

namespace Entities\Contact;

/** 
 * @Entity (repositoryClass="Repositories\Contact\ContactAbstract") 
 * @Table(name="contact_contactabstracts") 
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
     * @OneToOne(targetEntity="\Entities\Contact\Party", mappedBy="Contact", cascade={"persist", "remove"}, orphanRemoval=true)
     * @var Party $Inventory
     */
    protected $Party;

    /**
     * @param \Entities\Contact\Party $Party
     */
    public function setParty(Party $Party)
    {
	$this->Party = $Party;
    }
    
    /**
     * @return Party
     */
    public function getParty()
    {
	return $this->Party;
    }
    
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