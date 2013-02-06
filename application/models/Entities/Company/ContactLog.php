<?php
namespace Entities\Company;

/**
 * @Entity (repositoryClass="Repositories\Company\ContactLog") 
 * @Table(name="company_contactlogs")
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="contact-log")
 * @Crud\Entity\Permissions(view={"Admin"}, create={"Admin"})
 */
class ContactLog extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company", inversedBy="ContactLog", cascade={"persist"})
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company $Company
     */
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\ContactLog\Contact", mappedBy="ContactLog", cascade={"persist"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
     * @var \Doctrine\Common\Collections\ArrayCollection $Contacts
     */
    protected $Contacts;
    
    /**
     * @return integer
     */
    public function getId()
    {
	return $this->id;
    }
    
    /**
     * @return \Entities\Company
     */
    public function getCompany()
    {
	return $this->Company;
    }
    
    /**
     * @param \Entities\Company $Company
     */
    public function setCompany(\Entities\Company $Company)
    {
	$this->Company = $Company;
    }
    
    public function addContact(ContactLog\Contact $Contact)
    {
	$Contact->setContactLog($this);
	
	$this->Contacts->add($Contact);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getContacts()
    {
	return $this->Contacts;
    }
    
    public function toString()
    {
	return $this->getCompany()->getName();
    }
}