<?php
namespace Entities\File\Image;
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
    
    public function getResized($width, $height)
    {
	
    }
}
