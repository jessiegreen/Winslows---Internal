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
	}
    }
    
    public function indexAction()
    {	
	$session		= new Zend_Session_Namespace('Dataservice');
	$session->redirect	= $_SERVER['REQUEST_URI'];
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
		$this->_session_builder->builder["values"] = 
		    $this->_mapper->setLegHeight(str_pad($this->_params["leg_height"], 2, 0, STR_PAD_LEFT), $this->_session_builder->builder["values"]);
		$this->addSuccessFlashMessage("Changed leg height.");
	    }
	    
	    if(
		isset($this->_params["builder_size"]) 
		&& $this->_params["builder_size"] 
		    != $this->_mapper->getSize($this->_session_builder->builder["values"])
	    ){
		$size_array = explode("X", $this->_params["builder_size"]);
		$size_array[0] = str_pad($size_array[0], 2, 0, STR_PAD_LEFT);
		$size_array[1] = str_pad($size_array[1], 2, 0, STR_PAD_LEFT);
		$size = implode("X", $size_array);
		$this->_session_builder->builder["values"] = 
		    $this->_mapper->setSize($this->_params["builder_size"], $this->_session_builder->builder["values"]);
		$this->addSuccessFlashMessage("Changed size.");
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
		$covered_walls_type	    = $this->_mapper->getCoveredWallsTypeCodeFromSideString($side, $this->_session_builder->builder["values"]);
		$covered_walls_height	    = $this->_mapper->getCoveredWallsHeightCodeFromSideString($side, $this->_session_builder->builder["values"]);
		$covered_walls_orientation  = $this->_mapper->getOrientationCodeFromSideString($side, $this->_session_builder->builder["values"]);
		
		if(
		    isset($this->_params["builder_walls_height_".$side])
		    && $this->_params["builder_walls_height_".$side] != $covered_walls_height		    
		)
		{
		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setCoveredWallsHeightFromSideString(
				    $this->_params["builder_walls_height_".$side], 
				    $side, 
				    $this->_session_builder->builder["values"]
				    );
		    $this->addSuccessFlashMessage("Changed ".$side." partial wall height.");
		}
		
		if(
		    isset($this->_params["builder_walls_orientation_".$side])
		    && $this->_params["builder_walls_orientation_".$side] != "null"
		    && $this->_params["builder_walls_orientation_".$side] != $covered_walls_orientation		    
		)
		{
		    $this->_session_builder->builder["values"] = 
			$this->_mapper->setOrientationFromSideString(
				    $this->_params["builder_walls_orientation_".$side], 
				    $side, 
				    $this->_session_builder->builder["values"]
				    );
		    $this->addSuccessFlashMessage("Changed ".$side." wall siding orientation.");
		}
		
		if(
		    isset($this->_params["builder_walls_type_".$side])
		    && $this->_params["builder_walls_type_".$side] != $covered_walls_type		    
		)
		{
		    $this->_session_builder->builder["values"] = 
			    $this->_mapper->setCoveredWallsTypeFromSideString(
				    $this->_params["builder_walls_type_".$side], 
				    $side, 
				    $this->_session_builder->builder["values"]
				    );
		    if(in_array($this->_params["builder_walls_type_".$side], array("", "NO")))
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
			if(in_array($this->_params["builder_walls_type_".$side], array("PB", "PT"))){
			    $this->_session_builder->builder["values"] = 
				$this->_mapper->setCoveredWallsHeightFromSideString("1", $side, $this->_session_builder->builder["values"]);
			}
			else
			{
			    $this->_session_builder->builder["values"] = 
				$this->_mapper->setCoveredWallsHeightFromSideString("", $side, $this->_session_builder->builder["values"]);
			}
		    }
		    $this->addSuccessFlashMessage("Changed ".$side." wall style.");
		}
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
    }
    
    public function windowsAction()
    {	
        $this->_helper->layout->disableLayout();
    }
    
    public function messengerAction(){
	$this->_helper->layout->disableLayout();
    }
    
    public function clearAction(){
	$this->_helper->layout->disableLayout();
	$this->_session_builder->builder = array();
	$this->_initializeSessionBuilder();
	$this->addSuccessFlashMessage("Builder Reset");
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
	    $this->addErrorFlashMessage($exc->getMessage());
	}
    }
    
    private function _setLocation(){
	if(isset($this->_params['set'])){
	    $this->_session_builder->builder["location"] = $this->_params['set'];
	    $this->addSuccessFlashMessage("Changed location");
	}
    }
    
    private function _setValueArrayValue($mapper_method, $value = ""){
	if(strlen($value)>0 && method_exists($this->_mapper, "set".$mapper_method)){
	    $mapper_method_name = "set".$mapper_method;
	    $this->_session_builder->builder["values"] = $this->_mapper->$mapper_method_name($value, $this->_session_builder->builder["values"]);
	    $this->addSuccessFlashMessage("Changed ".$mapper_method);
	}
    }
    
    private function _setValueArrayValueFromSetParam($mapper_method){
	if(isset($this->_params['set'])){
	    $this->_setValueArrayValue($mapper_method, $this->_params["set"]);
	    return true;
	}
	else return false;
    }
    
    private function addSuccessFlashMessage($message)
    {
	$this->_flashMessenger->addMessage(
		array(
		    "message" => $message, 
		    "status" => "success", 
		    "type" => "flash"
		    )
		);	
    }
    
    private function addErrorFlashMessage($message)
    {
	$this->_flashMessenger->addMessage(
		array(
		    "message" => $message, 
		    "status" => "error", 
		    "type" => "flash"
		    )
		);	
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
	$return .= "<div style='clear:both'><h4 style='background-color:red;margin-top:0px;padding-top:0px;'>".implode("<br />", $errors)."</h4>";
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
}

