<?php
include "../config/db.php"; // database connection

if(isset($_POST['registration'])){
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO User (username, password) VALUES ('$username', '$password')";
    if(mysqli_query($conn, $query)){
        echo "<script>alert('✅ User Registered Successfully!'); window.location='registration.html';</script>";
    } else {
        echo "<script>alert('❌ Registration Failed!'); window.location='registration.html';</script>";
    }
}
?>
