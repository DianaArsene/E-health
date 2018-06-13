<?php
session_start();


// captcha generator
//Load captcha library
include_once "libs/captcha/Captcha.php";
$captcha = new CoolCaptcha\Captcha();
//We want random data
$captcha->wordsFile = '';
$captcha->shadowColor = [0, 0, 0];
$captcha->blur = TRUE;
$captcha->createImage();
$_SESSION['captcha_image'] = $captcha->im;