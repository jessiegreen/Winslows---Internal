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

class BuilderArrayMapper 
{   
    public function __construct() {
	
    }
    
    public function getSize($builder_values_array){
	$width	= (int)$this->getFrameWidthCode($builder_values_array);
	$length = (int)$this->getFrameLengthCode($builder_values_array);
	if($width && $length){
	    return $width."X".$length;
	}
	return '';
    }
    
    public function setSize($value, $builder_values_array){
	$size_array				    = explode("X", $value);
	
	if(isset($size_array[0]))$builder_values_array = $this->setFrameWidth($size_array[0], $builder_values_array);
	if(isset($size_array[1]))$builder_values_array = $this->setFrameLength($size_array[1], $builder_values_array);
	return $builder_values_array;
    }
    
    public function getStructureTypeCode($builder_values_array){
	if(isset($builder_values_array['type'][0]['type'])){
	    return $builder_values_array['type'][0]['type'];
	}
	return '';
    }
    
    public function setStructureType($value, $builder_values_array){
	$builder_values_array['type'][0]['type'] = $value;
	return $builder_values_array;
    }
    
    public function getModel($builder_values_array){
	switch ($this->getStructureTypeCode($builder_values_array)) {
	    case "MC":
		return $this->getMetalStructureModelCode($builder_values_array);
	    break;
	    case "WF":
		return $this->getStorageBuildingModelCode($builder_values_array);
	    break;
	}
    }
    
    public function setModel($value, $builder_values_array){
	switch ($this->getStructureTypeCode($builder_values_array)) {
	    case "MC":
		return $this->setMetalStructureModel($value, $builder_values_array);
	    break;
	    case "WF":
		return $this->setStorageBuildingModel($value, $builder_values_array);
	    break;
	}
    }
    
    public function getModelIndex($builder_values_array){
	switch ($this->getStructureTypeCode($builder_values_array)) {
	    case "MC":
		return "metal_model";
	    break;
	    case "WF":
		return "wood_model";
	    break;
	}
    }
    
    public function getStorageBuildingModelCode($builder_values_array){
	if(isset($builder_values_array['wood_model'][0]['name'])){
	    return $builder_values_array['wood_model'][0]['name'];
	}
	return '';
    }   
    
    public function setStorageBuildingModel($value, $builder_values_array){
	$builder_values_array['wood_model'][0]['name'] = $value;
	return $builder_values_array;
    }
    
    public function getMetalStructureModelCode($builder_values_array){
	if(isset($builder_values_array['metal_model'][0]['name'])){
	    return $builder_values_array['metal_model'][0]['name'];
	}
	return '';
    }
    
    public function setMetalStructureModel($value, $builder_values_array){
	$builder_values_array['metal_model'][0]['name'] = $value;
	return $builder_values_array;
    }
    
    public function getFrameWidthCode($builder_values_array){
	if(isset($builder_values_array['width'][0]) && isset($builder_values_array['width'][0]['width'])){
	    return $builder_values_array['width'][0]['width'];
	}
	return '';
    }
    
    public function setFrameWidth($value, $builder_values_array){
	$builder_values_array['width'][0]['width'] = $value;
	return $builder_values_array;
    }
    
    public function getFrameLengthCode($builder_values_array){
	if(isset($builder_values_array['length'][0]) && isset($builder_values_array['length'][0]['length'])){
	    return $builder_values_array['length'][0]['length'];
	}
	return '';
    }
    
    public function setFrameLength($value, $builder_values_array){
	$builder_values_array['length'][0]['length'] = $value;
	return $builder_values_array;
    }

    public function getLegHeightCode($builder_values_array){
	if(isset($builder_values_array['leg_height'][0]) && isset($builder_values_array['leg_height'][0]['height'])){
	    return $builder_values_array['leg_height'][0]['height'];
	}
	return '';
    }
    
    public function setLegHeight($value, $builder_values_array){
	$builder_values_array['leg_height'][0]['height'] = $value;
	return $builder_values_array;
    }
    
    public function setRoofColor($value, $builder_values_array){
	$builder_values_array['color_roof'][0]['color'] = $value;
	return $builder_values_array;
    }
    
    public function getRoofColorCode($builder_values_array){
	if(isset($builder_values_array['color_roof'][0]['color'])){
	    return $builder_values_array['color_roof'][0]['color'];
	}
	return '';
    }
    
