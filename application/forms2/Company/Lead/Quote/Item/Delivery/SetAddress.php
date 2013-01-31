<?php
namespace Forms\Company\Lead\Quote\Item\Delivery;
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
class SetAddress extends \Dataservice_Form
{    
    /* @var $Delivery \Entities\Company\Lead\Quote\Item\Delivery */
    private $Delivery;
    
    public function __construct(\Entities\Company\Lead\Quote\Item\Delivery $Delivery, $options = null)
    {
	$this->Delivery = $Delivery;
	
	parent::__construct($options);	
    }
    
    public function init($options = array())
    {
	$form = new SetAddress\Subform($this->Delivery, $options);	
	
	$this->addSubForm($form, "company_lead_quote_item_delivery_setaddress");

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}