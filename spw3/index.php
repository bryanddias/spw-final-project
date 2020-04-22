<!DOCTYPE html>

<html>
<head>
<title>CAPTAIN SOAP</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" href="style.css" media="all">

</head>
<body id="top">

<div class="wrapper row0">
  <div id="topbar" class="hoc clear"> 
   
    <div class="fl_left">
      <ul>
        <li><i class="fa fa-phone"></i> +00 (123) 456 7890</li>
        <li><i class="fa fa-envelope-o"></i> bddias19@gmail.com</li>
      </ul>
    </div>
    <div class="fl_right">
      <ul>
        <li><a href="index.php"><i class="fa fa-lg fa-home"></i></a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="reg.php">Register</a></li>
        <li><div id="searchbox" >
	
	<form action="search.php" method="get" enctype="multipart/form-data" >
	
	<input type="text" name="value" autocomplete="off" placeholder="Search this site" size="15" style=" border:2px solid #456879;
	border-radius:10px;
	height: 30px;
	width: 100%;overflow: hidden; padding-right: .5em" required >
	
	<input  type="submit" name="search" value="Search" style="color:black;float: right;overflow: hidden; padding-right: .5em">

	
	<form>

</div></li>
        
      </ul>
    </div>
    
    
  </div>
</div>



<!-- Top Background Image Wrapper -->
<div class="bgded overlay" style="background-image:url('rx7.jpg');"> 
  
  <div class="wrapper row1">
    <header id="header" class="hoc clear"> 
      
      <div id="logo" class="fl_left">
        <h1><a href="index.php">CAPTAIN SOAP</a></h1>
      </div>
      
      
    </header>
  </div>
  
  
  
  <div id="pageintro" class="hoc clear"> 
    
    <div class="flexslider basicslider">
      <ul class="slides">
        <li>
          <article>
            <p>Captain Soap's</p>
            <h3 class="heading">Blog</h3>
            <p>Hopefully, secure enough</p>
            <footer>

            </footer>
          </article>
        </li>
        
      </ul>
    </div>
    
  </div>
  
</div>

<div class="wrapper row3 coloured">
  <main class="hoc container clear" > 
    <!-- Blog Feed Begins -->
    <div class="col-md-4" ><?php include("includes/main_content.php"); ?></div>
    <!-- Blog Feed Ends -->
    
    
  </main>
</div>



<div class="wrapper row4 bgded overlay" style="background-image:url('images/demo/backgrounds/03.png');">
  <footer id="footer" class="hoc clear"> 
    
    <h3 class="heading">CAPTAIN SOAP</h3>
    <nav>
      <ul class="nospace inline pushright uppercase">
        <li><a href="index.php"><i class="fa fa-lg fa-home"></i></a></li>
      
      </ul>
    </nav>
    
    
  </footer>
</div>

<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    
    <p class="fl_left"> <a href="#"></a></p>
    <p class="fl_right"> <a></a></p>
    
  </div>
</div>

<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<script src="layout/scripts/jquery.flexslider-min.js"></script>
</body>
</html>