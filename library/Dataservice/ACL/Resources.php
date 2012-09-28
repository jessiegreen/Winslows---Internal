<?php

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
class Dataservice_ACL_Resources 
{
    private $arrModules = array();
    private $arrControllers = array();
    private $arrActions = array();
    private $arrIgnore = array('.', '..', '.svn', '.git');

    public function __get($strVar) 
    {
	return ( isset($this->$strVar) ) ? $this->$strVar : null;
    }

    public function __set($strVar, $strValue) 
    {
	$this->$strVar = $strValue;
    }
    
    public function cleanDB(\Doctrine\ORM\EntityManager $em)
    {
	$Resources	= $em->getRepository("Entities\Website\Resource")->findAll();
	$results_array	= array("removed" => array(), "kept" => array());
	
	/* @var $Resource \Entities\Website\Resource */
	foreach ($Resources as $Resource) 
	{
	    $remove			= false;
	    $module			= $Resource->getModule();
	    $controller			= $Resource->getController();
	    $action			= $Resource->getAction();
	    $controller_mc		= $this->_hyphensToMixedCase($controller);
	    $controller_file		= $controller_mc."Controller";
	    $controller_module_string	= $module == "default" ? "" : ucfirst($module)."_";
	    $controller_class		= $controller_module_string.$controller_file;
	    $controller_file_path	= APPLICATION_PATH.'/modules/'.$module.'/controllers/'.$controller_file.'.php';
	    
	    if(!file_exists($controller_file_path))$remove = true;	    
	    else
	    {
		if (!class_exists($controller_class))Zend_Loader::loadFile($controller_file_path);	    
	    
		$objReflection  = new Zend_Reflection_Class($controller_class);

		if(!$objReflection->hasMethod(ucfirst($action).'Action'))$remove = true;
	    }
	    
	    if($remove === true)
	    {
		$result = "removed";
		$em->remove($Resource);
	    }
	    else $result = "kept";
	    $results_array[$result][] = $Resource->getName();
	}
	$em->flush();
	return $results_array;
    }

    public function writeToDB(\Doctrine\ORM\EntityManager $em, Entities\Website\WebsiteAbstract $Website) 
    {
	$Role = $em->getRepository("Entities\Company\Employee\Role")->findOneBy(array("name" => "Web Admin"));
	
	$this->checkForData();
	
	foreach ($this->arrModules as $strModuleName) 
	{#--Modules
	    if (array_key_exists($strModuleName, $this->arrControllers)) 
	    {
		foreach ($this->arrControllers[$strModuleName] as $strControllerName) 
		{#--Controllers
		    if (array_key_exists($strControllerName, $this->arrActions[$strModuleName])) 
		    {
			foreach ($this->arrActions[$strModuleName][$strControllerName] as $strActionName)
			{#--Actions
			    $existing = $em->getRepository("Entities\Website\Resource")->findBy(
					    array(
						"module" => $strModuleName, 
						"controller" => $strControllerName, 
						"action" => $strActionName
						)
				    );
			    
			    if(!$existing)
			    {
				$resource = new \Entities\Website\Resource;
				$resource->setName(ucwords($strModuleName.' | '.$strControllerName . " - " . $strActionName));
				$resource->setModule($strModuleName);
				$resource->setController($strControllerName);
				$resource->setAction($strActionName);
				$resource->setRouteName("$strModuleName/$strControllerName/$strActionName");
				$resource->addRole($Role);
				$resource->setWebsite($Website);
				$em->persist($resource);
				$em->flush();
			    }
			}
		    }
		}
	    }
	}
	
	return $this;
    }

    private function checkForData()
    {
	if(count($this->arrModules) < 1)throw new Exception('No modules found.');
	if(count($this->arrControllers) < 1)throw new Exception('No Controllers found.');
	if(count($this->arrActions) < 1)throw new Exception('No Actions found.');
    }

    public function buildAllArrays($website_index) 
    {
	$this->buildModulesArray($website_index);
	$this->buildControllerArrays($website_index);
	$this->buildActionArrays($website_index);
	return $this;
    }

    public function buildModulesArray($website_index) 
    {
	$dstApplicationModules	= opendir(APPLICATION_PATH.'/modules');
	
	while(($dstFile = readdir($dstApplicationModules)) !== false) 
	{	    
	    if(!in_array($dstFile, $this->arrIgnore)) 
	    {
		if($website_index == $dstFile && is_dir(APPLICATION_PATH . '/modules/' . $dstFile) )
		{
		    $this->arrModules[] = $dstFile;
		}
	    }
	}
	closedir($dstApplicationModules);
    }

    public function buildControllerArrays()
    {
	if (count($this->arrModules) > 0) 
	{
	    foreach ($this->arrModules as $strModuleName) 
	    {
		$datControllerFolder = opendir(APPLICATION_PATH.'/modules/'.$strModuleName.'/controllers');
		
		while (($dstFile = readdir($datControllerFolder) ) !== false) 
		{
		    if (!in_array($dstFile, $this->arrIgnore)) 
		    {
			if (preg_match('/Controller/', $dstFile))
			{
			    $this->arrControllers[$strModuleName][] = $this->_mixedCaseToHyphens(substr($dstFile, 0, -14));
			}
		    }
		}
		closedir($datControllerFolder);
	    }
	}
    }

    public function buildActionArrays() 
    {
	if (count($this->arrControllers) > 0)
	{
	    foreach ($this->arrControllers as $strModule => $arrController)
	    {
		foreach ($arrController as $strController) 
		{
		    $strClassName   = $this->_hyphensToMixedCase($strController) . 'Controller';
		    $fileName	    = $strClassName;
		    
		    if($strModule != "default")$strClassName = ucfirst ($strModule).'_'.$strClassName;
		    
		    if (!class_exists($strClassName)) 
		    {
			Zend_Loader::loadFile(APPLICATION_PATH.'/modules/'.$strModule.'/controllers/' . $fileName . '.php');
		    }

		    $objReflection  = new Zend_Reflection_Class($strClassName);
		    $arrMethods	    = $objReflection->getMethods();
		    
		    foreach ($arrMethods as $objMethods)
		    {
			if (preg_match('/Action/', $objMethods->name))
			{
			    $this->arrActions[$strModule][$strController][] = $this->_camelCaseToHyphens(substr($objMethods->name, 0, -6));
			}
		    }
		}
	    }
	}
    }
    
    private function _hyphensToMixedCase($string)
    {
	return join("", array_map('ucwords', explode("-", $string)));
    }
    
    private function _mixedCaseToHyphens($string)
    {
	return ltrim($this->_camelCaseToHyphens($string), "\-");
    }

    private function _camelCaseToHyphens($string)
    {	
	$length		    = strlen($string);
	$convertedString    = '';
	
	for ($i = 0; $i < $length; $i++)
	{
	    if (ord($string[$i]) >= ord('A') && ord($string[$i]) <= ord('Z'))
	    {
		$convertedString .= '-' . strtolower($string[$i]);
	    } else
	    {
		$convertedString .= $string[$i];
	    }
	}
	return strtolower(rtrim($convertedString, "-"));
    }
}