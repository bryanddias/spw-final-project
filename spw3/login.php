<?php
// **PREVENTING SESSION HIJACKING**
// Prevents javascript XSS attacks aimed to steal the session ID
ini_set('session.cookie_httponly', 1);

// **PREVENTING SESSION FIXATION**
// Session ID cannot be passed through URLs
ini_set('session.use_only_cookies', 1);

// Uses a secure connection (HTTPS) if possible
ini_set('session.cookie_secure', 1);
header('X-Frame-Options: DENY');


include "csrf.php";

// Initialize the session
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){


 
// Check if the user is already logged in, if yes then redirect him to welcome page

    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "includes/connect.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = htmlspecialchars(trim($_POST["username"]));
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim(htmlspecialchars($_POST["password"]));
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The username or password you entered is not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Login</title>
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
        <li><i class="fa fa-envelope-o"></i> bddias19@gmail.com</li>
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
        <div class="container">
            <div class="login-box">
            <div class="row">
            <div class="col-md-6 login-left">
                <h2>Login</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return checkform(this);"
>
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label style="color:#e6e5e5;">Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" autocomplete="off" style="background-color: #a9a6a6;" required >
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>     
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label style="color:#e6e5e5;">Password</label>
                <input type="password" name="password" autocomplete="off" class="form-control" style="background-color: #a9a6a6;" required>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

                    <!-- START CAPTCHA -->
                        <br>
                        <div class="capbox">

                        <div id="CaptchaDiv"></div>

                        <div class="capbox-inner">
                        Type the above number:<br>

                        <input type="hidden" id="txtCaptcha">
                        <input type="text" name="CaptchaInput" autocomplete="off" id="CaptchaInput" size="15"><br>

                        </div>
                        </div>
                        <br><br>
                        <!-- END CAPTCHA -->


           
                        <input type="hidden" name="_token" class="form-control" value="<?php echo $_session['_token'];?>"/>


            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="reg.php">Sign up now</a>.</p>
        </form>


            <script type="text/javascript">

                        // Captcha Script

                        function checkform(theform){
                        var why = "";

                        if(theform.CaptchaInput.value == ""){
                        why += "- Please Enter CAPTCHA Code.\n";
                        }
                        if(theform.CaptchaInput.value != ""){
                        if(ValidCaptcha(theform.CaptchaInput.value) == false){
                        why += "- The CAPTCHA Code Does Not Match.\n";
                        }
                        }
                        if(why != ""){
                        alert(why);
                        return false;
                        }
                        }

                        var a = Math.ceil(Math.random() * 9)+ '';
                        var b = Math.ceil(Math.random() * 9)+ '';
                        var c = Math.ceil(Math.random() * 9)+ '';
                        var d = Math.ceil(Math.random() * 9)+ '';
                        var e = Math.ceil(Math.random() * 9)+ '';

                        var code = a + b + c + d + e;
                        document.getElementById("txtCaptcha").value = code;
                        document.getElementById("CaptchaDiv").innerHTML = code;

                        // Validate input against the generated number
                        function ValidCaptcha(){
                        var str1 = removeSpaces(document.getElementById('txtCaptcha').value);
                        var str2 = removeSpaces(document.getElementById('CaptchaInput').value);
                        if (str1 == str2){
                        return true;
                        }else{
                        return false;
                        }
                        }

                        // Remove the spaces from the entered and generated code
                        function removeSpaces(string){
                        return string.split(' ').join('');
                        }
                        </script>

            </div>

            
            </div>
        </div>

    </body>
</html>