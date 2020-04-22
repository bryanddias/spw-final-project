<html>
	<head>
		<title>CAPTAIN SOAP</title>

<link rel="stylesheet" href="style.css" media="all">
	</head>

<body>
<div><?php include("includes/header.php"); ?></div>

<div id="main_content">
<?php 
include("includes/connect.php");

if(isset($_GET['id'])){

$page_id = mysqli_real_escape_string($con,$_GET['id']);

	$select_query = "select * from posts where post_id='$page_id'";

$run_query = mysqli_query($con,$select_query);

while($row=mysqli_fetch_array($run_query)){

	$post_id = $row['post_id']; 
	$post_title = $row['post_title'];
	$post_date = $row['post_date'];
	$post_author = $row['post_author'];
	$post_image = $row['post_image'];
	$post_content =$row['post_content'];



?>

<h2>
<a href="pages.php?id=<?php echo $post_id; ?>">

<center><h6 style="color:white"><?php echo $post_title; ?></h6></center>

</a>

</h2>

<p align="left" style="color:white">Published on:&nbsp;&nbsp;<b><?php echo $post_date; ?></b></p>

<p align="right" style="color:white">Posted by:&nbsp;&nbsp;<b><?php echo $post_author; ?></b></p>

<center><img src="images/<?php echo $post_image; ?>" width="500" height="300" /></center>

<p align="justify" ><center style="color:white"><?php echo $post_content; ?></center></p>


<?php } }?>
</div>







<div id="footer"><b><br><br><center style="color:white">© 2020 CAPTAIN SOAP</center></b></div>




</body>
</html>