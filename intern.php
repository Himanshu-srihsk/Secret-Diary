<?php
session_start();
$error="";
if(array_key_exists("logout",$_GET)){
unset($_SESSION);
setcookie("id","",time()-60*60);
$_COOKIE['id']="";
 session_destroy();
}else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
header("Location:loggedpage.php");
}
if(array_key_exists("submit",$_POST)){
include("connection.php"); 


if(!$_POST['email']){
$error.="An Email address is required";

}
if(!$_POST['password']){
$error.="A password is required";

}
if($error!=""){
$error="<p>There were error(s) in your form</p>".$error;
}
else{
if($_POST['signup']==1){
$query="select id from project where email='".mysql_real_escape_string($_POST['email'])."'";
$result=mysql_query($query);
if(mysql_num_rows($result)>0)
{
$error="that email address is already taken";
}else{
$query="insert into project(email,password) values('".mysql_real_escape_string($_POST['email'])."','".mysql_real_escape_string($_POST['password'])."')";
if(!mysql_query($query)){
$error="<p>Couldnot signed you up-please try again later</p>";
}else{
$query="update project set password='".md5(md5(mysql_insert_id()).$_POST['password'])."' where id=".mysql_insert_id()."";
mysql_query($query);
$_SESSION['id']=mysql_insert_id();
if($_POST['stayloggedin']=='1'){

setcookie("id",mysql_insert_id(),time()+60*60*24*365);
}
header("Location:loggedpage.php");
}
}
}
else{

$query="select * from project where email='".mysql_real_escape_string($_POST['email'])."'";
$result=mysql_query($query);
$row=mysql_fetch_array($result);

      if (isset($row))
{
$hashedpassword=md5(md5($row['id']).$_POST['password']);
if($hashedpassword==$row['password'])
{
$_SESSION['id']=$row['id'];
if($_POST['stayloggedin']=='1'){

setcookie("id",$row['id'],time()+60*60*24*365);
}
header("Location:exam.php");
}
else {
                            
      $error = "That email/password combination could not be found.";
                            
  }
  }
else{

$error = "That email/password combination could not be found.";
}

}
}
}


?>







<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
<style type="text/css">
.container{
text-align:center;
width:400px;
}
#homepagecontainer{

margin-top:150px;
}
html { 
  background: url(diarypic.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
    }
	body{
	background:none;
	color:white;
	
	}
	#loginform{
	display:none;
	}
	.toggleform{
	font-weight:bold;
	
	}
	#diary{
	width:1500px;
	height:1000px;

	
	}
	
	#containerLoggedInPage{
	margin-top:60px;
	
	}

</style>
    <title>Secret Diary!</title>
  </head>
  <body>














  <div class="container" id="homepagecontainer">
    <h1>Online testing system</h1>
	<p>Interested? Sign up now!</p>
	<p><strong>Store your thoughts permanently and securely.</strong></p>
  <div id="error"><?php  if($error!=""){
echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
 } ?></div>
<form method="post" id="signupform">
<fieldset class="form-group">
<input class="form-control" type="email" name="email" placeholder="Your Email">
</fieldset>
<fieldset class="form-group">
<input class="form-control" type="password" name="password" placeholder="Password">
</fieldset>
<div class="checkbox">
<label>

<input  type="checkbox" name="stayloggedin"  value=1>Stay logged in
</label>
</div>
<fieldset class="form-group">
<input type="hidden" name="signup" value="1">
<input class="btn btn-success" type="submit" name="submit" value="sign up">

</fieldset>
 
<p><a class="toggleform">Log in</a></p>
</form>

<form method="post" id="loginform">
<p> Login using your Username and pasword</p>
<fieldset class="form-group">
<input class="form-control" type="email" name="email" placeholder="Your Email">
</fieldset>
<fieldset class="form-group">
<input class="form-control" type="password" name="password" placeholder="Password">
</fieldset>
<div class="checkbox">
<label>
<input type="checkbox" name="stayloggedin"  value=1>Stay logged in
</label>
</div>
<fieldset class="form-group">
<input type="hidden" name="signup" value="0">
<input class="btn btn-success" type="submit" name="submit" value="Log In">
</fieldset>
<p><a class="toggleform" >Sign up</a></p>
</form>
</div>
 
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>

	  
	  
	   

      <script type="text/javascript">
        $(".toggleform").click(function() {
            
            $("#signupform").toggle();
            $("#loginform").toggle();
            
            
        });
		$('#diary').bind('input propertychange', function() {

     
$.ajax({
  method: "POST",
  url: "updatedatabase.php",
  data: {content:$("#diary").val()}
 
});
});

</script> 

 </body>
</html>






