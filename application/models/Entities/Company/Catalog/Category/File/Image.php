<?php
namespace Entities\Company\Catalog\Category\File;

/** 
 * @Entity (repositoryClass="Repositories\Company\Catalog\Category\File\Image") 
 * @Table(name="company_catalog_category_file_images") 
 * @Crud\Entity\Url(value="catalog-category-file-image")
 * @Crud\Entity\Permissions(view={"Admin"}, edit={"Admin"}, create={"Admin"}, delete={"Admin"})
 */
class Image extends \Entities\Company\File\Image\ImageAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Catalog\Category", inversedBy="Images")
     * @Crud\Relationship\Permissions()
     * @var \Entities\Company\Catalog\Category $Category
     */     
    protected $Category;
    
    /**
     * @param \Entities\Company\Catalog\Category $Category
     */
    public function setCategory(\Entities\Company\Catalog\Category $Category)
    {
	$this->Category = $Category;
    }
    
    /**
     * @return \Entities\Company\Catalog\Category
     */
    public function getCategory()
    {
	return $this->Category;
    }
    
    public function populate(array $array)
    {
	$Category = $this->_getEntityFromArray($array, "Entities\Company\Catalog\Category", "category_id");

	if($Category && $Category->getId())
	    $this->setCategory($Category);
	
	parent::populate($array);
    }
}