<div id="main_content">
<?php 

include("includes/connect.php");

$select_posts = "select * from posts order by post_date DESC";

$run_posts = mysqli_query($con,$select_posts);

while($row=mysqli_fetch_array($run_posts)){

	$post_id = $row['post_id']; 
	$post_title = $row['post_title'];
	$post_date = $row['post_date'];
	$post_author = $row['post_author'];
	$post_image = $row['post_image'];
	$post_content = substr($row['post_content'],0,200);



?>

<h2>
<a href="pages.php?id=<?php echo $post_id; ?>">
</a>

</h2>
<h6 class="heading"><?php echo $post_title; ?></h6>
<p align="left">Published on:&nbsp;&nbsp;<b><?php echo $post_date; ?></b></p>

<p align="right">Posted by:&nbsp;&nbsp;<b><?php echo $post_author; ?></b></p>

<center><img src="images/<?php echo $post_image; ?>" width="500" height="300" /></center>

<p align="justify"><?php echo $post_content; ?></p>

<p align="right"><a href="pages.php?id=<?php echo $post_id; ?>" style="color:white">Read More</a></p>
<hr>

<?php } ?>
</div>

