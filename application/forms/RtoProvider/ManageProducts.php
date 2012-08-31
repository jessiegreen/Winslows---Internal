<?php
namespace Forms\RtoProvider;
/**
 * Name:
 * Company:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class ManageProducts extends \Dataservice_Form
{
    private $_RtoProvider;
    
    public function __construct(\Entities\Company\RtoProvider $RtoProvider, $options = null)
    {
	$this->_RtoProvider = $RtoProvider;
	parent::__construct($options);
    }
    
    public function init($options = array())
    {	
        $form = new ManageProducts\Subform($this->_RtoProvider, $options);
	
	$this->addSubForm($form, "rto_provider_manageproducts");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
