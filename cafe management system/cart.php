<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart</title>
    <style>
         body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

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
        h2 {text-align:center;}
        table {width:80%;margin:20px auto;border-collapse:collapse;background:white;box-shadow:0 0 10px rgba(0,0,0,0.1);}
        th, td {padding:10px;text-align:center;border-bottom:1px solid #ddd;}
        th {background:#2c3e50;color:white;}
        .total {font-weight:bold;}
        a.button {display:inline-block;padding:10px 20px;background:#f39c12;color:white;text-decoration:none;border-radius:5px;}
        a.button:hover {background:#219150;}
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
<h2>Your Cart</h2>

<?php
if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
    echo "<table>
            <tr>
                <th>Item</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>";
    $total = 0;
    foreach($_SESSION['cart'] as $item){
        $subtotal = $item['price'] * $item['qty'];
        $total += $subtotal;
        echo "<tr>
                <td>{$item['name']}</td>
                <td>Rs {$item['price']}</td>
                <td>{$item['qty']}</td>
                <td>Rs $subtotal</td>
              </tr>";
    }
    echo "<tr><td colspan='3' class='total'>Total</td><td>Rs $total</td></tr>";
    echo "</table>";
    echo "<div style='text-align:center;'><a href='checkout.php' class='button'>Checkout</a></div>";
}else{
    echo "<p style='text-align:center;'>Your cart is empty.</p>";
}
?>

</body>
</html>
