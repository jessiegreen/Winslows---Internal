<?php

/**
 * 
 * @author jessie
 *
 */

class Dataservice_Controller_File extends Dataservice_Controller_Action
{    
    public function viewAction()
    {
	try 
	{
	    $this->_helper->layout->disableLayout();
	    $this->_helper->viewRenderer->setNoRender(true);
	    $this->_History->doNotTrack();

	    $File	= $this->_em->getRepository("Entities\File\FileAbstract")->find($this->_request->getParam("id", 0));
	    $finfo	= finfo_open(FILEINFO_MIME_TYPE);
	    $file_path  = $File->getFullPath();

	    if($File)
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