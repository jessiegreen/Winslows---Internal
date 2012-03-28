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

class Parser 
{   
    /**
     * @var \Doctrine\ORM\EntityManager $_em
     */
    private $_em;
    
    /**
     * @var Repositories\CbOption $_OptionRepos
     */
    private $_OptionRepos;
    
    /**
     * @var Repositories\CbValue $_ValueRepos
     */
    private $_ValueRepos;
    
    /**
     * @var Repositories\CbValueOption $_ValueOptionRepos
     */
    private $_ValueOptionRepos;
    
    /**
     * @var array $_array
     */
    private $_array;
    
    /**
     * @param string $code 
     */
    public function __construct() {
	$front	    = \Zend_Controller_Front::getInstance();
	$bootstrap  = $front->getParam("bootstrap");
	$this->_em  = $bootstrap->getResource('entityManager');
	$this->_OptionRepos	    = $this->_em->getRepository("\Entities\CbOption");
	$this->_ValueRepos	    = $this->_em->getRepository("\Entities\CbValue");
	$this->_ValueOptionRepos    = $this->_em->getRepository("\Entities\CbValueOption");
    }
    
    public function parseToArray($code, $details = false){
	$this->validateCode($code);
	$code	= $this->cleanCode($code);
	
	$this->parseCode($code, $details);
	
	return $this->_array;
    }
    
    private function getNextCode($code)
    {
	$option_code	= substr($code, 0, 2);
	$Option		= $this->_OptionRepos->findOneByCode($option_code);
	if(!$Option){
	    throw new \Exception("Option '".$option_code."' does not exist");
	}
	return $Option;
    }
    
    private function parseCode($code, $details = false)
    {
	/* @var $Option \Entities\CbOption */
	$Option		= $this->getNextCode($code);
	$option_index	= $Option->getIndex();
	
	//$option['details'] = $Option->toArray();
	$code = $this->deleteParsed($code, 2);
	
	$values = $Option->getValues();
	
	if(count($values)<1){
	    throw new \Exception("Option ".$Option->getName()." has no values");
	}
	
	/* @var $Value \Entities\CbValue */
	foreach($values as $Value)
	{
	    $value_index    = $Value->getIndex();
	    $value_id	    = $Value->getId();
	    $length	    = $Value->getLength();
	    
	    //$option['values'][$value_index]['details'] = $Value->toArray();
	    
	    $valueoption_code	= substr($code, 0, $length);
	    $na_code = "";
	    
	    for($i=$length;$i>=1;$i--)
	    {
		$na_code .= "_";
	    }
	    
	    if($valueoption_code == $na_code)
	    {
		
	    }
	    elseif(!$valueoption_code)
	    {
		throw new \Exception("No Value Option in code for '".$Option->getName()."-".$Value->getName()."'.");
	    }
	    else
	    {
		/* @var $ValueOption \Entities\CbValueOption */
		$ValueOption = $this->_ValueOptionRepos->findOneBy(array('code' => $valueoption_code, 'value_id' => $value_id));

		if(!$ValueOption){
		    throw new \Exception("Value Option '".$valueoption_code."' does not exist for ".$Option->getCode()."-".$Value->getName());
		}

		if(!$details)$option[$value_index][] = $ValueOption->getCode();
		else{
		    $option["values"][$value_index]["optionvalue"]  = $ValueOption->toArray();
		    $option["values"][$value_index]["details"]	    = $Value->toArray();
		    $option["details"]				    = $this->_getOptionDetailsFromIndex($option_index);
		}
	    }
	    
	    $code = $this->deleteParsed($code, $length);
	}
	
	$this->_array[$option_index][]  = $option;
	
	if(strlen($code)>0){
	    $this->parseCode($code, $details);
	}
    }
    
    private function deleteParsed($code, $length)
    {
	return substr( $code, $length );
    }
    
    private function validateCode($code)
    {
	if(!is_string($code))
	{
	    throw new \Exception("Code is invalid format"); 
	}
	if(strlen($code)<1)
	{
	    throw new \Exception("Code is empty");
	}
    }
    
    private function cleanCode($code){
	$code = trim($code);
	return $code;
    }
    
    /**
     * @param string $index
     * @return \Entities\CbOption
     */
    private function _getOptionObjectFromIndex($index){
	return $this->_OptionRepos->findOneBy(array("index_string" => $index));
    }
    
    /**
     * @param string $index
     * @return array 
     */
    private function _getOptionDetailsFromIndex($index){
	return $this->_getOptionObjectFromIndex($index)->toArray();
    }
}

?>
