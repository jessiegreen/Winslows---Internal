<?php
class Contact
{
    protected $Party;
    
    public function setParty(Party $Party)
    {
	$this->Party = $Party;
    }
}