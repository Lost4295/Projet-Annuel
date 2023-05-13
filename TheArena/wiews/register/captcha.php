<?php
session_start();
header("Content-Type: image/png");



$image = imagecreate(400, 200);


$back = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));

$listOfChars = "abcdefghijklmnopqrstuvwxyz0123456789";
$listOfChars  = str_shuffle($listOfChars);
$captcha = substr($listOfChars, 0, rand(6, 8));
$_SESSION['captcha'] = $captcha;



$listOfFonts = glob("fonts/*.ttf");

$x = 30;

for ($i=0; $i < strlen($captcha); $i++) {

	$listOfColors[] = imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
	imagettftext($image,
		rand(30, 40),
		rand(-30, 30),
		$x,
		rand(80, 120),
		$listOfColors[$i],
		$listOfFonts[array_rand($listOfFonts)],
		$captcha[$i]
    );

	$x += rand(35, 45);
}



$form = rand(2, 4);

for ($i=0; $i<$form; $i++) {

	imageellipse(
		$image,
		rand(0, 400),
		rand(0, 200),
		rand(0, 400),
		rand(0, 200),
		$listOfColors[array_rand($listOfColors)]
    );


	imagerectangle(
		$image,
		rand(0, 400),
		rand(0, 200),
		rand(0, 400),
		rand(0, 200),
		$listOfColors[array_rand($listOfColors)]
    );


	imageline(
		$image,
		rand(0, 400),
		rand(0, 200),
		rand(0, 400),
		rand(0, 200),
		$listOfColors[array_rand($listOfColors)]
    );

}


imagepng($image);
