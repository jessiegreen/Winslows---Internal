<?php
namespace Forms\Company\Lead\Quote;
use Entities\Company\Lead\Quote\Item as Item;
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
class Item extends \Zend_Form
{    
    private $_Item;
    
    public function __construct(\Item $Item, $options = null)
    {
	$this->_Item = $Item;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Item\Subform($this->_Item, $options);
	$this->addDisplayGroups($form->getDisplayGroups());
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
	    'style'	=> "clear:both"
        ));
    }
}