    public function setTrimColor($value, $builder_values_array){
	$builder_values_array['color_trim'][0]['color'] = $value;
	return $builder_values_array;
    }
    
    public function getTrimColorCode($builder_values_array){
	if(isset($builder_values_array['color_trim'][0]['color'])){
	    return $builder_values_array['color_trim'][0]['color'];
	}
	return '';
    }
    
    public function setSidesColor($value, $builder_values_array){
	$builder_values_array['color_sides'][0]['color'] = $value;
	return $builder_values_array;
    }
    
    public function getSidesColorCode($builder_values_array){
	if(isset($builder_values_array['color_sides'][0]['color'])){
	    return $builder_values_array['color_sides'][0]['color'];
	}
	return '';
    }
    
    public function setEndsColor($value, $builder_values_array){
	$builder_values_array['color_ends'][0]['color'] = $value;
	return $builder_values_array;
    }
    
    public function getEndsColorCode($builder_values_array){
	if(isset($builder_values_array['color_ends'][0]['color'])){
	    return $builder_values_array['color_ends'][0]['color'];
	}
	return '';
    }
    
    public function getCoveredWallsTypeCodeFromSideString($side, $builder_values_array){
	 return call_user_func(
				array(
				    $this,'getCovered'.ucfirst(strtolower($side)).'TypeCode'
				    ), 
				$builder_values_array
				);
    }
    
    public function setCoveredWallsTypeFromSideString($value, $side, $builder_values_array){
	 return call_user_func(
				array(
				    $this,'setCovered'.ucfirst(strtolower($side)).'Type'
				    ), 
				$value,
				$builder_values_array
				);
    }
    
    public function getCoveredWallsHeightCodeFromSideString($side, $builder_values_array){
	 return call_user_func(
				array(
				    $this,'getCovered'.ucfirst(strtolower($side)).'HeightCode'
				    ), 
				$builder_values_array
				);
    }
    
    public function setCoveredWallsHeightFromSideString($value, $side, $builder_values_array){
	 return call_user_func(
				array(
				    $this,'setCovered'.ucfirst(strtolower($side)).'Height'
				    ), 
				$value,
				$builder_values_array
				);
    }
    
    public function getCoveredLeftTypeCode($builder_values_array){
	if(isset($builder_values_array['covered_left'][0]['type'])){
	    return $builder_values_array['covered_left'][0]['type'];
	}
	return '';
    }
    
    public function setCoveredLeftType($value, $builder_values_array){
	$builder_values_array['covered_left'][0]['type'] = $value;
	return $builder_values_array;
    }
    
    public function getCoveredLeftHeightCode($builder_values_array){
	if(isset($builder_values_array['covered_left'][0]['height'])){
	    return $builder_values_array['covered_left'][0]['height'];
	}
	return '';
    }
    
    public function setCoveredLeftHeight($value, $builder_values_array){
	$builder_values_array['covered_left'][0]['height'] = $value;
	return $builder_values_array;
    }
    
    public function getCoveredRightTypeCode($builder_values_array){
	if(isset($builder_values_array['covered_right'][0]['type'])){
	    return $builder_values_array['covered_right'][0]['type'];
	}
	return '';
    }
    
    public function setCoveredRightType($value, $builder_values_array){
	$builder_values_array['covered_right'][0]['type'] = $value;
	return $builder_values_array;
    }
    
    public function getCoveredRightHeightCode($builder_values_array){
	if(isset($builder_values_array['covered_right'][0]['height'])){
	    return $builder_values_array['covered_right'][0]['height'];
	}
	return '';
    }
    
    public function setCoveredRightHeight($value, $builder_values_array){
	$builder_values_array['covered_right'][0]['height'] = $value;
	return $builder_values_array;
    }
    
    public function getCoveredFrontTypeCode($builder_values_array){
	if(isset($builder_values_array['covered_front'][0]['type'])){
	    return $builder_values_array['covered_front'][0]['type'];
	}
	return '';
    }
    
    public function setCoveredFrontType($value, $builder_values_array){
	$builder_values_array['covered_front'][0]['type'] = $value;
	return $builder_values_array;
    }
    
    public function getCoveredFrontHeightCode($builder_values_array){
	if(isset($builder_values_array['covered_front'][0]['height'])){
	    return $builder_values_array['covered_front'][0]['height'];
	}
	return '';
    }
    
