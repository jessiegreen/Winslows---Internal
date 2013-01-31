<?php
namespace Entities\Company;

/**
 * @Entity (repositoryClass="Repositories\Company\TimeClock") 
 * @Table(name="company_timeclocks")
 * @HasLifecycleCallbacks
 * @Crud\Entity\Url(value="time-clock")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class TimeClock extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /**
     * @OneToOne(targetEntity="\Entities\Company", inversedBy="TimeClock", cascade={"persist"})
     * @var \Entities\Company $Company
     */
    protected $Company;
    
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\TimeClock\Entry", mappedBy="TimeClock", cascade={"persist"})
     * @var \Doctrine\Common\Collections\ArrayCollection $Entries
     */
    protected $Entries;
    
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
    
    public function addEntry(TimeClock\Entry $Entry)
    {
	$Entry->setTimeClock($this);
	
	$this->Entries->add($Entry);
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getEntries()
    {
	return $this->Entries;
    }
}