<?php
namespace Services\Company\Supplier\Product\Configurable\Instance\MetalBuildingAbstract\Pricer;

class Data extends \Services\Company\Supplier\Product\Configurable\Instance\Pricer\DataAbstract
{
    #STATIC METHODS AND PROPERTIES ONLY!!!
    
    /**
     * array(RoofTypeCode_WindSnowLoadCode => array(FrameSize => value)
     * @var array
     */
    static protected $_base_prices = 
		    array(
			#Regular Roof _ Regular Wind Snow
			"1_1" => array(
			    "12X21" => 595,
			    "12X26" => 895,
			    "12X31" => 1095,
			    "12X36" => 1295,
			    "12X41" => 1495,
			    "18X21" => 695,
			    "18X26" => 995,
			    "18X31" => 1195,
			    "18X36" => 1395,
			    "18X41" => 1695,
			    "20X21" => 995,
			    "20X26" => 1195,
			    "20X31" => 1495,
			    "20X36" => 1795,
			    "20X41" => 2095,
			    "22X21" => 1195,
			    "22X26" => 1495,
			    "22X31" => 1795,
			    "22X36" => 2095,
			    "22X41" => 2495,
			    "24X21" => 1295,
			    "24X26" => 1595,
			    "24X31" => 1995,
			    "24X36" => 2295,
			    "24X41" => 2695
		    ),
		    #Boxed Roof _ Regular Wind Snow
		    "2_1" => array(
			    "12X21" => 695,
			    "12X26" => 995,
			    "12X31" => 1195,
			    "12X36" => 1395,
			    "12X41" => 1695,
			    "18X21" => 795,
			    "18X26" => 1095,
			    "18X31" => 1395,
			    "18X36" => 1595,
			    "18X41" => 1895,
			    "20X21" => 1095,
			    "20X26" => 1295,
			    "20X31" => 1595,
			    "20X36" => 1895,
			    "20X41" => 2295,
			    "22X21" => 1295,
			    "22X26" => 1595,
			    "22X31" => 1895,
			    "22X36" => 2195,
			    "22X41" => 2695,
			    "24X21" => 1495,
			    "24X26" => 1895,
			    "24X31" => 2195,
			    "24X36" => 2595,
			    "24X41" => 3095
		    ),
		    #Vertical Roof _ Regular Wind Snow
		    "3_1" => array(
			    "12X21" => 995,
			    "12X26" => 1395,
			    "12X31" => 1695,
			    "12X36" => 1995,
			    "12X41" => 2295,
			    "18X21" => 1095,
			    "18X26" => 1495,
			    "18X31" => 1795,
			    "18X36" => 2095,
			    "18X41" => 2495,
			    "20X21" => 1295,
			    "20X26" => 1695,
			    "20X31" => 1995,
			    "20X36" => 2395,
			    "20X41" => 2695,
			    "22X21" => 1595,
			    "22X26" => 1995,
			    "22X31" => 2395,
			    "22X36" => 2795,
			    "22X41" => 3295,
			    "24X21" => 1695,
			    "24X26" => 2095,
			    "24X31" => 2595,
			    "24X36" => 2995,
			    "24X41" => 3495
		    ),
		    #Rgular Roof _ High Wind
		    "1_2" => array(
			    "12X21" => 695,
			    "12X26" => 995,
			    "12X31" => 1295,
			    "12X36" => 1495,
			    "12X41" => 1695,
			    "18X21" => 795,
			    "18X26" => 1195,
			    "18X31" => 1395,
			    "18X36" => 1595,
			    "18X41" => 1895,
			    "20X21" => 1095,
			    "20X26" => 1395,
			    "20X31" => 1695,
			    "20X36" => 1995,
			    "20X41" => 2295,
			    "22X21" => 1295,
			    "22X26" => 1695,
			    "22X31" => 1995,
			    "22X36" => 2295,
			    "22X41" => 2695,
			    "24X21" => 1495,
			    "24X26" => 1895,
			    "24X31" => 2295,
			    "24X36" => 2695,
			    "24X41" => 3095
		    ),
		    #Boxed Roof _ High Wind
		    "2_2" => array(
			    "12X21" => 795,
			    "12X26" => 1095,
			    "12X31" => 1395,
			    "12X36" => 1595,
			    "12X41" => 1895,
			    "18X21" => 895,
			    "18X26" => 1295,
			    "18X31" => 1595,
			    "18X36" => 1795,
			    "18X41" => 2095,
			    "20X21" => 1195,
			    "20X26" => 1495,
			    "20X31" => 1795,
			    "20X36" => 2095,
			    "20X41" => 2495,
			    "22X21" => 1395,
			    "22X26" => 1795,
			    "22X31" => 2095,
			    "22X36" => 2495,
			    "22X41" => 2895,
			    "24X21" => 1595,
			    "24X26" => 1995,
			    "24X31" => 2395,
			    "24X36" => 2795,
			    "24X41" => 3295
		    ),
		    #Vertical Roof _ High Wind
		    "3_2" => array(
			    "12X21" => 1095,
			    "12X26" => 1495,
			    "12X31" => 1895,
			    "12X36" => 2195,
			    "12X41" => 2495,
			    "18X21" => 1195,
			    "18X26" => 1695,
			    "18X31" => 1995,
			    "18X36" => 2295,
			    "18X41" => 2695,
			    "20X21" => 1495,
			    "20X26" => 1895,
			    "20X31" => 2295,
			    "20X36" => 2695,
			    "20X41" => 3095,
			    "22X21" => 1695,
			    "22X26" => 2195,
			    "22X31" => 2595,
			    "22X36" => 2995,
			    "22X41" => 3495,
			    "24X21" => 1895,
			    "24X26" => 2395,
			    "24X31" => 2795,
			    "24X36" => 3395,
			    "24X41" => 3895
		    ),
		    #Regular Roof _ Snow Wind
		    "1_3" => array(
			    "12X21" => 695,
			    "12X26" => 995,
			    "12X31" => 1295,
			    "12X36" => 1495,
			    "12X41" => 1695,
			    "18X21" => 795,
			    "18X26" => 1195,
			    "18X31" => 1395,
			    "18X36" => 1595,
			    "18X41" => 1895,
			    "20X21" => 1095,
			    "20X26" => 1395,
			    "20X31" => 1695,
			    "20X36" => 1995,
			    "20X41" => 2295,
			    "22X21" => 1295,
			    "22X26" => 1695,
			    "22X31" => 1995,
			    "22X36" => 2295,
			    "22X41" => 2695,
			    "24X21" => 1495,
			    "24X26" => 1895,
			    "24X31" => 2295,
			    "24X36" => 2695,
			    "24X41" => 3095
		    ),
		    #Boxed Roof _ Snow Wind
		    "2_3" => array(
			    "12X21" => 795,
			    "12X26" => 1095,
			    "12X31" => 1395,
			    "12X36" => 1595,
			    "12X41" => 1895,
			    "18X21" => 895,
			    "18X26" => 1295,
			    "18X31" => 1595,
			    "18X36" => 1795,
			    "18X41" => 2095,
			    "20X21" => 1195,
			    "20X26" => 1495,
			    "20X31" => 1795,
			    "20X36" => 2095,
			    "20X41" => 2495,
			    "22X21" => 1395,
			    "22X26" => 1795,
			    "22X31" => 2095,
			    "22X36" => 2495,
			    "22X41" => 2895,
			    "24X21" => 1595,
			    "24X26" => 1995,
			    "24X31" => 2395,
			    "24X36" => 2795,
			    "24X41" => 3295
		    ),
		    #Vertical Roof _ Snow Wind
		    "3_3" => array(
			    "12X21" => 1095,
			    "12X26" => 1495,
			    "12X31" => 1895,
			    "12X36" => 2195,
			    "12X41" => 2495,
			    "18X21" => 1195,
			    "18X26" => 1695,
			    "18X31" => 1995,
			    "18X36" => 2295,
			    "18X41" => 2695,
			    "20X21" => 1495,
			    "20X26" => 1895,
			    "20X31" => 2295,
			    "20X36" => 2695,
			    "20X41" => 3095,
			    "22X21" => 1695,
			    "22X26" => 2195,
			    "22X31" => 2595,
			    "22X36" => 2995,
			    "22X41" => 3495,
			    "24X21" => 1895,
			    "24X26" => 2395,
			    "24X31" => 2795,
			    "24X36" => 3395,
			    "24X41" => 3895
		    ),
		    #Regular Roof _ High Snow Wind
		    "1_4" => array(
			    "12X21" => 995,
			    "12X26" => 1295,
			    "12X31" => 1595,
			    "12X36" => 1895,
			    "12X41" => 2095,
			    "18X21" => 1095,
			    "18X26" => 1395,
			    "18X31" => 1695,
			    "18X36" => 1995,
			    "18X41" => 2295,
			    "20X21" => 1495,
			    "20X26" => 1895,
			    "20X31" => 2295,
			    "20X36" => 2695,
			    "20X41" => 3095,
			    "22X21" => 1895,
			    "22X26" => 2395,
			    "22X31" => 2895,
			    "22X36" => 3395,
			    "22X41" => 3895,
			    "24X21" => 2095,
			    "24X26" => 2595,
			    "24X31" => 3195,
			    "24X36" => 3795,
			    "24X41" => 4295
		    ),
		    #Boxed Roof _ High Snow Wind
		    "2_4" => array(
			    "12X21" => 1095,
			    "12X26" => 1395,
			    "12X31" => 1695,
			    "12X36" => 1995,
			    "12X41" => 2295,
			    "18X21" => 1195,
			    "18X26" => 1495,
			    "18X31" => 1795,
			    "18X36" => 2095,
			    "18X41" => 2495,
			    "20X21" => 1595,
			    "20X26" => 1995,
			    "20X31" => 2395,
			    "20X36" => 2795,
			    "20X41" => 3295,
			    "22X21" => 1995,
			    "22X26" => 2495,
			    "22X31" => 2995,
			    "22X36" => 3495,
			    "22X41" => 4095,
			    "24X21" => 2195,
			    "24X26" => 2695,
			    "24X31" => 3295,
			    "24X36" => 3895,
			    "24X41" => 4495
		    ),
		    #Vertical Roof _ High Snow Wind
		    "3_4" => array(
			    "12X21" => 1395,
			    "12X26" => 1695,
			    "12X31" => 2095,
			    "12X36" => 2495,
			    "12X41" => 2895,
			    "18X21" => 1495,
			    "18X26" => 1895,
			    "18X31" => 2295,
			    "18X36" => 2695,
			    "18X41" => 3095,
			    "20X21" => 1895,
			    "20X26" => 2395,
			    "20X31" => 2895,
			    "20X36" => 3395,
			    "20X41" => 3895,
			    "22X21" => 2295,
			    "22X26" => 2895,
			    "22X31" => 3495,
			    "22X36" => 4095,
			    "22X41" => 4695,
			    "24X21" => 2495,
			    "24X26" => 3095,
			    "24X31" => 3695,
			    "24X36" => 4395,
			    "24X41" => 5095
		    )
	    );
    
