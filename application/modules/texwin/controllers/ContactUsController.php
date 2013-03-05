<?php
/**
 * Description of IndexController
 *
 * @author Jessie
 */

class Texwin_ContactUsController extends Dataservice_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {	    
	#--Set title
	$this->view->headTitle()->append("Contact Us");

	require_once APPLICATION_PATH.'/classes/__Forms.php';
	require_once APPLICATION_PATH.'/models/Contacts.php';
	require_once APPLICATION_PATH.'/models/Users.php';
	require_once APPLICATION_PATH.'/models/Locations.php';
	$__Forms = new __Forms();
	$Contacts = new Contacts;
	$Users = new Users;
	$Locations = new Locations();

	$form = $__Forms->formContactUsContact();
	$element = $form->getElement('submit');  
	$element->removeDecorator('label');
	$form_display = $form;
	#--If form is submitted
	if ($this->getRequest()->isPost()) {
	    #--Get post data
	    $formData = $this->getRequest()->getPost();
	    #--Check if posted data is valid
	    if ($form->isValid($formData)) {
		$data = $form->getValues();

		$Users->insertRow(
			array(
			    'users_full_name'	=> $data['name'],
			    'users_email'	=> $data['email'],
			    'users_address'	=> $data['location'],
			    'users_phone1'	=> $data['number'],
			    'users_credentials_id' => '3'
			)
		);
		#--Get db connection from registry stored there in bootstrap
		$db = Zend_Registry::get('db');
		$insert_id = $db->lastInsertId();
		$Contacts->insertRow(
			array(
			    'contacts_users_id' => $insert_id,
			    'contacts_comments'	=> $data['comments'],
			    'contacts_type_1' => $data['type1'],
			    'contacts_type_2' => $data['type2'],
			    'contacts_type_3' => $data['type3'],
			    'contacts_type_4' => $data['type4']
			)
		);

		$form_display = "<div class='form_success'>";
		$form_display .= "<div class='success_message'>Thank you for contacting us.</div>";
		$form_display .= 'Name :'.htmlspecialchars($data['name']).'<br />';
		$form_display .= 'Phone:'.htmlspecialchars($data['number']).'<br />';
		$form_display .= 'Email:'.htmlspecialchars($data['email']).'<br />';
		$form_display .= 'Comments:'.htmlspecialchars($data['comments']);
		$form_display .= "</div>";

		$mail = new Zend_Mail();
		$mail->setBodyHtml($form_display);
		$mail->setFrom('donotreply@texwin.com', 'Texwin - Contact');
//		$mail->addTo('winslowssales@gmail.com', 'Mike Winslow');
		$mail->setSubject('ATTN: Texwin - New Web Contact');
		$mail->send();

	    }
	    else {
		#--If data not valid rerender form with submitted data and errors displayed
		$form->populate($formData);
	    }
	}
	$this->view->assign('form',$form_display);
    }
}

