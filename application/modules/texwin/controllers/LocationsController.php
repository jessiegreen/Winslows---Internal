<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Texwin_LocationsController extends Dataservice_Controller_Action
{

    public function __initAction() {
	
    }
    
    public function indexAction()
    {
	$this->view->headTitle()->append('Locations');
        require_once APPLICATION_PATH.'/models/Locations.php';
        
        $searchRadius = $_POST['distance'];
        $searchzipcode = $_POST['zipcode'];
        $searchcity = $_POST['city'];
        $searchstate = $_POST['state'];

        $searchAddress = $searchcity.'+'.$searchstate.'+'.$searchzipcode;
        if(empty($searchcity) && empty($searchzipcode) )     $searchAddress = '516 Twilight Trail 75080'  ;
        if(!is_numeric($searchRadius))      $searchRadius = '';
        $locations = new Locations();

        $location_array = $locations->getLocations($searchAddress,$searchRadius);
        $this->view->assign('locations', $location_array['results']);
        $this->view->assign('searchkey', $location_array['searchkey']);

        $form = new Zend_Form;

        $state = new Zend_Form_Element_Select('state');
        $state->setLabel('State')
              ->setMultiOptions(array('tx'=>'Texas', 'ok'=>'Oklahoma'))
              ->setValue($searchstate);;

        $city = new Zend_Form_Element_Text('city');
        $city->setLabel('City')
             ->setValue($searchcity);

        $zipcode = new Zend_Form_Element_Text('zipcode');
        $zipcode->setLabel('Zip Code')
                ->setValue($searchzipcode);

        $distance = new Zend_Form_Element_Select('distance');
        $distance->setLabel('Miles')
              ->setMultiOptions(array('5'=>'5','10'=>'10','15'=>'15','25'=>'25','50'=>'50','100'=>'100', '150'=>'150'))
              ->setValue(($searchRadius ? $searchRadius : "50"));



        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Search');
        
        
        $form->addElements(array($state, $city,
            $zipcode, $distance, $submit));


        $form->setAction('/locations/index');
        $form->setMethod('POST');
        $form->setAttrib('id', 'login');
        $this->view->form = $form;

    }

    public function testAction()
    {

        $form = new Zend_Form;
        $form->addElement('text','address', array('label' => 'Address','validators' => array('alnum')));
        $form->addElement('text','distance', array('label' => 'Distance','validators' => array('alnum')));
        $form->addElement('submit', 'Search', array('label' => 'Login'));

        $form->setAction('index');
        $form->setMethod('get');
        $form->setAttrib('id', 'login');
        echo $form->render($view);
        
    }


}

?>
