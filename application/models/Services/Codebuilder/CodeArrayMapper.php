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

class CodeArrayMapper 
{   
    public function __construct() {
	
    }
    
    public function getSize($options){
	$width	= $this->getFrameWidth($options);
	$length = $this->getFrameLength($options);
	if($width && $length){
	    return $width."X".$length;
	}
	else return '';
    }
    
    public function getStructureType($options){
	if(isset($options['AA'][0]['values']['2']['value_option']['name'])){
	    return $options['AA'][0]['values']['2']['value_option']['name'];
	}
	else return '';
    }
    
    public function getStructureTypeCode($options){
	if(isset($options['AA'][0]['values']['2']['value_option']['code'])){
	    return $options['AA'][0]['values']['2']['value_option']['code'];
	}
	else return '';
    }
    
    public function getStorageBuildingModel($options){
	if(isset($options['BI'][0]['values']['57']['value_option']['name'])){
	    return $options['BI'][0]['values']['57']['value_option']['name'];
	}
	else return '';
    }
    
    public function getStorageBuildingModelCode($options){
	if(isset($options['BI'][0]['values']['57']['value_option']['code'])){
	    return $options['BI'][0]['values']['57']['value_option']['code'];
	}
	else return '';
    }   
    
    public function getMetalStructureModel($options){
	if(isset($options['CP'][0]['values']['99']['value_option']['name'])){
	    return $options['CP'][0]['values']['99']['value_option']['name'];
	}
	else return '';
    }
    
    public function getMetalStructureModelCode($options){
	if(isset($options['CP'][0]['values']['99']['value_option']['code'])){
	    return $options['CP'][0]['values']['99']['value_option']['code'];
	}
	else return '';
    } 
    
