<?php
namespace Forms\Company\Lead;
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
class Search extends \Dataservice_Form
{    
    public function init()
    {
	$this->addElement('text', 'lead_lookup', array(
            'label'	    => 'Lead/Customer Search:',
	    'description'   => 'Name, Phone, Address, or Email'
        ));
    }
}