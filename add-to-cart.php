<?php
session_start();
include 'db_connection.php';

if (isset($_POST['productId']) && isset($_POST['quantity'])) {
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    $userId = $_SESSION['user_id'];

    $checkQuery = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("ii", $userId, $productId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        echo "Product already exists in the cart.";
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $userId, $productId, $quantity);

        if ($stmt->execute()) {
            echo "Product added to cart!";
        } else {
            echo "Error adding product to cart";
        }

        $stmt->close();
    }

    $checkStmt->close();
    $conn->close();
} else {
    echo "Product ID and quantity not specified.";
}
