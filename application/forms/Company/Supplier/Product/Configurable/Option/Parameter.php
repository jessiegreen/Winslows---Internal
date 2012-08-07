<?php

/**
 * Name:
 * Product:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_ConfigurableProductOption extends Zend_Form
{    
    private $_ConfigurableProductOption;
    
    public function __construct($options = null, Entities\ConfigurableProductOption $ConfigurableProductOption = null)
    {
	$this->_ConfigurableProductOption = $ConfigurableProductOption;
	parent::__construct($options, $this->_ConfigurableProductOption);
    }
    
    public function init($options = array())
    {	
        $form = new Form_ConfigurableProductOption_Subform($options, $this->_ConfigurableProductOption);
	
	$this->addSubForm($form, "configurableproductoption");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
