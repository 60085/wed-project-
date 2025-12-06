<?php
include "../config/db.php";

// ADD ITEM
if(isset($_POST['add_item'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $image = $_FILES['image']['name'];
    $target = "../assest/" . basename($image);

    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        $query = "INSERT INTO items (name, price, category, image) VALUES ('$name', $price, '$category', '$image')";
        mysqli_query($conn, $query);
        $msg = "Item added successfully!";
    } else {
        $msg = "Image upload failed!";
    }
}

// DELETE ITEM
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM items WHERE id=$id");
    header("Location: admin_dashboard.php");
    exit;
}

// UPDATE ITEM
if(isset($_POST['update_item'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    $image = $_FILES['image']['name'];
    if($image != ""){
        $target = "../assest/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $query = "UPDATE items SET name='$name', price=$price, category='$category', image='$image' WHERE id=$id";
    } else {
        $query = "UPDATE items SET name='$name', price=$price, category='$category' WHERE id=$id";
    }
    mysqli_query($conn, $query);
    header("Location: admin_dashboard.php");
    exit;
}

// FETCH ITEMS
$items = mysqli_query($conn, "SELECT * FROM items");

// EDIT ITEM DATA
$edit_item = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $edit_item = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM items WHERE id=$id"));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f7f7f7;
    margin: 0;
}

.navbar {
    background: #2c3e50;
    color: white;
    padding: 15px 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}

.navbar h2 {
    margin: 0;
    font-size: 24px;
}

.container {
    padding: 30px;
    max-width: 1200px;
    margin: auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

h3 {
    color: #2c3e50;
    margin-bottom: 15px;
}

form input, form select, form button {
    display: block;
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
}

form input:focus, form select:focus {
    border-color: #f39c12;
    outline: none;
}

form button {
    background: #2c3e50;
    color: white;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: 0.3s;
}

form button:hover {
    background: #f39c12;
}

a.cancel-btn {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 15px;
    background: #e74c3c;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-size: 14px;
}

a.cancel-btn:hover {
    background: #c0392b;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
    background: #fff;
    border-radius: 5px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

th, td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background: #2c3e50;
    color: white;
}

tr:hover {
    background: #f9f9f9;
}

img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 5px;
}

.msg {
    color: #27ae60;
    font-weight: bold;
    margin-bottom: 10px;
}

a.btn {
    padding: 5px 12px;
    background: #2c3e50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-right: 5px;
    font-size: 14px;
    transition: 0.3s;
}

a.btn:hover {
    background: #f39c12;
    color: #fff;
}
.navbar a {
    text-decoration: none;
    color: white;
    font-size: 16px;
    padding: 8px 15px;
    border-radius: 5px;
    background: #f39c12;
    transition: background 0.3s, color 0.3s;
}

.navbar a:hover {
    background: white;
    color: #2c3e50;
}
</style>

</head>
<body>

<div class="navbar">
    <h2>Admin Dashboard</h2>
    <a href="login.html">Log Out</a>
</div>
<br><br>
<div class="container">

    <!-- ADD / UPDATE FORM -->
    <h3><?= $edit_item ? "Update Item" : "Add New Item" ?></h3>
    <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $edit_item['id'] ?? '' ?>">
        <input type="text" name="name" placeholder="Item Name" required value="<?= $edit_item['name'] ?? '' ?>">
        <input type="number" name="price" placeholder="Price" required value="<?= $edit_item['price'] ?? '' ?>">
        <select name="category" required>
    <option value="">--Select Category--</option>
    <option value="Drinks" <?= (isset($edit_item['category']) && $edit_item['category']=='Drinks') ? 'selected' : '' ?>>Drinks</option>
    <option value="Fast Food" <?= (isset($edit_item['category']) && $edit_item['category']=='Fast Food') ? 'selected' : '' ?>>Fast Food</option>
    <option value="Sweets" <?= (isset($edit_item['category']) && $edit_item['category']=='Sweets') ? 'selected' : '' ?>>Sweets</option>
    <option value="Snacks" <?= (isset($edit_item['category']) && $edit_item['category']=='Snacks') ? 'selected' : '' ?>>Snacks</option>
</select>

        <?php if($edit_item && $edit_item['image']): ?>
            <img src="../assest/<?= $edit_item['image'] ?>" alt=""><br>
        <?php endif; ?>
        <input type="file" name="image">
        <button type="submit" name="<?= $edit_item ? 'update_item' : 'add_item' ?>">
            <?= $edit_item ? "Update Item" : "Add Item" ?>
        </button>
        <?php if($edit_item): ?>
            <a href="admin_dashboard.php">Cancel</a>
        <?php endif; ?>
    </form>

    <!-- DISPLAY ITEMS -->
    <h3>All Items</h3>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Price</th><th>Category</th><th>Image</th><th>Actions</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($items)) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><img src="../assest/<?= $row['image'] ?>" alt=""></td>
            <td>
                <a class="btn" href="admin_dashboard.php?edit=<?= $row['id'] ?>">Edit</a>
                <a class="btn" href="admin_dashboard.php?delete=<?= $row['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>

</body>
</html>
