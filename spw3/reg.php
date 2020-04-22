<?php
// Include config file
require_once "includes/connect.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = mysqli_real_escape_string($con,htmlspecialchars($_POST["username"]));
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = mysqli_real_escape_string($con,trim(htmlspecialchars($_POST["username"])));
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = mysqli_real_escape_string($con,htmlspecialchars(trim($_POST["password"])));
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = mysqli_real_escape_string($con,trim(htmlspecialchars($_POST["confirm_password"])));
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

             echo '<script language="javascript">';
            echo 'alert("Registration Successful. Now you can Login.")';
            echo '</script>';   

            
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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

            <div class="col-md-4 login-left">
                <h2>Register</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return checkform(this);">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" required name="username" pattern="[a-zA-Z0-9]{1,15}" title="Username should only contain letters and numbers [maximum of 15 characters]" autocomplete="off" class="form-control" value="<?php echo $username; ?>" style="background-color: #a9a6a6;" required>
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" required name="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$" title="Password mush have Uppercase,Lowercase and numbers" autocomplete="off" class="form-control" value="<?php echo $password; ?>" style="background-color: #a9a6a6;" required>
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" autocomplete="off" class="form-control" value="<?php echo $confirm_password; ?>" style="background-color: #a9a6a6;" required>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
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
                    

                    

            <div class="form-group">
            <input type="checkbox" name="Terms" required value="check" id="terms"/><font>I agree to the following <a href="#" style="color:#7FFF00;">Terms and conditions</a></font>
            </div>


            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
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