    /**
     * Gable Price from carport price sheet
     * @var int 
     */
    protected static $_wall_end_gable_noncertified_price = 150;
    
    /**
     * Gable Price from carport price sheet
     * @var int 
     */
    protected static $_wall_end_gable_certified_price = 175;
    
    /**
     * Vertical addition are from pricing for upgrades and additions sheet
     * @var int
     */
    protected static $_wall_end_gable_vertical_price = 50;
    
    /**
     * Frame width indexes
     * @var array
     */
    protected static $_wall_end_closed_vertical_pricing_array = 
	    array(
		"12" => 100,
		"18" => 200,	
		"20" => 225,
		"22" => 250,
		"24" => 275
	    );
    
    /**
     * These are half of the Both Sides Closed Vertical Prices
     * Frame length indexes 
     * @var array 
     */
    protected static $_wall_side_closed_vertical_pricing_array = 
	    array(
		"21" => 100,
		"26" => 125,	
		"31" => 150,
		"36" => 175,
		"41" => 200
	    );

    /**
     * array("width" => array(FrameWidth => array("leg_height" => array(LegHeight => value)
     * @var array 
     */
    protected static $_wall_end_closed_uncertified_prices_array = 
	    array(
		"width" => array(
		    "12" => array(
			"leg_height" => array(
			    "5"  => 350,
			    "6"  => 375,
			    "7"  => 425,
			    "8"  => 475,
			    "9"  => 500,
			    "10" => 575,
			    "11" => 650,
			    "12" => 725
			)
		    ),
		    "18" => array(
			"leg_height" => array(
			    "5"  => 420,
			    "6"  => 450,
			    "7"  => 505,
			    "8"  => 560,
			    "9"  => 590,
			    "10" => 680,
			    "11" => 770,
			    "12" => 860
			)
		    ),
		    "20" => array(
			"leg_height" => array(
			    "5"  => 490,
			    "6"  => 525,
			    "7"  => 585,
			    "8"  => 645,
			    "9"  => 680,
			    "10" => 785,
			    "11" => 890,
			    "12" => 995
			)
		    ),
		    "22" => array(
			"leg_height" => array(
			    "5"  => 560,
			    "6"  => 600,
			    "7"  => 665,
			    "8"  => 730,
			    "9"  => 770,
			    "10" => 890,
			    "11" => 1010,
			    "12" => 1130
			)
		    ),
		    "24" => array(
			"leg_height" => array(
			    "5"  => 630,
			    "6"  => 675,
			    "7"  => 745,
			    "8"  => 815,
			    "9"  => 860,
			    "10" => 995,
			    "11" => 1130,
			    "12" => 1265
			)
		    )
		)
	    );
    
