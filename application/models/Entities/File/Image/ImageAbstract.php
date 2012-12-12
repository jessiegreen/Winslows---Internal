<?php
namespace Entities\File\Image;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/** 
 * @Entity (repositoryClass="Repositories\File\Image\ImageAbstract") 
 * @Table(name="file_image_imageabstracts")
 */
 abstract class ImageAbstract extends ImageBaseAbstract
{        
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\File\Image\ResizedClone", mappedBy="Image", cascade={"persist", "remove"})
     * @var ArrayCollection $ResizedClones
     */
    protected $ResizedClones;
    
    public function __construct()
    {
	$this->ResizedClones = new ArrayCollection();
	
	parent::__construct();
    }
    
    public function addResizedClone(ResizedClone $ResizedClone)
    {
	$this->getResizedClones()->add($ResizedClone);
    }
    
    /**
     * @return ArrayCollection
     */
    public function getResizedClones()
    {
	return $this->ResizedClones;
    }
    
    public function getResized($width, $height, \Doctrine\ORM\EntityManager $em, $crop = true)
    {
	$Matching = $this->_getSizeClone($width, $height);
	
	if($Matching != false)
	    return $Matching;
	
	$ResizedClone = new ResizedClone();
	
	$ResizedClone->setImage($this);
	$ResizedClone->setDescription("");
	$ResizedClone->setName("");
	$ResizedClone->setExtension($this->getExtension());
	$ResizedClone->setFileType($this->getFileType());
	$ResizedClone->setOriginalFileName($this->getOriginalFileName()."-".$width."X".$height);
	$ResizedClone->setHeight($height);
	$ResizedClone->setWidth($width);
	$ResizedClone->setFileSize(0);
	
	$this->addResizedClone($ResizedClone);
		
	$em->persist($this);
	$em->flush();

	$new_path = $this->_copyAndResizeFile($width, $height, $ResizedClone, $crop);
	
	$ResizedClone->setFileSize(filesize($new_path));
	
	return $this->_getSizeClone($width, $height);
    }
    
    /**
     * @param int $width
     * @param int $height
     * @return ImageBaseAbstract|false
     */
    private function _getSizeClone($width, $height)
    {
	$Matching = $this->getResizedClones()->filter(
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
    
    private function _copyAndResizeFile($width, $height, ResizedClone $ResizedClone, $crop = true)
    {	
	$filter = new \Dataservice_Filter_ImageSize();
	
	$filter->setOutputPathBuilder(
		
        new \Dataservice_Filter_ImageSize_PathBuilder_Standard($ResizedClone->getFileStoreDirectoryFromConfig()));
	
	#--Create Renaming function in config
	$filter->getConfig()
		->setHeight($height)
		->setWidth($width);
	
	if($crop == true)
	    $filter->getConfig()->setStrategy(new \Dataservice_Filter_ImageSize_Strategy_Crop());
		
	return $filter->filter($ResizedClone->getFullPath());
    }
}
