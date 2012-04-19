<?php
/**
 * 
 * @author jessie
 *
 */

class BuilderController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    /**
     * @var Zend_Session_Namespace $_session_builder
     */
    private $_session_builder;
    
    /**
     * @var \Services\Codebuilder\Codebuilder $_codebuilder
     */
    private $_codebuilder;
    
    /**
     * @var \Services\Codebuilder\BuilderArrayMapper $_mapper
     */
    private $_mapper;
    
    /**
     * @var Zend_Controller_Action_Helper_FlashMessenger $_flashMessenger
     */
    private $_flashMessenger;
    
    private $_hints = array();
    
    private $_postAction = true;
    
    private $_price_message = "";
    
    private $_local_messages = array();
    
    public function init(){
	header("Cache-Control: no-cache, must-revalidate");
	$this->_request		= $this->getRequest();
	$this->_params		= $this->_request->getParams();
	$this->_codebuilder	= new \Services\Codebuilder\Codebuilder();
	$this->_mapper		= $this->_codebuilder->getBuilderArrayMapper();
	$this->_session_builder	= new Zend_Session_Namespace('builder');
	$this->_flashMessenger	= $this->_helper->getHelper('FlashMessenger');
	
	$this->_initializeSessionBuilder();
	
	$this->view->headLink()->appendStylesheet('/css/builder.css');
	$this->view->headScript()->appendFile("/javascript/jquery.maphilight.js");
	$this->view->headScript()->appendFile("/javascript/builder/builder.js");
    }
    
    public function postDispatch() {
	parent::postDispatch();
	if($this->_postAction)
	{
	    $this->setHints();
	    $this->view->hints = json_encode($this->_hints);
	    $this->_updateAndValidateBuilderSessionCodeAndPrice();

	    $this->view->price		= $this->_session_builder->builder["price"];
	    $this->view->code		= $this->_session_builder->builder["code"];
	    $this->view->details	= $this->codeToHtml();
	    $this->view->price_details	= $this->_price_message;
	    $this->view->local_messages = $this->_local_messages;
	}
    }
    
    public function indexAction()
    {	
	$this->_helper->layout->setLayout("basic");
	$session		= new Zend_Session_Namespace('Dataservice');
	$session->redirect	= $_SERVER['REQUEST_URI'];
	$this->view->headScript()->appendFile("/javascript/jquery-ui.min.js");
	$css = isset($this->_params["color"]) ? $this->_params["color"] : "";
	switch ($css) {
	    case "green":
		$this->view->headLink()->appendStylesheet('/css/jquery-ui/south-street/jquery-ui.custom.css');
		$this->view->headLink()->appendStylesheet('/css/builder-green.css');
		break;
	    default:
		$this->view->headLink()->appendStylesheet('/css/jquery-ui/redmond/jquery-ui.custom.css');
		break;
	}
    }
    
    public function locationAction() 
    {	
        $this->_helper->layout->disableLayout();
	$this->_setLocation();
	$this->view->selected	= $this->_session_builder->builder["location"];
    }
    
    public function typeAction()
    {	
        $this->_helper->layout->disableLayout();

	$this->_setValueArrayValueFromSetParam("StructureType");
	
	$this->view->form	= $this->getFormType();
	$this->view->selected	= $this->_mapper->getStructureTypeCode($this->_session_builder->builder["values"]);
    }
    
    public function modelAction()
    {	
        $this->_helper->layout->disableLayout();

	$this->_setValueArrayValueFromSetParam("Model");
	
	$this->view->form	= $this->getFormModel();
	$this->view->selected	= $this->_mapper->getModel($this->_session_builder->builder["values"]);
    }
    
    public function sizeAction()
    {	
        $this->_helper->layout->disableLayout();
	
	if($this->_request->isPost())
	{
	    if(
		isset($this->_params["leg_height"]) 
		&& $this->_params["leg_height"] 
		    != $this->_mapper->getLegHeightCode($this->_session_builder->builder["values"])
	    ){
		$tallest_door_height	= $this->_getTallestDoorHeight() + 12;
		$new_leg_height_inches	= $this->_params["leg_height"] * 12;
		$ok_to_change		= true;
		
		if($tallest_door_height > $new_leg_height_inches)
		{
		    $ok_to_change = false;
		    $this->_addErrorLocalMessage("Cannot reduce leg height to ".$this->_params["leg_height"]."' because of doors");
		}
		if($ok_to_change)
		{
		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setLegHeight(str_pad($this->_params["leg_height"], 2, 0, STR_PAD_LEFT), $this->_session_builder->builder["values"]);
		    $this->_addSuccessFlashMessage("Changed leg height.");
		}
	    }
	    
	    if(
		isset($this->_params["builder_size"]) 
		&& $this->_params["builder_size"] 
		    != $this->_mapper->getSize($this->_session_builder->builder["values"])
	    ){
		$total_widths_array = $this->_getDoorWindowTotalWidthsArray();
		$total_width	    = $total_widths_array["F"] + 30;
		$total_length	    = $total_widths_array["L"] + 30;
		$new_width	    = $this->_getWidthFromSize($this->_params["builder_size"]);
		$new_width_inches   = $new_width * 12;
		$new_length	    = $this->_getLengthFromSize($this->_params["builder_size"]);
		$new_length_inches  = $new_length * 12;
		$ok_to_change	    = true;
		
		if($new_width_inches < ($total_widths_array["F"] + 30) || $new_width_inches < ($total_widths_array["B"] + 30)){
		    $this->_addErrorLocalMessage("Cannot reduce width to ".$new_width." because of doors and/or windows");
		    $ok_to_change = false;
		}
		if($new_length_inches < ($total_widths_array["L"]+30) || $new_length_inches < ($total_widths_array["R"]+30)){
		    $this->_addErrorLocalMessage("Cannot reduce length to ".$new_length." because of doors and/or windows");
		    $ok_to_change = false;
		}
		
		if($ok_to_change){
		    $size = $this->_sizeToCode($this->_params["builder_size"], 2);

		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setSize($size, $this->_session_builder->builder["values"]);
		    $this->_addSuccessFlashMessage("Changed size.");
		}
	    }
	}
	
	$this->view->form	= $this->getFormSize();
	$this->view->selected	= $this->_mapper->getSize($this->_session_builder->builder["values"]);
    }
    
    public function wallsAction()
    {	
        $this->_helper->layout->disableLayout();
	
	if($this->_request->isPost())
	{
	    foreach (array("left", "right", "front", "back") as $side) 
	    {
		$this->_setCoveredWalls(
			$side, 
			isset($this->_params["builder_walls_orientation_".$side]) ? $this->_params["builder_walls_orientation_".$side] : "", 
			isset($this->_params["builder_walls_type_".$side]) ? $this->_params["builder_walls_type_".$side] : "", 
			isset($this->_params["builder_walls_height_".$side]) ? $this->_params["builder_walls_height_".$side] : ""
			);
	    }
	}
	
	$this->view->form	= $this->getFormWalls();
	$this->view->selected	= $this->_mapper->getSize($this->_session_builder->builder["values"]);
    }
    
    public function colorsAction()
    {	
        $this->_helper->layout->disableLayout();
	
	if(isset($this->_params["side"]) && isset($this->_params["set"]))
	{
	    $this->_setValueArrayValueFromSetParam(ucfirst(strtolower($this->_params["side"]))."Color");
	}
	
	$roof_code  = $this->_mapper->getRoofColorCode($this->_session_builder->builder["values"]);
	$trim_code  = $this->_mapper->getTrimColorCode($this->_session_builder->builder["values"]);
	$sides_code = $this->_mapper->getSidesColorCode($this->_session_builder->builder["values"]);
	$ends_code  = $this->_mapper->getEndsColorCode($this->_session_builder->builder["values"]);
	
	if(!$roof_code){
	    $this->_session_builder->builder["values"] = 
		    $this->_mapper->setRoofColor("TN", $this->_session_builder->builder["values"]);
	    $roof_code  = $this->_mapper->getRoofColorCode($this->_session_builder->builder["values"]);
	}
	if(!$trim_code){
	    $this->_session_builder->builder["values"] = 
		    $this->_mapper->setTrimColor("WH", $this->_session_builder->builder["values"]);
	    $trim_code  = $this->_mapper->getTrimColorCode($this->_session_builder->builder["values"]);
	}
	if(!$sides_code){
	    $this->_session_builder->builder["values"] = 
		    $this->_mapper->setSidesColor("TN", $this->_session_builder->builder["values"]);
	    $sides_code = $this->_mapper->getSidesColorCode($this->_session_builder->builder["values"]);
	}
	if(!$ends_code){
	    $this->_session_builder->builder["values"] = 
		    $this->_mapper->setEndsColor("TN", $this->_session_builder->builder["values"]);
	    $ends_code  = $this->_mapper->getEndsColorCode($this->_session_builder->builder["values"]);
	}
	
	$this->view->selected_array = array(
	    "roof"  => array(
			    "code"	=> $roof_code,
			    "details"	=> $this->_codebuilder->getValueOptionDetailsFromCode("color_roof", "color", $roof_code)
			),
	    "trim"  => array(
			    "code"	=> $trim_code,
			    "details"	=> $this->_codebuilder->getValueOptionDetailsFromCode("color_trim", "color", $trim_code)
			),
	    "ends"  => array(
			    "code"	=> $ends_code,
			    "details"	=> $this->_codebuilder->getValueOptionDetailsFromCode("color_ends", "color", $ends_code)
			),
	    "sides" => array(
			    "code"	=> $sides_code,
			    "details"	=> $this->_codebuilder->getValueOptionDetailsFromCode("color_sides", "color", $sides_code)
			)
	);
    }
    
    public function doorsAction()
    {	
        $this->_helper->layout->disableLayout();
	
	if($this->_request->isPost())
	{
	    if(isset($this->_params["delete"])){
		$this->_session_builder->builder["values"] = 
			$this->_mapper->removeDoor(
				$this->_params["delete"],
				$this->_session_builder->builder["values"]
				);
		$this->_addSuccessFlashMessage("Removed Door.");
	    }
	    if(
		isset($this->_params["type"])
		&& isset($this->_params["size"])
		&& isset($this->_params["location"])
	    ){
		if($this->_params["type"] == "RU"){		    
		    $size = $this->_sizeToInches($this->_params["size"]);
		}
		else $size = $this->_params["size"];
		
		$size = $this->_sizeToCode($size, 3);
		
		$this->_addDoor($size, $this->_params["location"], $this->_params["type"]);
	    }
	}
	
	$this->view->doors = $this->_getCurrentDoorsAsArray();
    }
    
    public function windowsAction()
    {	
        $this->_helper->layout->disableLayout();
	
	if($this->_request->isPost())
	{
	    if(isset($this->_params["delete"])){
		$this->_session_builder->builder["values"] = 
			$this->_mapper->removeWindow(
				$this->_params["delete"],
				$this->_session_builder->builder["values"]
				);
		$this->_addSuccessFlashMessage("Removed Window.");
	    }
	    if(
		isset($this->_params["type"])
		&& isset($this->_params["size"])
		&& isset($this->_params["location"])
	    ){
		$this->_addWindow($this->_params["size"], $this->_params["location"], $this->_params["type"]);
	    }
	}
	
	$this->view->windows = $this->_getCurrentWindowsAsArray();
    }
    
    public function optionsAction(){
	$this->_helper->layout->disableLayout();
    }
    
    public function messengerAction(){
	$this->_helper->layout->disableLayout();
    }
    
    public function clearAction(){
	$this->_helper->layout->disableLayout();
	$this->_session_builder->builder = array();
	$this->_initializeSessionBuilder();
	$this->_addSuccessFlashMessage("Builder Reset");
    }
    
    private function _updateAndValidateBuilderSessionCodeAndPrice()
    {
	try {
	    $this->_session_builder->builder["code"] = 
		    $this->_codebuilder->getCodeFromBuilderArray($this->_session_builder->builder["values"]);
	    if(
		$this->_mapper->getStructureTypeCode($this->_session_builder->builder["values"])
		&& $this->_mapper->getModel($this->_session_builder->builder["values"])
		&& $this->_mapper->getSize($this->_session_builder->builder["values"])
		&& $this->_mapper->getLegHeightCode($this->_session_builder->builder["values"])
	    )
	    {
		$this->_codebuilder->validateBuilderValuesArray(
			$this->_mapper, $this->_session_builder->builder["values"], 
			$this->_session_builder->builder["location"]
			);
		$price_array = $this->_codebuilder->getPriceFromBuilderValuesArray(
				$this->_session_builder->builder["values"], 
				$this->_session_builder->builder["location"]
			);
		$this->_session_builder->builder["price"]   = $price_array["price"];
		$this->_price_message			    = $this->_priceDetailsToHtml($price_array["details"]);
	    }
	    else
	    {
		$this->_session_builder->builder["price"] = 0;
		$this->_hints[] = "Cannot price";
	    }
	} catch (Exception $exc) {
	    $this->_addErrorFlashMessage($exc->getMessage());
	}
    }
    
    private function _setLocation(){
	if(isset($this->_params['set'])){
	    $this->_session_builder->builder["location"] = $this->_params['set'];
	    $this->_addSuccessFlashMessage("Changed location");
	}
    }
    
    private function _setValueArrayValue($mapper_method, $value = ""){
	if(strlen($value)>0 && method_exists($this->_mapper, "set".$mapper_method)){
	    $mapper_method_name = "set".$mapper_method;
	    $this->_session_builder->builder["values"] = $this->_mapper->$mapper_method_name($value, $this->_session_builder->builder["values"]);
	    $this->_addSuccessFlashMessage("Changed ".$mapper_method);
	}
    }
    
    private function _setValueArrayValueFromSetParam($mapper_method){
	if(isset($this->_params['set'])){
	    $this->_setValueArrayValue($mapper_method, $this->_params["set"]);
	    return true;
	}
	else return false;
    }
    
    private function _addSuccessFlashMessage($message)
    {
	$this->_flashMessenger->addMessage(
		array(
		    "message" => $message, 
		    "status" => "success", 
		    "type" => "flash"
		    )
		);	
    }
    
    private function _addSuccessLocalMessage($message)
    {
	$this->_local_messages[] = "<div class='messenger_success'>$message</div>";
    }
    
    private function _addErrorFlashMessage($message)
    {
	$this->_flashMessenger->addMessage(
		array(
		    "message" => $message, 
		    "status" => "error", 
		    "type" => "flash"
		    )
		);	
    }
    
    private function _addErrorLocalMessage($message)
    {
	$this->_local_messages[] = "<div class='messenger_error'>$message</div>";
    }
    
    private function _initializeSessionBuilder()
    {
	if(!is_array($this->_session_builder->builder)){
	    $this->_session_builder->builder = array();
	}
	
	if(!isset($this->_session_builder->builder["values"]) || !is_array($this->_session_builder->builder["values"])){
	    $this->_session_builder->builder["values"] = array();
	}
	
	if(!isset($this->_session_builder->builder["code"])){
	    $this->_session_builder->builder["code"] = "";
	}
	if(!isset($this->_session_builder->builder["price"])){
	    $this->_session_builder->builder["price"] = 0;
	}
	
	if(!isset($this->_session_builder->builder["location"])){
	    $this->_session_builder->builder["location"] = "nt";
	}
    }
    
    public function setHints()
    {	
	if(strtolower($this->getRequest()->getActionName()) == "clear")
	{
	    return;
	}
	if(!$this->_session_builder->builder["location"]){
	    $this->_hints[] = "Choose a Location &raquo;";
	    return;
	}
	if(!$this->_mapper->getStructureTypeCode($this->_session_builder->builder["values"]))
	{
	    $this->_hints[] = "Choose a Building Type &raquo;";
	    return;
	}
	if(!$this->_mapper->getModel($this->_session_builder->builder["values"]))
	{
	    $this->_hints[] = "Choose a Model &raquo;";
	    return;
	}
	if(!$this->_mapper->getSize($this->_session_builder->builder["values"]))
	{
	    $this->_hints[] = "Choose a Size &raquo;";
	    return;
	}
	if(!$this->_mapper->getLegHeightCode($this->_session_builder->builder["values"]))
	{
	    $this->_hints[] = "Choose a Leg Height &raquo;";
	    return;
	}
	$this->_hints[] = "Customize your building with walls, doors, windows, colors, etc.  &raquo;";
    }
    
    public function getFormModel()
    {
	$model_options = $this->_codebuilder->getFormOptions()->getModelOptions(
				$this->_session_builder->builder["location"], 
				$this->_mapper->getStructureTypeCode($this->_session_builder->builder["values"]),
				$this->_mapper->getModelIndex($this->_session_builder->builder["values"])
			    );
	
	$form = new Form_Builder_Model(
			    null,
			    $model_options, 
			    $this->_mapper->getModel($this->_session_builder->builder["values"])
			);
	return $form;
    }
    
    public function getFormType()
    {	
	$structure_type_options = $this->_codebuilder->getFormOptions()->getStructureTypeOptions($this->_session_builder->builder["location"]);
	
	$form = new Form_Builder_Type(
		null,
		$structure_type_options, 
		$this->_mapper->getStructureTypeCode($this->_session_builder->builder["values"])
		);
	return $form;
    }
    
    public function getFormSize()
    {	
	$size_options["size"] = $this->_codebuilder->getFormOptions()->getSizeOptions(
					$this->_mapper->getStructureTypeCode($this->_session_builder->builder["values"]),
					$this->_mapper->getModel($this->_session_builder->builder["values"])
				    );
	$size_options["leg_height"] = $this->_codebuilder->getFormOptions()->getLegHeightOptions(
					$this->_mapper->getStructureTypeCode($this->_session_builder->builder["values"]),
					$this->_mapper->getModel($this->_session_builder->builder["values"])
				    );
	
	$size_selected["size"]	     = $this->_mapper->getSize($this->_session_builder->builder["values"]);
	$size_selected["leg_height"] = $this->_mapper->getLegHeightCode($this->_session_builder->builder["values"]);
	
	$form = new Form_Builder_Size(
		null,
		$size_options, 
		$size_selected
		);
	return $form;
    }
	    
    public function getFormWalls()
    {	
	$walls_options_array = $this->_codebuilder->getFormOptions()->getWallsOptions(
					$this->_mapper->getStructureTypeCode($this->_session_builder->builder["values"])
				    );
	$walls_selected_array = array();
	
	foreach (array("Left", "Right", "Front", "Back") as $side) {
	    $type	    = $this->_mapper->getCoveredWallsTypeCodeFromSideString($side, $this->_session_builder->builder["values"]);
	    //$type	    = !$type ? "NO" : $type;
	    $height	    = call_user_func( array($this->_mapper,'getCovered'.$side.'HeightCode'), $this->_session_builder->builder["values"]);
	    //$height	    = !$height ? "1" : $height;
	    $orientation    = call_user_func( array($this->_mapper,'get'.$side.'OrientationCode'), $this->_session_builder->builder["values"]);
	    //$orientation    = !$orientation ? "H" : $orientation;
	    
	    $walls_selected_array[strtolower($side)]["type"] = $type;
	    $walls_selected_array[strtolower($side)]["height"] = $height;
	    $walls_selected_array[strtolower($side)]["orientation"] = $orientation;
	}
	
	$form = new Form_Builder_Walls(null, $walls_options_array, $walls_selected_array);
	return $form;
    }
    
    public function codeToHtml(){	
	$code = $this->_session_builder->builder["code"];
		
	$parser = \Services\Codebuilder\Factory::factoryParser();
	$errors	= array();
	$return = "";
	
	try {
	    $options	= $parser->parseToArray($code, true);
	} catch (Exception $exc) {
	    $errors[] = $exc->getMessage();
	}
	
	if(!$errors){
	    //$return .= print_r($options,true);
	    foreach($options as $option_code => $option_array)
	    {
		foreach($option_array as $option)
		{
		    $return .= "<h4 style='margin:2px;padding:2px;font-size:13px;'>".$option['details']['name']."</h4>";
		    $return .= "<ol style='margin:2px;padding:2px;font-size:11px;'>";
		    foreach ($option['values'] as $value) {
			$return .= "<li>".$value['details']['name'].": ".$value['optionvalue']['name']."</li>";
		    }
		    $return .= "</ol>";
		}
	    }
	}
	$return .= "</div><div style='clear:both'></div>";
	return $return;
    }
    
    private function _priceDetailsToHtml($details_array = array())
    {
	$return = "";
	$return .= "<h4 style='margin:2px;padding:2px;font-size:13px;'>Price Details</h4>";
	$return .= "<ol style='margin:2px;padding:2px;font-size:11px;'>";
	foreach ($details_array as $details) {
	    $return .= "<li>".$details['name'].": $".number_format($details['price'],2)." - ".$details['note']."</li>";
	}
	$return .= "</ol>";
	$return .= "</div><div style='clear:both'></div>";
	return $return;
    }
    
    private function _getCurrentDoorsAsArray(){
	$doors_array = array();
	$doors_count = $this->_mapper->getDoorsCount($this->_session_builder->builder["values"]);
	
	if($doors_count>0){
	    for($i=0;$i<$doors_count;$i++)
	    {
		$type_array	= $this->_codebuilder->getValueOptionDetailsFromCode(
					"door", 
					"type", 
					$this->_mapper->getDoorTypeCode($this->_session_builder->builder["values"], $i)
				    );
		$door_size	= $this->_mapper->getDoorSize($this->_session_builder->builder["values"], $i);
		$location	= $this->_codebuilder->getValueOptionDetailsFromCode(
					"door", 
					"location", 
					$this->_mapper->getDoorLocationCode($this->_session_builder->builder["values"], $i)
				    );
		
		$doors_array[$i] = array(
		    "display_num"   => $i+1,
		    "type"	    => $type_array["name"],
		    "size"	    => $door_size,
		    "location"	    => $location["name"]
		);
	    }
	}
	
	return $doors_array;
    }
    
    private function _getCurrentWindowsAsArray(){
	$windows_array = array();
	$windows_count = $this->_mapper->getWindowsCount($this->_session_builder->builder["values"]);
	
	if($windows_count>0)
	{
	    for($i=0;$i<$windows_count;$i++)
	    {
		$type_array	= $this->_codebuilder->getValueOptionDetailsFromCode(
					    "window", 
					    "type", 
					    $this->_mapper->getWindowTypeCode($this->_session_builder->builder["values"], $i)
					);
		$window_size	= $this->_mapper->getWindowSize($this->_session_builder->builder["values"], $i);
		$location	= $this->_codebuilder->getValueOptionDetailsFromCode(
					    "window", 
					    "location", 
					    $this->_mapper->getWindowLocationCode($this->_session_builder->builder["values"], $i)
					);
		
		$windows_array[$i] = array(
		    "display_num"   => $i+1,
		    "type"	    => $type_array["name"],
		    "size"	    => $window_size,
		    "location"	    => $location["name"]
		);
	    }
	}
	
	return $windows_array;
    }
    
    private function _getLocationLegend()
    {
	return array("L" => "Left", "R" => "Right", "F" => "Front", "B" => "Back");
    }
    
    private function _addWindow($size, $location, $type)
    {
	$location_legend	= $this->_getLocationLegend();
	$ok_to_add		= true;

	#--Make sure the walls are closed
	$this->_checkAndSetWallCoveredForDoorOrWindow("window", $location_legend[$location]);
	$ok_to_add = $this->_checkAndSetFrameWidthLengthForDoorOrWindow("window", $size, $location, $type);
	
	if($ok_to_add)
	{	    
	    $size = $this->_sizeToCode($size, 2);
	    $this->_session_builder->builder["values"] = 
		    $this->_mapper->addWindow(
			    $size, 
			    $location, 
			    $type,
			    "",
			    "",
			    $this->_session_builder->builder["values"]
			    );
	    $this->_addSuccessFlashMessage("Added Window.");
	}
    }
    
    private function _addDoor($size, $location, $type)
    {
	$location_legend	= $this->_getLocationLegend();
	$ok_to_add		= true;
	
	#--Make sure the walls are closed
	$this->_checkAndSetWallCoveredForDoorOrWindow("door", $location_legend[$location]);
	$this->_checkAndSetLegHeightForDoor($size);
	$ok_to_add = $this->_checkAndSetFrameWidthLengthForDoorOrWindow("door", $size, $location, $type);
	
	if($ok_to_add){
	    $this->_session_builder->builder["values"] = 
		$this->_mapper->addDoor(
			$size, 
			$location, 
			$type,
			"",
			$this->_session_builder->builder["values"]
			);
		    
	    $this->_addSuccessFlashMessage("Added Door.");
	}
    }
    
    private function _getDoorWindowTotalWidthsArray()
    {
	$doors_count		= $this->_mapper->getDoorsCount($this->_session_builder->builder["values"]);
	$windows_count		= $this->_mapper->getWindowsCount($this->_session_builder->builder["values"]);
	$widths_array		= array("L" => 0, "R" => 0, "F" => 0, "B" => 0);
	if($doors_count>0){
	    for($i=0;$i<$doors_count;$i++)
	    {
		$widths_array[$this->_mapper->getDoorLocationCode($this->_session_builder->builder["values"], $i)] 
			+= (int) $this->_mapper->getDoorWidthCode($this->_session_builder->builder["values"], $i);
	    }
	}
	
	if($windows_count>0){
	    for($i=0;$i<$windows_count;$i++)
	    {
		$widths_array[$this->_mapper->getWindowLocationCode($this->_session_builder->builder["values"], $i)] 
			+= (int) $this->_mapper->getWindowWidthCode($this->_session_builder->builder["values"], $i);
	    }
	}
	
	return $widths_array;
    }
    
    private function _getTallestDoorHeight(){
	$doors_count	= $this->_mapper->getDoorsCount($this->_session_builder->builder["values"]);
	$tallest_door	= 0;
	
	if($doors_count>0){
	    for($i=0;$i<$doors_count;$i++)
	    {
		$door_height = $this->_mapper->getDoorHeightCode($this->_session_builder->builder["values"], $i);
		if($door_height > $tallest_door)$tallest_door = $door_height;
	    }
	}
	
	return $tallest_door;
    }
    
    private function _checkAndSetLegHeightForDoor($size)
    {
	$leg_height		= $this->_mapper->getLegHeightCode($this->_session_builder->builder["values"]);
	$leg_height_inches	= $leg_height * 12;
	$new_leg_height_inches	= $leg_height_inches;
	$added_door_size_array	= explode("X", $size);
	$added_door_height	= $added_door_size_array[1];
	
	if(($added_door_height + 8) > $leg_height_inches)
	{
	    while($new_leg_height_inches < ($added_door_height+8)){
		$new_leg_height_inches += 12;
	    }
		
	    $new_leg_height = $new_leg_height_inches/12;
	    
	    if($new_leg_height != $leg_height){
		$this->_session_builder->builder["values"] = 
		    $this->_mapper->setLegHeight(
			    str_pad($new_leg_height, 2, 0, STR_PAD_LEFT), 
			    $this->_session_builder->builder["values"]
			    );
		$this->_addSuccessLocalMessage("Increased building leg height to accomodate a door.");
	    }
	}	
    }
    
    private function _checkAndSetWallCoveredForDoorOrWindow($door_or_window, $side_string)
    {	
	if($this->_mapper->getCoveredWallsTypeCodeFromSideString($side_string, $this->_session_builder->builder["values"]) != "CL"){
	    $this->_setCoveredWalls($side_string, "", "CL", "");
	    $this->_addSuccessLocalMessage("Updated the ".$side_string." side of the building to be covered to accomodate a ".$door_or_window.".");
	}
    }
    
    private function _checkAndSetFrameWidthLengthForDoorOrWindow($door_or_window, $size, $location, $type)
    {
	$location_legend	= $this->_getLocationLegend();
	$building_length_feet	= (int) $this->_mapper->getFrameLengthCode($this->_session_builder->builder["values"]);
	$building_length_inches	=  $building_length_feet * 12;
	$building_width_feet	= (int) $this->_mapper->getFrameWidthCode($this->_session_builder->builder["values"]);
	$building_width_inches	= $building_width_feet * 12;
	$added_door_size_array	= explode("X", $size);
	$added_door_width	= $added_door_size_array[0];
	$size_message		= $type == "RU" ? $this->_sizeToFeet($size) : $this->_sizeCodeToSize($size);
	$ok_to_add		= true;
	
	#--Get the total width in inches of all doors and windows for each side of the building
	$door_window_widths = $this->_getDoorWindowTotalWidthsArray();
	#--Add the new door width to the total of the appropriate side
	$door_window_widths[$location] += $added_door_width;
	#--Add an extra 30 inches for frame legs etc
	$total_width = (30 + $door_window_widths[$location]);
	#--Length (Sides)
	if(in_array($location, array("L", "R"))){
	    if($building_length_inches < $total_width){
		$new_length = $building_length_feet;
		$max_width  = false;
		
		while (($total_width/12) > $new_length && $max_width == false) 
		{
		    if($building_length_feet >= 41){
			$ok_to_add  = false;
			$max_width  = true;
		    }
		    else{
			$new_length += 5;
		    }
		}
		if(($new_length*12) > $building_length_inches)
		{
		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setFrameLength(
				$new_length, 
				$this->_session_builder->builder["values"]
				);
		    $this->_addSuccessLocalMessage("Increased building length to accomodate ".$door_or_window.".");
		}
		else{
		    $this->_addErrorLocalMessage(
			    "Maximum building length reached. You can not add any more ".$size_message.
			    " ".$door_or_window."s to the ".$location_legend[$location]." side;"
			    );
		    $ok_to_add = false;
		}
	    }
	}
	else #Width (Ends)
	{
	    if($building_width_inches < $total_width)
	    {
		$new_length = $building_width_feet;
		$max_width  = false;
		
		while (($total_width/12) > $new_length && $max_width == false) 
		{
		    switch ($new_length)
		    {
			case "12":
			    $new_length = 18;
			    break;
			case "18":
			    $new_length = 20;
			    break;
			case "20":
			    $new_length = 22;
			    break;
			case "22":
			    $new_length = 24;
			    break;
			default:
			    #--Cant make the building big enough to accomodate the door. Leave building at 
			    #-- current width and just don't add the door.
			    $new_length = $building_width_feet;
			    $max_width	= true;
			    break;
		    }
		}
		
		if(($new_length*12) > $building_width_inches)
		{
		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setFrameWidth(
				$new_length, 
				$this->_session_builder->builder["values"]
				);
		    $this->_addSuccessLocalMessage("Increased building width to accomodate ".$door_or_window.".");
		}
		else{
		    $this->_addErrorLocalMessage(
			    "Maximum building width reached. You can not add any more ".$size_message.
			    " ".$door_or_window."s to the ".$location_legend[$location]." side;"
			    );
		    $ok_to_add = false;
		}
	    }
	}
	
	return $ok_to_add;
    }
    
    private function _sizeToInches($size)
    {
	$size_array	= explode("X", $size);	    
	$size_array[0]	= $size_array[0]*12;
	$size_array[1]	= $size_array[1]*12;
	
	return implode("X", $size_array);
    }
    
    private function _sizeToFeet($size)
    {
	$size_array	= explode("X", $size);	    
	$size_array[0]	= round(($size_array[0]/12), 0, PHP_ROUND_HALF_UP);
	$size_array[1]	=  round(($size_array[1]/12), 0, PHP_ROUND_HALF_UP);
	
	return implode("X", $size_array);
    }
    
    private function _sizeToCode($size, $length)
    {
	$size_array	= explode("X", $size);
	$size_array[0]	= str_pad($size_array[0], $length, 0, STR_PAD_LEFT);
	$size_array[1]	= str_pad($size_array[1], $length, 0, STR_PAD_LEFT);
	$size		= implode("X", $size_array);
	
	return $size;
    }
    
    private function _sizeCodeToSize($size)
    {
	$size_array	= explode("X", $size);
	$size_array[0]	= number_format($size_array[0]);
	$size_array[1]	= number_format($size_array[1]);
	$size		= implode("X", $size_array);
	
	return $size;
    }
    
    private function _getWidthFromSize($size)
    {
	$size_array	= explode("X", $size);
	return number_format($size_array[0]);
    }
    
    private function _getLengthFromSize($size)
    {
	$size_array	= explode("X", $size);
	return number_format($size_array[1]);
    }
    
    private function _setCoveredWalls($side, $orientation, $type, $height)
    {
	$locations_legend	    = $this->_getLocationLegend();
	$door_window_widths_array   = $this->_getDoorWindowTotalWidthsArray();
	$covered_walls_type	    = $this->_mapper->getCoveredWallsTypeCodeFromSideString($side, $this->_session_builder->builder["values"]);
	$covered_walls_height	    = $this->_mapper->getCoveredWallsHeightCodeFromSideString($side, $this->_session_builder->builder["values"]);
	$covered_walls_orientation  = $this->_mapper->getOrientationCodeFromSideString($side, $this->_session_builder->builder["values"]);

	if($type != "CL" && $door_window_widths_array[array_search(ucfirst(strtolower($side)), $locations_legend)] > 0){
	    $this->_addErrorLocalMessage(
		    "Can not change the wall type from closed on the ".$side." side because of doors/windows"
		    );
	}
	else{
	    if($height != $covered_walls_height)
	    {
		$this->_session_builder->builder["values"] = 
		    $this->_mapper->setCoveredWallsHeightFromSideString(
				$height, 
				$side, 
				$this->_session_builder->builder["values"]
				);
		$this->_addSuccessFlashMessage("Changed ".$side." partial wall height.");
	    }

	    if($orientation != "null" && $orientation != $covered_walls_orientation)
	    {
		$this->_session_builder->builder["values"] = 
		    $this->_mapper->setOrientationFromSideString(
				$orientation, 
				$side, 
				$this->_session_builder->builder["values"]
				);
		$this->_addSuccessFlashMessage("Changed ".$side." wall siding orientation.");
	    }

	    if($type != $covered_walls_type)
	    {
		$this->_session_builder->builder["values"] = 
			$this->_mapper->setCoveredWallsTypeFromSideString(
				$type, 
				$side, 
				$this->_session_builder->builder["values"]
				);
		if(in_array($type, array("", "NO")))
		{#--If the wall is not covered then clear any orientation or height values for that side
		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setOrientationFromSideString("", $side, $this->_session_builder->builder["values"]);
		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setCoveredWallsHeightFromSideString("", $side, $this->_session_builder->builder["values"]);
		}
		else
		{ #--Wall is covered so set defaults
		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setOrientationFromSideString("H", $side, $this->_session_builder->builder["values"]);
		    if(in_array($type, array("PB", "PT"))){
			$this->_session_builder->builder["values"] = 
			    $this->_mapper->setCoveredWallsHeightFromSideString("1", $side, $this->_session_builder->builder["values"]);
		    }
		    else
		    {
			$this->_session_builder->builder["values"] = 
			    $this->_mapper->setCoveredWallsHeightFromSideString("", $side, $this->_session_builder->builder["values"]);
		    }
		}
		$this->_addSuccessFlashMessage("Changed ".$side." wall style.");
	    }
	}
    }
    
    public function renderAction()
    {
	$render_array = array();
	//Set the content type
	header('content-type: image/png');
	//Create our basic image stream 300x300 pixels
	$image = imagecreatetruecolor(450, 267);
	//Turn off alpha blending for background ?
	imagealphablending($image, false);
	$white = imagecolorallocate($image, 255, 255, 255);
	imagefilledrectangle($image,0,0,450, 267,$white);
	//Turn alpha blending back on
	imagealphablending($image,true);

	$render_array["color_key"] = array(
				"BR" => "barnred",
				"BL" => "black",
				"PG" => "pewtergrey",
				"SS" => "sandstone",
				"WH" => "white",
				"CL" => "clay",
				"BY" => "burgandy",
				"EG" => "evergreen",
				"QG" => "quaker",
				"TN" => "tan",
				"EB" => "earth",
				"SB" => "slate",
				"PB" => "pebble",
			);
	$render_array["roof_type"]  = "regular";//Temporary. Will get from builder array
	$render_array["model"]	    = "standard";//Temporary. Will get from builder array
	$render_array["size"]	    = "122105";
					str_replace("X", "", $this->_mapper->getSize($this->_session_builder->builder["values"])).
					$this->_mapper->getLegHeightCode($this->_session_builder->builder["values"]);
	$render_array["base_path"]  = $render_array["roof_type"]."/".$render_array["model"]."/".$render_array["size"]."/".$render_array["roof_type"]."-".$render_array["model"]."-".$render_array["size"];
	
	$this->_renderRoofBack($image, $render_array);
	$this->_renderWallBack($image, $render_array);
	$this->_renderWallLeft($image, $render_array);
	$this->_renderFrame($image, $render_array);
	$this->_renderWallRight($image, $render_array);
	$this->_renderWallFront($image, $render_array);
	$this->_renderRoofFront($image, $render_array);
	$this->_renderRoofTrim($image, $render_array);
	
	imagesavealpha($image,true);
	imagepng($image);
	
	imagedestroy($image);

	exit;
    }
    
    private function _renderFrame($image, $render_array){
	foreach(array("rail", "rail copy") as $rail){
	    $this->_renderPart($image, $render_array["base_path"]."-frame - $rail.png");
	}
	
	foreach(array("back", "middle copy", "middle", "middle 1", "front") as $bow){
	    $this->_renderPart($image, $render_array["base_path"]."-frame - bow - $bow.png");
	}
    }
    
    private function _renderRoofBack($image, $render_array){
	$color_code = $this->_mapper->getRoofColorCode($this->_session_builder->builder["values"]);
	$color	    = $render_array["color_key"][$color_code];
	$this->_renderPart($image, $render_array["base_path"]."-roof - back - $color.png");
    }
    
    private function _renderRoofFront($image, $render_array){
	$color_code = $this->_mapper->getRoofColorCode($this->_session_builder->builder["values"]);
	$color	    = $render_array["color_key"][$color_code];
	$this->_renderPart($image, $render_array["base_path"]."-roof - color - $color.png");
	$this->_renderPart($image, $render_array["base_path"]."-roof - lines.png");
    }
    
    private function _renderRoofTrim($image, $render_array){
	$color_code = $this->_mapper->getTrimColorCode($this->_session_builder->builder["values"]);
	$color	    = $render_array["color_key"][$color_code];
	$this->_renderPart($image, $render_array["base_path"]."-trim - roof - front - color - $color.png");
	$this->_renderPart($image, $render_array["base_path"]."-trim - roof - back - color - $color.png");
	$this->_renderPart($image, $render_array["base_path"]."-trim - roof - front - lines.png");
    }
    
    private function _renderWallBack($image, $render_array){
	$color_code = $this->_mapper->getEndsColorCode($this->_session_builder->builder["values"]);
	$color	    = $render_array["color_key"][$color_code];
	switch($this->_mapper->getCoveredBackTypeCode($this->_session_builder->builder["values"])){
	    case "CL":
		$this->_renderPart($image, $render_array["base_path"]."-wall - back - color - $color.png");
		$orientation = $this->_mapper->getBackOrientationCode($this->_session_builder->builder["values"]);
		if($orientation == "V"){
		    $this->_renderPart($image, $render_array["base_path"]."-wall - back - vertical - lines.png");
		}
		else $this->_renderPart($image, $render_array["base_path"]."-wall - back - lines.png");
		break;
	    case "GB":
		$this->_renderPart($image, $render_array["base_path"]."-wall - back - gable - color - $color.png");
		$orientation = $this->_mapper->getFrontOrientationCode($this->_session_builder->builder["values"]);
		if($orientation == "V"){
		    $this->_renderPart($image, $render_array["base_path"]."-wall - back - gable - vertical - lines.png");
		}
		else $this->_renderPart($image, $render_array["base_path"]."-wall - back - gable - lines.png");
		break;
	    case "PB":
		$this->_renderPart($image, $render_array["base_path"]."-wall - back - bottom - color - $color.png");
		$this->_renderPart($image, $render_array["base_path"]."-wall - back - bottom - lines.png");
		break;
	}
    }
    
    private function _renderWallFront($image, $render_array){
	$color_code = $this->_mapper->getEndsColorCode($this->_session_builder->builder["values"]);
	$color	    = $render_array["color_key"][$color_code];
	$color_code = $this->_mapper->getTrimColorCode($this->_session_builder->builder["values"]);
	$trim_color = $render_array["color_key"][$color_code];
	switch($this->_mapper->getCoveredFrontTypeCode($this->_session_builder->builder["values"])){
	    case "CL":
		$this->_renderPart($image, $render_array["base_path"]."-wall - front - color - $color.png");
		$orientation = $this->_mapper->getFrontOrientationCode($this->_session_builder->builder["values"]);
		if($orientation == "V"){
		    $this->_renderPart($image, $render_array["base_path"]."-wall - front - vertical - lines.png");
		}
		else $this->_renderPart($image, $render_array["base_path"]."-wall - front - lines.png");
		$this->_renderPart($image, $render_array["base_path"]."-trim - wall - front - color - $trim_color.png");
		$this->_renderPart($image, $render_array["base_path"]."-trim - wall - front - lines.png");
		break;
	    case "GB":
		$this->_renderPart($image, $render_array["base_path"]."-wall - front - gable - color - $color.png");
		$orientation = $this->_mapper->getFrontOrientationCode($this->_session_builder->builder["values"]);
		if($orientation == "V"){
		    $this->_renderPart($image, $render_array["base_path"]."-wall - front - gable - vertical - lines.png");
		}
		else $this->_renderPart($image, $render_array["base_path"]."-wall - front - gable - lines.png");
		break;
	    case "PB":
		$this->_renderPart($image, $render_array["base_path"]."-wall - front - bottom - color - $color.png");
		$this->_renderPart($image, $render_array["base_path"]."-wall - front - bottom - lines.png");
		break;
	}
    }
    
    private function _renderWallLeft($image, $render_array){
	$color_code = $this->_mapper->getSidesColorCode($this->_session_builder->builder["values"]);
	$color	    = $render_array["color_key"][$color_code];
	switch($this->_mapper->getCoveredLeftTypeCode($this->_session_builder->builder["values"])){
	    case "CL":
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - left - color - $color.png");
		$orientation = $this->_mapper->getLeftOrientationCode($this->_session_builder->builder["values"]);
		if($orientation == "V"){
		    $this->_renderPart($image, $render_array["base_path"]."-wall - side - left - vertical - lines.png");
		}
		else $this->_renderPart($image, $render_array["base_path"]."-wall - side - left - lines.png");
		break;
	    case "PT":
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - left - top - color - $color.png");
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - left - top - lines.png");
		break;
	    case "PB":
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - left - bottom - color - $color.png");
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - left - bottom - lines.png");
		break;
	}
    }
    
    private function _renderWallRight($image, $render_array){
	$color_code = $this->_mapper->getSidesColorCode($this->_session_builder->builder["values"]);
	$color	    = $render_array["color_key"][$color_code];
	switch($this->_mapper->getCoveredRightTypeCode($this->_session_builder->builder["values"])){
	    case "CL":
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - right - color - $color.png");
		$orientation = $this->_mapper->getRightOrientationCode($this->_session_builder->builder["values"]);
		if($orientation == "V"){
		    $this->_renderPart($image, $render_array["base_path"]."-wall - side - right - vertical - lines.png");
		}
		else $this->_renderPart($image, $render_array["base_path"]."-wall - side - right - lines.png");
		break;
	    case "PT":
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - right - top - color - $color.png");
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - right - top - lines.png");
		break;
	    case "PB":
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - right - bottom - color - $color.png");
		$this->_renderPart($image, $render_array["base_path"]."-wall - side - right - bottom - lines.png");
		break;
	}
    }
    
    private function _renderPart($image, $path){
	$part		   = imagecreatefrompng("img/builder/render/".$path);
	$part_image_width  = imagesx($part);
	$part_image_height = imagesy($part);
	imagecopyresampled($image, $part, 0, 0, 0, 0, $part_image_width, $part_image_height, $part_image_width, $part_image_height);
	imagedestroy($part);
    }
}