    /**
     * array("width" => array(FrameWidth => array("leg_height" => array(LegHeight => value)
     * @var array 
     */
    protected static $_wall_end_closed_certified_prices_array = 
	    array(
		"width"   => array( 
		    "12"	=> array(
			"leg_height" => array(
			    "5"  => 400,
			    "6"  => 425,
			    "7"  => 475,
			    "8"  => 525,
			    "9"  => 550,
			    "10" => 625,
			    "11" => 700,
			    "12" => 775 
			)
		    ),
		    "18"	=> array(
			"leg_height" => array(
			    "5"  => 510,
			    "6"  => 540,
			    "7"  => 595,
			    "8"  => 650,
			    "9"  => 680,
			    "10" => 760,
			    "11" => 840,
			    "12" => 920 
			)
		    ),
		    "20"	=> array(
			"leg_height" => array(
			    "5"  => 620,
			    "6"  => 655,
			    "7"  => 715,
			    "8"  => 775,
			    "9"  => 810,
			    "10" => 895,
			    "11" => 980,
			    "12" => 1065 
			)
		    ),
		    "22"	=> array(
			"leg_height" => array(
			    "5"  => 730,
			    "6"  => 770,
			    "7"  => 835,
			    "8"  => 900,
			    "9"  => 940,
			    "10" => 1030,
			    "11" => 1120,
			    "12" => 1210
			)
		    ),
		    "24"	=> array(
			"leg_height" => array(
			    "5"  => 840,
			    "6"  => 885,
			    "7"  => 955,
			    "8"  => 1025,
			    "9"  => 1070,
			    "10" => 1185,
			    "11" => 1260,
			    "12" => 1355
			)
		    )
		)
	    );
    
