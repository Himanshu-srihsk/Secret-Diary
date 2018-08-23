<?php
mysql_connect("localhost","root","master1234");
$link=mysql_select_db("reg");
if(mysqli_connect_error()){
die("there was an error connecting to database");
}
?>