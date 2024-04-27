<?php
session_start();
include 'db_connection.php';

if (isset($_GET['user_id'])) {

    $userid = $_GET['user_id'];

    $removeQuery = "DELETE FROM Users WHERE user_id = $userid";
    if ($conn->query($removeQuery) === TRUE) {
        session_destroy();
        echo '<script>
                alert("Account deleted successfully.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Sign-in.html";
              </script>';
        exit();
    } else {
        echo '<script>
                alert("Error deleting the Account.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Account-management.php";
             </script>';
    }

    $conn->close();
}