    /**
     * These are half of the Both Sides Closed Prices
     * array("length" => array(FrameLength => array("leg_height" => array(LegHeight => value)
     * @var array 
     */
    protected static $_wall_side_closed_prices_array = 
	    array(
		"length"   => array(
		    "21"	=> array(
			"leg_height" => array(
			    "5"  => 137.50,
			    "6"  => 150,
			    "7"  => 175,
			    "8"  => 212.50,
			    "9"  => 225,
			    "10" => 250,
			    "11" => 287.50,
			    "12" => 300
			)
		    ),
		    "26"	=> array(
			"leg_height" => array(
			    "5"  => 172.50,
			    "6"  => 187.50,
			    "7"  => 217.50,
			    "8"  => 260,
			    "9"  => 277.50,
			    "10" => 310,
			    "11" => 355,
			    "12" => 375
			)
		    ),
		    "31"	=> array(
			"leg_height" => array(
			    "5"  => 207.50,
			    "6"  => 225,
			    "7"  => 260,
			    "8"  => 307.50,
			    "9"  => 330,
			    "10" => 370,
			    "11" => 422.50,
			    "12" => 450
			)
		    ),
		    "36"	=> array(
			"leg_height" => array(
			    "5"  => 242.50,
			    "6"  => 262.50,
			    "7"  => 302.50,
			    "8"  => 355,
			    "9"  => 382.50,
			    "10" => 430,
			    "11" => 490,
			    "12" => 525
			)
		    ),
		    "41"	=> array(
			"leg_height" => array(
			    "5"  => 275,
			    "6"  => 300,
			    "7"  => 345,
			    "8"  => 402.50,
			    "9"  => 435,
			    "10" => 490,
			    "11" => 557.50,
			    "12" => 600
			)
		    ),
		)
	    );
    
