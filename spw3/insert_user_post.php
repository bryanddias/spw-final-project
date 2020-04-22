<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["username"]))// || $_SESSION["loggedin"] !== true)
{
    header("location: login.php");
    exit;
}
?>


<html>
	<head>
		<title>Insert New Posts</title>
		<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	</head>
	
<body>
<div class="wrapper row0">
<div id="topbar" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="fl_left">
      <ul>
        <li><i class="fa fa-phone"></i> +00 (123) 456 7890</li>
        <li><i class="fa fa-envelope-o"></i> info@domain.com</li>
      </ul>
    </div>
    <div class="fl_right">
      <ul>
        <li><a href="index.php"><i class="fa fa-lg fa-home"></i></a></li>
    
      </ul>
    </div>
    <!-- ################################################################################################ -->
    </div>
</div>
<form method="post" action="insert_user_post.php" enctype="multipart/form-data">
	
	<table width="600" align="center" border="10">
		
		<tr>
			<td align="center" bgcolor="grey" colspan="6"><h1>Insert New Post Here</h1></td>
		</tr>
		
		<tr>
			<td align="right">Post Title:</td>
			<td><input type="text" name="title" size="30" required></td>
		</tr>
		
		<!--<tr>
			<td align="right">Post Author:</td>
			<td><input type="text" name="author" size="30" required></td>
		</tr>-->
		
		<tr>
			<td align="right">Post Keywords:</td>
			<td><input type="text" name="keywords" size="30" required></td>
		</tr>
		
		<tr>
			<td align="right">Post Image:</td>
			<td><input type="file" name="image" accept=".jpeg,.gif,.png" required></td>
		</tr>
		
		<tr>
			<td align="right">Post Content:</td>
			<td><textarea name="content" cols="30" rows="15" required></textarea></td>
		</tr>
		
		<tr>
			<td align="center" colspan="6"><input type="submit" name="submit" value="Publish Now"></td>
		</tr>

	
	</table>
</form>
</body>
</html>
<?php 
include("includes/connect.php"); 

if(isset($_POST['submit'])){

	  $post_title = htmlspecialchars(mysqli_real_escape_string($con,$_POST['title']));
	  $post_date = date('m-d-y h:i:A');
	 // $post_author = mysqli_real_escape_string($con,$_POST['author']);
	  $post_author =$_SESSION["username"];
	  $author_id =$_SESSION["id"];
	  $post_keywords = htmlspecialchars(mysqli_real_escape_string($con,$_POST['keywords']));
	  $post_content = htmlspecialchars(mysqli_real_escape_string($con,$_POST['content']));
	  $post_image= $_FILES['image']['name'];
	  $image_tmp= $_FILES['image']['tmp_name'];



	  $imageinfo = getimagesize($_FILES['image']['tmp_name']); //check image size
if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg') {
    echo "Sorry, we only accept GIF and JPEG images\n";
    exit;
}

	$blacklist = array(".php", ".phtml", ".php3", ".php4");
foreach ($blacklist as $item) {
    if(preg_match("/$item\$/i", $_FILES['image']['name'])) {
        echo "We do not allow uploading PHP files\n";
        exit;
    }
}

	
	
	if($post_title=='' or $post_author=='' or $post_keywords=='' or $post_content=='' or $post_image==''){
	
	echo "<script>alert('Please enter all the fields')</script>";
	exit();
	}

	else {
	
	 move_uploaded_file($image_tmp,"images/$post_image");
	
	  $insert_query = "insert into posts (user_id,post_title,post_date,post_author,post_image,post_keywords,post_content) values ('$author_id','$post_title','$post_date','$post_author','$post_image','$post_keywords','$post_content')";
	
	if(mysqli_query($con,$insert_query)){
	
	echo "<script>alert('post published successfuly')</script>";
	echo "<script>window.open('view_user_post.php','_self')</script>";
	
	}


}


}

/*else{

echo "<script>alert('User name or password is incorrect')</script>";

}*/


?>

<?php  ?>