    public function getFrameWidth($options){
	if(isset($options['AB'][0]['values']['3']['value_option']['name'])){
	    return $options['AB'][0]['values']['3']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameWidthCode($options){
	if(isset($options['AB'][0]['values']['3']['value_option']['code'])){
	    return $options['AB'][0]['values']['3']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrameLength($options){
	if(isset($options['AC'][0]['values']['4']['value_option']['name'])){
	    return $options['AC'][0]['values']['4']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameLengthCode($options){
	if(isset($options['AC'][0]['values']['4']['value_option']['code'])){
	    return $options['AC'][0]['values']['4']['value_option']['code'];
	}
	else return '';
    }
    
    public function getLegHeight($options){
	if(isset($options['AD'][0]['values']['5']['value_option']['name'])){
	    return $options['AD'][0]['values']['5']['value_option']['name'];
	}
	else return '';
    }
    
    public function getLegHeightCode($options){
	if(isset($options['AD'][0]['values']['5']['value_option']['code'])){
	    return $options['AD'][0]['values']['5']['value_option']['code'];
	}
	else return '';
    }
    
    public function getRoofColor($options){
	if(isset($options['AE'][0]['values']['6']['value_option']['name'])){
	    return $options['AE'][0]['values']['6']['value_option']['name'];
	}
	else return '';
    }
    
    public function getRoofColorCode($options){
	if(isset($options['AE'][0]['values']['6']['value_option']['code'])){
	    return $options['AE'][0]['values']['6']['value_option']['code'];
	}
	else return '';
    }
    
    public function getTrimColor($options){
	if(isset($options['AF'][0]['values']['7']['value_option']['name'])){
	    return $options['AF'][0]['values']['7']['value_option']['name'];
	}
	else return '';
    }
    
    public function getTrimColorCode($options){
	if(isset($options['AF'][0]['values']['7']['value_option']['code'])){
	    return $options['AF'][0]['values']['7']['value_option']['code'];
	}
	else return '';
    }
    
    public function getSidesColor($options){
	if(isset($options['AG'][0]['values']['8']['value_option']['name'])){
	    return $options['AG'][0]['values']['8']['value_option']['name'];
	}
	else return '';
    }
    
    public function getSidesColorCode($options){
	if(isset($options['AG'][0]['values']['8']['value_option']['code'])){
	    return $options['AG'][0]['values']['8']['value_option']['code'];
	}
	else return '';
    }
    
    public function getEndsColor($options){
	if(isset($options['AH'][0]['values']['9']['value_option']['name'])){
	    return $options['AH'][0]['values']['9']['value_option']['name'];
	}
	else return '';
    }
    
    public function getEndsColorCode($options){
	if(isset($options['AH'][0]['values']['9']['value_option']['code'])){
	    return $options['AH'][0]['values']['9']['value_option']['code'];
	}
	else return '';
    }
    
    public function getCoveredLeftType($options){
	if(isset($options['AI'][0]['values']['10']['value_option']['name'])){
	    return $options['AI'][0]['values']['10']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCoveredLeftTypeCode($options){
	if(isset($options['AI'][0]['values']['10']['value_option']['code'])){
	    return $options['AI'][0]['values']['10']['value_option']['code'];
	}
	else return '';
    }
    
    public function getCoveredLeftHeight($options){
	if(isset($options['AI'][0]['values']['11']['value_option']['name'])){
	    return $options['AI'][0]['values']['11']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCoveredLeftHeightCode($options){
	if(isset($options['AI'][0]['values']['11']['value_option']['code'])){
	    return $options['AI'][0]['values']['11']['value_option']['code'];
	}
	else return '';
    }
    
    public function getCoveredRightType($options){
	if(isset($options['AJ'][0]['values']['12']['value_option']['name'])){
	    return $options['AJ'][0]['values']['12']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCoveredRightTypeCode($options){
	if(isset($options['AJ'][0]['values']['12']['value_option']['code'])){
	    return $options['AJ'][0]['values']['12']['value_option']['code'];
	}
	else return '';
    }
    
    public function getCoveredRightHeight($options){
	if(isset($options['AJ'][0]['values']['13']['value_option']['name'])){
	    return $options['AJ'][0]['values']['13']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCoveredRightHeightCode($options){
	if(isset($options['AJ'][0]['values']['13']['value_option']['code'])){
	    return $options['AJ'][0]['values']['13']['value_option']['code'];
	}
	else return '';
    }
    
    public function getCoveredFrontType($options){
	if(isset($options['AK'][0]['values']['14']['value_option']['name'])){
	    return $options['AK'][0]['values']['14']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCoveredFrontTypeCode($options){
	if(isset($options['AK'][0]['values']['14']['value_option']['code'])){
	    return $options['AK'][0]['values']['14']['value_option']['code'];
	}
	else return '';
    }
    
    public function getCoveredFrontHeight($options){
	if(isset($options['AK'][0]['values']['15']['value_option']['name'])){
	    return $options['AK'][0]['values']['15']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCoveredFrontHeightCode($options){
	if(isset($options['AK'][0]['values']['15']['value_option']['code'])){
	    return $options['AK'][0]['values']['15']['value_option']['code'];
	}
	else return '';
    }
    
    public function getCoveredBackType($options){
	if(isset($options['AL'][0]['values']['16']['value_option']['name'])){
	    return $options['AL'][0]['values']['16']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCoveredBackTypeCode($options){
	if(isset($options['AL'][0]['values']['16']['value_option']['code'])){
	    return $options['AL'][0]['values']['16']['value_option']['code'];
	}
	else return '';
    }
    
    public function getCoveredBackHeight($options){
	if(isset($options['AL'][0]['values']['17']['value_option']['name'])){
	    return $options['AL'][0]['values']['17']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCoveredBackHeightCode($options){
	if(isset($options['AL'][0]['values']['17']['value_option']['code'])){
	    return $options['AL'][0]['values']['17']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrameGauge($options){
	if(isset($options['AM'][0]['values']['18']['value_option']['name'])){
	    return $options['AM'][0]['values']['18']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameGaugeCode($options){
	if(isset($options['AM'][0]['values']['18']['value_option']['code'])){
	    return $options['AM'][0]['values']['18']['value_option']['code'];
	}
	else return '';
    }
    
    public function getSheetMetalGauge($options){
	if(isset($options['CQ'][0]['values']['100']['value_option']['name'])){
	    return $options['CQ'][0]['values']['100']['value_option']['name'];
	}
	else return '';
    }
    
    public function getSheetMetalGaugeCode($options){
	if(isset($options['CQ'][0]['values']['100']['value_option']['code'])){
	    return $options['CQ'][0]['values']['100']['value_option']['code'];
	}
	else return '';
    }
    
    public function isCertified($options){
	if($this->getCertifiedCode($options) == "Y")
	{
	    return true;
	}
	else return false;
    }
    
    public function getCertifiedCode($options){
	if(isset($options['AN'][0]['values']['19']['value_option']['code'])){
	    return $options['AN'][0]['values']['19']['value_option']['code'];
	}
	else return '';
    }
    
    public function getLeftOrientation($options){
	if(isset($options['AO'][0]['values']['20']['value_option']['name'])){
	    return $options['AO'][0]['values']['20']['value_option']['name'];
	}
	else return '';
    }
    
    public function getLeftOrientationCode($options){
	if(isset($options['AM'][0]['values']['20']['value_option']['code'])){
	    return $options['AM'][0]['values']['20']['value_option']['code'];
	}
	else return '';
    }
    
    public function getRightOrientation($options){
	if(isset($options['AP'][0]['values']['21']['value_option']['name'])){
	    return $options['AP'][0]['values']['21']['value_option']['name'];
	}
	else return '';
    }
    
    public function getRightOrientationCode($options){
	if(isset($options['AP'][0]['values']['21']['value_option']['code'])){
	    return $options['AP'][0]['values']['21']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrontOrientation($options){
	if(isset($options['AQ'][0]['values']['22']['value_option']['name'])){
	    return $options['AQ'][0]['values']['22']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrontOrientationCode($options){
	if(isset($options['AQ'][0]['values']['22']['value_option']['code'])){
	    return $options['AQ'][0]['values']['22']['value_option']['code'];
	}
	else return '';
    }
    
    public function getBackOrientation($options){
	if(isset($options['AR'][0]['values']['23']['value_option']['name'])){
	    return $options['AR'][0]['values']['23']['value_option']['name'];
	}
	else return '';
    }
    
    public function getBackOrientationCode($options){
	if(isset($options['AR'][0]['values']['23']['value_option']['code'])){
	    return $options['AR'][0]['values']['23']['value_option']['code'];
	}
	else return '';
    }
    
    public function getRoofOrientation($options){
	if(isset($options['AS'][0]['values']['24']['value_option']['name'])){
	    return $options['AS'][0]['values']['24']['value_option']['name'];
	}
	else return '';
    }
    
    public function getRoofOrientationCode($options){
	if(isset($options['AS'][0]['values']['24']['value_option']['code'])){
	    return $options['AS'][0]['values']['24']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasAnchors($options){
	if($this->getAnchorsCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getAnchorsCode($options){
	if(isset($options['AT'][0]['values']['25']['value_option']['code'])){
	    return $options['AT'][0]['values']['25']['value_option']['code'];
	}
	else return '';
    }
    
    public function getAnchorsType($options){
	if(isset($options['AT'][0]['values']['26']['value_option']['name'])){
	    return $options['AT'][0]['values']['26']['value_option']['name'];
	}
	else return '';
    }
    
    public function getAnchorsTypeCode($options){
	if(isset($options['AT'][0]['values']['26']['value_option']['code'])){
	    return $options['AT'][0]['values']['26']['value_option']['code'];
	}
	else return '';
    }
    
    public function getAnchorsQuantity($options){
	if(isset($options['AT'][0]['values']['27']['value_option']['name'])){
	    return $options['AT'][0]['values']['27']['value_option']['name'];
	}
	else return '';
    }
    
    public function getAnchorsQuantityCode($options){
	if(isset($options['AT'][0]['values']['27']['value_option']['code'])){
	    return $options['AT'][0]['values']['27']['value_option']['code'];
	}
	else return '';
    }
    
    public function isSelfInstall($options){
	if($this->getSelfInstallCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getSelfInstallCode($options){
	if(isset($options['AU'][0]['values']['28']['value_option']['code'])){
	    return $options['AU'][0]['values']['28']['value_option']['code'];
	}
	else return '';
    }
    
    public function getDoorLocation($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['29']['value_option']['name'])){
	    return $options['AV'][$index]['values']['29']['value_option']['name'];
	}
	else return '';
    }
    
    public function getDoorLocationCode($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['29']['value_option']['code'])){
	    return $options['AV'][$index]['values']['29']['value_option']['code'];
	}
	else return '';
    }
    
    public function getDoorType($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['30']['value_option']['name'])){
	    return $options['AV'][$index]['values']['30']['value_option']['name'];
	}
	else return '';
    }
    
    public function getDoorTypeCode($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['30']['value_option']['code'])){
	    return $options['AV'][$index]['values']['30']['value_option']['code'];
	}
	else return '';
    }
    
    public function getDoorWidth($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['31']['value_option']['name'])){
	    return $options['AV'][$index]['values']['31']['value_option']['name'];
	}
	else return '';
    }
    
    public function getDoorWidthCode($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['31']['value_option']['code'])){
	    return $options['AV'][$index]['values']['31']['value_option']['code'];
	}
	else return '';
    }
    
    public function getDoorHeight($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['32']['value_option']['name'])){
	    return $options['AV'][$index]['values']['32']['value_option']['name'];
	}
	else return '';
    }
    
    public function getDoorHeightCode($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['32']['value_option']['code'])){
	    return $options['AV'][$index]['values']['32']['value_option']['code'];
	}
	else return '';
    }
    
    public function getDoorInchesFromLeft($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['33']['value_option']['name'])){
	    return $options['AV'][$index]['values']['33']['value_option']['name'];
	}
	else return '';
    }
    
    public function getDoorInchesFromLeftCode($options, $door_number){
	$index = $door_number-1;
	
	if(isset($options['AV'][$index]['values']['33']['value_option']['code'])){
	    return $options['AV'][$index]['values']['33']['value_option']['code'];
	}
	else return '';
    }
    
    public function getDoorsCount($options){
	if(isset($options['AV'])){
	    return count($options['AV']);
	}
	else return 0;
    }
    
    #--Window
    public function getWindowLocation($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['34']['value_option']['name'])){
	    return $options['AW'][$index]['values']['34']['value_option']['name'];
	}
	else return '';
    }
    
    public function getWindowLocationCode($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['34']['value_option']['code'])){
	    return $options['AW'][$index]['values']['34']['value_option']['code'];
	}
	else return '';
    }
    
    public function getWindowType($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['35']['value_option']['name'])){
	    return $options['AW'][$index]['values']['35']['value_option']['name'];
	}
	else return '';
    }
    
    public function getWindowTypeCode($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['35']['value_option']['code'])){
	    return $options['AW'][$index]['values']['35']['value_option']['code'];
	}
	else return '';
    }
    
    public function getWindowWidth($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['36']['value_option']['name'])){
	    return $options['AW'][$index]['values']['36']['value_option']['name'];
	}
	else return '';
    }
    
    public function getWindowWidthCode($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['36']['value_option']['code'])){
	    return $options['AW'][$index]['values']['36']['value_option']['code'];
	}
	else return '';
    }
    
    public function getWindowHeight($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['37']['value_option']['name'])){
	    return $options['AW'][$index]['values']['37']['value_option']['name'];
	}
	else return '';
    }
    
    public function getWindowHeightCode($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['37']['value_option']['code'])){
	    return $options['AW'][$index]['values']['37']['value_option']['code'];
	}
	else return '';
    }
    
    public function getWindowInchesFromLeft($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['38']['value_option']['name'])){
	    return $options['AW'][$index]['values']['38']['value_option']['name'];
	}
	else return '';
    }
    
