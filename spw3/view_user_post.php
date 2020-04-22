<?php 
session_start();

if(!isset($_SESSION["username"])){

header("location: login.php");
}
else {

?>



<html>
	<head>
		<title>User Panel</title>
	
	<link rel="stylesheet" href="admin_style.css" />
	</head>
	
<body>
<div id="header">

<h1>Welcome "<?php echo $_SESSION['username'];?>"</h1>

</div> 

<div id="sidebar">
<h2><a href="logout.php">Logout</a></h2>
<h2><a href="view_user_post.php">View Posts</a></h2>
<!--<h2><a href="index.php?insert=insert">Inser New Post</a></h2>-->
<h2><a href="insert_user_post.php">Inser New Post</a></h2>
<h2><a href="index.php">Go to live BLOG</a></h2>
<!--<h2><a href="#">View Comments</a></h2>-->

</div>

<table width="1000" border="2" align="center" bgcolor="pink"> 
	<tr>
		<td colspan="10" align="center" bgcolor="yellow"><h1>View All Posts</h1></td>
	</tr>
	
	<tr bgcolor="orange">
		<th>Post No</th>
		<th>Post Date</th>
		<th>Post Author</th>
		<th>Post Title:</th>
		<th>Post Post Image</th>
		<th>Post Content</th>
		<th>Delete Post</th>
		<th>Edit Post</th>
	</tr>
<?php 
include("includes/connect.php");

$queryforuserid = "select * from users where username='".$_SESSION['username']."'"; //order by 1 DESC";
$runthequery = mysqli_query($con,$queryforuserid);
while($output=mysqli_fetch_array($runthequery)){
$id = $output['id'];
}


$query = "select * from posts where user_id='$id'";//order by 1 DESC"; 


$run = mysqli_query($con,$query);

while($row=mysqli_fetch_array($run)){

	$post_id = $row['post_id'];
	$post_date = $row['post_date'];
	$post_author = $row['post_author'];
	$post_title = $row['post_title'];
	$post_image = $row['post_image'];
	$post_content= substr($row['post_content'],0,100);
?>
<tr align="center">
		<td><?php echo $post_id; ?></td>
		<td><?php echo $post_date; ?></td>
		<td><?php echo $post_author; ?></td>
		<td><?php echo $post_title; ?></td>
		<td><img src="images/<?php echo $post_image; ?>" width="100" height="100"></td>
		<td><?php echo $post_content; ?></td>
		<td><a href="delete.php?del=<?php echo $post_id; ?>">Delete</a></td>
		<td><a href="edit_posts.php?edit=<?php echo $post_id; ?>">Edit</a></td>
	</tr>
<?php } ?>

</table>


</body>
</html>

<?php } ?>