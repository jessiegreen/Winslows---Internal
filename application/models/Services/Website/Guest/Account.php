<?php
namespace Services\Website\Guest;

class Account extends \Dataservice_Service_ServiceAbstract
{    
    public function getAccountByIP()
    {
	return $this->_em->getRepository("Entities\Website\Guest\Account")
		    ->findOneBy(array("ip_address" => $_SERVER['REMOTE_ADDR']));
    }
}