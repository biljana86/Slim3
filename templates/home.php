<?php @session_start();
if(!isset($_SESSION['name']))
        header('Location: index.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Emerald</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="css/default.css" rel="stylesheet" type="text/css" />
<link href="css/form.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

</head>

<body>
<div id="outer">
  <div id="header">
    <h1><a href="#">Emerald</a></h1>
    <h2><a href="#">Free CSS Templates</a></h2>
  </div>
    <?php if(isset($_SESSION['name']) && $_SESSION['name']!=""){?>
  <div id="menu">
    <ul>
      <li class="first"><a href="/home" accesskey="1">Home</a></li>
      <li><a href="/users" accesskey="2">list all users</a></li>
      <li><a href="/logout" accesskey="3">logout</a></li>
 
    </ul>
    </div><?php }?>
  <div id="content">
    <div id="primaryContentContainer">
      <div id="primaryContent">
     
  <p> HELLO {{name}}.</p>
     
      </div>
    </div>
    
    <div class="clear"></div>
  </div>
  <div id="footer">
    <p>Copyright &copy; 2007 Sitename.com. Designed by <a href="http://www.freecsstemplates.org">Free CSS Templates</a></p>
  </div>
</div>
</body>
</html>
