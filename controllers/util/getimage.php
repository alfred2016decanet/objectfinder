<?php
ini_set("memory_limit", "128M");

include('../../config/config.php');

if(empty($_GET['mode']))$mode="resize";else $mode=$_GET['mode'];
if($_GET['force']=='1')$force=true;else $force=false;
if(!empty($_GET['format']))$format=$_GET['format'];else $format='';
if(empty($_GET['filigrane']))$filigrane=0;else $filigrane = 1;

$c_img=new Image();
echo $c_img->getMini($_GET['img'], $_GET['large'], $_GET['haut'], $mode, $format, $force, $filigrane );
?>
