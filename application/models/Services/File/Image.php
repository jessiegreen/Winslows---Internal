<?php
namespace Services\File;

class Image extends \Dataservice_Service_ServiceAbstract
{   
    public function getHtmlImg(\Entities\File\Image\ImageAbstract $Image, $width, $height)
    {
	$Image = $Image->getWidth() == $width && $Image->getHeight() == $height ? $Image : $Image->getResized($width, $height, $this->_em);
	
	return '<img src="/file/view/id/'.$Image->getId().'/nohist/1" />';
    }
    
    public function getHtmlThumbImg(\Entities\File\Image\ImageAbstract $Image)
    {
	return $this->getHtmlImg($Image, 100, 100);
    }
}