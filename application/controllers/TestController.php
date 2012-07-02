<?php

/**
 * 
 * @author jessie
 *
 */

class TestController extends Zend_Controller_Action
{
    protected $_request;
    protected $_params;
    
    public function init(){
	$this->_request	    = $this->getRequest();
	$this->_params	    = $this->_request->getParams();
	$this->view->headLink()->appendStylesheet('/css/test.css');
    }

    public function indexAction()
    {	
	#--Get Auth Instance
        $auth = Zend_Auth::getInstance();

	#--Check if user logged in
        if (!$auth->hasIdentity()) {
	    $this->_helper->redirector('index', 'login');
	    exit();
	}
	ini_set('max_execution_time', 123456);
	set_time_limit(240);
	
	$cache_prices	= array();
	$codebuilder	= new Services\Codebuilder\Codebuilder;
	$widths		= array(12,18,20,22,24);
	$lengths	= array(21,26,31,36,41);
	//$leg_heights	= array("regular" => range(5, 12), "boxed_eave" => range(6, 12), "vertical" => range(6, 12));
	$i		= 0;
	$sku		= 1000;
	$types		= array(
				"carports" => array(
				    "standard"	=> array(
					"regular"   => array(
					    "name"	    => "Standard Carport - Regular Roof",
					    "url"	    => "standard-carport-regular-roof",
					    "categories"    => "5,9,11,13,14,51,52,56",
					    "code"	    => "AAMCCPRAAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A standard style carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A standard style carport to protect you or your things.",
					    "price_location" => "nt",
					    "image"	    => "/standard_regular_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_ne_texas,us_central",
					    "leg_heights"    => range(5, 12)
					),
					"boxed_eave"   => array(
					    "name"	    => "Standard Carport - Boxed Eave Roof",
					    "url"	    => "standard-carport-boxed-eave-roof",
					    "categories"    => "5,9,12,13,14,51,52,57",
					    "code"	    => "AAMCCPBAAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A boxed eave roof carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A boxed eave roof carport to protect you or your things.",
					    "price_location" => "nt",
					    "image"	    => "/standard_boxed_eave_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_ne_texas,us_central",
					    "leg_heights"    => range(6, 12)
					),
					"vertical"   => array(
					    "name"	    => "Standard Carport - Vertical Roof",
					    "url"	    => "standard-carport-vertical-roof",
					    "categories"    => "5,9,61,13,14,51,52,62",
					    "code"	    => "AAMCCPVAAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A vertical roof carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A vertical roof carport to protect you or your things.",
					    "price_location" => "nt",
					    "image"	    => "/standard_vertical_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_ne_texas,us_central",
					    "leg_heights"    => range(6, 12)
					),
				    ),
				    "high_wind"	=> array(
					"regular"   => array(
					    "name"	    => "High Wind Carport - Regular Roof",
					    "url"	    => "high-wind-carport-regular-roof",
					    "categories"    => "16,17,18,21",
					    "code"	    => "AAMCCPRWAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A standard style carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our high wind model is perfect for locations where damaging winds and rains can occur. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A standard style carport to protect you or your things.",
					    "price_location" => "fl",
					    "image"	    => "/standard_regular_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_florida",
					    "leg_heights"    => range(5, 12)
					),
					"boxed_eave"   => array(
					    "name"	    => "High Wind Carport - Boxed Eave Roof",
					    "url"	    => "high-wind-carport-boxed-eave-roof",
					    "categories"    => "16,17,18,22",
					    "code"	    => "AAMCCPBWAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A boxed eave roof carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our high wind model is perfect for locations where damaging winds and rains can occur. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A boxed eave roof carport to protect you or your things.",
					    "price_location" => "fl",
					    "image"	    => "/standard_boxed_eave_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_florida",
					    "leg_heights"    => range(6, 12)
					),
					"vertical"   => array(
					    "name"	    => "High Wind Carport - Vertical Roof",
					    "url"	    => "high-wind-carport-vertical-roof",
					    "categories"    => "16,17,18,64",
					    "code"	    => "AAMCCPVWAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A vertical roof carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our high wind model is perfect for locations where damaging winds and rains can occur. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A vertical roof carport to protect you or your things.",
					    "price_location" => "fl",
					    "image"	    => "/standard_vertical_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_florida",
					    "leg_heights"    => range(6, 12)
					),
				    ),
				    "snow_wind"	=> array(
					"regular"   => array(
					    "name"	    => "Snow and Wind Carport - Regular Roof",
					    "url"	    => "snow-wind-carport-regular-roof",
					    "categories"    => "24,25,26,27",
					    "code"	    => "AAMCCPRSAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A standard style carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our snow and wind model is constructed to sustain the damaging winds and snow loads of your area. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A standard style carport to protect you or your things.",
					    "price_location" => "ne",
					    "image"	    => "/standard_regular_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_northeast",
					    "leg_heights"    => range(5, 12)
					),
					"boxed_eave"   => array(
					    "name"	    => "Snow and Wind Carport - Boxed Eave Roof",
					    "url"	    => "snow-wind-carport-boxed-eave-roof",
					    "categories"    => "24,25,26,28",
					    "code"	    => "AAMCCPBSAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A boxed eave roof carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our snow and wind model is constructed to sustain the damaging winds and snow loads of your area. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A boxed eave roof carport to protect you or your things.",
					    "price_location" => "ne",
					    "image"	    => "/standard_boxed_eave_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_northeast",
					    "leg_heights"    => range(6, 12)
					),
					"vertical"   => array(
					    "name"	    => "Snow and Wind Carport - Vertical Roof",
					    "url"	    => "snow-wind-carport-vertical-roof",
					    "categories"    => "24,25,26,65",
					    "code"	    => "AAMCCPVSAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A vertical roof carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our snow and wind model is constructed to sustain the damaging winds and snow loads of your area. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A vertical roof carport to protect you or your things.",
					    "price_location" => "ne",
					    "image"	    => "/standard_vertical_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_northeast",
					    "leg_heights"    => range(6, 12)
					),
				    ),
				    "high_snow_wind"	=> array(
					"regular"   => array(
					    "name"	    => "High Snow and Wind Carport - Regular Roof",
					    "url"	    => "high-snow-wind-carport-regular-roof",
					    "categories"    => "15,33,34,35",
					    "code"	    => "AAMCCPRXAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A standard style carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our snow and wind model is constructed to sustain the damaging winds and snow loads of your area. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A standard style carport to protect you or your things.",
					    "price_location" => "mi",
					    "image"	    => "/standard_regular_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_michigan",
					    "leg_heights"    => range(5, 12)
					),
					"boxed_eave"   => array(
					    "name"	    => "High Snow and Wind Carport - Boxed Eave Roof",
					    "url"	    => "high-snow-wind-carport-boxed-eave-roof",
					    "categories"    => "15,33,34,36",
					    "code"	    => "AAMCCPBXAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A boxed eave roof carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our snow and wind model is constructed to sustain the damaging winds and snow loads of your area. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A boxed eave roof carport to protect you or your things.",
					    "price_location" => "mi",
					    "image"	    => "/standard_boxed_eave_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_michigan",
					    "leg_heights"    => range(6, 12)
					),
					"vertical"   => array(
					    "name"	    => "High Snow and Wind Carport - Vertical Roof",
					    "url"	    => "high-snow-wind-carport-vertical-roof",
					    "categories"    => "15,33,34,63",
					    "code"	    => "AAMCCPVXAB%sAC%sAD%sAINO_AJNO_AE%sAF%sAG%sAH%sALNO_AKNO_",
					    "short_description"	=> "A vertical roof carport to protect you or your things.",
					    "description"   => "Carports are one of the easiest and most cost ".
								"effective ways of protecting your car, truck, boat, or possessions".
								"from the sun and weather. Our carports ".
								"are made of steel and can stand the test of time. ".
								"Our snow and wind model is constructed to sustain the damaging winds and snow loads of your area. ".
								"With free installation and delivery in our service areas you can't beat these deals.",
					    "meta"	    => "carport, standard roof, cover, patio, car cover, boat cover, truck cover",
					    "meta_desc"	    => "A vertical roof carport to protect you or your things.",
					    "price_location" => "mi",
					    "image"	    => "/standard_vertical_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 0,
					    "visible_stores" => "us_michigan",
					    "leg_heights"    => range(6, 12)
					),
				    )
				),
				"garages" => array(
				    "standard"	=> array(
					"regular"   => array(
					    "name"	    => "Standard Single Car Garage - Regular Roof",
					    "url"	    => "standard-single-car-garage-regular-roof",
					    "categories"    => "13,5,43,14,51,53,66,69",
					    "code"	    => "AAMCCPRAAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel standard style garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, standard roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A standard style single car garage to protect your car, truck, boat or anything you want to keep safe.",
					    "price_location" => "nt",
					    "image"	    => "/standard_regular_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_ne_texas,us_central",
					    "leg_heights"    => range(9, 12)
					),
					"boxed_eave"   => array(
					    "name"	    => "Standard Single Car Garage - Boxed Eave Roof",
					    "url"	    => "standard-single-car-garage-boxed-eave-roof",
					    "categories"    => "13,5,43,14,51,53,67,70",
					    "code"	    => "AAMCCPBAAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel boxed eave roof garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, boxed eave roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A boxed eave roof single car garage to protect you or your things.",
					    "price_location" => "nt",
					    "image"	    => "/standard_boxed_eave_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_ne_texas,us_central",
					    "leg_heights"    => range(9, 12)
					),
					"vertical"   => array(
					    "name"	    => "Standard Single Car Garage - Vertical Roof",
					    "url"	    => "standard-single-car-garage-vertical-roof",
					    "categories"    => "13,5,43,14,51,53,68,71",
					    "code"	    => "AAMCCPVAAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel vertical roof garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, vertical roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A vertical roof single car garage to protect you or your things.",
					    "price_location" => "nt",
					    "image"	    => "/standard_vertical_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_ne_texas,us_central",
					    "leg_heights"    => range(9, 12)
					),
				    ),
				    "high_wind"	=> array(
					"regular"   => array(
					    "name"	    => "High Wind Single Car Garage - Regular Roof",
					    "url"	    => "high-wind-single-car-garage-regular-roof",
					    "categories"    => "16,17,23,75",
					    "code"	    => "AAMCCPRWAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel standard style garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, standard roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A standard style single car garage to protect you or your things.",
					    "price_location" => "fl",
					    "image"	    => "/standard_regular_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_florida",
					    "leg_heights"    => range(9, 12)
					),
					"boxed_eave"   => array(
					    "name"	    => "High Wind Single Car Garage - Boxed Eave Roof",
					    "url"	    => "high-wind-single-car-garage-boxed-eave-roof",
					    "categories"    => "16,17,23,76",
					    "code"	    => "AAMCCPBWAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel boxed eave garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, boxed eave roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A boxed eave roof single car garage to protect you or your things.",
					    "price_location" => "fl",
					    "image"	    => "/standard_boxed_eave_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_florida",
					    "leg_heights"    => range(9, 12)
					),
					"vertical"   => array(
					    "name"	    => "High Wind Single Car Garage - Vertical Roof",
					    "url"	    => "high-wind-single-car-garage-vertical-roof",
					    "categories"    => "16,17,23,77",
					    "code"	    => "AAMCCPVWAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel vertical roof garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, vertical roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A vertical roof single car garage to protect you or your things.",
					    "price_location" => "fl",
					    "image"	    => "/standard_vertical_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_florida",
					    "leg_heights"    => range(9, 12)
					),
				    ),
				    "snow_wind"	=> array(
					"regular"   => array(
					    "name"	    => "Snow and Wind Single Car Garage - Regular Roof",
					    "url"	    => "snow-wind-single-car-garage-regular-roof",
					    "categories"    => "24,25,29,78",
					    "code"	    => "AAMCCPRSAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel standard style garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, standard roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A standard style single car garage to protect you or your things.",
					    "price_location" => "ne",
					    "image"	    => "/standard_regular_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_northeast",
					    "leg_heights"    => range(9, 12)
					),
					"boxed_eave"   => array(
					    "name"	    => "Snow and Wind Single Car Garage - Boxed Eave Roof",
					    "url"	    => "snow-wind-boxed-single-car-garage-eave-roof",
					    "categories"    => "24,25,29,79",
					    "code"	    => "AAMCCPBSAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel boxed eave garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, boxed eave roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A boxed eave roof single car garage to protect you or your things.",
					    "price_location" => "ne",
					    "image"	    => "/standard_boxed_eave_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_northeast",
					    "leg_heights"    => range(9, 12)
					),
					"vertical"   => array(
					    "name"	    => "Snow and Wind Single Car Garage - Vertical Roof",
					    "url"	    => "snow-wind-single-car-garage-vertical-roof",
					    "categories"    => "24,25,29,80",
					    "code"	    => "AAMCCPVSAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel vertical roof garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, vertical roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A vertical roof single car garage to protect you or your things.",
					    "price_location" => "ne",
					    "image"	    => "/standard_vertical_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_northeast",
					    "leg_heights"    => range(9, 12)
					),
				    ),
				    "high_snow_wind"	=> array(
					"regular"   => array(
					    "name"	    => "High Snow and Wind Single Car Garage - Regular Roof",
					    "url"	    => "high-snow-wind-single-car-garage-regular-roof",
					    "categories"    => "15,33,37,72",
					    "code"	    => "AAMCCPRXAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel standard style garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, standard roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A standard style single car garage to protect you or your things.",
					    "price_location" => "mi",
					    "image"	    => "/standard_regular_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_michigan",
					    "leg_heights"    => range(9, 12)
					),
					"boxed_eave"   => array(
					    "name"	    => "High Snow and Wind Single Car Garage - Boxed Eave Roof",
					    "url"	    => "high-snow-wind-boxed-single-car-garage-eave-roof",
					    "categories"    => "15,33,37,73",
					    "code"	    => "AAMCCPBXAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel boxed eave garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, boxed eave roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A boxed eave roof single car garage to protect you or your things.",
					    "price_location" => "mi",
					    "image"	    => "/standard_boxed_eave_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_michigan",
					    "leg_heights"    => range(9, 12)
					),
					"vertical"   => array(
					    "name"	    => "High Snow and Wind Single Car Garage - Vertical Roof",
					    "url"	    => "high-snow-wind-single-car-garage-vertical-roof",
					    "categories"    => "15,33,37,74",
					    "code"	    => "AAMCCPVXAB%sAC%sAD%sAICL_AJCL_AE%sAF%sAG%sAH%sALCL_AKCL_AOHAPHAQHARHAVFRU096096___",
					    "short_description"	=> "An all steel vertical roof garage to protect your car and possessions.",
					    "description"   => "Keep your vehicles and stuff safe from the elements etc. with one of ".
								"our all steel garages. Our garages are extremely durable and can be ".
								"installed on your level land. Choose from the many colors and roof styles".
								"that we offer today.",
					    "meta"	    => "garage, car, vertical roof, storage building, car cover, boat cover, truck cover, shed",
					    "meta_desc"	    => "A vertical roof single car garage to protect you or your things.",
					    "price_location" => "mi",
					    "image"	    => "/standard_vertical_garage_1221.png",
					    "doors"	    => 0,
					    "windows"	    => 0,
					    "garage_doors"  => 1,
					    "visible_stores" => "us_michigan",
					    "leg_heights"    => range(9, 12)
					),
				    )
				)
			    );
	
	$metal_colors	= array(
			    "BR" => "Barn Red",
			    "BL" => "Black",
			    "BY" => "Burgandy",
			    "CL" => "Clay",
			    "EB" => "Earth Brown",
			    "EG" => "Evergreen",
			    "PB" => "Pebble Beige",
			    "PG" => "Pewter Grey",
			    "QG" => "Quaker Grey",
			    "TN" => "Sandstone",
			    "SB" => "Slate Blue",
			    "TN" => "Tan",
			    "WH" => "White",
			);  
	
	$trim_colors	= array(
			    "BR" => "Barn Red",
			    "BL" => "Black",
			    "BY" => "Burgandy",
			    "CL" => "Clay",
			    "EB" => "Earth Brown",
			    "EG" => "Evergreen",
			    "PB" => "Pebble Beige",
			    "PG" => "Pewter Grey",
			    "QG" => "Quaker Grey",
			    "TN" => "Sandstone",
			    "SB" => "Slate Blue",
			    "TN" => "Tan",
			    "WH" => "White",
			); 
	
	$fields		= array("store"				    => "admin",
				"websites"			    => "2",
				"attribute_set"			    => "Metal Buildings",
				"type"				    => "simple",
				"category_ids"			    => "",
				"sku"				    => "",
				"has_options"			    => "0",
				"name"				    => "",
				"url_key"			    => "",
				"country_of_manufacture"	    => "United States",
				"msrp_enabled"			    => "Use config",
				"msrp_display_actual_price_type"    => "Use config",
				"meta_title"			    => "",
				"meta_description"		    => "",
				"image"				    => "",
				"small_image"			    => "",
				"thumbnail"			    => "",
				"custom_design"			    => "",
				"page_layout"			    => "No layout updates",
				"options_container"		    => "Block after Info Column",
				"gift_message_available"	    => "No",
				"url_path"			    => "",
				"image_label"			    => "",
				"small_image_label"		    => "",
				"thumbnail_label"		    => "",
				"price"				    => "",
				"special_price"			    => "",
				"weight"			    => "",
				"msrp"				    => "",
				"status"			    => "Enabled",
				"visibility"			    => "Not Visible Individually",
				"enable_googlecheckout"		    => "Yes",
				"tax_class_id"			    => "Taxable Goods",
				"is_recurring"			    => "No",
				"featured"			    => "No",
				"entry_doors"			    => "0",
				"garage_doors"			    => "0",
				"metal_building_windows"	    => "0",
				"description"			    => "",
				"short_description"		    => "",
				"meta_keyword"			    => "",
				"custom_layout_update"		    => "",
				"news_from_date"		    => "",
				"news_to_date"			    => "",
				"special_from_date"		    => "",
				"special_to_date"		    => "",
				"custom_design_from"		    => "",
				"custom_design_to"		    => "",
				"qty"				    => "0",
				"min_qty"			    => "0",
				"use_config_min_qty"		    => "1",
				"is_qty_decimal"		    => "0",
				"backorders"			    => "0",
				"use_config_backorders"		    => "1",
				"min_sale_qty"			    => "1",
				"use_config_min_sale_qty"	    => "1",
				"max_sale_qty"			    => "0",
				"use_config_max_sale_qty"	    => "1",
				"is_in_stock"			    => "0",
				"low_stock_date"		    => "05/07/12 04:39 PM",
				"notify_stock_qty"		    => "",
				"use_config_notify_stock_qty"	    => "1",
				"manage_stock"			    => "0",
				"use_config_manage_stock"	    => "1",
				"stock_status_changed_auto"	    => "1",
				"use_config_qty_increments"	    => "1",
				"qty_increments"		    => "0",
				"use_config_enable_qty_inc"	    => "1",
				"enable_qty_increments"		    => "0",
				"stock_status_changed_automatically"=> "1",
				"use_config_enable_qty_increments"  => "1",
				"product_name"			    => "",
				"store_id"			    => "0",
				"product_type_id"		    => "simple",
				"product_status_changed"	    => "",
				"product_changed_websites"	    => "",
				"metal_building_code"		    => "",
				"metal_building_metal_color"	    => "tan",
				"metal_building_trim_color"	    => "white",
				"metal_building_width"		    => "",
				"metal_building_length"		    => "",
				"metal_building_leg_height"	    => "",
				"configurable_attributes"	    => "",
				"simples_skus"			    => ""
		);		    
	
	foreach($types as $type => $models){
	    foreach($models as $model => $roof_types){		
		foreach ($roof_types as $roof_type => $values){
		$file_path	= "C:\\Users\\Jessie\\Documents\\SourceGit\\Store.Winslowsinc\\var\\import\\import_".$type."_".$model."_".$roof_type.".csv";
		$fp		= fopen($file_path, 'w');
		fwrite($fp, "\xEF\xBB\xBF");
		fputcsv($fp, array_keys($fields), ",", '"');
		    foreach($widths as $width){
			foreach($lengths as $length){
			    foreach($values["leg_heights"] as $leg_height){
				$name			= $values["name"]." - ".$width."X".$length."X".$leg_height;
				$url			= $values["url"]."-".$width.$length.str_pad($leg_height, 2, "0", STR_PAD_LEFT);
				$temp_fields		= $fields;
				$simple_skus		= array();
				
				foreach($metal_colors as $metal_color_key => $metal_color){
				    foreach($trim_colors as $trim_color_key => $trim_color){
					
					$temp_fields		= $fields;
					$code			= sprintf(
								    $values["code"], 
								    (string)$width, 
								    (string) $length, 
								    str_pad($leg_height, 2, "0", STR_PAD_LEFT),
								    $metal_color_key,
								    $trim_color_key,
								    $metal_color_key,
								    $metal_color_key
								);
					if(!isset($cache_prices[$type.$model.$roof_type.$width.$length.$leg_height])){
					    $price_array = $codebuilder->getPriceFromCode($code, $values["price_location"]);
					    $cache_prices[$type.$model.$roof_type.$width.$length.$leg_height] = str_replace(",", "", (string)$price_array["price"]);
					}
					
					$temp_fields["category_ids"]	    = $values["categories"];
					$temp_fields["sku"]		    = "W".$sku."_".$metal_color_key."_".$trim_color_key;
					$temp_fields["name"]		    = $name;
					$temp_fields["url_key"]		    = $name;
					$temp_fields["description"]	    = $values["description"];
					$temp_fields["short_description"]   = $values["short_description"];
					$temp_fields["meta_description"]    = $name;
					$temp_fields["meta_title"]	    = $values["meta_desc"];
					$temp_fields["meta_keyword"]	    = $values["meta"];
					$temp_fields["image"]		    = $values["image"];
					$temp_fields["small_image"]	    = $values["image"];
					$temp_fields["thumbnail"]	    = $values["image"];
					$temp_fields["url_path"]	    = $url.".html";
					$temp_fields["image_label"]	    = $name;
					$temp_fields["small_image_label"]   = $name;
					$temp_fields["thumbnail_label"]	    = $name;
					$temp_fields["price"]		    = $cache_prices[$type.$model.$roof_type.$width.$length.$leg_height];
					$temp_fields["product_name"]	    = $name;
					$temp_fields["metal_building_code"] = $code;
					$temp_fields["metal_building_width"]	    = $width;
					$temp_fields["metal_building_length"]	    = $length;
					$temp_fields["metal_building_leg_height"]   = $leg_height;
					$temp_fields["metal_building_metal_color"]  = $metal_color;
					$temp_fields["metal_building_trim_color"]   = $trim_color;

					fputcsv($fp, $temp_fields, ",", '"');
					//if($i<200)Zend_Debug::dump($temp_fields);
					
					$simple_skus[] = "W".$sku."_".$metal_color_key."_".$trim_color_key;
					$i++;
				    }
				}
				
				foreach(array("admin", $values["visible_stores"]) as $store){
				    $code = sprintf(
						$values["code"], 
						(string)$width, 
						(string) $length, 
						str_pad($leg_height, 2, "0", STR_PAD_LEFT),
						"TN",
						"WH",
						"TN",
						"TN"
					    );
				    if(!isset($cache_prices[$type.$model.$roof_type.$width.$length.$leg_height])){
					$price_array = $codebuilder->getPriceFromCode($code, $values["price_location"]);
					$cache_prices[$type.$model.$roof_type.$width.$length.$leg_height] = str_replace(",", "", (string) $price_array["price"]);
				    }

				    $temp_fields["category_ids"]			= $values["categories"];
				    $temp_fields["sku"]					= "W".$sku;
				    $temp_fields["name"]				= $name;
				    $temp_fields["type"]				= "configurable";
				    $temp_fields["url_key"]				= $name;
				    $temp_fields["description"]				= $values["description"];
				    $temp_fields["short_description"]			= $values["short_description"];
				    $temp_fields["meta_description"]			= $name;
				    $temp_fields["meta_title"]				= $values["meta_desc"];
				    $temp_fields["meta_keyword"]			= $values["meta"];
				    $temp_fields["image"]				= $values["image"];
				    $temp_fields["small_image"]				= $values["image"];
				    $temp_fields["thumbnail"]				= $values["image"];
				    $temp_fields["url_path"]				= $url.".html";
				    $temp_fields["image_label"]				= $name;
				    $temp_fields["small_image_label"]			= $name;
				    $temp_fields["thumbnail_label"]			= $name;
				    $temp_fields["price"]				= $cache_prices[$type.$model.$roof_type.$width.$length.$leg_height];
				    $temp_fields["product_name"]			= $name;
				    $temp_fields["metal_building_code"]			= $code;
				    $temp_fields["metal_building_width"]		= $width;
				    $temp_fields["metal_building_length"]		= $length;
				    $temp_fields["metal_building_leg_height"]		= $leg_height;
				    $temp_fields["metal_building_metal_color"]		= "Tan";
				    $temp_fields["metal_building_trim_color"]		= "White";
				    $temp_fields["product_type_id"]			= "configurable";
				    $temp_fields["configurable_attributes"]		= (string) "metal_building_metal_color,metal_building_trim_color";
				    $temp_fields["simples_skus"]			= (string) implode(",",$simple_skus);
				    $temp_fields["has_options"]				= "1";
				    $temp_fields["stock_status_changed_auto"]		= "0";
				    $temp_fields["stock_status_changed_automatically"]	= "0";
				    $temp_fields["visibility"]				= $store == "admin" ? "Not Visible Individually" : "Catalog,Search";
				    $temp_fields["store"]				= $store;

				    fputcsv($fp, $temp_fields, ",", '"');
				    //if($i<200)Zend_Debug::dump($temp_fields);
				}
				
				$i++;
				$sku++;
			    }
			}
		    }
		    fclose($fp);	
		}	
	    }
	}
	
	echo "$i records";
    }