    public function setCoveredFrontHeight($value, $builder_values_array){
	$builder_values_array['covered_front'][0]['height'] = $value;
	return $builder_values_array;
    }
    
    public function getCoveredBackTypeCode($builder_values_array){
	if(isset($builder_values_array['covered_back'][0]['type'])){
	    return $builder_values_array['covered_back'][0]['type'];
	}
	return '';
    }
    
    public function setCoveredBackType($value, $builder_values_array){
	$builder_values_array['covered_back'][0]['type'] = $value;
	return $builder_values_array;
    }
    
    public function getCoveredBackHeightCode($builder_values_array){
	if(isset($builder_values_array['covered_back'][0]['height'])){
	    return $builder_values_array['covered_back'][0]['height'];
	}
	return '';
    }
    
    public function setCoveredBackHeight($value, $builder_values_array){
	$builder_values_array['covered_back'][0]['height'] = $value;
	return $builder_values_array;
    }
    
    public function getFrameGaugeCode($builder_values_array){
	if(isset($builder_values_array['frame_gauge'][0]['gauge'])){
	    return $builder_values_array['frame_gauge'][0]['gauge'];
	}
	return '';
    }
    
    public function getSheetMetalGaugeCode($builder_values_array){
	if(isset($builder_values_array['sheet_metal_gauge'][0]['gauge'])){
	    return $builder_values_array['sheet_metal_gauge'][0]['gauge'];
	}
	return '';
    }
    
    public function isCertified($builder_values_array){
	if($this->getCertifiedCode($builder_values_array) == "Y")
	{
	    return true;
	}
	else return false;
    }
    
    public function getCertifiedCode($builder_values_array){
	if(isset($builder_values_array['certified'][0]['certified'])){
	    return $builder_values_array['certified'][0]['certified'];
	}
	return '';
    }
    
    public function getOrientationCodeFromSideString($side, $builder_values_array){
	 return call_user_func(
				array(
				    $this,'get'.ucfirst(strtolower($side)).'OrientationCode'
				    ), 
				$builder_values_array
				);
    }
    
    public function setOrientationFromSideString($value, $side, $builder_values_array){
	 return call_user_func(
				array(
				    $this,'set'.ucfirst(strtolower($side)).'Orientation'
				    ), 
				$value,
				$builder_values_array
				);
    }
    
    public function getLeftOrientationCode($builder_values_array){
	if(isset($builder_values_array['orientation_left'][0]['orientation'])){
	    return $builder_values_array['orientation_left'][0]['orientation'];
	}
	return '';
    }
    
    public function setLeftOrientation($value, $builder_values_array){
	$builder_values_array['orientation_left'][0]['orientation'] = $value;
	return $builder_values_array;
    }
    
    public function getRightOrientationCode($builder_values_array){
	if(isset($builder_values_array['orientation_right'][0]['orientation'])){
	    return $builder_values_array['orientation_right'][0]['orientation'];
	}
	return '';
    }
    
    public function setRightOrientation($value, $builder_values_array){
	$builder_values_array['orientation_right'][0]['orientation'] = $value;
	return $builder_values_array;
    }
    
    public function getFrontOrientationCode($builder_values_array){
	if(isset($builder_values_array['orientation_front'][0]['orientation'])){
	    return $builder_values_array['orientation_front'][0]['orientation'];
	}
	return '';
    }
    
    public function setFrontOrientation($value, $builder_values_array){
	$builder_values_array['orientation_front'][0]['orientation'] = $value;
	return $builder_values_array;
    }
    
    public function getBackOrientationCode($builder_values_array){
	if(isset($builder_values_array['orientation_back'][0]['orientation'])){
	    return $builder_values_array['orientation_back'][0]['orientation'];
	}
	return '';
    }
    
    public function setBackOrientation($value, $builder_values_array){
	$builder_values_array['orientation_back'][0]['orientation'] = $value;
	return $builder_values_array;
    }
    
    public function getRoofOrientationCode($builder_values_array){
	if(isset($builder_values_array['orientation_roof'][0]['orientation'])){
	    return $builder_values_array['orientation_roof'][0]['orientation'];
	}
	return '';
    }
    
