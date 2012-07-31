<?php
/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
namespace Entities;
/** 
 * @Entity (repositoryClass="Repositories\Order") 
 * @Table(name="orders") 
 */

class Order extends Quote
{
    /** @Column(type="datetime", nullable=true) */
    private $purchased_date;
    
    public function setPurchasedDate(\DateTime $DateTime)
    {
        $this->purchased_date = $DateTime;
    }
    
    public function getPurchasedDate()
    {
	return $this->purchased_date;
    }
    
    public function populate(array $array){
	foreach ($array as $key => $value) {
	    if(property_exists($this, $key)){
		$this->$key = $value;
	    }
	}
    }
}