    /**
     * array("leg_height" => array(LegHeight => array("length" => array(FrameLength => value)
     * @var array 
     */
    protected static $_leg_height_prices_standard = 
			    array(
				"leg_height" => array(
					"5"	=> array(
					    "length" => array(
						"21" => 0,
						"26" => 0,
						"31" => 0,
						"36" => 0,
						"41" => 0
					    )
					),
					"6"	=> array(
					    "length" => array(
						"21" => 50,
						"26" => 60,
						"31" => 75,
						"36" => 85,
						"41" => 100
					    )
					),
					"7"	=> array(
					    "length" => array(
						"21" => 100,
						"26" => 120,
						"31" => 150,
						"36" => 170,
						"41" => 200
					    )
					),
					"8"	=> array(
					    "length" => array(
						"21" => 150,
						"26" => 180,
						"31" => 225,
						"36" => 255,
						"41" => 300
					    )
					),
					"9"	=> array(
					    "length" => array(
						"21" => 200,
						"26" => 240,
						"31" => 300,
						"36" => 340,
						"41" => 400
					    )
					),
					"10"	=> array(
					    "length" => array(
						"21" => 250,
						"26" => 300,
						"31" => 375,
						"36" => 425,
						"41" => 500
					    )
					),
					"11"	=> array(
					    "length" => array(
						"21" => 300,
						"26" => 360,
						"31" => 450,
						"36" => 510,
						"41" => 600
					    )
					),
					"12"	=> array(
					    "length" => array(
						"21" => 350,
						"26" => 420,
						"31" => 525,
						"36" => 595,
						"41" => 700
					    )
					),
				)
			    );
    
    /**
     * array("leg_height" => array(LegHeight => array("length" => array(FrameLength => value)
     * @var array 
     */
    protected static $_leg_height_prices_aframe = 
			    array(
				"leg_height" => array(
					"6"	=> array(
					    "length" => array(
						"21" => 0,
						"26" => 0,
						"31" => 0,
						"36" => 0,
						"41" => 0
					    )
					),
					"7"	=> array(
					    "length" => array(
						"21" => 50,
						"26" => 60,
						"31" => 75,
						"36" => 85,
						"41" => 100
					    )
					),
					"8"	=> array(
					    "length" => array(
						"21" => 100,
						"26" => 120,
						"31" => 150,
						"36" => 170,
						"41" => 200
					    )
					),
					"9"	=> array(
					    "length" => array(
						"21" => 150,
						"26" => 180,
						"31" => 225,
						"36" => 255,
						"41" => 300
					    )
					),
					"10"	=> array(
					    "length" => array(
						"21" => 200,
						"26" => 240,
						"31" => 300,
						"36" => 340,
						"41" => 400
					    )
					),
					"11"	=> array(
					    "length" => array(
						"21" => 250,
						"26" => 300,
						"31" => 375,
						"36" => 425,
						"41" => 500
					    )
					),
					"12"	=> array(
					    "length" => array(
						"21" => 300,
						"26" => 360,
						"31" => 450,
						"36" => 510,
						"41" => 600
					    )
					)
				)
			    );
    
