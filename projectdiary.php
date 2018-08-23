<?php

    session_start();

    $error = "";  

    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";  
        
        session_destroy();
        
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
        
        header("Location: loggedpage.php");
        
    }

    if (array_key_exists("submit", $_POST)) {
        
        include("connection.php");
        
        if (!$_POST['email']) {
            
            $error .= "An email address is required<br>";
            
        } 
        
        if (!$_POST['password']) {
            
            $error .= "A password is required<br>";
            
        } 
        
        if ($error != "") {
            
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT id FROM `project` WHERE email = '".mysql_real_escape_string($_POST['email'])."' LIMIT 1";

                $result = mysql_query($query);

                if (mysql_num_rows($result) > 0) {

                    $error = "That email address is taken.";

                } else {

                    $query = "INSERT INTO `project` (`email`, `password`) VALUES ('".mysql_real_escape_string($_POST['email'])."', '".mysql_real_escape_string($_POST['password'])."')";

                    if (!mysql_query($query)) {

                        $error = "<p>Could not sign you up - please try again later.</p>";

                    } else {

                        $query = "UPDATE `project` SET password = '".md5(md5(mysql_insert_id()).$_POST['password'])."' WHERE id = ".mysql_insert_id()." LIMIT 1";
                        
                        $id = mysql_insert_id();
                        
                        mysql_query($query);

                        $_SESSION['id'] = $id;

                        if ($_POST['stayloggedin'] == '1') {

                            setcookie("id", $id, time() + 60*60*24*365);

                        } 
                            
                        header("Location: loggedpage.php");

                    }

                } 
                
            } else {
                    
                    $query = "SELECT * FROM `project` WHERE email = '".mysql_real_escape_string( $_POST['email'])."'";
                
                    $result = mysql_query($query);
                
                    $row = mysql_fetch_array($result);
                
                    if (isset($row)) {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if (isset($_POST['stayloggedin']) AND $_POST['stayloggedin'] == '1') {

                                setcookie("id", $row['id'], time() + 60*60*24*365);

                            } 

                            header("Location: loggedpage.php");
                                
                        } else {
                            
                            $error = "That email/password combination could not be found.";
                            
                        }
                        
                    } else {
                        
                        $error = "That email/password combination could not be found.";
                        
                    }
                    
                }
            
        }
        
        
    }


?>

<?php include("header.php"); ?>
      
      <div class="container" id="homepagecontainer">
      
    <h1>Secret Diary</h1>
          
          <p class="lead"><strong>Store your thoughts permanently and securely.</strong></p>
          
          <div id="error"><?php if ($error!="") {
    echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
    
} ?></div>

<form method="post" id="signupform">
    
    <p class="lead">Interested? Sign up now.</p>
    
    <fieldset class="form-group">

        <input class="form-control" type="email" name="email" placeholder="Your Email">
        
    </fieldset>
    
    <fieldset class="form-group">
    
        <input class="form-control" type="password" name="password" placeholder="Password">
        
    </fieldset>
    
    <div class="checkbox">
    
        <label>
    
        <input type="checkbox" name="stayloggedin" value=1> Stay logged in
            
        </label>
        
    </div>
    
    <fieldset class="form-group">
    
        <input type="hidden" name="signUp" value="1">
        
        <input class="btn btn-success" type="submit" name="submit" value="Sign Up!">
        
    </fieldset>
    
    <p><a class="toggleform">Log in</a></p>

</form>

<form method="post" id ="loginform">
    
    <p>Log in using your username and password.</p>
    
    <fieldset class="form-group">

        <input class="form-control" type="email" name="email" placeholder="Your Email">
        
    </fieldset>
    
    <fieldset class="form-group">
    
        <input class="form-control" type="password" name="password" placeholder="Password" id="myInput">
       
    </fieldset>
    
    <div class="checkbox">
    
        <label>
               <input type="checkbox" onclick="myFunction()">Show Password
            <input type="checkbox" name="stayloggedin" value=1> Stay logged in
            
        </label>
        
    </div>
        
        <input type="hidden" name="signUp" value="0">
    
    <fieldset class="form-group">
        
        <input class="btn btn-success" type="submit" name="submit" value="Log In!">
        
    </fieldset>
    
    <p><a class="toggleform">Sign up</a></p>

</form>
          
      </div>

<?php include("footer.php"); ?>


