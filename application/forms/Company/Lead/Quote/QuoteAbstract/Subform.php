<?php
namespace Forms\Company\Lead\Quote\QuoteAbstract;
use Entities\Company\Lead\Quote\QuoteAbstract as QuoteAbstract;
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
class Subform extends \Zend_Form_SubForm
{
    private $_QuoteAbstract;
    
    public function __construct($options = null, QuoteAbstract $QuoteAbstract = null) 
    {
	$this->_QuoteAbstract = $QuoteAbstract;
	parent::__construct($options);
    }
}