<?php
namespace Forms\Company\Lead\Quote\Item;
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
class SetDeliveryType extends \Dataservice_Form
{    
    /* @var $Item \Entities\Company\Lead\Quote\Item */
    private $Item;
    
    public function __construct(\Entities\Company\Lead\Quote\Item $Item, $options = null)
    {
	$this->Item = $Item;
	
	parent::__construct($options);	
    }
    
    public function init($options = array())
    {
	$form = new SetDeliveryType\Subform($this->Item, $options);	
	
	$this->addSubForm($form, "company_lead_quote_item_setdeliverytype");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}