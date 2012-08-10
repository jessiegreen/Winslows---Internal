<?php
class Dataservice_Form extends \Zend_Form
{
    public function addCancelButton($url)
    {
	$this->addElement("button", "cancel", 
		array("onclick" => "location='".$url."'")
		);
    }
}