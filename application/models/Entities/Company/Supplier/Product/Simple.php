<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities\Company\Supplier\Product;
/** 
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Simple") 
 * @Table(name="company_product_simples") 
 */
class Simple extends ProductAbstract
{
    /**
     * @Column(type="decimal", precision=40, scale=2)
     * @var decimal $price
     */
    private $price;
    
    /**
     * @return decimal
     */
    public function getPrice()
    {
	return $this->price;
    }
    
    /**
     * @param integer $price
     */
    public function setPrice(integer $price)
    {
	$this->price = $price;
    }
    
    /**
     * @return string
     */
    public function getDescriminator() {
	return parent::TYPE_Simple;
    }
    
    public function populate(array $array)
    {
	foreach ($array as $key => $value) 
	{
	    if(property_exists($this, $key))
	    {
		$this->$key = $value;
	    }
	}
    }
}