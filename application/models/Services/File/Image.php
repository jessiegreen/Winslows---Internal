<?php
namespace Services\File;

class Image extends \Dataservice_Service_ServiceAbstract
{   
    public function getHtmlImg(\Entities\File\Image\ImageAbstract $Image, $width, $height)
    {
	$Image = $Image->getWidth() == $width && $Image->getHeight() == $height ? 
		    $Image : 
		    $this->getResized($Image, $width, $height, $this->_em);
	
	return '<img title="'.htmlspecialchars($Image->getName()).'" src="/file/view/id/'.$Image->getId().'/nohist/1" />';
    }
    
    public function getHtmlThumbImg(\Entities\File\Image\ImageAbstract $Image)
    {
	return $this->getHtmlImg($Image, 100, 100);
    }
    
    /**
     * Checks for an existing clone of the stated size and returns if not it creates one and returns it.
     * 
     * @param \Entities\File\Image\ImageAbstract $Image
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @return \Entities\File\Image\ResizedClone
     * @throws \Exception
     */
    public function getResized(\Entities\File\Image\ImageAbstract $Image, $width, $height, $crop = true)
    {
	$Matching = $this->_getResizedCloneOfCertainSize($Image, $width, $height);
	
	if($Matching != false)
	    return $Matching;
	
	$ResizedClone = new \Entities\File\Image\ResizedClone();
	
	$ResizedClone->setDescription("");
	$ResizedClone->setName("");
	$ResizedClone->setExtension($Image->getExtension());
	$ResizedClone->setFileType($Image->getFileType());
	$ResizedClone->setOriginalFileName($Image->getOriginalFileName()."-".$width."X".$height);
	$ResizedClone->setHeight($height);
	$ResizedClone->setWidth($width);
	$ResizedClone->setFileSize(0);
	
	$Image->addResizedClone($ResizedClone);
		
	$this->_em->persist($Image);
	$this->_em->flush();

	try 
	{
	    $new_path = $this->_copyAndResizeFile($width, $height, $ResizedClone, $crop);

	    $ResizedClone->setFileSize(filesize($new_path));

	    $this->_em->persist($ResizedClone);
	    $this->_em->flush();

	    $SizedClone = $this->_getResizedCloneOfCertainSize($Image, $width, $height);

	    if(!$SizedClone)throw new \Exception("Could not get sized clone.");
	} 
	catch (\Exception $exc)
	{
	    $this->_em->remove($ResizedClone);
	    $this->_em->flush();
	    
	    throw new \Exception("Could not create new file. Removing record. ".$exc->getMessage());
	}
	
	return $SizedClone;
    }
    
    /**
     * Checks if a ResizedClone of stated size already exists and returns it if not it returns false
     * 
     * @param int $width
     * @param int $height
     * @return \Entities\File\Image\ResizedClone|false
     */
    private function _getResizedCloneOfCertainSize(\Entities\File\Image\ImageAbstract $Image, $width, $height)
    {
	$Matching = $Image->getResizedClones()->filter(
		    function ($Clone) use ($width, $height){
			if($Clone->getWidth() == $width && $Clone->getHeight() == $height)
			    return true;
			
			return false;
		    }
		);
		
	if($Matching->count() > 0)
	    return $Matching->first();
	
	return false;
    }
    
    /**
     * Makes a copy of the original parent file and resizes it
     * 
     * @param int $width
     * @param int $height
     * @param \Entities\File\Image\ResizedClone $ResizedClone
     * @param bool $crop
     * @return string
     */
    private function _copyAndResizeFile($width, $height, \Entities\File\Image\ResizedClone $ResizedClone, $crop = true)
    {	
	copy($ResizedClone->getImage()->getFullPath(), $ResizedClone->getFullPath());
	
	$filter = new \Dataservice_Filter_ImageSize();
	
	$filter->setOutputPathBuilder(
	    new \Dataservice_Filter_ImageSize_PathBuilder_Standard($ResizedClone->getDirectory())
	);
	
	
	#--Create Renaming function in config
	$filter->getConfig()
		->setHeight($height)
		->setWidth($width)
		->setOverwriteMode(\Dataservice_Filter_ImageSize::OVERWRITE_ALL);
	
	if($crop == true)
	    $filter->getConfig()->setStrategy(new \Dataservice_Filter_ImageSize_Strategy_Crop());
		
	return $filter->filter($ResizedClone->getFullPath());
    }
}