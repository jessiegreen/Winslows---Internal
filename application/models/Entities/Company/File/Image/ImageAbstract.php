<?php
namespace Entities\Company\File\Image;

use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;
/** 
 * @Entity (repositoryClass="Repositories\Company\File\Image\ImageAbstract") 
 * @Table(name="company_file_image_imageabstracts")
 */
 abstract class ImageAbstract extends ImageBaseAbstract
{        
    /**
     * Bidirectional - One-To-Many (INVERSE SIDE)
     *
     * @OneToMany(targetEntity="\Entities\Company\File\Image\ResizedClone", mappedBy="Image", cascade={"persist", "remove"})
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
}
