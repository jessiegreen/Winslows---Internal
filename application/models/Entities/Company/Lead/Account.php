<?php
namespace Entities\Company\Lead;

/** 
 * @Entity (repositoryClass="Repositories\Company\Lead\Account") 
 * @Table(name="company_lead_accounts") 
 * @Crud\Entity\Url(value="lead-account")
 * @Crud\Entity\Permissions(view={"Admin", "Manager"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Account extends \Entities\Company\Website\Account\AccountAbstract
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