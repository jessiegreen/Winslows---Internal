<?php
namespace Forms\Company\Website;
/**
 * Name:
 * Supplier:
 *
 * Description for class (if any)...
 *
 * @author     Jessie Green <jessie.winslows@gmail.com>
 * @copyright  2012 Winslows inc.
 * @version    Release: @package_version@
 */
class Subform extends \Forms\Website\SubForm
{
    private $_Website;
    
    public function __construct( \Entities\Website\WebsiteAbstract $Website, $options = null)
    {
	$this->_Website = $Website;
	parent::__construct($Website, $options);
    }
    
    public function init()
    {		
	$this->addElement(new \Dataservice_Form_Element_CompanySelect("company_id", array(
            'required'	    => true,
            'label'	    => 'Company:',
	    'belongsTo'	    => 'company_website',
	    'value'	    => $this->_Website && $this->_Website->getCompany() ? $this->_Website->getCompany()->getId() : ""
        )));
	
	parent::init();
    }
}