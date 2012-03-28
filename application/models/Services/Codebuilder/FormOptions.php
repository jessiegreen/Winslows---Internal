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

class FormOptions
{
    /**
     * @var Data $_data 
     */
    private $_data;
    
    /**
     * @var \Doctrine\ORM\EntityManager $_em
     */
    private $_em;
    
    /**
     * @var OptionsMapper $_optionsmapper
     */
    private $_optionsmapper;
    
    /**
     * @var \Repositories\CbOption  $_option_repos
     */
    private $_option_repos;
    
    /**
     * @var \Repositories\CbValue  $_value_repos
     */
    private $_value_repos;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
	$this->_data		= Factory::factoryData();
	$this->_em		= $em;
	$this->_option_repos	= $em->getRepository("\Entities\CbOption");
	$this->_value_repos	= $em->getRepository("\Entities\CbValue");
	$this->_optionsmapper	= Factory::factoryOptionsMapper($this->_em);
    }
    
    public function getAreaOptions()
    {
	return array_keys($this->_data->location_types);
    }
    
    public function getStructureTypeOptions($location)
    {
	$options	= array();
	$allowed_types	= array_keys($this->_data->location_types_models[$location]);

	foreach ($this->getValueOptionsByIndexes("type", "type") as $valueoption) {
	    if(in_array($valueoption->getCode(),$allowed_types)){
		$option = $valueoption->toArray();
		$options[] = $option;
	    } 
	}
	return $options;
    }
    
    public function getModelOptions($location, $structure_type, $model_index) 
    {
	$options = array();
	if(
	    key_exists($location, $this->_data->location_types_models)
	    && key_exists($structure_type, $this->_data->location_types_models[$location])
	){
	    $allowed_models = $this->_data->location_types_models[$location][$structure_type];	
	    foreach ($this->getValueOptionsByIndexes($model_index, "name") as $valueoption) {
		if(in_array($valueoption->getCode(),$allowed_models)){
		    $option	    = $valueoption->toArray();
		    $options[]  = $option;
		} 
	    }
	    return $options;
	}
	return array();
    }
    
    public function getSizeOptions($structure_type, $model){
	if(
	    key_exists($structure_type, $this->_data->model_sizes_prices)
	    && key_exists($model, $this->_data->model_sizes_prices[$structure_type])
	){
	    return array_keys($this->_data->model_sizes_prices[$structure_type][$model]);
	}
    }
    
    public function getLegHeightOptions($structure_type, $model){
	$leg_height_price_array = $this->_data->getModelLegHeightPricesArray();
	$leg_height_array	= $leg_height_price_array["type"][$structure_type]["model"][$model]["leg_height"];
	return array_keys($leg_height_array);
    }
    
    public function getWallsOptions($structure_type)
    {
	$walls_options_array = array();
	
	foreach (array("left", "right", "front", "back") as $side) 
	{
	    $option = $this->_option_repos->findOneBy(array("index_string" => "covered_".$side));
	    $values = $option->getValues()->toArray();
	    
	    foreach ($values as $value)
	    {
		foreach ($value->getValueOptions() as $option_values) 
		{
		    $walls_options_array[$side][$value->getIndex()][$option_values->getCode()] = $option_values->getName();
		}
	    }
	    
	    $option = $this->_option_repos->findOneBy(array("index_string" => "orientation_".$side));
	    $values = $option->getValues()->toArray();
	    
	    foreach ($values as $value) {
		foreach ($value->getValueOptions() as $option_values) {
		    $walls_options_array[$side][$value->getIndex()][$option_values->getCode()] = $option_values->getName();
		}
	    }
	}
	return $walls_options_array;
    }
    
    public function getValueOptionsByIndexes($option_index, $value_index)
    {
	/* @var $option \Entities\CbOption */
	$option		= $this->_option_repos->findOneBy(array("index_string" => $option_index));
	/* @var $values \Doctrine\Common\Collections\ArrayCollection */
	$values		= $option->getValues()->toArray();
	
	if(is_array($values)){
	    foreach ($values as $value) {
		if($value->getIndex() == $value_index){
		    return $value->getValueOptions()->toArray();
		}
	    }
	}
    }
}

?>
