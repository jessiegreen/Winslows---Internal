<?php
class Winslows_IndexController extends Dataservice_Controller_Action
{        
    public function indexAction()
    {
	$this->view->headScript()->appendFile("/javascript/winslows/index/index/slider.js");
	$this->view->headScript()->appendFile("/javascript/winslows/index/index/banner.js");

        $this->view->slides = $this->getSliderArray();
    }
    
    private function getSliderArray()
    {
        return array(
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            ),
            array(
                "slide_image"   => "sheet_metal_thumb_1.png",
                "slide_title"   => "Garages"
            )
        );
    }
}

