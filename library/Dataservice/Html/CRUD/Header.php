<?php
namespace Dataservice\Html\CRUD;

class Header
{
    private $title;
    
    public function __construct($title = "")
    {
        $this->title = $title;
    }
    
    public static function factory($title = "")
    {
	return new Header($title);
    }
    
    public function getHtml()
    {
	return '<h1 class="header1">'.$this->title.'</h1>';
    }
}