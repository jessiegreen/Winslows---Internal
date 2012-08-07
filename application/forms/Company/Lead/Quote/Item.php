<?php

/**
 * Name:
 * Quote:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Form_QuoteProduct extends Zend_Form
{    
    private $_QuoteProduct;
    
    public function __construct(Entities\QuoteProduct $QuoteProduct, $options = null)
    {
	$this->_QuoteProduct = $QuoteProduct;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Form_QuoteProduct_Subform($this->_QuoteProduct, $options);
	$this->addDisplayGroups($form->getDisplayGroups());
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
	    'style'	=> "clear:both"
        ));
    }
}

?>
