<?php
namespace Services\Company\File;

class Image extends \Dataservice_Service_ServiceAbstract
{   
    /**
     * @return Image
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    /**
     * Checks for an existing clone of the stated size and returns if not it creates one and returns it.
     * 
     * @param \Entities\Company\File\Image\ImageAbstract $Image
     * @param int $width
     * @param int $height
     * @param bool $crop
     * @return \Entities\Company\File\Image\ResizedClone
     * @throws \Exception
     */
    public function getResized(\Entities\Company\File\Image\ImageAbstract $Image, $width, $height, $crop = true)
    {
	$Matching = $this->_getResizedCloneOfCertainSize($Image, $width, $height);
	
	if($Matching != false)
	    return $Matching;
	
	$ResizedClone = new \Entities\Company\File\Image\ResizedClone();
	
	$ResizedClone->setDescription("");
	$ResizedClone->setName("");
	$ResizedClone->setExtension($Image->getExtension());
	$ResizedClone->setFileType($Image->getFileType());
	$ResizedClone->setOriginalFileName($Image->getOriginalFileName()."-".$width."X".$height);
	$ResizedClone->setIsPublic($Image->getIsPublic());
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
     * @return \Entities\Company\File\Image\ResizedClone|false
     */
    private function _getResizedCloneOfCertainSize(\Entities\Company\File\Image\ImageAbstract $Image, $width, $height)
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
     * @param \Entities\Company\File\Image\ResizedClone $ResizedClone
     * @param bool $crop
     * @return string
     */
    private function _copyAndResizeFile($width, $height, \Entities\Company\File\Image\ResizedClone $ResizedClone, $crop = true)
    {	
	copy($ResizedClone->getImage()->getFullRealPath(), $ResizedClone->getFullRealPath());
	
	$filter = new \Dataservice_Filter_ImageSize();
	
	$filter->setOutputPathBuilder(
	    new \Dataservice_Filter_ImageSize_PathBuilder_Standard($ResizedClone->getDirectoryRealPath())
	);
	
	
	#--Create Renaming function in config
	$filter->getConfig()
		->setHeight($height)
		->setWidth($width)
		->setOverwriteMode(\Dataservice_Filter_ImageSize::OVERWRITE_ALL);
	
	if($crop == true)
	    $filter->getConfig()->setStrategy(new \Dataservice_Filter_ImageSize_Strategy_Crop());
	
	return $filter->filter($ResizedClone->getFullRealPath());
    }
}