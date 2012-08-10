<?php
namespace Forms\Company\Lead;
use Entities\Company\Lead\Quote as Quote;
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
class Quote extends \Dataservice_Form
{    
    private $_Quote;
    
    public function __construct($options = null, Quote $Quote = null)
    {
	$this->_Quote = $Quote;
	parent::__construct($options, $this->_Quote);
    }
    
    public function init($options = array())
    {	
        $form = new Quote\Subform($options, $this->_Quote);
	
	$this->addSubForm($form, "company_lead_quote");
	
	$this->addElement('submit', 'submit', array(
            'ignore'   => true,
        ));
    }
}

?>
