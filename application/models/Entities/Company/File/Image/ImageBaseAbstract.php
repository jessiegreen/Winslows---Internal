<?php
namespace Entities\Company\File\Image;

/** 
 * @Entity (repositoryClass="Repositories\Company\File\Image\ImageBaseAbstract") 
 * @Table(name="company_file_image_imagebaseabstracts") 
 */
abstract class ImageBaseAbstract extends \Entities\Company\File\FileAbstract
{    
    /** 
     * @Column(type="integer", length=20) 
     * @var integer $width
     */
    protected $width;
    
    /** 
     * @Column(type="integer", length=20) 
     * @var integer $height
     */
    protected $height;
    
    /**
     * @param integer $width
     */
    public function setWidth($width)
    {
	$this->width = $width;
    }
    
    /**
     * @return integer
     */
    public function getWidth()
    {
	return $this->width;
    }
    
    /**
     * @param integer $height
     */
    public function setHeight($height)
    {
	$this->height = $height;
    }
    
    /**
     * @return integer
     */
    public function getHeight()
    {
	return $this->height;
    }
    
    /**
     * @return Zend_Config
     */
    protected function getConfig()
    {
	return \Zend_Registry::get('config')->dataService->fileStore->imageStore;
    }
    
    public function uploadFile($temp_full_path)
    {
	parent::uploadFile($temp_full_path);
	
	$image_size = getimagesize($this->getFullPath());
	
	$this->setWidth($image_size[0]);
	
	$this->setHeight($image_size[1]);
    }
}
