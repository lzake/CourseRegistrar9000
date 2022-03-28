<?php
function OpenCon()
 {
 $dbhost = "localhost";
 $dbuser = "CST499_user";
 $dbpass = "CST499_user_password";
 $db = "course_registrar_database";
 $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);
 
 return $conn;
 }
 
function CloseCon($conn)
 {
 $conn -> close();
 }
   
?>