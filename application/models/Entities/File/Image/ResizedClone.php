<?php
namespace Entities\File\Image;
/** 
 * @Entity (repositoryClass="Repositories\File\Image\ResizedClone") 
 * @Table(name="file_image_resizedclones")
 */
class ResizedClone extends ImageBaseAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\File\Image\ImageAbstract", inversedBy="ResizedClones")
     * @var \Entities\File\Image\ImageAbstract $Image 
     */  
    protected $Image;
    
    /**
     * @return ImageAbstract
     */
    public function getImage()
    {
	return $this->Image;
    }
    
    /** 
     * @param \Entities\File\Image\ImageAbstract $Image
     */
    public function setImage(ImageAbstract $Image)
    {
	$this->Image = $Image;
    }
}
