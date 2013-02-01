<?php
namespace Dataservice\Html\CRUD;

class Header
{
    private $title;
    
    /**
     * @param string $title
     */
    public function __construct($title = "")
    {
        $this->title = $title;
    }
    
    /**
     * @param string $title
     * @return \Dataservice\Html\CRUD\Header
     */
    public static function factory($title = "")
    {
	return new Header($title);
    }
    
    /**
     * @return string
     */
    public function getHtml()
    {
	return '<h1 class="header1">'.$this->title.'</h1>';
    }
    
    public function render()
    {
	echo $this->getHtml();
    }
}