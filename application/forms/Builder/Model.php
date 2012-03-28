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
class Form_Builder_Model extends Zend_Form
{
    private $_localmodels;
    private $_localselected;
    
    public function __construct($options = null, $models = null, $selected = null) {
	$this->_localmodels	    = $models;
	$this->_localselected	    = $selected;
	parent::__construct($options);
    }
    
    public function init($options = array()){
	$this->setAttrib("id", "form_model");
	$options = array();
	foreach ($this->_localmodels as $model) {
	    $options[$model["code"]] = $model['name']."<br /><div style='color:silver;margin-left:20px'>".$model['description']."</div>"; 
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
