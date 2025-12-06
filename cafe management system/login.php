<?php
include "../config/db.php"; // correct path to db.php
session_start();

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded admin login first
    if($username === "admin" && $password === "123"){
        $_SESSION['admin'] = "admin";
        echo "<script>alert('Login Successful!'); window.location='admin_dashboard.php';</script>";
        exit(); // stop further execution
    }

    // Otherwise check database
    $query = "SELECT * FROM User WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);

        if(password_verify($password, $row['password'])){
            $_SESSION['admin'] = $row['username'];
            echo "<script>alert('Login Successful!'); window.location='index.html';</script>";
        } else {
            echo "<script>alert('Incorrect Password!'); window.location='login.html';</script>";
        }
    } else {
        echo "<script>alert('User Not Found!'); window.location='login.html';</script>";
    }
}
?>
