<?php

/**
 * Name:
 * Location:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_Builder_Walls extends Zend_Form
{
    private $_options_array;
    private $_selected_array;
    
    public function __construct($options = null, $options_array = array(), $selected_array = array()) {
	$this->_options_array	= $options_array;
	$this->_selected_array	= $selected_array;
	
	parent::__construct($options);
    }
    
    public function init($options = array()){
	$this->setAttrib("id", "form_walls");
	
	$radio_decorators = array(
		    array('Label',array('tag'=>'div','placement' => 'APPEND', "style" => "font-weight:600;padding:10px;padding-left:0px;line-height: 30px;")),
		    'ViewHelper',
		    array('HtmlTag',array('tag'=>'div', "class" => "jquery_radio"))
		);
	
	foreach(array("left", "right", "front", "back") as $side){
	    $radio1 = $this->addElement('radio', 'builder_walls_type_'.$side, array(
		'required'	    => true,
		'escape'	    => false,
		'label'		    => "Style:",
		'class'		    => "jquery_radio",
		'separator'	    => "",
		'multioptions'	    => $this->_options_array[$side]["type"],
		'value'		    => $this->_selected_array[$side]["type"]
	    ));
	    
	    $radio1->setElementDecorators($radio_decorators);
	    
	    if(in_array($this->_selected_array[$side]["type"], array("PT", "PB")))
	    {
		$radio2 = $this->addElement('radio', 'builder_walls_height_'.$side, array(
		    'required'	    => false,
		    'escape'	    => false,
		    'label'	    => "Partial Wall Height:",
		    'class'	    => "jquery_radio",
		    'separator'	    => "",
		    'multioptions'  => $this->_options_array[$side]["height"],
		    'value'	    => $this->_selected_array[$side]["height"]
		));

		$radio2->setElementDecorators($radio_decorators);
	    }
	    
	    if(in_array($this->_selected_array[$side]["type"], array("CL", "GB")))
	    {
		$radio3 = $this->addElement('radio', 'builder_walls_orientation_'.$side, array(
		    'required'	    => false,
		    'escape'	    => false,
		    'label'	    => "Siding Orientation:",
		    'class'	    => "jquery_radio",
		    'separator'	    => "",
		    'multioptions'  => $this->_options_array[$side]["orientation"],
		    'value'	    => $this->_selected_array[$side]["orientation"]
		));

		$radio3->setElementDecorators($radio_decorators);
	    }
	    
	    $this->addDisplayGroup(array(
                    'builder_walls_type_'.$side,
                    'builder_walls_height_'.$side,
                    'builder_walls_orientation_'.$side
        
            ),$side,array('legend' => ucfirst($side)." Wall"));
	    
	    $group = $this->getDisplayGroup($side);
	    
	    $group->setDecorators(array(
                    'FormElements',
                    array('Fieldset',array("style" => "margin-bottom:5px;border: solid 1px silver;padding-left:25px;")),
                    array('HtmlTag',array('tag'=>'div', "class" => "form_div"))
	    ));
	}
	
	$this->clearDecorators();
        $this->setDecorators(array(
                'FormElements',
                array('HtmlTag',array('tag'=>'div')),
                'Form'
        ));
    }
}

?>
