<?php
namespace Entities\Company\Lead;

class Account extends \Entities\Company\Website\Account\AccountAbstract
{
    /**
     * @OneToOne(targetEntity="\Entities\Company\Lead", inversedBy="Account", cascade={"persist"})
     * @var \Entities\Company\Lead $Lead
     */
    private $Lead;
    
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
}