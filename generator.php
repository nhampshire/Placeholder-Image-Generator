<?php
/**
 * Image Placeholder Generator
 * Author: Nick Hampshire
 * Date Created: 22/01/2015
 * See in use at nhampshire.com/images/
 *
 * Notes:
 * specify width and height of image using  url parameters
 * w = width
 * h = height
 * If no h parameter is defined then it will use the width parameter, creating a square.
 * If neither are defined then a 500x500 image will be created.
 *
 * If the specified values are greater than 5000 then a 500x500 image will be created. 
 */
$width = 500;
$height = 500;
$fontSize = 5; //default size 1-5, 5 being largest

/** 
 * Splitting these into their rgb values incase I end up adding color change functionality
 **/
//bg
$bg_r = 200;
$bg_g = 200;
$bg_b = 200;
//text
$t_r = 255;
$t_g = 255;
$t_b = 255;

/** 
 * If height isn't specified then it will use the width value (generating a square)
 */
if(isset($_GET['w']))
{
	$width = $_GET['w'];
	if(intval($width) < 1 || intval($width > 5000)) //if isn't a valid integer or too large
	{
		$width = 500;
	}
	if(isset($_GET['h']))
	{
		$height = $_GET['h'];
		if(intval($height) < 1 || intval($width > 5000)) //if isn't a valid integer or too large
		{
			$height = 500;
		}
	}
	else
	{
		$height = $width;
	}
}

$text = $width."x".$height; //text to add to image

/**
 * Cases where text won't fit on image
 **/
if($width < 50 || $height <50)
{
	$fontSize = 3; //reduce text size to fit
}
if($width < 40 || $height < 40)
{
	$text = ''; //too small to fit text
}

/**
 * Centering text/offsetting based on width and height of text
 **/
$fontWidth = imagefontwidth($fontSize);
$textHeight = imagefontheight($fontSize);
$textLength = strlen($text);          // number of characters
$textWidth = $textLength * $fontWidth;              // text width
$xPos = ($width - $textWidth)/2;
$yPos = ($height - $textHeight)/2;


/** 
 * Finally create and output the image
 */
header("Content-Type: image/png");
$outputImage = @imagecreate($width, $height)
    or die("Something went wrong");
$background_color = imagecolorallocate($outputImage, $bg_r, $bg_g, $bg_b);
$text_color = imagecolorallocate($outputImage, $t_r, $t_g, $t_b);
imagestring ($outputImage, $fontSize, $xPos, $yPos, $text, $text_color);
imagepng($outputImage);
imagedestroy($outputImage);

?>
