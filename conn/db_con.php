<?php
session_start();
$dbServername = "localhost";
$dbUsername  = "root";
$dbPassword = "";
$dbName = "stock";
$conn =new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
