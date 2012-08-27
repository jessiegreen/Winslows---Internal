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
 * @Entity (repositoryClass="Repositories\Company\Supplier\Product\Configurable") 
 * @Table(name="company_supplier_product_configurables") 
 */

class Configurable extends ProductAbstract
{
    /** 
     * @Column(type="string", length=255) 
     * @var string $class_name
     */
    private $class_name;
    
    /**
     * @ManytoMany(targetEntity="\Entities\Company\Supplier\Product\Configurable\Option", mappedBy="ConfigurableProducts", cascade={"ALL"})
     * @var array $Options
     */
    private $Options;
    
    public function __construct()
    {
	$this->Options = new ArrayCollection();
	parent::__construct();
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOptions()
    {
	return $this->Options;
    }
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOptionsOrderedByCategory()
    {
	$arr = $this->getOptions()->toArray();
	
	usort($arr, function($a, $b)
	{
	    $name_a = $a->getCategory()->getOrder();
	    $name_b = $b->getCategory()->getOrder();

	    return $name_a == $name_b ? 0 : $name_a > $name_b ? 1 : - 1;

	});
	
	return $arr;
    }
        
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option $Option
     */
    public function addOption(Configurable\Option $Option)
    {
	$Option->addConfigurableProduct($this);
	$this->Options[] = $Option;
    }
    
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option $Option
     * @return boolean
     */
    public function removeOption(Configurable\Option $Option)
    {
	foreach ($this->Options as $key => $Option2) 
	{
	    if($Option->getId() == $Option2->getId())
	    {
		$this->Options[$key];
		
		unset($this->Options[$key]);
		
		$Option->removeConfigurableProduct($this);
		
		return true;
	    }
	}
	return false;
    }
    
    
    /**
     * @param string $option_index
     * @return ArrayCollection
     */
    public function getRequiredOptions()
    {
	return $this->getOptions()->filter(
	    /* @var $Option \Entities\Company\Supplier\Product\Configurable\Option */
	    function($Option)
	    {
		if($Option->isRequired())
		    return true;
		else return false;
	    }
	);
    }
    
    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->class_name;
    }

    /**
     * @param string $class_name
     */
    public function setClassName($class_name)
    {
        $this->class_name = $class_name;
    }
    
    /**
     * @return string
     */
    public function getDescriminator() 
    {
	return parent::TYPE_Configurable;
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