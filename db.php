<?php
if ($_SERVER['PHP_SELF'] == "/vuln_jmpl/db.php"){
    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        header("location: index.php");
        die();
    }
}
// Change servername and port
$servername = "localhost";
$username = "root";
$password = "";
$database = "pentest";

// Create connection
try{
    $conn = new mysqli($servername, $username, $password, $database);
} catch(Exception $e){
    die("Database connection failed");
}

?>