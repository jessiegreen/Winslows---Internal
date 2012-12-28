<?php
namespace Entities\Company\Lead;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Account") 
 * @Table(name="company_lead_accounts") 
 */
class Account extends \Entities\Website\Account\AccountAbstract
{
    /**
     * @OneToOne(targetEntity="\Entities\Company\Lead", inversedBy="Account", cascade={"persist"})
     * @var \Entities\Company\Lead $Lead
     */
    protected $Lead;
    
    /**
     * @return \Entities\Company\Lead
     */
    public function getPerson()
    {
	return $this->getLead();
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
     * @return string
     */
    public function getDescriminator()
    {
	return self::TYPE_Lead;
    }
}