    /**
     * array("leg_height" => array(LegHeight => array("length" => array(FrameLength => value)
     * @var array 
     */
    protected static $_leg_height_prices_snow_standard = 
			    array(
				"leg_height" => array(
					"5"	=> array(
					    "length" => array(
						"21" => 0,
						"26" => 0,
						"31" => 0,
						"36" => 0,
						"41" => 0
					    )
					),
					"6"	=> array(
					    "length" => array(
						"21" => 60,
						"26" => 70,
						"31" => 80,
						"36" => 90,
						"41" => 100
					    )
					),
					"7"	=> array(
					    "length" => array(
						"21" => 120,
						"26" => 140,
						"31" => 160,
						"36" => 180,
						"41" => 200
					    )
					),
					"8"	=> array(
					    "length" => array(
						"21" => 180,
						"26" => 210,
						"31" => 240,
						"36" => 270,
						"41" => 300
					    )
					),
					"9"	=> array(
					    "length" => array(
						"21" => 240,
						"26" => 280,
						"31" => 320,
						"36" => 360,
						"41" => 400
					    )
					),
					"10"	=> array(
					    "length" => array(
						"21" => 300,
						"26" => 350,
						"31" => 400,
						"36" => 450,
						"41" => 500
					    )
					),
					"11"	=> array(
					    "length" => array(
						"21" => 360,
						"26" => 420,
						"31" => 480,
						"36" => 540,
						"41" => 600
					    )
					),
					"12"	=> array(
					    "length" => array(
						"21" => 420,
						"26" => 490,
						"31" => 560,
						"36" => 630,
						"41" => 700
					    )
					),
				)
			    );
    
    /**
     * array("leg_height" => array(LegHeight => array("length" => array(FrameLength => value)
     * @var array 
     */
    protected static $_leg_height_prices_snow_aframe = 
			    array(
				"leg_height" => array(
					"6"	=> array(
					    "length" => array(
						"21" => 0,
						"26" => 0,
						"31" => 0,
						"36" => 0,
						"41" => 0
					    )
					),
					"7"	=> array(
					    "length" => array(
						"21" => 60,
						"26" => 70,
						"31" => 80,
						"36" => 90,
						"41" => 100
					    )
					),
					"8"	=> array(
					    "length" => array(
						"21" => 120,
						"26" => 140,
						"31" => 160,
						"36" => 180,
						"41" => 200
					    )
					),
					"9"	=> array(
					    "length" => array(
						"21" => 180,
						"26" => 210,
						"31" => 240,
						"36" => 270,
						"41" => 300
					    )
					),
					"10"	=> array(
					    "length" => array(
						"21" => 240,
						"26" => 280,
						"31" => 320,
						"36" => 360,
						"41" => 400
					    )
					),
					"11"	=> array(
					    "length" => array(
						"21" => 300,
						"26" => 350,
						"31" => 400,
						"36" => 450,
						"41" => 500
					    )
					),
					"12"	=> array(
					    "length" => array(
						"21" => 360,
						"26" => 420,
						"31" => 480,
						"36" => 540,
						"41" => 600
					    )
					)
				)
			    );
				    
    /**
     * Panel Length Indexes. Panels are 3' wide
     * @var array 
     */
    static protected $_panel_prices = 
			array(
			    "21" => 75, 
			    "26" => 90, 
			    "31" => 105, 
			    "36" => 120
			    );
    
    /**
     * Frame width Indexes
     * Random price from Mike
     * @var array 
     */
    static protected $_wall_end_partial_coverage_bracing_prices = 
			array(
			    "12" => 150, 
			    "18" => 150, 
			    "20" => 150, 
			    "22" => 175, 
			    "24" => 175
			);
    
    /**
     * Frame length Indexes
     * @var array 
     */
    static protected $_frame_gauge_12_gauge_prices = 
			array(
			    "21" => 100,
			    "26" => 125,
			    "31" => 150,
			    "36" => 175,
			    "41" => 200
			);
    
