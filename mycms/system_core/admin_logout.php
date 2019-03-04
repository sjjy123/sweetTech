<?php
session_start();
$_SESSION["adminID"]="";
$_SESSION["adminName"]="";
header("location:../index.php");
?>