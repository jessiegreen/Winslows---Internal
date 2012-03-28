<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 */
namespace Services\Codebuilder;

class Factory 
{
    public static function factoryCodebuilder()
    {
	return new Codebuilder;
    }
    
    public static function factoryParser()
    {
	return new Parser();
    }
    
    public static function factoryValidator()
    {
	return new Validator();
    }
    
    public static function factoryPricing()
    {
	return new Pricing();
    }
    
    public static function factoryBuilderArrayMapper()
    {
	return new BuilderArrayMapper();
    }
    
    public static function factoryData()
    {
	return new Data();
    }
    
    public static function factoryFormOption(\Doctrine\ORM\EntityManager $em)
    {
	return new FormOptions($em);
    }
    
    public static function factoryOptionsMapper(\Doctrine\ORM\EntityManager $em)
    {
	return new OptionsMapper($em);
    }
    
    public static function factoryCbOption()
    {
	return new \Entities\CbOption();
    }
    
    public static function factoryCbValue()
    {
	return new \Entities\CbValue();
    }
    
    public static function factoryCbValueOption()
    {
	return new \Entities\CbValueOption();
    }
    
    public static function factoryRequiredData()
    {
	return new RequiredData();
    }
}

?>
