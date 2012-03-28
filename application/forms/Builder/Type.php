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
class Form_Builder_Type extends Zend_Form
{
    private $_localtypes;
    private $_localselected;
    
    public function __construct($options = null, $types = null, $selected = null) {
	$this->_localtypes	    = $types;
	$this->_localselected	    = $selected;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	$this->setAttrib("id", "form_type");
	$options = array();
	foreach ($this->_localtypes as $type) {
	    $options[$type["code"]] = $type['name']."<br /><div style='color:silver;margin-left:20px'>".$type['description']."</div>"; 
	}
	
	$builder_type = $this->addElement('radio', 'builder_type', array(
            'required'	    => true,
	    'escape'	    => false,
	    'multioptions'  => $options,
	    'value'	    => $this->_localselected ? $this->_localselected : ""
        ));
	
	
	$builder_type->removeDecorator('label');
	$this->clearDecorators();
        $this->addDecorator('FormElements')
         ->addDecorator('HtmlTag', array('tag' => '<ul>', 'class' => 'form_list'))
         ->addDecorator('Form');
        
        $this->setElementDecorators(array(
            array('ViewHelper'),
            array('Errors'),
            array('Description'),
            array('Label', array('separator'=>'')),
            array('HtmlTag', array('tag' => 'li')),
        ));
    }
}

?>
