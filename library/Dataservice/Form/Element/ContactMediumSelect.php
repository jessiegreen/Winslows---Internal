<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmployeeSelect
 *
 * @author jgreen
 */
class Dataservice_Form_Element_ContactMediumSelect extends Zend_Form_Element_Select
{
    protected $_Lead;
    protected $_Contact;
    
    public function __construct($spec, \Entities\Lead $Lead, Entities\Contact $Contact = null, $options = null)
    {
	$this->_Lead	    = $Lead;
	$this->_Contact	    = $Contact;
	parent::__construct($spec, $options);
    }
    
    public function init()
    {
	$Contact = !$this->_Contact ? new \Entities\Contact() : $this->_Contact;
	$array	 = array();
	
	foreach($this->_Lead->getEmployee()->getLocation()->getCompany()->getLocations() as $Location){
	    $value	    = json_encode(array("type" => "location", "type_detail" => $Location->getName()));
	    $array[$value]  = $Contact->getTypeDisplay("location").": ".$Location->getName();
	}
	foreach($this->_Lead->getPersonPhoneNumbers() as $PhoneNumber){
	    $value	    = json_encode(array("type" => "phone", "type_detail" => $PhoneNumber->getNumberDisplay()));
	    $array[$value]  = $Contact->getTypeDisplay("phone").": ".$PhoneNumber->getNumberDisplay();
	}
	foreach($this->_Lead->getPersonEmailAddresses() as $Emailaddress){
	    $value	    = json_encode(array("type" => "email", "type_detail" => $Emailaddress->getAddress()));
	    $array[$value]  = $Contact->getTypeDisplay("email").": ".$Emailaddress->getAddress();
	}
	
	if($Contact->getId() && $Contact->getType() && $Contact->getTypeDetail()){
	    $value	    = json_encode(array("type" => $Contact->getType(), "type_detail" => $Contact->getTypeDetail()));
	    $array[$value]  = $Contact->getTypeDisplay($Contact->getType()).": ".$Contact->getTypeDetail();
	}
        $this->addMultiOption("", 'Please select...');
        foreach ($array as $key => $option) {
            $this->addMultiOption($key, $option);
        }
    }
}

?>
