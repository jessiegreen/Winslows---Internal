<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of __Login
 *
 * @author Jessie
 */
class Form_Login_Login extends Zend_Form
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

?>
