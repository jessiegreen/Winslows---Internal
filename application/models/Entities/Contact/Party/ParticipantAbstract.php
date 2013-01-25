<?php
namespace Entities\Contact\Party;

class ParticipantAbstract
{
    /**
     * @var \Entities\Contact\Party\Entity 
     */
    protected $Entity;
    
    public function setEntity(\Entities\Contact\Party\Entity $Entity)
    {
	$this->Entity = $Entity;
    }
}