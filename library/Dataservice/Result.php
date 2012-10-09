<?php
class Dataservice_Result
{
    /**
     * @var bool $_valid
     */
    private $_valid;
    
    /**
     * @var array() $_error_messages 
     */
    private $_error_messages = array();
    
    /**
     * @param bool $starting_value
     */
    public function __construct($starting_value = true)
    {
	$this->_valid = (boolean) $starting_value;
    }

    public function setValidFalse($error_message = "")
    {
	$this->_valid = false;
	
	if($error_message)$this->addErrorMessage($error_message);
    }
    
    public function setValidTrue()
    {
	$this->_valid = true;
    }
    
    public function isValid()
    {
	return $this->_valid;
    }
    
    /**
     * @param string $message
     */
    public function addErrorMessage($message)
    {
	$this->_error_messages[] = (string) $message;
    }
    
    /**
     * @param array $messages
     */
    public function addErrorMessages($messages)
    {
	$this->_error_messages = array_merge($this->_error_messages, $messages);
    }
    
    /**
     * @return array
     */
    public function getErrorMessages()
    {
	return $this->_error_messages;
    }
    
    /**
     * @return string
     */
    public function getDisplayErrorMessages($list_class = "", $item_class = "")
    {
	$string = '<ul class="'.$list_class.'">';
	
	$string .= ltrim(implode('</li><li class="'.$item_class.'">', $this->getErrorMessages()),'</li>');
	
	$string .= '</li></ul>';
	
	return $string;
    }
}