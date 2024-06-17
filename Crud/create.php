<?php

session_start();
require 'config.php';

if(!isset($_SESSION['user_id']))
{
    header('Location:login.php');
}

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $name = $_POST['name'];
    $description = $_POST['description'];
    $imagePath = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    $stmt = $conn->prepare("INSERT INTO items(name, description, image_path) VALUES(?, ?, ?)");
    $stmt->bind_param('sss', $name, $description, $imagePath);
    $stmt->execute();
    $stmt->close();

    header("Location:index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
    <label for="">Name</label>
    <input type="text" name="name"><br>
    <label for="">Description</label>
    <input type="text" name="description"><br>
    <label for="">Image</label>
    <input type="file" name="image"><br>
    <button type="submit">Submit</button>
</form>
    
</body>
</html>
