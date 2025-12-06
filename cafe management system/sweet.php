<?php
session_start();
include "../config/db.php";

// Add to cart logic
if(isset($_POST['add_to_cart'])){
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];

    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if(isset($_SESSION['cart'][$item_id])){
        $_SESSION['cart'][$item_id]['qty'] += 1;
    } else {
        $_SESSION['cart'][$item_id] = array(
            'name' => $item_name,
            'price' => $item_price,
            'qty' => 1
        );
    }

    echo "<script>alert('✅ Item added to cart');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Café Items - Fast Food</title>
    <style>
        body {margin:0;font-family:Arial,sans-serif;background:#f7f7f7;}
        /* NAVBAR */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 30px;
    background-color: #2c3e50;
    color: white;
}

.navbar h2 {
    margin: 0;
}

.navbar ul {
    margin: 0;
    padding: 0;
    display: flex;
    list-style: none;
}

.navbar ul li {
    margin-left: 20px;
    position: relative; /* for dropdown positioning */
}

.navbar ul li a {
    text-decoration: none;
    color: white;
    font-size: 16px;
    padding: 10px 15px;
    display: block;
}

.navbar ul li a:hover {
    color: #f39c12;
}

/* Dropdown */
.dropdown .dropbtn::after {
    content: " ▼";
    font-size: 12px;
    margin-left: 5px;
}

.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #2c3e50;
    min-width: 150px;
    z-index: 1;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

.dropdown-content a {
    color: white;
    padding: 10px 15px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #fee4ba;
}

/* Show dropdown on hover */
.dropdown:hover .dropdown-content {
    display: block;
}
        .items-section {padding:40px;text-align:center;}
        .items-grid {display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:25px;padding:0 20px;}
        .card {background:white;padding:15px;box-shadow:0 0 10px rgba(0,0,0,0.1);border-radius:10px;}
        .card img {width:100%;height:180px;border-radius:10px;object-fit:cover;}
        .card h3 {margin:10px 0;color:#2c3e50;}
        .card p {margin:5px 0;color:#777;}
        .price {font-size:18px;font-weight:bold;color:#27ae60;}
        .card button {padding:10px;width:100%;border:none;background:#e67e22;color:white;border-radius:5px;cursor:pointer;}
        .card button:hover {background:#cf6d18;}
    </style>
</head>
<body>


    <!-- NAVBAR -->
    <div class="navbar">
    <h2>Café Store</h2>
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About</a></li>
        <!-- Items dropdown -->
        <li class="dropdown">
            <a href="items.php" class="dropbtn">Items ▼</a>
            <div class="dropdown-content">
                <a href="Drink.php">Drinks</a>
                <a href="fastFood.php">Fast Food</a>
                <a href="Sweet.php">Sweets</a>
                <a href="snaks.php">Snacks</a>
            </div>
        </li>

        <li><a href="cart.php">Cart</a></li>
        <li><a href="Contact.html">Contact Us</a></li>
    </ul>
    <a href="login.html" style="
    text-decoration: none;
    color: white;
    font-size: 16px;
    padding: 8px 15px;
    border-radius: 5px;
    background-color: #f39c12;
    transition: background 0.3s, color 0.3s;
" 
onmouseover="this.style.background='white'; this.style.color='#2c3e50';" 
onmouseout="this.style.background='#f39c12'; this.style.color='white';">
    Log Out
</a>

</div>

<div class="items-section">
    <h2>Sweet Items</h2>
    <div class="items-grid">
        <?php
        // Sirf 'Fast Food' category wale items fetch karo
        $query = "SELECT * FROM items WHERE category='Sweets'";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)){
            echo "
            <div class='card'>
                <img src='../assest/{$row['image']}' alt='{$row['name']}'>
                <h3>{$row['name']}</h3>
                <p class='price'>Rs {$row['price']}</p>
                <form method='POST'>
                    <input type='hidden' name='item_id' value='{$row['id']}'>
                    <input type='hidden' name='item_name' value='{$row['name']}'>
                    <input type='hidden' name='item_price' value='{$row['price']}'>
                    <button type='submit' name='add_to_cart'>Add to Cart</button>
                </form>
            </div>";
        }
        ?>
    </div>
</div>

</body>
</html>
