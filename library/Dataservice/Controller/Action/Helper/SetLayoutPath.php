<?php 
/** 
* Sets the layout path on a per-module basis 
* 
* @author     Lloyd Watkin 
* @since      16/02/2010 
* @package    Pro 
* @subpackage Controller_Action_Helper 
*/  

/** 
* Sets the layout path on a per-module basis 
* 
* @author     Lloyd Watkin 
* @since      16/02/2010 
* @package    Pro 
* @subpackage Controller_Action_Helper 
*/  
class Dataservice_Controller_Action_Helper_SetLayoutPath  
   extends Zend_Controller_Action_Helper_Abstract  
{  
   /** 
    * Base path 
    * 
    * @var string 
    */  
   protected $_path;  

   /** 
    * Construct 
    * 
    * @param string $path 
    */  
   public function __construct($path)  
   {  
       $this->setBasePath($path);  
   }  

   /** 
    * Set base path 
    * 
    * @param string $path 
    */  
   public function setBasePath($path)  
   {  
       if (!is_string($path) || empty($path)) {  
	   throw new Exception('Excepted string for base path');  
       }  
       $this->_path = $path;  
   }  

   /** 
    * Get the base path 
    * 
    * @return string 
    */  
   protected function _getBasePath()  
   {  
       if (is_null($this->_path)) {  
	   if (!defined('APPLICATION_PATH')) {  
	       throw new Exception('Base path can not be determined');  
	   }  
	   $this->_path = APPLICATION_PATH;  
       }  
       return $this->_path;  
   }  

   /** 
    * Sets layout path based on module 
    */  
   public function preDispatch()  
   {  
       $module = preg_replace(  
	   '/[^A-Z]/i', '', $this->getRequest()->getModuleName()  
       );  
       
       if ($bootstrap = $this->getActionController()  
			  ->getInvokeArg('bootstrap')) {  

	   $view = $bootstrap->getResource('view');  
	   $layoutPath = $this->_getBasePath() .  
	       "/modules/{$module}/layouts/scripts/";  

	   /* If layout directory exists then apply it, otherwise just fall 
	    * back on the default 
	    */  
	   if (is_dir($layoutPath)) {  
	       $this->getActionController()  
		    ->getHelper('layout')  
		    ->setLayoutPath($layoutPath);  
//	       $view->headLink()->appendStylesheet(  
//		   "/styles/{$module}/style.css"  
//	       );  
	   }  
       }  
   }  
}  