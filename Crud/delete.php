<?php

session_start();
require 'config.php';

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}
$id=$_GET['id'];
$stmt=$conn->prepare('DELETE from items WHERE id=?');
$stmt->bind_param('i',$id);
$stmt->execute();
$stmt->close();

header('Location:index.php');
exit();



?>