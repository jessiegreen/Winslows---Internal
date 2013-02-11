<?php
class Company_FileImageResizedCloneController extends \Dataservice_Controller_Crud_Action
{
    public function init()
    {
	$this->_EntityClass = "\Entities\Company\File\FileAbstract";
	
	parent::init();
    }
}
