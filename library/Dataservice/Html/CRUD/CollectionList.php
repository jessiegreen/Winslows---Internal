<?php
namespace Dataservice\Html\CRUD;

class CollectionList
{
    /**
     * @var array 
     */
    private $collection	    = array();
    
    /**
     * @var string 
     */
    private $url	    = "";
    
    /**
     * @var string 
     */
    private $header	    = "";
    
    /**
     * @var string 
     */
    private $body	    = "";
    
    /**
     * @return \Dataservice_View_Helper_CRUD_Tabs
     */
    public function __construct($collection, $url, $title = "", $permissions = array())
    {
	$this->collection   = $collection;
	$this->url	    = $url;
	$this->permissions  = \Dataservice_Array::merge_unique_recursive($this->permissions, $permissions);
	
	return $this;
    }
    
    /**
     * @return string
     */
    public function getBody()
    {
	return $this->body;
    }
    
    /**
     * @return string
     */
    public function getHeader()
    {
	return $this->header;
    }
    
    public function returnHtml()
    {
	if($title || count($))
	return $this->getHeader().$this->getBody();
    }
    
    public function renderHtml()
    {
	echo $this->returnHtml();
    }
}