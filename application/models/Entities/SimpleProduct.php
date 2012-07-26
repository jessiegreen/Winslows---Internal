<?php
/**
 * Name:
 * Location:
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities;
/** 
 * @Entity (repositoryClass="Repositories\SimpleProduct") 
 * @Table(name="products_simple") 
 */

class SimpleProduct extends Product
{
    /**
    * @Column(type="decimal", precision=40, scale=2)
    */
    private $price;
    
    public function getPrice(){
	return $this->price;
    }
    
    public function setPrice($price){
	$this->price = $price;
    }
    
    public function getDescriminator() {
	return parent::TYPE_Simple;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}