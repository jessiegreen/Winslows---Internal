<?php
class Dataservice_View_Helper_Winslows_Index_Banner extends Zend_View_Helper_Abstract
{
    private $current_strings = array("thirteen-years", "holiday-savings", "scratch-dent");
    
    public function Winslows_Index_Banner()
    {
        $strings = array();
        
        foreach($this->current_strings as $string)
        {
            $strings[] = $this->view->partial("index/partials/".$string.".phtml");
        }
        
        return $strings;
    }
}
