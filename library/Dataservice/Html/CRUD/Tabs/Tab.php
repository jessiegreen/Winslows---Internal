<?php
namespace Dataservice\Html\CRUD\Tabs;

class Tab
{
    /**
     * @var string 
     */
    private $name	    = "";
    
    /**
     * @var string 
     */
    private $header_html    = "";
    
    /**
     * @var string 
     */
    private $content_html    = "";
    
    public function __construct($name)
    {
	$this->name = $name;
    }
    
    public function addContent($html)
    {
	$this->content_html .= $html;
    }
    
    public function getTabHtml()
    {
	return '<li><a href="#'.str_ireplace(" ", "_", $this->name).'">'.$this->name.'</a></li>';
    }
    
    public function getBodyHtml()
    {
	$html = '<div id="'.str_ireplace(" ", "_", $this->name).'">';
	$html .= $this->content_html;
	$html .= '</div>';
	
	return $html;
    }
}