    /**
     * Frame gauge then frame length Indexes
     * @var array 
     */
    static protected $_certified_wind_snow_load_wind_snow_array = 
		    array(
			"0" => array(
			    "21" => 100,
			    "26" => 125,
			    "31" => 150,
			    "36" => 175,
			    "41" => 200
			),
			"16" => array(
			    "21" => 100,
			    "26" => 125,
			    "31" => 150,
			    "36" => 175,
			    "41" => 200
			),
			"14" => array(
			    "21" => 100,
			    "26" => 125,
			    "31" => 150,
			    "36" => 175,
			    "41" => 200
			),
			"12" => array(
			    "21" => 400,
			    "26" => 500,
			    "31" => 600,
			    "36" => 700,
			    "41" => 800
			)
		    );
    
    /**
     * Frame length Indexes
     * @var array 
     */
    static protected $_certified_wind_snow_load_standard_array = 
		    array(
			"21" => 200,
			"26" => 250,
			"31" => 300,
			"36" => 350,
			"41" => 400
		    );
    
    /**
     * @var float
     */
    static protected $_jtrim_per_foot_price = 1.00;

    /**
     * @var float
     */
    static protected $_auger_anchors_price = 25.00;
    
    /**
     * @var array
     */
    static protected $_extra_braces_array = array(
	"2" => array(
	    "21" => 60,
	    "26" => 80,
	    "31" => 100,
	    "36" => 120,
	    "41" => 140,
	),
	"4" => array(
	    "21" => 90,
	    "26" => 120,
	    "31" => 150,
	    "36" => 180,
	    "41" => 210,
	)
    );

    /**
     * @return array
     */
    static public function getLegHeightPrice($roof_WS_key, $leg_height, $frame_length)
    {
	$array = array(
		    "1_1" => self::$_leg_height_prices_standard,
		    "2_1" => self::$_leg_height_prices_aframe,
		    "3_1" => self::$_leg_height_prices_aframe,
		    "1_2" => self::$_leg_height_prices_standard,
		    "2_2" => self::$_leg_height_prices_aframe,
		    "3_2" => self::$_leg_height_prices_aframe,
		    "1_3" => self::$_leg_height_prices_standard,
		    "2_3" => self::$_leg_height_prices_aframe,
		    "3_3" => self::$_leg_height_prices_aframe,
		    "1_4" => self::$_leg_height_prices_snow_standard,
		    "2_4" => self::$_leg_height_prices_snow_aframe,
		    "3_4" => self::$_leg_height_prices_snow_aframe
		);
	
	return $array[$roof_WS_key]
			["leg_height"][self::_formatNumberForIndex($leg_height)]
			["length"][self::_formatNumberForIndex($frame_length, 0, "", "")];
    }
    
    /**
     * @return array
     */
    static public function getBasePrice($roof_WS_key, $frame_size)
    {
	$base_prices_array = self::$_base_prices;
	
	return $base_prices_array[$roof_WS_key][$frame_size];
    }
    
    /**
     * @return array
     */
    static public function getWallsPricesArray()
    {
	return self::$_walls_prices_array;
    }
    
    /**
     * @return array
     */
    static public function getFrameGauge12Price($frame_length)
    {
	$array = self::$_frame_gauge_12_gauge_prices;
	
	return $array[self::_formatNumberForIndex($frame_length)];
    }
    
    /**
     * @param string $frame_width
     * @return array
     */
    static public function getWallEndPartialCoverageBracingPrice($frame_width)
    {
	$price_array = self::$_wall_end_partial_coverage_bracing_prices;
	
	return (float) $price_array[self::_formatNumberForIndex($frame_width)];
    }
    
    static public function getWallEndPartialCoverageBracingWidths()
    {
	return array_keys(self::$_wall_end_partial_coverage_bracing_prices);
    }
    
    /**
     * @param string $panel_length 21, 26, 31, 36, 41
     * @return array
     */
    static public function getPanelPrice($panel_length)
    {
	$price_array = self::$_panel_prices;
	
	return $price_array[self::_formatNumberForIndex($panel_length)];
    }
    
    /**
     * @return type
     */
    static public function getPanelSizes()
    {
	return array_keys(self::$_panel_prices);
    }
    
    /**
     * @return array
     */
    static public function getWallsPartialCoverageSidePanelPricesArray()
    {
	return self::$_walls_partial_coverage_side_panel_prices;
    }
    
