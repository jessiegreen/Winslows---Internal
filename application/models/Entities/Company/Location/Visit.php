<?php
namespace Entities\Company\Location;

class Visit extends \Entities\Location\Visit
{
    /**
     * @ManyToOne(targetEntity="\Entities\Company\Lead")
     * @var \Entities\Company\Lead $Lead
     */
    protected $Lead;
    
    /**
     * @param \Entities\Company\Lead $Lead
     */
    public function setLead(\Entities\Company\Lead $Lead)
    {
	$this->Lead = $Lead;
    }
    
    /**
     * @return \Entities\Company\Lead
     */
    public function getLead()
    {
	return $this->Lead;
    }
}