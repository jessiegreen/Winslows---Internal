<?php
namespace Entities\Company\File\Image;
/** 
 * @Entity (repositoryClass="Repositories\Company\File\Image\ResizedClone") 
 * @Table(name="company_file_image_resizedclones")
 * @Crud\Entity\Url(value="file-image-resized-clone")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class ResizedClone extends ImageBaseAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\File\Image\ImageAbstract", inversedBy="ResizedClones")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\File\Image\ImageAbstract $Image 
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
     * @param \Entities\Company\File\Image\ImageAbstract $Image
     */
    public function setImage(ImageAbstract $Image)
    {
	$this->Image = $Image;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
	return $this->Image->getName();
    }
    
    /**
     * @return string
     */
    public function getDescription()
    {
	return $this->Image->getDescription();
    }
    
    /**
     * @return string
     */
    public function getOriginalFileName()
    {
	return $this->Image->getOriginalFileName();
    }
}
