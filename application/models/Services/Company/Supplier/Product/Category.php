<?php
namespace Services\Company\Supplier\Product;

class Category extends \Dataservice_Service_ServiceAbstract
{
    /**
     * @return Category
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    public function getAllCategories()
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Category")->findBy(array(), array("index_string" => "ASC"));
    }
    
    /**
     * @param \Entities\Company $Company
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAllCompanyProductCategories(\Entities\Company $Company)
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Category")->findByCompany($Company);
    }
    
    /**
     * @param \Entities\Company $Company
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAllCompanyProductTopCategories(\Entities\Company $Company)
    {
	return $this->_em->getRepository("Entities\Company\Supplier\Product\Category")->findByCompanyAndBeingTop($Company);
    }
}