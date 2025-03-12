<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SBIT3I_ECOMM";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
