<?php

    session_start();

    if (array_key_exists("content", $_POST)) {
        
        include("connection.php");
        
      $query = "UPDATE project SET diary = '".mysql_real_escape_string($_POST['content'])."' WHERE id = ".mysql_real_escape_string($_SESSION['id'])." LIMIT 1";
        
      mysql_query($query);
        
    }

?>
