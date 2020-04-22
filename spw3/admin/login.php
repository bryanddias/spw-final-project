<?php 
header('X-Frame-Options: DENY');

// **PREVENTING SESSION HIJACKING**
// Prevents javascript XSS attacks aimed to steal the session ID
ini_set('session.cookie_httponly', 1);

// **PREVENTING SESSION FIXATION**
// Session ID cannot be passed through URLs
ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
ini_set('session.cookie_secure', 1);


include "../csrf.php";

session_start();
?>

<html>
	<head>
		<title>Admin Login</title>
	</head>

<body bgcolor="gray">
	
	<form method="post" action="login.php">
	
		<table width="400" border="10" align="center" bgcolor="pink">
			
			<tr>
				<td bgcolor="yellow" colspan="4" align="center"><h1>Admin Login form</h1></td>
			</tr>
		
			<tr>
				<td align="right">User Name:</td>
				<td><input type="text" name="user_name" autocomplete="off" required></td>
			</tr>
			
			<tr>
				<td align="right">User Password:</td>
				<td><input type="password" name="user_pass" autocomplete="off" required></td>
			</tr>
			<input type="hidden" name="_token" class="form-control" value="<?php echo $_session['_token'];?>"/>
			<tr>
				<td colspan="4" align="center"><input type="submit" name="login" value="Login"></td>
			</tr>
		
		
		</table>
	</form>

</body>
</html>
<?php 
include("includes/connect.php");

if(isset($_POST['login'])){
	
	$user_name = mysqli_real_escape_string($con,$_POST['user_name']);
	$user_pass = mysqli_real_escape_string($con,$_POST['user_pass']);
	

	$admin_query = "select * from admin_login where user_name='$user_name'";


	

	$run = mysqli_query($con,$admin_query); 

	$row1 = mysqli_fetch_assoc($run);
	$passfromdb = $row1["user_pass"];
	if (password_verify($user_pass, $passfromdb)) {


	
	
	$row=mysqli_fetch_assoc($run);
	$_SESSION['idd']=$row["user_id"];
	$_SESSION['user_name']=$user_name;
	
	
	echo "<script>window.open('index.php','_self')</script>";
	}
	else {
	
	echo "<script>alert('User name or password is incorrect')</script>";
	
	}
}


?>