<?php
namespace Services\Winslows;

class Product extends \Dataservice_Service_ServiceAbstract
{
    private $Company;
    
    /**
     * @return Product
     */
    public static function factory()
    {
	return parent::factory();
    }
    
    public function __construct()
    {
	$this->Company = \Services\Company::factory()->getCurrentCompany();
	
	parent::__construct();
    }
    
    /**
     * @return array
     */
    public function getAllProductCategories()
    {
	return \Services\Company\Supplier\Product\Category::factory()->getAllCompanyProductCategories($this->Company);
    }
    
    /**
     * @return array
     */
    public function getTopProductCategories()
    {
	return \Services\Company\Supplier\Product\Category::factory()->getAllCompanyProductTopCategories($this->Company);
    }
}