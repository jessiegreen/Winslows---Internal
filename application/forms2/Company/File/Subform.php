<?php
namespace Forms\Company\File;

class Subform extends \Zend_Form_SubForm
{
    private $_File;
    
    public function __construct( \Entities\Company\File\FileAbstract $File, $options = null)
    {
	$this->_File = $File;
	
	parent::__construct($options);
    }
    
    public function init()
    {		
	$this->addElement('text', 'name', array(
            'required'	    => false,
            'label'	    => 'Name:',
	    'belongsTo'	    => 'file',
	    'value'	    => $this->_File ? $this->_File->getName() : ""
        ));
	
	$this->addElement('textarea', 'description', array(
            'required'	    => false,
	    'cols'	    => 75,
	    'rows'	    => 10,
            'label'	    => 'Description:',
	    'belongsTo'	    => 'file',
	    'value'	    => $this->_File ? $this->_File->getDescription() : ""
        ));
	
	$this->addElement('file', 'file', array(
            'required'	    => true,
            'label'	    => 'File:',
	    'belongsTo'	    => 'file'
        ));
    }
}