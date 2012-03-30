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

class Pricing {
    /**
     * @var decimal $_price
     */
    private $_price = 0;
    
    /**
     * @var \Services\Codebuilder\Data $_data
     */
    private $_data;
    
    /**
     * @var array $_details
     */
    private $_details;
    
    public function __construct() {
	$this->_data	= Factory::factoryData();
    }
    
    public function price(BuilderArrayMapper $BuilderArrayMapper, $builder_values_array){
	switch($BuilderArrayMapper->getStructureTypeCode($builder_values_array)){
	    #--Metal Structure
	    case "MC":
		#--Set Base Price
		$this->_getBasePrice($BuilderArrayMapper, $builder_values_array);
		$this->_priceFrameGauge($BuilderArrayMapper, $builder_values_array);
		$this->_priceWalls($BuilderArrayMapper, $builder_values_array);
		$this->_priceLegHeight($BuilderArrayMapper, $builder_values_array);
		$this->_priceDoors($BuilderArrayMapper, $builder_values_array);
	    break;
	    #--Wood Structure
	    case "WF":
		#--Set Base Price
		$this->_getBasePrice($BuilderArrayMapper, $builder_values_array);
	    break;
	    default:
		throw new \Exception("Type is required.");
	}
	$price = $this->_price;
	$this->_price = 0;
	return number_format($price,2);
    }
    
    private function _getBasePrice(BuilderArrayMapper $BuilderArrayMapper, $builder_values_array)
    {
	$prices_array		= $this->_data->model_sizes_prices;
	$structure_type_code	= $BuilderArrayMapper->getStructureTypeCode($builder_values_array);
	$model_code		= $BuilderArrayMapper->getModel($builder_values_array);
	$size_code		= $BuilderArrayMapper->getSize($builder_values_array);
	if(
	    key_exists($structure_type_code, $prices_array)
	    && key_exists($model_code, $prices_array[$structure_type_code])
	    && key_exists($size_code, $prices_array[$structure_type_code][$model_code])
	)
	{
	    $base_price = $prices_array[$structure_type_code][$model_code][$size_code];
	    $this->_addDetail("Base", $base_price, $size_code);
	    $this->_price += $prices_array[$structure_type_code][$model_code][$size_code];
	}
    }
    
    private function _priceFrameGauge(BuilderArrayMapper $BuilderArrayMapper, $builder_values_array){
	$framegauge_code = $BuilderArrayMapper->getFrameGaugeCode($builder_values_array);
	if($framegauge_code)
	{
	    $prices_array = $this->_data->framegauge_prices;
	    if(key_exists($framegauge_code, $prices_array))
	    {
		$price		= $prices_array[$framegauge_code];
		$this->_price  += $price;
		$this->_addDetail("Frame Gauge", $price, $framegauge_code);
	    }
	}
    }
    
