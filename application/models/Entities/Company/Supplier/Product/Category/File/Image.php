<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */

namespace Entities\Company\Supplier\Product\Category\File;

/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\File\Image") 
 * @Table(name="company_supplier_product_category_file_images") 
 */
class Image extends \Entities\Company\File\Image\ImageAbstract
{
    /** 
     * @ManyToOne(targetEntity="\Entities\Company\Supplier\Product\Category", inversedBy="Images")
     * @var \Entities\Company\Supplier\Product\Category $Product
     */     
    protected $Category;
    
    /**
     * @param \Entities\Company\Supplier\Product\ProductAbstract $Product
     */
    public function setCategory(\Entities\Company\Supplier\Product\Category $Category)
    {
	$this->Category = $Category;
    }
    
    /**
     * @return \Entities\Company\Supplier\Product\Category
     */
    public function getCategory()
    {
	return $this->Category;
    }
}