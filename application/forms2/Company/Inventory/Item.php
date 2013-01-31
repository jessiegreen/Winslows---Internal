<?php
namespace Forms\Company\Inventory;

class Item extends \Dataservice_Form
{    
    private $_Item;
    
    public function __construct(\Entities\Company\Inventory\Item $Item, $options = null)
    {
	$this->_Item = $Item;
	
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new Item\Subform($this->_Item, $options);
	
	$this->addSubForm($form, "company_inventory_item");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
	    'style'	=> "clear:both"
        ));
    }
}