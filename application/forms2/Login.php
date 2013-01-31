<?php
namespace Forms;

class Login extends \Zend_Form
{
    public function init($options = array())
    {
        $username = $this->addElement('text', 'username', array(
            'required'   => true,
            'label'      => 'Username:',
        ));

        $password = $this->addElement('password', 'password', array(
            'filters'    => array('StringTrim'),
            'required'   => true,
            'label'      => 'Password:',
        ));

        $login = $this->addElement('submit', 'login', array(
            'ignore'   => true,
        ));

    }
}