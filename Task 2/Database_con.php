<?php

$mysqli = new mysqli('localhost', 'root', '', 'smart_method');

mysqli_query($mysqli,"set names utf8");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
} else {
    
}
?>