    public function addpersonAction(){
	$data = $this->_params;
	$form = new Form_EmployeeAddComplete();
	
	if($this->_request->isPost()){
	    if($form->isValid($data)){
		$flashMessenger = $this->_helper->getHelper('FlashMessenger');
		try {
		    $em		    = $this->_helper->EntityManager();
		    $employee	    = new \Entities\Employee;
		    $personaddress  = new \Entities\PersonAddress;
		    $webaccount	    = new \Entities\Webaccount;

		    if(isset($data['webaccount']['username']))$webaccount->setUsername($data['webaccount']['username']);
		    if(isset($data['webaccount']['username']))$webaccount->setPassword ($data['webaccount']['password']);
		    
		    if(isset($data['employee']['title']))$employee->setTitle($data['employee']['title']);
		    if(isset($data['person']['first_name']))$employee->setFirstName($data['person']['first_name']);
		    if(isset($data['person']['middle_name']))$employee->setMiddleName($data['person']['middle_name']);
		    if(isset($data['person']['last_name']))$employee->setLastName($data['person']['last_name']);
		    if(isset($data['person']['suffix']))$employee->setSuffix ($data['person']['suffix']);

		    if(isset($data['address']['name']))$personaddress->setName($data['address']['name']);
		    if(isset($data['address']['address_1']))$personaddress->setAddress1($data['address']['address_1']);
		    if(isset($data['address']['address_2']))$personaddress->setAddress2($data['address']['address_2']);
		    if(isset($data['address']['city']))$personaddress->setCity($data['address']['city']);
		    if(isset($data['address']['state']))$personaddress->setState($data['address']['state']);
		    if(isset($data['address']['zip_1']))$personaddress->setZip1($data['address']['zip_1']);
		    if(isset($data['address']['zip_2']))$personaddress->setZip2($data['address']['zip_2']);

		    $employee->addPersonAddress($personaddress);
		    $employee->setWebaccount($webaccount);
		    $em->persist($employee);
		    $em->flush();

		    $flashMessenger->addMessage(array('message' => 'Employee Added', 'status' => 'success'));
		    $this->_redirect('/test');

		} catch (Exception $exc) {
		    $flashMessenger->addMessage(array('message' => $exc->getMessage(), 'status' => 'error'));
		    $this->_redirect('/test');
		}
	    }
	    else{
		$form->populate($data);
	    }
	}
	$this->view->form = $form;	
    }
    
