<?php
session_start();

require 'config.php';

if(!isset($_SESSION['user_id']))
{
    header('Location:login.php');
    exit();
}

$result = $conn->query('SELECT * from items');
$items = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
</head>
<body>
    <h2>Items</h2>
    <a href="create.php">Add new Item</a>
    <a href="logout.php">Logout</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>

        <?php foreach($items as $item) : ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= $item['name'] ?></td>
                <td><?= $item['description'] ?></td>
                <td>
                    <?php if ($item['image_path']): ?>
                        <img src="<?= $item['image_path'] ?>" alt="<?= $item['name'] ?>" style="width:100px;">
                    <?php endif; ?>
                </td>
                <td>
                    <a href="edit.php?id=<?= $item['id'] ?>">Update</a>
                    <a href="delete.php?id=<?= $item['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
