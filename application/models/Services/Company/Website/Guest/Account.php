<?php
namespace Services\Company\Website\Guest;

class Account extends \Dataservice_Service_ServiceAbstract
{    
    public function getAccountByIP()
    {
	return $this->_em->getRepository("Entities\Company\Website\Guest\Account")
		    ->findOneBy(array("ip_address" => $_SERVER['REMOTE_ADDR']));
    }
}