    public function testAction(){
	/* @var $em \Doctrine\ORM\EntityManager */
	$em	= $this->_helper->EntityManager();
	$menu	= new Entities\Menu;
	$name	= "Top";
	$menu->setName($name);
	
	$menuitem = new \Entities\MenuItem;
	$menuitem->setLabel("Home");
	$menuitem->setLinkModule("default");
	$menuitem->setLinkController("index");
	$menuitem->setLinkAction("index");
	$menuitem->setLinkParams("");
	$menuitem->setNameIndex("home");
	$menuitem->setIcon("house.png");
	
	$menu->addMenuItem($menuitem);
	
	$menuitem = new \Entities\MenuItem;
	$menuitem->setLabel("Sales");
	$menuitem->setLinkModule("default");
	$menuitem->setLinkController("sales");
	$menuitem->setLinkAction("index");
	$menuitem->setLinkParams("");
	$menuitem->setNameIndex("sales");
	$menuitem->setIcon("money.png");
	
	$submenuitem = new \Entities\MenuItem;
	$submenuitem->setLabel("Sales");
	$submenuitem->setLinkModule("default");
	$submenuitem->setLinkController("sales");
	$submenuitem->setLinkAction("inventory");
	$submenuitem->setLinkParams("");
	$submenuitem->setNameIndex("inventory");
	$submenuitem->setIcon("inventory.png");
	
	$menuitem->AddChild($submenuitem);	
	$menu->addMenuItem($menuitem);
	
	$em->persist($menu);
	$em->flush();
	
	/* @var $menu \Repositories\Men */
	$menu   = $em->getRepository('Entities\Menu');
	Zend_Debug::dump($menu->findAll());
	exit;
    }
    
