<?php
// Copyright (c) 2009-2012 Andreas Baumgart
// 
// This source file is subject to the MIT license that is bundled with this 
// package in the file LICENSE.txt.

/**
 * @see Dataservice_Filter_ImageSize_Strategy_Interface 
 */
require_once 'Dataservice/Filter/ImageSize/Strategy/Interface.php';

/**
 * Strategy for resizing the image so that its smalles edge fits into the frame.
 * The rest is cropped.
 */
class Dataservice_Filter_ImageSize_Strategy_Crop 
    implements Dataservice_Filter_ImageSize_Strategy_Interface
{
    /**
     * Return canvas resized according to the given dimensions.
     * @param resource $image GD image resource
     * @param int $width Output width
     * @param int $height Output height
     * @return resource GD image resource
     */
    public function resize($image, $width, $height)
    {
        $origWidth = imagesx($image);
        $origHeight = imagesy($image);
        // ratio = 473 / 600 = .788
        $ratio = $origWidth / $origHeight;
        //$w = 600 * .788 = 472
//        $w = $origWidth * $ratio;
//        $h = $origHeight * $ratio;
        
        $cropped = imagecreatetruecolor($width, $height);
	
	if ($ratio < 1) 
	{ // "tall" crop
	    $cropWidth = min($origHeight * $ratio, $origWidth);
	    $cropHeight = $cropWidth / $ratio;
	} 
	else 
	{ // "wide" crop
	    $cropHeight = min($origWidth / $ratio, $origHeight);
	    $cropWidth = $cropHeight * $ratio;
	}
	
      //imagecopyresampled(resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
        imagecopyresampled($cropped            , $image              , 0          , 0          , 0          , 0          , $width     , $height    , $cropWidth , $cropHeight);
	
        return $cropped;
    }
}

//if ($imagetype[1] == "jpg" || $imagetype[1] == "JPG") 
//{
//    $im		= imagecreatefromjpeg($add);
//    $width	= imagesx($im);
//    $height	= imagesy($im);
//    $newimage	= imagecreatetruecolor($n_width, $n_height);
//
//
//    $ar		= 1.00;
//
//    if ($ar < 1) 
//    { // "tall" crop
//	$cropWidth = min($height * $ar, $width);
//	$cropHeight = $cropWidth / $ar;
//    } 
//    else 
//    { // "wide" crop
//	$cropHeight = min($width / $ar, $height);
//	$cropWidth = $cropHeight * $ar;
//    }
//
//    imagecopyresized($newimage, $im, 0, 0, 0, 0, $n_width, $n_height, $cropWidth, $cropHeight);
//    imagejpeg($newimage, $tsrc, 100);
//}