    public function hasAnchors($builder_values_array){
	if($this->getAnchorsCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getAnchorsCode($builder_values_array){
	if(isset($builder_values_array['anchors'][0]['has_anchors'])){
	    return $builder_values_array['anchors'][0]['has_anchors'];
	}
	return '';
    }
    
    public function getAnchorsTypeCode($builder_values_array){
	if(isset($builder_values_array['anchors'][0]['type'])){
	    return $builder_values_array['anchors'][0]['type'];
	}
	return '';
    }
    
    public function getAnchorsQuantityCode($builder_values_array){
	if(isset($builder_values_array['anchors'][0]['quantity'])){
	    return $builder_values_array['anchors'][0]['quantity'];
	}
	return '';
    }
    
    public function isSelfInstall($builder_values_array){
	if($this->getSelfInstallCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getSelfInstallCode($builder_values_array){
	if(isset($builder_values_array['self_install'][0]['self_install'])){
	    return $builder_values_array['self_install'][0]['self_install'];
	}
	return '';
    }
    
    public function addDoor($size = "",$location = "", $type = ""){
	
    }
    
    public function getDoorSize($builder_values_array){
	$width	= (int)$this->getDoorWidthCode($builder_values_array);
	$length = (int)$this->getDoorHeightCode($builder_values_array);
	if($width && $length){
	    return $width."X".$length;
	}
	return '';
    }
    
    public function getDoorLocationCode($builder_values_array, $door_number){
	$index = $door_number-1;
	
	if(isset($builder_values_array['door'][$index]['location'])){
	    return $builder_values_array['door'][$index]['location'];
	}
	return '';
    }
    
    public function getDoorTypeCode($builder_values_array, $door_number){
	$index = $door_number-1;
	
	if(isset($builder_values_array['door'][$index]['type'])){
	    return $builder_values_array['door'][$index]['type'];
	}
	return '';
    }
    
    public function getDoorWidthCode($builder_values_array, $door_number){
	$index = $door_number-1;
	
	if(isset($builder_values_array['door'][$index]['width'])){
	    return $builder_values_array['door'][$index]['width'];
	}
	return '';
    }
    
    public function getDoorHeightCode($builder_values_array, $door_number){
	$index = $door_number-1;
	
	if(isset($builder_values_array['door'][$index]['height'])){
	    return $builder_values_array['door'][$index]['height'];
	}
	return '';
    }
    
    public function getDoorInchesFromLeftCode($builder_values_array, $door_number){
	$index = $door_number-1;
	
	if(isset($builder_values_array['door'][$index]['from_left'])){
	    return $builder_values_array['door'][$index]['from_left'];
	}
	return '';
    }
    
    public function getDoorsCount($builder_values_array){
	if(isset($builder_values_array['door'])){
	    return count($builder_values_array['door']);
	}
	else return 0;
    }
    
    public function getWindowLocationCode($builder_values_array, $window_number){
	$index = $window_number-1;
	
	if(isset($builder_values_array['window'][$index]['location'])){
	    return $builder_values_array['window'][$index]['location'];
	}
	return '';
    }
    
    public function getWindowTypeCode($builder_values_array, $window_number){
	$index = $window_number-1;
	
	if(isset($builder_values_array['window'][$index]['type'])){
	    return $builder_values_array['window'][$index]['type'];
	}
	return '';
    }
    
    public function getWindowWidthCode($builder_values_array, $window_number){
	$index = $window_number-1;
	
	if(isset($builder_values_array['window'][$index]['width'])){
	    return $builder_values_array['window'][$index]['width'];
	}
	return '';
    }
    
    public function getWindowHeightCode($builder_values_array, $window_number){
	$index = $window_number-1;
	
	if(isset($builder_values_array['window'][$index]['height'])){
	    return $builder_values_array['window'][$index]['height'];
	}
	return '';
    }
    
    public function getWindowInchesFromLeftCode($builder_values_array, $window_number){
	$index = $window_number-1;
	
	if(isset($builder_values_array['window'][$index]['from_left'])){
	    return $builder_values_array['window'][$index]['from_left'];
	}
	return '';
    }
    
    public function getWindowInchesFromBottomCode($builder_values_array, $window_number){
	$index = $window_number-1;
	
	if(isset($builder_values_array['window'][$index]['from_bottom'])){
	    return $builder_values_array['window'][$index]['from_bottom'];
	}
	return '';
    }
    
    public function getWindowsCount($builder_values_array){
	if(isset($builder_values_array['window'])){
	    return count($builder_values_array['window']);
	}
	else return 0;
    }
    #--End Window
    
    public function getFrameOutLocationCode($builder_values_array, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($builder_values_array['frame_out'][$index]['location'])){
	    return $builder_values_array['frame_out'][$index]['location'];
	}
	return '';
    }
    
    public function getFrameOutTypeCode($builder_values_array, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($builder_values_array['frame_out'][$index]['type'])){
	    return $builder_values_array['frame_out'][$index]['type'];
	}
	return '';
    }
    
    public function getFrameOutWidthCode($builder_values_array, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($builder_values_array['frame_out'][$index]['width'])){
	    return $builder_values_array['frame_out'][$index]['width'];
	}
	return '';
    }
    
    public function getFrameOutHeightCode($builder_values_array, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($builder_values_array['frame_out'][$index]['height'])){
	    return $builder_values_array['frame_out'][$index]['height'];
	}
	return '';
    }
    
