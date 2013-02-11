<?php
class Dataservice_Controller_Company_File_Action extends Dataservice_Controller_Crud_Action
{    
    public function viewAction()
    {
	try 
	{
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
	    $this->_History->doNotTrack();
	    
	    $finfo	= finfo_open(FILEINFO_MIME_TYPE);
	    $file_path  = $this->_Entity->getFullPath();

	    if($this->_Entity)
	    {
		header("Content-length: ". filesize($file_path));
		header("Content-type: ". finfo_file($finfo, $file_path));
		readfile($file_path);
	    }
	} 
	catch (\Exception $exc)
	{
	    
	}

	exit;
    }
}