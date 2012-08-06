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
     * @var string $validator
     */
    private $validator;
    
    /** 
     * @Column(type="string", length=255) 
     * @var string $pricer
     */
    private $pricer;
    
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
     * @return array
     */
    public function getOptions(){
	return $this->Options;
    }
        
    /**
     * @param \Entities\Company\Supplier\Product\Configurable\Option $Option
     */
    public function addOption(Configurable\Option $Option){
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
     * @return string
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @param string $validator
     */
    public function setValidator(string $validator)
    {
        $this->validator = $validator;
    }
    
    /**
     * @return string
     */
    public function getPricer()
    {
        return $this->pricer;
    }

    /**
     * @param string $pricer
     */
    public function setPricer(string $pricer)
    {
        $this->pricer = $pricer;
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