    private function _priceWalls(BuilderArrayMapper $BuilderArrayMapper, $builder_values_array) 
    {
	$sides			= array("left" => "Left", "right" => "Right", "front" => "Front", "back" => "Back");
	$walls_pricing_array	= $this->_data->walls_prices;
	$side_location_array	= array("left" => "side", "right" => "side", "front" => "end", "back" => "end");
	
	foreach ($sides as $side_lower => $side_upper) 
	{
	    $type	    = $BuilderArrayMapper->getCoveredWallsTypeCodeFromSideString($side_lower, $builder_values_array);
	    $partial_height = $BuilderArrayMapper->getCoveredWallsHeightCodeFromSideString($side_lower, $builder_values_array);
	    $orientation    = $BuilderArrayMapper->getOrientationCodeFromSideString($side_lower, $builder_values_array) == "V" ? "vertical" : "horizontal";
	    $certified	    = $BuilderArrayMapper->isCertified($builder_values_array) ? "certified" : "noncertified";
	    $width	    = (int) $BuilderArrayMapper->getFrameWidthCode($builder_values_array);
	    $length	    = (int) $BuilderArrayMapper->getFrameLengthCode($builder_values_array);
	    $leg_height	    = (int) $BuilderArrayMapper->getLegHeightCode($builder_values_array);
	    $side_location  = $side_location_array[$side_lower];
	    #--Is it an end or side?
	    switch ($side_location) 
	    {
		case "end":
		    switch($type){
			case "GB":
			    $price = $walls_pricing_array["location"][$side_location]
							["type"]["gable"]
							["certified"][$certified]
							["orientation"][$orientation];
			    $this->_price += $price;
			    $this->_addDetail($side_upper." wall", $price, $type);
			    break;
			case "PT"://partial top
			case "PB"://partial bottom
			    $bracing		= array("12" => 150, "18" => 150, "20" => 150, "22" => 175, "24" => 175);
			    $panel_length_array = array("12" => 75, "18" => 75 ,"20" => 75, "22" => 90, "24" => 90);
			    $amount_of_panels	= ceil($partial_height/3);
			    $price		= (($amount_of_panels*$panel_length_array[$width])+($bracing[$width]*$amount_of_panels));
			    $this->_price	+= $price;
			    $this->_addDetail($side_upper." wall", $price, $type." ".$partial_height."ft w/ bracing");
			    break;
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["type"]["closed"]
							["certified"][$certified]
							["orientation"][$orientation]
							["width"][$width]
							["leg_height"][$leg_height];
			    $this->_price += $price;
			    $this->_addDetail($side_upper." wall", $price, $type);
			    break;
			case "":
			case "NO"://no wall
			default:
		    }
		    break;
		case "side":
		    switch($type)
		    {
			//partial
			case "PB":
			case "PT":
			    $panel_length_array = array("21" => 75, "26" => 90, "31" => 105, "36" => 120, "41" => 170);
			    $amount_of_panels	= ceil($partial_height/3);
			    $price = ($amount_of_panels*$panel_length_array[$length]);
			    $this->_price += $price;
			    $this->_addDetail($side_upper." wall", $price, $type." ".$partial_height."ft");
			    break;
			//closed
			case "CL"://closed
			    $price = $walls_pricing_array["location"][$side_location]
							["orientation"][$orientation]
							["length"][$length]
							["leg_height"][$leg_height];
			    $this->_price += $price;
			    $this->_addDetail($side_upper." wall", $price, $type);
			    break;
			case "":
			case "NO":
			default:
		    }
		    break;
		default:
		    break;
	    }
	}
    }
    
    private function _priceLegHeight(BuilderArrayMapper $BuilderArrayMapper, $builder_values_array){
	$leg_height		= (int)$BuilderArrayMapper->getLegHeightCode($builder_values_array);
	$structure_type_code	= $BuilderArrayMapper->getStructureTypeCode($builder_values_array);
	$model_code		= $BuilderArrayMapper->getModel($builder_values_array);
	$price_array		= $this->_data->getModelLegHeightPricesArray();
	$length			= (int)$BuilderArrayMapper->getFrameLengthCode($builder_values_array);
	$price			= $price_array["type"][$structure_type_code]["model"][$model_code]["leg_height"][$leg_height]["length"][$length];
	$this->_price		+= $price;
	$this->_addDetail("Leg Height", $price, $leg_height."ft");
    }
    
    private function _priceDoors(BuilderArrayMapper $BuilderArrayMapper, $builder_values_array){
	$doors_count	= $BuilderArrayMapper->getDoorsCount($builder_values_array);
	if($doors_count>0){
	    $price_array	= $this->_data->doors_array;
	    $price		= 0;
	    $type		= $BuilderArrayMapper->getStructureTypeCode($builder_values_array);
	    $certified		= $BuilderArrayMapper->getCertifiedCode($builder_values_array);
	    $certified		= $certified == "Y" ? "certified" : "uncertified"; 
	    
	    for($i=0;$i<$doors_count;$i++){
		$door_type  = $BuilderArrayMapper->getDoorTypeCode($builder_values_array, $i);
		$size	    = $BuilderArrayMapper->getDoorSize($builder_values_array, $i);
		$price	    = $price_array["type"][$type]["certified"][$certified]["door_type"][$door_type][$size];
		$this->_price += $price;
		$this->_addDetail("Door ", $price, $size);
	    }
	}
    }
    
    private function _addDetail($name = "", $price = 0, $note = ""){
	$this->_details[] = array("name" => $name, "price" => $price, "note" => $note);
    }
    
    public function getDetails(){
	return $this->_details;
    }
}

?>
