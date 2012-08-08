<?php
namespace Forms\Company\Customer;
use Entities\Company\Customer as Customer;
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
class Subform extends \Forms\Company\Lead\Subform
{    
    private $_Customer;
    
    public function __construct($options = null, Customer $Customer = null) 
    {
	$this->_Customer = $Customer;
	parent::__construct($options, $this->_Customer);
    }
    
    public function init($options = array())
    {	
	parent::init($options);
    }
}

?>
