<?php
class Winslows_FileController extends Dataservice_Controller_Company_File_Action
{
    public function init()
    {
	$this->_EntityClass = "\Entities\Company\File\FileAbstract";
	
	parent::init();
    }
    
    public function editAction() {
	
    }
    
    public function deleteAction() {
	
    }
}
