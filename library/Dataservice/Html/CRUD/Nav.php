<?php
namespace Dataservice\Html\CRUD;

class Nav
{
    private $href;
    
    private $text;
    
    public function __construct($text = "", $href = "")
    {
	$this->href	= $href;
	$this->text	= $text;
    }
    
    public static function factory($text = "", $href = "")
    {
	return new Nav($text, $href);
    }
    
    public function getHtml()
    {
	$html =  "<div>";
	$html .= \Dataservice\Html\Anchor::backAnchorIcon($this->text, $this->href);
	$html .= "</div>";
	
	return $html;
    }
}