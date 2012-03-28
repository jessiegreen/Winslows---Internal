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
class Form_Builder_Size extends Zend_Form
{
    private $_localoptions;
    private $_localselected;
    
    public function __construct($options = null, $options_array = array(), $selected_array = array()) {
	$this->_localoptions	    = $options_array;
	$this->_localselected	    = $selected_array;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	$this->setAttrib("id", "form_size");
	$options = array();
	foreach ($this->_localoptions["size"] as $size) {
	    $size_array = explode("X", $size);
	    $options[$size] = $size_array[0]."Wx".$size_array[1]."L"; 
	}
	
	foreach ($this->_localoptions["leg_height"] as $leg_height) {
	    $height_options[$leg_height] = $leg_height; 
	}
	
	$builder_type = $this->addElement('radio', 'builder_size', array(
            'required'	    => true,
	    'escape'	    => false,
	    'separator'	    => "",
	    'multioptions'  => $options,
	    'value'	    => $this->_localselected["size"]
        ));
	
	$this->addDisplayGroup(array("builder_size"), "size_group", array('legend' => "Width X Length"));
	
	$group = $this->getDisplayGroup("size_group");
	    
	$group->setDecorators(array(
		'FormElements',
		array('Fieldset',array("style" => "margin-bottom:5px;border: solid 1px silver;padding-left:25px;")),
		array('HtmlTag',array('tag'=>'div', "class" => "form_div"))
	));
	
	$builder_type = $this->addElement('radio', 'leg_height', array(
            'required'	    => true,
	    'escape'	    => false,
	    'separator'	    => "",
	    'multioptions'  => $height_options,
	    'value'	    => $this->_localselected["leg_height"]
        ));
	
	$this->addDisplayGroup(array("leg_height"), "leg_height_group", array('legend' => "Leg Height"));
	
	$group = $this->getDisplayGroup("leg_height_group");
	    
	$group->setDecorators(array(
		'FormElements',
		array('Fieldset',array("style" => "margin-bottom:5px;border: solid 1px silver;padding-left:25px;")),
		array('HtmlTag',array('tag'=>'div', "class" => "form_div"))
	));
	
	$group->setDecorators(array(
                    'FormElements',
                    array('Fieldset',array("style" => "margin-bottom:5px;border: solid 1px silver;padding-left:25px;")),
                    array('HtmlTag',array('tag'=>'div', "class" => "form_div"))
	    ));
    }
}

?>
