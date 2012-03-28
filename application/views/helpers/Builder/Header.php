<?php

/**
 * Builder Header helper
 *
 */
class Builder_View_Helper_Header // extends Zend_View_Helper_Abstract
{
    public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public function header()
    {
	$this->view->headScript()->appendFile("/javascript/jquery-ui.min.js");
	$this->view->headLink()->appendStylesheet('/css/jquery-ui/redmond/jquery-ui.custom.css');
        $return = '<div id="builder_container">
		    <h4>Welcome to the building wizard!</h4>
		    <h4>Current Code: <span id="builder_code"></span></h4>
		    <h4>Price: <span id="builder_price"></span></h4>
		    <div id="builder_options_bar">
			<input id="reset" type="button" class="blue_button" value="Reset"/>
			<div id="tabs_messenger"></div>
			<div style="clear:both"></div>
		    </div>
		    <div id="builder_left_pane">
			<img src="/img/builder/renderings/4.jpg" style="width:100%" />
			<div id="builder_hints"></div>
			<div id="builder_details"></div>
			<div id="price_details"></div>
		    </div>
		    <div id="builder_right_pane">';
	$return .= '<div id="example">
			<ul>
			    <li><a href="/builder/location" title="Location">Building Location</a></li>
			    <li><a href="/builder/type" title="Type">Building Type</a></li>
			    <li><a href="/builder/model" title="Model">Model</a></li>
			    <li><a href="/builder/size" title="Size">Size</a></li>
			    <li><a href="/builder/walls" title="Walls">Walls</a></li>
			    <li><a href="/builder/colors" title="Colors">Colors</a></li>
			    <li><a href="/builder/doors" title="Doors">Doors</a></li>
			    <li><a href="/builder/windows" title="Windows">Windows</a></li>
			</ul>
			    <div id="Location" class="tab_conts"></div>
			    <div id="Type" class="tab_conts"></div>
			    <div id="Model" class="tab_conts"></div>
			    <div id="Size" class="tab_conts"></div>
			    <div id="Walls" class="tab_conts"></div>
			    <div id="Colors" class="tab_conts"></div>
			    <div id="Doors" class="tab_conts"></div>
			    <div id="Windows" class="tab_conts"></div>
		    </div>';
	
	return $return;
    }
}

?>