<?php
namespace Dataservice\Html;

class Image 
{    
    /**
     * @var string
     */
    protected $_source;
    
    /**
     * @var string
     */
    protected $_title;
    
    /**
     * @var string
     */
    protected $_style;
    
    /**
     * @var string
     */
    protected $_class;
    
    /**
     * @var array 
     */
    protected $_additionalAttributes = array();
    
    public static function factory()
    {
	return new Image;
    }
    
    /**
     * @param string $source
     * @return \Dataservice\Html\Image
     */
    public function setSource($source)
    {
	$this->_source = $source;
	
	return $this;
    }
    
    /**
     * @return string
     */
    public function getSource()
    {
	return $this->_source;
    }
    
    /**
     * @param string $title
     * @return \Dataservice\Html\Image
     */
    public function setTitle($title)
    {
	$this->_title = $title;
	
	return $this;
    }
    
    /**
     * @return string
     */
    public function getTitle()
    {
	return $this->_title;
    }
    
    /**
     * @param string $style
     * @return \Dataservice\Html\Image
     */
    public function setStyle($style)
    {
	$this->_style = $style;
	
	return $this;
    }
    
    /**
     * @return string
     */
    public function getStyle()
    {
	return $this->_style;
    }
    
    /**
     * @param string $class
     * @return \Dataservice\Html\Image
     */
    public function setClass($class)
    {
	$this->_class = $class;
	
	return $this;
    }
    
    /**
     * @return string
     */
    public function getClass()
    {
	return $this->_class;
    }
    
    /**
     * @param string $key
     * @param string $value
     * @return \Dataservice\Html\Image
     */
    public function addAdditionalAttribute($key, $value)
    {
	$this->_additionalAttributes[$key] = $value;
	
	return $this;
    }
    
    /**
     * @return array
     */
    public function getAdditionalAttributes()
    {
	return $this->_additionalAttributes;
    }
    
    /**
     * @param string $key
     * @return null|mixed
     */
    public function getAdditionalAttributeValue($key)
    {
	if(isset($this->_additionalAttributes[$key]))
	    return $this->_additionalAttributes[$key];
	
	else return null;
    }
    
    /**
     * @return string
     */
    public function getHtml()
    {
	$image = '<img ';
	
	if($this->getTitle())$image .= ' title="'.htmlspecialchars($this->getTitle()).'" ';
	if($this->getSource())$image .= ' src="'.htmlspecialchars($this->getSource()).'" ';
	if($this->getStyle())$image .= ' style="'.htmlspecialchars($this->getStyle()).'" ';
	if($this->getClass())$image .= ' class="'.htmlspecialchars($this->getClass()).'" ';
	
	if($this->getAdditionalAttributes())
	{
	    foreach($this->getAdditionalAttributes() as $key => $value)
		$image .= ' '.$key.'="'.htmlspecialchars($value).'" ';
	}
	
	$image .= ' />';
	
	return $image;
    }
    
    public function render()
    {
	echo $this->getHtml();
    }
}
