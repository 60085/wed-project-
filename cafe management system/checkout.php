<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0){
    echo "<script>alert('Your cart is empty!'); window.location='item.php';</script>";
    exit;
}

// Customer details (simple prompt, ya form se le sakte ho)
$customer_name = "Guest User"; // simple demo
$phone = "0000000000";         // simple demo
$table_no = 1;                 // example table number

// Calculate total amount
$total_amount = 0;
foreach($_SESSION['cart'] as $item){
    $total_amount += $item['price'] * $item['qty'];
}

// Insert into orders table
$query_order = "INSERT INTO orders (customer_name, phone, table_no, total_amount, status) 
                VALUES ('$customer_name', '$phone', $table_no, $total_amount, 'Pending')";

if(mysqli_query($conn, $query_order)){
    $order_id = mysqli_insert_id($conn); // last inserted order id

    // Insert into order_items table
    foreach($_SESSION['cart'] as $item_id => $item){
        $name = $item['name'];
        $qty = $item['qty'];
        $price = $item['price'];

        $query_item = "INSERT INTO order_items (order_id, item_name, qty, price) 
                       VALUES ($order_id, '$name', $qty, $price)";
        mysqli_query($conn, $query_item);
    }

    // Clear cart session
    unset($_SESSION['cart']);

    echo "<script>alert('✅ Order placed successfully!'); window.location='items.php';</script>";
}else{
    echo "<script>alert('❌ Failed to place order!'); window.location='cart.php';</script>";
}
?>
