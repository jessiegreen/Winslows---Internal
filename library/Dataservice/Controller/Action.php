<?php
/**
 * Description of Action
 *
 * @author jgreen
 */
class Dataservice_Controller_Action extends Zend_Controller_Action
{
    /**
     *
     * @var Zend_Controller_Request_Abstract
     */
    protected $_request;
    /**
     *
     * @var array() 
     */
    protected $_params;
    /**
     *  @var \Doctrine\ORM\EntityManager $_em 
     */
    protected $_em;
    
    /**
     * @var Dataservice_Controller_Action_Helper_FlashMessenger $_FlashMessenger 
     */
    public $_FlashMessenger;
    
    /**
     * @var Dataservice_Controller_Action_Helper_History $_History 
     */
    public $_History;
    
    public function init()
    {
	$this->_request		= $this->getRequest();
	$this->_params		= $this->_request->getParams();
	$this->_em		= $this->_helper->EntityManager();
	$this->_FlashMessenger	= new Dataservice_Controller_Action_Helper_FlashMessenger;
	$this->_History		= new Dataservice_Controller_Action_Helper_History();
	
	$css_string = "/css/".$this->_request->getModuleName().
			"/".$this->_request->getControllerName().
			"/".$this->_request->getActionName().".css";
	
	if(file_exists(PUBLIC_PATH.$css_string))
	    $this->view->headLink()->appendStylesheet(BASE_URL.$css_string);
	
	parent::init();
    }
    
    public function getEntityFromParamFields($entity_name, $fields = array())
    {
	$find_by	= array();
	$entity_string	= "Entities\\".$entity_name;
	$Entity		= null;
	
	foreach($fields as $field)
	{
	    if(!isset($this->_params[$field]))
		throw new Exception("param '".htmlspecialchars($field)."' does not exist");
	    else
	    {
		$find_by[$field] = $this->_params[$field];
	    }
	}
	
	if(
	    !class_exists($entity_string, true)
	){
	    throw new Exception("Entity '".htmlspecialchars($entity_name)."' does not exist");
	}
	
	if(count($find_by) > 0)
	    $Entity = $this->_em->getRepository($entity_string)->findOneBy($find_by);
	
	return !$Entity ? new $entity_string : $Entity;
    }
    
    public function isPostAndValid(Zend_Form $form, $params = null)
    {
	if($params === null)
	{
	    $params = $this->_params;
	}
	
	if($this->_request->isPost())
	{
	    if($form->isValid($params))return true;
	    else
	    {
		$form->populate($params);
		
		return false;
	    }
	}
	return false;
    }
}