    public function codetohtmlAction(){
	$this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
	
	$code	    = "";	
	$state	    = "";
	
	if(isset($this->_params['state'])){
	    $state = $this->_params['state'];
	}
	
	if(isset($this->_params['code'])){
	    $code = $this->_params['code'];
	}
	
	$parser		    = \Services\Codebuilder\Factory::factoryParser();
	$validator	    = \Services\Codebuilder\Factory::factoryValidator();
	$pricing	    = \Services\Codebuilder\Factory::factoryPricing();
	$BuilderArrayMapper    = \Services\Codebuilder\Factory::factoryBuilderArrayMapper();
	$errors	    = array();
	$warnings   = array();
	$price	    = 0;
	
	try {
	    $options	= $parser->parseToArray($code);
	    $validator->validateArray($BuilderArrayMapper, $options, $state);
	    $warnings	= $validator->getWarnings();
	    $errors	= $validator->getErrors();
	    if(count($errors)<1)$price	= $pricing->price($BuilderArrayMapper, $options);
	} catch (Exception $exc) {
	    $errors[] = $exc->getMessage();
	}
	echo "<h4 style='background-color:red'>".implode("<br />", $errors)."</h4>";
	echo "<h4 style='background-color:yellow'>".implode("<br />", $warnings)."</h4>";
	if(!$errors){
	    echo "$".$price;
	    echo "<h3>".$code."</h3>";

//	    foreach($options as $option_code => $option_array)
//	    {
//		foreach($option_array as $option)
//		{
//		    echo "<h3>".$option['details']['name']."</h3>";
//		    echo "<ol>";
//		    foreach ($option['values'] as $value) {
//			echo "<li>".$value['details']['name'].": ".$value['value_option']['name']."</li>";
//		    }
//		    echo "</ol>";
//		}
//	    }
	}
//	
//	echo "<pre>";
//	print_r($options);
//	echo "</pre>";
    }

    public function testinsertAction(){
	/* @var $em \Doctrine\ORM\EntityManager */
//	$em		    = $this->_helper->EntityManager();
//	/* @var $value \Entities\CbValue */
//	$value		    = $em->getRepository("\Entities\CbValue")->findOneById(56);
//
//	if($value){
//	foreach(range(1, 40) as $inches){
//	    $valueoption = new Entities\CbValueOption;
//	    $valueoption->setName($inches);
//	    $valueoption->setCode(str_pad($inches, 2, "0", STR_PAD_LEFT));
//	    $valueoption->setDescription("");
//	    $value->AddValueOption($valueoption);
//	    $em->persist($value);
//	}	
//	
//	    $em->flush();
//	}
//	exit;
    }

}

