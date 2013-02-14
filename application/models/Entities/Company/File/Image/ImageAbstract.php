<?php
namespace Entities\Company\File\Image;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/** 
 * @Entity (repositoryClass="Repositories\Company\File\Image\ImageAbstract") 
 * @Table(name="company_file_image_imageabstracts")
 * @Crud\Entity\Url(value="")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
 abstract class ImageAbstract extends ImageBaseAbstract
{        
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\File\Image\ResizedClone", mappedBy="Image", cascade={"persist", "remove"})
     * @Crud\Relationship\Permissions(add={"Admin"}, remove={"Admin"})
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
	$ResizedClone->setImage($this);
	
	$this->ResizedClones[] = $ResizedClone;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getResizedClones()
    {
	return $this->ResizedClones;
    }   
    
    /**
     * @param string $width
     * @param string $height
     * @return ImageBaseAbstract
     */
    public function getSize($width, $height)
    {
	return $this->getWidth() == $width && $this->getHeight() == $height ? 
		    $this : 
		    \Services\Company\File\Image::factory()->getResized($this, $width, $height);
    }
    
    /**
     * @return ImageBaseAbstract
     */
    public function getThumb()
    {
	return $this->getSize($this, 100, 100);
    }
}
