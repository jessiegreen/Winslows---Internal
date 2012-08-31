<?php
namespace Forms;
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
class RtoProvider extends \Zend_Form
{    
    private $_RtoProvider;
    
    public function __construct($options = null, \Entities\Company\RtoProvider $RtoProvider = null)
    {
	$this->_RtoProvider = $RtoProvider;
	parent::__construct($options, $this->_RtoProvider);
    }
    
    public function init($options = array())
    {	
        $form = new RtoProvider\Subform($options, $this->_RtoProvider);
	
	$this->addSubForm($form, "rto_provider");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
