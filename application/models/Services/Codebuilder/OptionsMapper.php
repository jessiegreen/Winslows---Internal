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
class OptionsMapper 
{   
    /**
     * @var \Repositories\CbOption  $_option_repos
     */
    private $_option_repos;
    
    /**
     * @var \Repositories\CbValue  $_value_repos
     */
    private $_value_repos;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
	$this->_em		= $em;
	$this->_option_repos	= $em->getRepository("\Entities\CbOption");
	$this->_value_repos	= $em->getRepository("\Entities\CbValue");
    }
    
    public function getValueOptionsByIndexes($option_index, $value_index){
	$option		= $this->_option_repos->findOneBy(array("index_string" => $option_index));
	$values		= $this->option->getValues();
	if(is_array($values)){
	    foreach ($values as $value) {
		if($value->getIndex() == $value_index){
		    return $value->getValueOptions();
		}
	    }
	}
    }

}
?>