    public function getFrameOutInchesFromLeftCode($builder_values_array, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($builder_values_array['frame_out'][$index]['from_left'])){
	    return $builder_values_array['frame_out'][$index]['from_left'];
	}
	return '';
    }
    
    public function getFrameOutInchesFromBottomCode($builder_values_array, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($builder_values_array['frame_out'][$index]['from_bottom'])){
	    return $builder_values_array['frame_out'][$index]['from_bottom'];
	}
	return '';
    }
    
    public function getFrameOutsCount($builder_values_array){
	if(isset($builder_values_array['frame_out'])){
	    return count($builder_values_array['frame_out']);
	}
	else return 0;
    }
    
    public function hasTranslucentPanels($builder_values_array) {
	if($this->getTranslucentPanelsCount($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getTranslucentPanelsCountCode($builder_values_array){
	if(isset($builder_values_array['translucent_panels'][0]['quantity'])){
	    return $builder_values_array['translucent_panels'][0]['quantity'];
	}
	return '';
    }
    
    public function hasKneeBraces($builder_values_array) {
	if($this->getKneeBracesCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getKneeBracesCountCode($builder_values_array){
	if(isset($builder_values_array['knee_braces'][0]['quantity'])){
	    return $builder_values_array['knee_braces'][0]['quantity'];
	}
	return '';
    }
    
    public function hasStormBraces($builder_values_array) {
	if($this->getStormBracesCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getStormBracesCountCode($builder_values_array){
	if(isset($builder_values_array['storm_braces'][0]['quantity'])){
	    return $builder_values_array['storm_braces'][0]['quantity'];
	}
	return '';
    }
    
    public function hasLockAndKeySets($builder_values_array) {
	if($this->getLockAndKeySetsCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getLockAndKeySetsCountCode($builder_values_array){
	if(isset($builder_values_array['lock_and_key_set'][0]['quantity'])){
	    return $builder_values_array['lock_and_key_set'][0]['quantity'];
	}
	return '';
    }
    
    public function hasLockChains($builder_values_array) {
	if($this->getLockChainsCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getLockChainsCountCode($builder_values_array){
	if(isset($builder_values_array['lock_chain'][0]['quantity'])){
	    return $builder_values_array['lock_chain'][0]['quantity'];
	}
	return '';
    }
    
    public function hasRoofVents($builder_values_array) {
	if($this->getRoofVentsCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getRoofVentsCountCode($builder_values_array){
	if(isset($builder_values_array['vent_roof'][0]['quantity'])){
	    return $builder_values_array['vent_roof'][0]['quantity'];
	}
	return '';
    }
    
    public function hasGableJtrim($builder_values_array){
	if($this->getGableJTrimCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getGableJTrimCode($builder_values_array){
	if(isset($builder_values_array['j_trim_gable'][0]['j_trim_gable'])){
	    return $builder_values_array['j_trim_gable'][0]['j_trim_gable'];
	}
	return '';
    }
    
    public function hasLoft($builder_values_array){
	if($this->getLoftWidthCode($builder_values_array)>0 || $this->getLoftDepthCode($builder_values_array)>0){
	    return true;
	}
	else return false;
    }
    
    public function getLoftWidthCode($builder_values_array){
	if(isset($builder_values_array['loft'][0]['width'])){
	    return $builder_values_array['loft'][0]['width'];
	}
	return '';
    }
    
    public function getLoftDepthCode($builder_values_array){
	if(isset($builder_values_array['loft'][0]['depth'])){
	    return $builder_values_array['loft'][0]['depth'];
	}
	return '';
    }
    
    public function hasPorch($builder_values_array){
	if($this->getPorchWidthCode($builder_values_array)>0 || $this->getPorchDepthCode($builder_values_array)>0){
	    return true;
	}
	else return false;
    }
    
    public function getPorchLocationCode($builder_values_array){
	if(isset($builder_values_array['BJ'][0]['location'])){
	    return $builder_values_array['BJ'][0]['location'];
	}
	return '';
    }
    
    public function getPorchTypeCode($builder_values_array){
	if(isset($builder_values_array['porch'][0]['type'])){
	    return $builder_values_array['porch'][0]['type'];
	}
	return '';
    }
    
    public function getPorchWidthCode($builder_values_array){
	if(isset($builder_values_array['porch'][0]['width'])){
	    return $builder_values_array['porch'][0]['width'];
	}
	return '';
    }
    
    public function getPorchDepthCode($builder_values_array){
	if(isset($builder_values_array['porch'][0]['depth'])){
	    return $builder_values_array['porch'][0]['depth'];
	}
	return '';
    }
    
    public function isPorchRecessed($builder_values_array){
	if($this->getPorchRecessedCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getPorchRecessedCode($builder_values_array){
	if(isset($builder_values_array['porch'][0]['recessed'])){
	    return $builder_values_array['porch'][0]['recessed'];
	}
	return '';
    }
    
    public function hasPorchRailingWithSpindles($builder_values_array){
	if($this->getPorchRailingWithSpindlesCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getPorchRailingWithSpindlesCode($builder_values_array){
	if(isset($builder_values_array['porch'][0]['railing'])){
	    return $builder_values_array['porch'][0]['railing'];
	}
	return '';
    }
    
    public function hasTreatedStudPlates($builder_values_array){
	if($this->getTreatedStudPlatesCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getTreatedStudPlatesCode($builder_values_array){
	if(isset($builder_values_array['stud_plates_treated'][0]['stud_plates_treated'])){
	    return $builder_values_array['stud_plates_treated'][0]['stud_plates_treated'];
	}
	return '';
    }
    
    public function hasWoodRamp($builder_values_array){
	if($this->getWoodRampWidthCode($builder_values_array)>0 || $this->getWoodRampDepthCode($builder_values_array)>0){
	    return true;
	}
	else return false;
    }
    
    public function getWoodRampWidthCode($builder_values_array){
	if(isset($builder_values_array['ramp_wood'][0]['width'])){
	    return $builder_values_array['ramp_wood'][0]['width'];
	}
	return '';
    }
    
    public function getWoodRampDepthCode($builder_values_array){
	if(isset($builder_values_array['ramp_wood'][0]['depth'])){
	    return $builder_values_array['ramp_wood'][0]['depth'];
	}
	return '';
    }
    
    public function hasPerimeterBlocking($builder_values_array){
	if($this->getPerimeterBlockingCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getPerimeterBlockingCode($builder_values_array){
	if(isset($builder_values_array['blocking_perimeter'][0]['blocking_perimeter'])){
	    return $builder_values_array['blocking_perimeter'][0]['blocking_perimeter'];
	}
	return '';
    }
    
    public function getRaftersSizeCode($builder_values_array){
	if(isset($builder_values_array['rafters'][0]['size'])){
	    return $builder_values_array['rafters'][0]['size'];
	}
	return '';
    }
    
    public function getRaftersCentersCode($builder_values_array){
	if(isset($builder_values_array['rafters'][0]['centers'])){
	    return $builder_values_array['rafters'][0]['centers'];
	}
	return '';
    }
    
    public function hasTreatedFloorJoists($builder_values_array){
	if($this->getFloorJoistsTreatedCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getFloorJoistsTreatedCode($builder_values_array){
	if(isset($builder_values_array['floor_joists'][0]['treated'])){
	    return $builder_values_array['floor_joists'][0]['treated'];
	}
	return '';
    }
    
    public function getFloorJoistsCentersCode($builder_values_array){
	if(isset($builder_values_array['floor_joists'][0]['centers'])){
	    return $builder_values_array['floor_joists'][0]['centers'];
	}
	return '';
    }
    
    public function getFloorSheathingTypeCode($builder_values_array){
	if(isset($builder_values_array['floor_sheathing'][0]['type'])){
	    return $builder_values_array['floor_sheathing'][0]['type'];
	}
	return '';
    }
    
    public function hasShelves($builder_values_array){
	if($this->getShelvesDepthCode($builder_values_array)>0 || $this->getShelvesLengthCode($builder_values_array)>0){
	    return true;
	}
	else return false;
    }
    
    public function getShelvesDepthCode($builder_values_array){
	if(isset($builder_values_array['shelves'][0]['depth'])){
	    return $builder_values_array['shelves'][0]['depth'];
	}
	return '';
    }
    
    public function getShelvesLengthCode($builder_values_array){
	if(isset($builder_values_array['shelves'][0]['length'])){
	    return $builder_values_array['shelves'][0]['length'];
	}
	return '';
    }
    
    public function hasWorkBench($builder_values_array){
	if($this->getWorkBenchWidthCode($builder_values_array)>0){
	    return true;
	}
	else return false;
    }
    
    public function getWorkBenchWidthCode($builder_values_array){
	if(isset($builder_values_array['work_bench'][0]['width'])){
	    return $builder_values_array['work_bench'][0]['width'];
	}
	return '';
    }
    
    public function hasAcCutOuts($builder_values_array){
	if($this->getAcCutOutsCountCode($builder_values_array)>0){
	    return true;
	}
	else return false;
    }
    
    public function getAcCutOutsCountCode($builder_values_array){
	if(isset($builder_values_array['cutout_ac'][0]['quantity'])){
	    return $builder_values_array['cutout_ac'][0]['quantity'];
	}
	return '';
    }
    
    public function isKit($builder_values_array){
	if($this->getKitCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getKitCode($builder_values_array){
	if(isset($builder_values_array['kit'][0]['kit'])){
	    return $builder_values_array['kit'][0]['kit'];
	}
	return '';
    }
    
    public function hasOutlet110($builder_values_array) {
	if($this->getOutlet110CountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getOutlet110CountCode($builder_values_array){
	if(isset($builder_values_array['plug_110_int'][0]['quantity'])){
	    return $builder_values_array['plug_110_int'][0]['quantity'];
	}
	return '';
    }
    
    public function hasOutletAC220($builder_values_array) {
	if($this->getOutletAC220CountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getOutletAC220CountCode($builder_values_array){
	if(isset($builder_values_array['plug_220_ac'][0]['quantity'])){
	    return $builder_values_array['plug_220_ac'][0]['quantity'];
	}
	return '';
    }
    
    public function hasOutlet110GfiInterior($builder_values_array) {
	if($this->getOutlet110GfiInteriorCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getOutlet110GfiInteriorCountCode($builder_values_array){
	if(isset($builder_values_array['plug_110_gfi_int'][0]['quantity'])){
	    return $builder_values_array['plug_110_gfi_int'][0]['quantity'];
	}
	return '';
    }
    
    public function hasOutlet110GfiExterior($builder_values_array) {
	if($this->getOutlet110GfiExteriorCount($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getOutlet110GfiExteriorCountCode($builder_values_array){
	if(isset($builder_values_array['plug_110_gfi_ext'][0]['quantity'])){
	    return $builder_values_array['plug_110_gfi_ext'][0]['quantity'];
	}
	return '';
    }
    
    public function hasBreakerBox100NoMain($builder_values_array) {
	if($this->getBreakerBox100NoMainCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getBreakerBox100NoMainCountCode($builder_values_array){
	if(isset($builder_values_array['breaker_box_100_no'][0]['quantity'])){
	    return $builder_values_array['breaker_box_100_no'][0]['quantity'];
	}
	return '';
    }
    
    public function hasBreakerBox125NoMain($builder_values_array) {
	if($this->getBreakerBox125NoMainCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getBreakerBox125NoMainCountCode($builder_values_array){
	if(isset($builder_values_array['breaker_box_125_no'][0]['quantity'])){
	    return $builder_values_array['breaker_box_125_no'][0]['quantity'];
	}
	return '';
    }
    
    public function hasLight4FtFluorDouble($builder_values_array) {
	if($this->getLight4FtFluorDoubleCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getLight4FtFluorDoubleCountCode($builder_values_array){
	if(isset($builder_values_array['light_4_fluor'][0]['quantity'])){
	    return $builder_values_array['light_4_fluor'][0]['quantity'];
	}
	return '';
    }
    
    public function hasLight8FtFluorDouble($builder_values_array) {
	if($this->getLight8FtFluorDoubleCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getLight8FtFluorDoubleCountCode($builder_values_array){
	if(isset($builder_values_array['light_8_fluor'][0]['quantity'])){
	    return $builder_values_array['light_8_fluor'][0]['quantity'];
	}
	return '';
    }
    
    public function hasPorchLight($builder_values_array) {
	if($this->getPorchLightCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getPorchLightCountCode($builder_values_array){
	if(isset($builder_values_array['light_porch'][0]['quantity'])){
	    return $builder_values_array['light_porch'][0]['quantity'];
	}
	return '';
    }
    
    public function hasIncandescentLight($builder_values_array) {
	if($this->getIncandescentLightCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getIncandescentLightCountCode($builder_values_array){
	if(isset($builder_values_array['light_incandescent'][0]['quantity'])){
	    return $builder_values_array['light_incandescent'][0]['quantity'];
	}
	return '';
    }
    
    public function getInsulationR10LocationCode($builder_values_array, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($builder_values_array['insulation_r10'][$index]['location'])){
	    return $builder_values_array['insulation_r10'][$index]['location'];
	}
	return '';
    }
    
    public function getInsulationR7RadiantBarrierLocationCode($builder_values_array, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($builder_values_array['insulation_r7_rad'][$index]['location'])){
	    return $builder_values_array['insulation_r7_rad'][$index]['location'];
	}
	return '';
    }
    
    public function hasSkirtingWithMetal($builder_values_array){
	if($this->getSkirtingWithMetalCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getSkirtingWithMetalCode($builder_values_array){
	if(isset($builder_values_array['skirting_metal'][0]['skirting'])){
	    return $builder_values_array['skirting_metal'][0]['skirting'];
	}
	return '';
    }
    
    public function hasTreatedCedarPlySiding($builder_values_array){
	if($this->getTreatedCedarPlySidingCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getTreatedCedarPlySidingCode($builder_values_array){
	if(isset($builder_values_array['siding_treat_ply'][0]['siding_cedar'])){
	    return $builder_values_array['siding_treat_ply'][0]['siding_cedar'];
	}
	return '';
    }
    
    public function hasSmartSidingVerticalGroove($builder_values_array){
	if($this->getSmartSidingVerticalGrooveCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getSmartSidingVerticalGrooveCode($builder_values_array){
	if(isset($builder_values_array['siding_smart_vert'][0]['siding_smart'])){
	    return $builder_values_array['siding_smart_vert'][0]['siding_smart'];
	}
	return '';
    }
    
    public function hasHorizontalLapSiding($builder_values_array){
	if($this->getHorizontalLapSidingCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getHorizontalLapSidingCode($builder_values_array){
	if(isset($builder_values_array['siding_lap_horiz'][0]['siding_lap'])){
	    return $builder_values_array['siding_lap_horiz'][0]['siding_lap'];
	}
	return '';
    }
    
    public function hasCompositionRoof($builder_values_array){
	if($this->getHorizontalLapSidingCode($builder_values_array) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getCompositionRoofCode($builder_values_array){
	if(isset($builder_values_array['roof_comp'][0]['roof_comp'])){
	    return $builder_values_array['roof_comp'][0]['roof_comp'];
	}
	return '';
    }
    
    public function hasSkirtVents($builder_values_array) {
	if($this->getSkirtVentCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getSkirtVentCountCode($builder_values_array){
	if(isset($builder_values_array['vent_skirt'][0]['quantity'])){
	    return $builder_values_array['vent_skirt'][0]['quantity'];
	}
	return '';
    }
    
    public function hasPaintStain($builder_values_array) {
	if(strlen($this->getPaintStainTypeCode($builder_values_array))>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getPaintStainTypeCode($builder_values_array){
	if(isset($builder_values_array['paint_stain'][0]['type'])){
	    return $builder_values_array['paint_stain'][0]['type'];
	}
	return '';
    }
    
    public function hasRoofOverhang($builder_values_array) {
	if($this->getRoofOverhangLengthCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getRoofOverhangLengthCode($builder_values_array){
	if(isset($builder_values_array['roof_overhang'][0]['length'])){
	    return $builder_values_array['roof_overhang'][0]['length'];
	}
	return '';
    }
    
    public function hasShutterPairs($builder_values_array) {
	if($this->getShutterPairsCountCode($builder_values_array)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
        
    public function getShutterPairsCountCode($builder_values_array){
	if(isset($builder_values_array['window_shutters'][0]['gauge'])){
	    return $builder_values_array['window_shutters'][0]['gauge'];
	}
	return '';
    }
}
?>