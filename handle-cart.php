<?php
session_start();
include 'db_connection.php';

if (isset($_POST['update_cart'])) {
    $newQuantity = $_POST['cart_quantity'];
    $productId = $_POST['product_id'];

    $userId = $_SESSION['user_id'];

    $productCheckQuery = "SELECT product_quantity FROM products WHERE product_id = ?";
    $productCheckStmt = $conn->prepare($productCheckQuery);
    $productCheckStmt->bind_param("i", $productId);
    $productCheckStmt->execute();
    $productCheckResult = $productCheckStmt->get_result();

    if ($productCheckResult->num_rows > 0) {
        $productCheckRow = $productCheckResult->fetch_assoc();
        $availableQuantity = $productCheckRow['product_quantity'];

        if ($newQuantity <= $availableQuantity) {

            $updateQuery = "UPDATE cart SET quantity = ? WHERE product_id = ? AND user_id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("iii", $newQuantity, $productId, $userId);

            if ($updateStmt->execute()) {

                echo '<script>
                        alert("Update successful");
                        window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
                     </script>';
                exit();
            } else {

                echo '<script>
                        alert("Error updating quantity in the cart.");
                        window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
                     </script>';
            }


            $updateStmt->close();
        } else {

            echo '<script>
                    alert("The requested quantity exceeds the available quantity for this product.");
                    window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
                </script>';
        }
    } else {
        echo "Product not found.";
    }


    $productCheckStmt->close();
    $conn->close();
}



if (isset($_GET['remove_item'])) {
    $productIdToRemove = $_GET['remove_item'];

    $userId = $_SESSION['user_id'];


    $removeQuery = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";
    $removeStmt = $conn->prepare($removeQuery);
    $removeStmt->bind_param("ii", $productIdToRemove, $userId);

    if ($removeStmt->execute()) {

        echo '<script>
                alert("Success product removed from cart!!");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
              </script>';
        exit();
    } else {

        echo '<script>
                alert("Error removing the product from the cart.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
             </script>';
    }


    $removeStmt->close();
    $conn->close();
}


$cartIsEmpty = true;


$userId = $_SESSION['user_id'];

$cartQuery = "SELECT * FROM cart WHERE user_id = ?";
$cartStmt = $conn->prepare($cartQuery);
$cartStmt->bind_param("i", $userId);
$cartStmt->execute();
$cartResult = $cartStmt->get_result();

if ($cartResult->num_rows > 0) {
    $cartIsEmpty = false;
}

$cartStmt->close();

if (isset($_GET['delete_all'])) {
    if ($cartIsEmpty) {
        echo '<script>
                alert("The cart is already empty.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
              </script>';
    } else {

        $deleteQuery = "DELETE FROM cart WHERE user_id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $userId);

        if ($deleteStmt->execute()) {

            echo '<script>
                   alert("Success all products removed from cart!!");
                    window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
                  </script>';
            exit();
        } else {

            echo '<script>
                   alert("Error removing products from the cart.");
                   window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
                 </script>';
        }

        $deleteStmt->close();
        $conn->close();
    }
}

if (isset($_POST['proceed_to_checkout'])) {
    $userId = $_SESSION['user_id'];

    $cartQuery = "SELECT * FROM cart WHERE user_id = ?";
    $cartStmt = $conn->prepare($cartQuery);
    $cartStmt->bind_param("i", $userId);
    $cartStmt->execute();
    $cartResult = $cartStmt->get_result();

    if ($cartResult->num_rows == 0) {
        echo '<script>
                alert("Cart is empty. Add items to the cart before proceeding to checkout."); 
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php"; 
                </script>';
        exit();
    } else {

        $totalPrice = $_POST['total_price'];
        $totalQuantity = $_POST['total_quantity'];

        $productRow = $cartResult->fetch_assoc();
        $productId = $productRow['product_id'];


        $orderQuery = "INSERT INTO orders (order_total_amount, order_status, order_quantity, buyer_id, product_id) VALUES (?, 'pending', ?, ?, ?)";
        $orderStmt = $conn->prepare($orderQuery);
        $orderStmt->bind_param("idis", $totalPrice, $totalQuantity, $userId, $productId);

        if ($orderStmt->execute()) {
            $orderId = $orderStmt->insert_id;
            $clearCartQuery = "DELETE FROM cart WHERE user_id = ?";
            $clearCartStmt = $conn->prepare($clearCartQuery);
            $clearCartStmt->bind_param("i", $userId);
            $clearCartStmt->execute();

            $_SESSION['order_id'] = $orderId;
            $_SESSION['total_amount'] = $totalPrice;

            echo '<script>
                    alert("Order creation successful");
                    window.location.href = "http://localhost/System_EduMarket-ecommerce_website/checkout.php";
                    </script>';
            exit();
        } else {
            echo '<script>
                    alert("Order creation failed");
                    window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
                </script>';
        }
    }
}
