<?php
session_start();
include 'db_connection.php';

if (isset($_GET['product_id'])) {
    $productIdToRemove = $_GET['product_id'];

    $removeQuery = "DELETE FROM products WHERE product_id = ?";
    $removeStmt = $conn->prepare($removeQuery);
    $removeStmt->bind_param("i", $productIdToRemove);

    if ($removeStmt->execute()) {
        echo '<script>
                alert("Success product was deleted.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Products.php";
              </script>';
        exit();
    } else {
        echo '<script>
                alert("Error deleting the product.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Products.php";
             </script>';
    }

    $removeStmt->close();
    $conn->close();
}