    /**
     * @return float
     */
    static public function getWallEndGableCertifiedPrice()
    {
	return (float) self::$_wall_end_gable_certified_price;
    }
    
    /**
     * @return float
     */
    static public function getWallEndGableUnCertifiedPrice()
    {
	return (float) self::$_wall_end_gable_noncertified_price;
    }
    
    /**
     * @param string $frame_width
     * @param string $leg_height
     * @return float
     */
    static public function getWallEndClosedUnCertifiedPrice($frame_width, $leg_height)
    {
	$price_array = self::$_wall_end_closed_uncertified_prices_array;
	
	return (float) $price_array["width"][self::_formatNumberForIndex($frame_width)]
				    ["leg_height"][self::_formatNumberForIndex($leg_height)];
    }
    
    /**
     * @param string $frame_width
     * @param string $leg_height
     * @return float
     */
    static public function getWallEndClosedCertifiedPrice($frame_width, $leg_height)
    {
	$price_array = self::$_wall_end_closed_certified_prices_array;
	
	return (float) $price_array["width"][self::_formatNumberForIndex($frame_width)]
				    ["leg_height"][self::_formatNumberForIndex($leg_height)];
    }
    
    /**
     * @param string $frame_length
     * @param string $leg_height
     * @return float
     */
    static public function getWallSideClosedPrice($frame_length, $leg_height)
    {
	$price_array = self::$_wall_side_closed_prices_array;
	
	return (float) $price_array["length"][self::_formatNumberForIndex($frame_length)]
				    ["leg_height"][self::_formatNumberForIndex($leg_height)];
    }
    
    /**
     * @return float
     */
    static public function getWallEndGableVerticalPrice()
    {
	return (float) self::$_wall_end_gable_vertical_price;
    }
    
    /**
     * @param string $frame_length
     * @return float
     */
    static public function getWallSideClosedVerticalPrice($frame_length)
    {
	$price_array = self::$_wall_side_closed_vertical_pricing_array;
	
	return (float) $price_array[self::_formatNumberForIndex($frame_length)];
    }
    
    static public function getWallSideClosedVerticalFrameLengthsArray()
    {
	return array_keys(self::$_wall_side_closed_vertical_pricing_array);
    }
    
    /**
     * @param string $frame_width
     * @return float
     */
    static public function getWallEndClosedVerticalPrice($frame_width)
    {
	$price_array = self::$_wall_end_closed_vertical_pricing_array;
	
	return (float) $price_array[self::_formatNumberForIndex($frame_width)];
    }
    
    /**
     * @return float
     */
    static public function getJTrimPricePerFoot()
    {
	return (float) self::$_jtrim_per_foot_price;
    }
    
    /**
     * 
     */
    static public function getCertifiedWindSnowLoadStandardPrice($frame_length)
    {
	$array = self::$_certified_wind_snow_load_standard_array;
	
	return (float) $array[self::_formatNumberForIndex($frame_length)];
    }
    
    /**
     * @param string|int|float $frame_gauge
     * @param string|int|float $frame_length
     * @return float
     */
    static public function getCertifiedWindSnowLoadWindSnowPrice($frame_gauge, $frame_length)
    {
	$array = self::$_certified_wind_snow_load_wind_snow_array;
	
	return (float) $array[self::_formatNumberForIndex($frame_gauge)][self::_formatNumberForIndex($frame_length)];
    }
    
    /**
     * @return float
     */
    static public function getAugerAnchorsPrice()
    {
	return self::$_auger_anchors_price;
    }
    
    /**
     * @param string|float|int $size
     * @param string|float|int $frame_length
     * @return float
     */
    static public function getExtraKneeBracesPrice($size, $frame_length)
    {
	$array = self::$_extra_braces_array;
	
	return (float) $array[self::_formatNumberForIndex($size)][self::_formatNumberForIndex($frame_length)];
    }
    
    /**
     * @param string|float|int $size
     * @param string|float|int $frame_length
     * @return float
     */
    static public function getExtraStormBracesPrice($size, $frame_length)
    {
	$array = self::$_extra_braces_array;
	
	return (float) $array[self::_formatNumberForIndex($size)][self::_formatNumberForIndex($frame_length)];
    }
}