    public function getWindowInchesFromLeftCode($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['38']['value_option']['code'])){
	    return $options['AW'][$index]['values']['38']['value_option']['code'];
	}
	else return '';
    }
    
    public function getWindowInchesFromBottom($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['39']['value_option']['name'])){
	    return $options['AW'][$index]['values']['39']['value_option']['name'];
	}
	else return '';
    }
    
    public function getWindowInchesFromBottomCode($options, $window_number){
	$index = $window_number-1;
	
	if(isset($options['AW'][$index]['values']['39']['value_option']['code'])){
	    return $options['AW'][$index]['values']['39']['value_option']['code'];
	}
	else return '';
    }
    
    public function getWindowsCount($options){
	if(isset($options['AW'])){
	    return count($options['AW']);
	}
	else return 0;
    }
    #--End Window
    
    public function getFrameOutLocation($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['40']['value_option']['name'])){
	    return $options['AX'][$index]['values']['40']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameOutLocationCode($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['40']['value_option']['code'])){
	    return $options['AX'][$index]['values']['40']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrameOutType($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['41']['value_option']['name'])){
	    return $options['AX'][$index]['values']['41']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameOutTypeCode($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['41']['value_option']['code'])){
	    return $options['AX'][$index]['values']['41']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrameOutWidth($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['42']['value_option']['name'])){
	    return $options['AX'][$index]['values']['42']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameOutWidthCode($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['42']['value_option']['code'])){
	    return $options['AX'][$index]['values']['42']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrameOutHeight($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['43']['value_option']['name'])){
	    return $options['AX'][$index]['values']['43']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameOutHeightCode($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['43']['value_option']['code'])){
	    return $options['AX'][$index]['values']['43']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrameOutInchesFromLeft($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['44']['value_option']['name'])){
	    return $options['AX'][$index]['values']['44']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameOutInchesFromLeftCode($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['44']['value_option']['code'])){
	    return $options['AX'][$index]['values']['44']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrameOutInchesFromBottom($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['45']['value_option']['name'])){
	    return $options['AX'][$index]['values']['45']['value_option']['name'];
	}
	else return '';
    }
    
    public function getFrameOutInchesFromBottomCode($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['AX'][$index]['values']['45']['value_option']['code'])){
	    return $options['AX'][$index]['values']['45']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFrameOutsCount($options){
	if(isset($options['AX'])){
	    return count($options['AX']);
	}
	else return 0;
    }
    
    public function hasTranslucentPanels($options) {
	if($this->getTranslucentPanelsCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getTranslucentPanelsCount($options){
	if(isset($options['BA'][0]['values']['48']['value_option']['name'])){
	    return $options['BA'][0]['values']['48']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getTranslucentPanelsCountCode($options){
	if(isset($options['BA'][0]['values']['48']['value_option']['code'])){
	    return $options['BA'][0]['values']['48']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasKneeBraces($options) {
	if($this->getKneeBracesCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getKneeBracesCount($options){
	if(isset($options['BB'][0]['values']['49']['value_option']['name'])){
	    return $options['BB'][0]['values']['49']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getKneeBracesCountCode($options){
	if(isset($options['BB'][0]['values']['49']['value_option']['code'])){
	    return $options['BB'][0]['values']['49']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasStormBraces($options) {
	if($this->getStormBracesCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getStormBracesCount($options){
	if(isset($options['BC'][0]['values']['50']['value_option']['name'])){
	    return $options['BC'][0]['values']['50']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getStormBracesCountCode($options){
	if(isset($options['BC'][0]['values']['50']['value_option']['code'])){
	    return $options['BC'][0]['values']['50']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasLockAndKeySets($options) {
	if($this->getLockAndKeySetsCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getLockAndKeySetsCount($options){
	if(isset($options['BD'][0]['values']['51']['value_option']['name'])){
	    return $options['BD'][0]['values']['51']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getLockAndKeySetsCountCode($options){
	if(isset($options['BD'][0]['values']['51']['value_option']['code'])){
	    return $options['BD'][0]['values']['51']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasLockChains($options) {
	if($this->getLockChainsCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getLockChainsCount($options){
	if(isset($options['BE'][0]['values']['52']['value_option']['name'])){
	    return $options['BE'][0]['values']['52']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getLockChainsCountCode($options){
	if(isset($options['BE'][0]['values']['52']['value_option']['code'])){
	    return $options['BE'][0]['values']['52']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasRoofVents($options) {
	if($this->getRoofVentsCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getRoofVentsCount($options){
	if(isset($options['BF'][0]['values']['53']['value_option']['name'])){
	    return $options['BF'][0]['values']['53']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getRoofVentsCountCode($options){
	if(isset($options['BF'][0]['values']['53']['value_option']['code'])){
	    return $options['BF'][0]['values']['53']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasGableJtrim($options){
	if($this->getGableJTrimCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getGableJTrim($options){
	if(isset($options['BG'][0]['values']['54']['value_option']['name'])){
	    return $options['BG'][0]['values']['54']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getGableJTrimCode($options){
	if(isset($options['BG'][0]['values']['54']['value_option']['code'])){
	    return $options['BG'][0]['values']['54']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasLoft($options){
	if($this->getLoftWidth($options)>0 || $this->getLoftDepth($options)>0){
	    return true;
	}
	else return false;
    }
    
    public function getLoftWidth($options){
	if(isset($options['BH'][0]['values']['55']['value_option']['name'])){
	    return $options['BH'][0]['values']['55']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getLoftWidthCode($options){
	if(isset($options['BH'][0]['values']['55']['value_option']['code'])){
	    return $options['BH'][0]['values']['55']['value_option']['code'];
	}
	else return '';
    }
    
    public function getLoftDepth($options){
	if(isset($options['BH'][0]['values']['56']['value_option']['name'])){
	    return $options['BH'][0]['values']['56']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getLoftDepthCode($options){
	if(isset($options['BH'][0]['values']['56']['value_option']['code'])){
	    return $options['BH'][0]['values']['56']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasPorch($options){
	if($this->getPorchWidth($options)>0 || $this->getPorchDepth($options)>0){
	    return true;
	}
	else return false;
    }
    
    public function getPorchLocation($options){
	if(isset($options['BJ'][0]['values']['58']['value_option']['name'])){
	    return $options['BJ'][0]['values']['58']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getPorchLocationCode($options){
	if(isset($options['BJ'][0]['values']['58']['value_option']['code'])){
	    return $options['BJ'][0]['values']['58']['value_option']['code'];
	}
	else return '';
    }
    
    public function getPorchType($options){
	if(isset($options['BJ'][0]['values']['59']['value_option']['name'])){
	    return $options['BJ'][0]['values']['59']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getPorchTypeCode($options){
	if(isset($options['BJ'][0]['values']['59']['value_option']['code'])){
	    return $options['BJ'][0]['values']['59']['value_option']['code'];
	}
	else return '';
    }
    
    public function getPorchWidth($options){
	if(isset($options['BJ'][0]['values']['60']['value_option']['name'])){
	    return $options['BJ'][0]['values']['60']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getPorchWidthCode($options){
	if(isset($options['BJ'][0]['values']['60']['value_option']['code'])){
	    return $options['BJ'][0]['values']['60']['value_option']['code'];
	}
	else return '';
    }
    
    public function getPorchDepth($options){
	if(isset($options['BJ'][0]['values']['61']['value_option']['name'])){
	    return $options['BJ'][0]['values']['61']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getPorchDepthCode($options){
	if(isset($options['BJ'][0]['values']['61']['value_option']['code'])){
	    return $options['BJ'][0]['values']['61']['value_option']['code'];
	}
	else return '';
    }
    
    public function isPorchRecessed($options){
	if($this->getPorchRecessedCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getPorchRecessed($options){
	if(isset($options['BJ'][0]['values']['62']['value_option']['name'])){
	    return $options['BJ'][0]['values']['62']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getPorchRecessedCode($options){
	if(isset($options['BJ'][0]['values']['62']['value_option']['code'])){
	    return $options['BJ'][0]['values']['62']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasPorchRailingWithSpindles($options){
	if($this->getPorchRailingWithSpindlesCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getPorchRailingWithSpindles($options){
	if(isset($options['BJ'][0]['values']['63']['value_option']['name'])){
	    return $options['BJ'][0]['values']['63']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getPorchRailingWithSpindlesCode($options){
	if(isset($options['BJ'][0]['values']['63']['value_option']['code'])){
	    return $options['BJ'][0]['values']['63']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasTreatedStudPlates($options){
	if($this->getTreatedStudPlatesCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getTreatedStudPlates($options){
	if(isset($options['BK'][0]['values']['64']['value_option']['name'])){
	    return $options['BK'][0]['values']['64']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getTreatedStudPlatesCode($options){
	if(isset($options['BK'][0]['values']['64']['value_option']['code'])){
	    return $options['BK'][0]['values']['64']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasWoodRamp($options){
	if($this->getWoodRampWidth($options)>0 || $this->getWoodRampDepth($options)>0){
	    return true;
	}
	else return false;
    }
    
    public function getWoodRampWidth($options){
	if(isset($options['BL'][0]['values']['65']['value_option']['name'])){
	    return $options['BL'][0]['values']['65']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getWoodRampWidthCode($options){
	if(isset($options['BL'][0]['values']['65']['value_option']['code'])){
	    return $options['BL'][0]['values']['65']['value_option']['code'];
	}
	else return '';
    }
    
    public function getWoodRampDepth($options){
	if(isset($options['BL'][0]['values']['66']['value_option']['name'])){
	    return $options['BL'][0]['values']['66']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getWoodRampDepthCode($options){
	if(isset($options['BL'][0]['values']['66']['value_option']['code'])){
	    return $options['BL'][0]['values']['66']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasPerimeterBlocking($options){
	if($this->getPerimeterBlockingCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getPerimeterBlocking($options){
	if(isset($options['BM'][0]['values']['67']['value_option']['name'])){
	    return $options['BM'][0]['values']['67']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getPerimeterBlockingCode($options){
	if(isset($options['BM'][0]['values']['67']['value_option']['code'])){
	    return $options['BM'][0]['values']['67']['value_option']['code'];
	}
	else return '';
    }
    
    public function getRaftersSize($options){
	if(isset($options['BN'][0]['values']['68']['value_option']['name'])){
	    return $options['BN'][0]['values']['68']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getRaftersSizeCode($options){
	if(isset($options['BN'][0]['values']['68']['value_option']['code'])){
	    return $options['BN'][0]['values']['68']['value_option']['code'];
	}
	else return '';
    }
    
    public function getRaftersCenters($options){
	if(isset($options['BN'][0]['values']['68']['value_option']['name'])){
	    return $options['BN'][0]['values']['68']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getRaftersCentersCode($options){
	if(isset($options['BN'][0]['values']['69']['value_option']['code'])){
	    return $options['BN'][0]['values']['69']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasTreatedFloorJoists($options){
	if($this->getFloorJoistsTreatedCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getFloorJoistsTreated($options){
	if(isset($options['BO'][0]['values']['70']['value_option']['name'])){
	    return $options['BO'][0]['values']['70']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getFloorJoistsTreatedCode($options){
	if(isset($options['BO'][0]['values']['70']['value_option']['code'])){
	    return $options['BO'][0]['values']['70']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFloorJoistsCenters($options){
	if(isset($options['BO'][0]['values']['71']['value_option']['name'])){
	    return $options['BO'][0]['values']['71']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getFloorJoistsCentersCode($options){
	if(isset($options['BO'][0]['values']['71']['value_option']['code'])){
	    return $options['BO'][0]['values']['71']['value_option']['code'];
	}
	else return '';
    }
    
    public function getFloorSheathingType($options){
	if(isset($options['BP'][0]['values']['72']['value_option']['name'])){
	    return $options['BP'][0]['values']['72']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getFloorSheathingTypeCode($options){
	if(isset($options['BP'][0]['values']['72']['value_option']['code'])){
	    return $options['BP'][0]['values']['72']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasShelves($options){
	if($this->getShelvesDepth($options)>0 || $this->getShelvesLength($options)>0){
	    return true;
	}
	else return false;
    }
    
    public function getShelvesDepth($options){
	if(isset($options['BQ'][0]['values']['73']['value_option']['name'])){
	    return $options['BQ'][0]['values']['73']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getShelvesDepthCode($options){
	if(isset($options['BQ'][0]['values']['73']['value_option']['code'])){
	    return $options['BQ'][0]['values']['73']['value_option']['code'];
	}
	else return '';
    }
    
    public function getShelvesLength($options){
	if(isset($options['BQ'][0]['values']['74']['value_option']['name'])){
	    return $options['BQ'][0]['values']['74']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getShelvesLengthCode($options){
	if(isset($options['BQ'][0]['values']['74']['value_option']['code'])){
	    return $options['BQ'][0]['values']['74']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasWorkBench($options){
	if($this->getWorkBenchWidth($options)>0){
	    return true;
	}
	else return false;
    }
    
    public function getWorkBenchWidth($options){
	if(isset($options['BR'][0]['values']['75']['value_option']['name'])){
	    return $options['BR'][0]['values']['75']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getWorkBenchWidthCode($options){
	if(isset($options['BR'][0]['values']['75']['value_option']['code'])){
	    return $options['BR'][0]['values']['75']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasAcCutOuts($options){
	if($this->getAcCutOutsCount($options)>0){
	    return true;
	}
	else return false;
    }
    
    public function getAcCutOutsCount($options){
	if(isset($options['BS'][0]['values']['76']['value_option']['name'])){
	    return $options['BS'][0]['values']['76']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getAcCutOutsCountCode($options){
	if(isset($options['BS'][0]['values']['76']['value_option']['code'])){
	    return $options['BS'][0]['values']['76']['value_option']['code'];
	}
	else return '';
    }
    
    public function isKit($options){
	if($this->getKitCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getKit($options){
	if(isset($options['BT'][0]['values']['77']['value_option']['name'])){
	    return $options['BT'][0]['values']['77']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getKitCode($options){
	if(isset($options['BT'][0]['values']['77']['value_option']['code'])){
	    return $options['BT'][0]['values']['77']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasOutlet110($options) {
	if($this->getOutlet110Count($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getOutlet110Count($options){
	if(isset($options['BU'][0]['values']['78']['value_option']['name'])){
	    return $options['BU'][0]['values']['78']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getOutlet110CountCode($options){
	if(isset($options['BU'][0]['values']['78']['value_option']['code'])){
	    return $options['BU'][0]['values']['78']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasOutletAC220($options) {
	if($this->getOutletAC220Count($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getOutletAC220Count($options){
	if(isset($options['BV'][0]['values']['79']['value_option']['name'])){
	    return $options['BV'][0]['values']['79']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getOutletAC220CountCode($options){
	if(isset($options['BV'][0]['values']['79']['value_option']['code'])){
	    return $options['BV'][0]['values']['79']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasOutlet110GfiInterior($options) {
	if($this->getOutlet110GfiInteriorCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getOutlet110GfiInteriorCount($options){
	if(isset($options['BW'][0]['values']['80']['value_option']['name'])){
	    return $options['BW'][0]['values']['80']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getOutlet110GfiInteriorCountCode($options){
	if(isset($options['BW'][0]['values']['80']['value_option']['code'])){
	    return $options['BW'][0]['values']['80']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasOutlet110GfiExterior($options) {
	if($this->getOutlet110GfiExteriorCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getOutlet110GfiExteriorCount($options){
	if(isset($options['BX'][0]['values']['81']['value_option']['name'])){
	    return $options['BX'][0]['values']['81']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getOutlet110GfiExteriorCountCode($options){
	if(isset($options['BX'][0]['values']['81']['value_option']['code'])){
	    return $options['BX'][0]['values']['81']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasBreakerBox100NoMain($options) {
	if($this->getBreakerBox100NoMainCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getBreakerBox100NoMainCount($options){
	if(isset($options['BY'][0]['values']['82']['value_option']['name'])){
	    return $options['BY'][0]['values']['82']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getBreakerBox100NoMainCountCode($options){
	if(isset($options['BY'][0]['values']['82']['value_option']['code'])){
	    return $options['BY'][0]['values']['82']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasBreakerBox125NoMain($options) {
	if($this->getBreakerBox125NoMainCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getBreakerBox125NoMainCount($options){
	if(isset($options['BZ'][0]['values']['83']['value_option']['name'])){
	    return $options['BZ'][0]['values']['83']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getBreakerBox125NoMainCountCode($options){
	if(isset($options['BZ'][0]['values']['83']['value_option']['code'])){
	    return $options['BZ'][0]['values']['83']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasLight4FtFluorDouble($options) {
	if($this->getLight4FtFluorDoubleCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getLight4FtFluorDoubleCount($options){
	if(isset($options['CA'][0]['values']['84']['value_option']['name'])){
	    return $options['CA'][0]['values']['84']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getLight4FtFluorDoubleCountCode($options){
	if(isset($options['CA'][0]['values']['84']['value_option']['code'])){
	    return $options['CA'][0]['values']['84']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasLight8FtFluorDouble($options) {
	if($this->getLight8FtFluorDoubleCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getLight8FtFluorDoubleCount($options){
	if(isset($options['CB'][0]['values']['85']['value_option']['name'])){
	    return $options['CB'][0]['values']['85']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getLight8FtFluorDoubleCountCode($options){
	if(isset($options['CB'][0]['values']['85']['value_option']['code'])){
	    return $options['CB'][0]['values']['85']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasPorchLight($options) {
	if($this->getPorchLightCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getPorchLightCount($options){
	if(isset($options['CC'][0]['values']['86']['value_option']['name'])){
	    return $options['CC'][0]['values']['86']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getPorchLightCountCode($options){
	if(isset($options['CC'][0]['values']['86']['value_option']['code'])){
	    return $options['CC'][0]['values']['86']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasIncandescentLight($options) {
	if($this->getIncandescentLightCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getIncandescentLightCount($options){
	if(isset($options['CD'][0]['values']['87']['value_option']['name'])){
	    return $options['CD'][0]['values']['87']['value_option']['name'];
	}
	else return 0;
    }
    
    public function getIncandescentLightCountCode($options){
	if(isset($options['CD'][0]['values']['87']['value_option']['code'])){
	    return $options['CD'][0]['values']['87']['value_option']['code'];
	}
	else return '';
    }
    
    public function getInsulationR10Location($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['CE'][$index]['values']['88']['value_option']['name'])){
	    return $options['CE'][$index]['values']['88']['value_option']['name'];
	}
	else return '';
    }
    
    public function getInsulationR10LocationCode($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['CE'][$index]['values']['88']['value_option']['code'])){
	    return $options['CE'][$index]['values']['88']['value_option']['code'];
	}
	else return '';
    }
    
    public function getInsulationR7RadiantBarrierLocation($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['CF'][$index]['values']['89']['value_option']['name'])){
	    return $options['CF'][$index]['values']['89']['value_option']['name'];
	}
	else return '';
    }
    
    public function getInsulationR7RadiantBarrierLocationCode($options, $frameout_number){
	$index = $frameout_number-1;
	
	if(isset($options['CF'][$index]['values']['89']['value_option']['code'])){
	    return $options['CF'][$index]['values']['89']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasSkirtingWithMetal($options){
	if($this->getSkirtingWithMetalCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getSkirtingWithMetal($options){
	if(isset($options['CG'][0]['values']['90']['value_option']['name'])){
	    return $options['CG'][0]['values']['90']['value_option']['name'];
	}
	else return '';
    }
    
    public function getSkirtingWithMetalCode($options){
	if(isset($options['CG'][0]['values']['90']['value_option']['code'])){
	    return $options['CG'][0]['values']['90']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasTreatedCedarPlySiding($options){
	if($this->getTreatedCedarPlySidingCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getTreatedCedarPlySiding($options){
	if(isset($options['CH'][0]['values']['91']['value_option']['name'])){
	    return $options['CH'][0]['values']['91']['value_option']['name'];
	}
	else return '';
    }
    
    public function getTreatedCedarPlySidingCode($options){
	if(isset($options['CH'][0]['values']['91']['value_option']['code'])){
	    return $options['CH'][0]['values']['91']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasSmartSidingVerticalGroove($options){
	if($this->getSmartSidingVerticalGrooveCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getSmartSidingVerticalGroove($options){
	if(isset($options['CI'][0]['values']['92']['value_option']['name'])){
	    return $options['CI'][0]['values']['92']['value_option']['name'];
	}
	else return '';
    }
    
    public function getSmartSidingVerticalGrooveCode($options){
	if(isset($options['CI'][0]['values']['92']['value_option']['code'])){
	    return $options['CI'][0]['values']['92']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasHorizontalLapSiding($options){
	if($this->getHorizontalLapSidingCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getHorizontalLapSiding($options){
	if(isset($options['CJ'][0]['values']['93']['value_option']['name'])){
	    return $options['CJ'][0]['values']['93']['value_option']['name'];
	}
	else return '';
    }
    
    public function getHorizontalLapSidingCode($options){
	if(isset($options['CJ'][0]['values']['93']['value_option']['code'])){
	    return $options['CJ'][0]['values']['93']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasCompositionRoof($options){
	if($this->getHorizontalLapSidingCode($options) == "Y"){
	    return true;
	}
	else return false;
    }
    
    public function getCompositionRoof($options){
	if(isset($options['CK'][0]['values']['94']['value_option']['name'])){
	    return $options['CK'][0]['values']['94']['value_option']['name'];
	}
	else return '';
    }
    
    public function getCompositionRoofCode($options){
	if(isset($options['CK'][0]['values']['94']['value_option']['code'])){
	    return $options['CK'][0]['values']['94']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasSkirtVents($options) {
	if($this->getSkirtVentCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getSkirtVentCount($options){
	if(isset($options['CL'][0]['values']['95']['value_option']['name'])){
	    return $options['CL'][0]['values']['95']['value_option']['name'];
	}
	else return '';
    }
    
    public function getSkirtVentCountCode($options){
	if(isset($options['CL'][0]['values']['95']['value_option']['code'])){
	    return $options['CL'][0]['values']['95']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasPaintStain($options) {
	if(strlen($this->getPaintStainTypeCode($options))>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getPaintStainType($options){
	if(isset($options['CM'][0]['values']['96']['value_option']['name'])){
	    return $options['CM'][0]['values']['96']['value_option']['name'];
	}
	else return '';
    }
    
    public function getPaintStainTypeCode($options){
	if(isset($options['CM'][0]['values']['96']['value_option']['code'])){
	    return $options['CM'][0]['values']['96']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasRoofOverhang($options) {
	if($this->getRoofOverhangLength($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getRoofOverhangLength($options){
	if(isset($options['CN'][0]['values']['97']['value_option']['name'])){
	    return $options['CN'][0]['values']['97']['value_option']['name'];
	}
	else return '';
    }
    
    public function getRoofOverhangLengthCode($options){
	if(isset($options['CN'][0]['values']['97']['value_option']['code'])){
	    return $options['CN'][0]['values']['97']['value_option']['code'];
	}
	else return '';
    }
    
    public function hasShutterPairs($options) {
	if($this->getShutterPairsCount($options)>0){
	    return true;
	}
	else{
	    return false;
	}
    }
    
    public function getShutterPairsCount($options){
	if(isset($options['CO'][0]['values']['98']['value_option']['name'])){
	    return $options['CO'][0]['values']['98']['value_option']['name'];
	}
	else return '';
    }
    
    public function getShutterPairsCountCode($options){
	if(isset($options['CO'][0]['values']['98']['value_option']['code'])){
	    return $options['CO'][0]['values']['98']['value_option']['code'];
	}
	else return '';
    }
}
?>