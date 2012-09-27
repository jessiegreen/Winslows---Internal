<?php

namespace Entities\Company\RtoProvider;

/**
 * @Entity (repositoryClass="Repositories\Company\RtoProvider\Application") 
 * @Table(name="company_rtoprovider_applications")
 * @HasLifecycleCallbacks
 */
class Application extends \Dataservice_Doctrine_Entity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @var integer $id
     */
    protected $id;
    
    /** 
     * @Column(type="integer", length=3) 
     * @var integer $points
     */
    protected $points;

    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Lead", inversedBy="Applications")
     * @var \Entities\Company\Lead
     */  
    protected $Lead;
    
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\RtoProvider", inversedBy="Applications")
     * @var \Entities\Company\RtoProvider
     */  
    protected $RtoProvider;
    
    /**
     * @return \Entities\Company\RtoProvider
     */
    public function getRtoProvider()
    {
	return $this->RtoProvider;
    }
    
    /**
     * @param \Entities\Company\RtoProvider $RtoProvider
     */
    public function setRtoProvider(\Entities\Company\RtoProvider $RtoProvider)
    {
	$this->RtoProvider = $RtoProvider;
    }
    
    /**
     * @return \Entities\Company\Lead
     */
    public function getLead()
    {
	return $this->Lead;
    }
    
    /**
     * @param \Entities\Company\Lead $Lead
     */
    public function setLead(\Entities\Company\Lead $Lead)
    {
	$this->Lead = $Lead;
    }

    /**
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }
    
    /**
     * @return boolean
     */
    public function isApproved()
    {
	return (int) $this->getPoints() > (int) $this->getRtoProvider()->getMinimumPoints() ? true : false;
    }
}