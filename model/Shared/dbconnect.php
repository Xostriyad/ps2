<?php
try 
{
    //$dbh = new PDO('mysql:host=mysql.epic-enkidu.com;dbname=epicenkidu', "planets2", "loadgals");
	$dbh = new PDO('mysql:host=localhost;dbname=planetside2', "puser", "pass");
} 
catch (PDOException $e) 
{
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>