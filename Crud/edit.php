<?php

session_start();
require 'config.php';

if(!isset($_SESSION['user_id']))
{
    header("Location:login.php");
    exit();
}

$id = $_GET['id'];

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
    } else {
        $imagePath = $_POST['existing_image'];
    }

    $stmt = $conn->prepare('UPDATE items SET name=?, description=?, image_path=? WHERE id=?');
    $stmt->bind_param('sssi', $name, $description, $imagePath, $id);
    $stmt->execute();
    $stmt->close();
    header('Location:index.php');
    exit();
}
else {
    $stmt = $conn->prepare("SELECT name, description, image_path FROM items WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $description, $imagePath);
    $stmt->fetch();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Page</title>
</head>
<body>

<form action="" method="post" enctype="multipart/form-data">
    <label for="">Name</label>
    <input type="text" name="name" value="<?= $name ?>"><br>
    <label for="">Description</label>
    <input type="text" name="description" value="<?= $description ?>"><br>
    <label for="">Image</label>
    <input type="file" name="image"><br>
    <input type="hidden" name="existing_image" value="<?= $imagePath ?>"><br>
    <button type="submit">Update</button>
</form>
    
</body>
</html>
