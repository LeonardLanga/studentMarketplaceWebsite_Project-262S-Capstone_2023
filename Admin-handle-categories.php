<?php
session_start();
include 'db_connection.php';

if (isset($_GET['remove_category'])) {
    $categoryIdToRemove = $_GET['remove_category'];

    $removeQuery = "DELETE FROM category WHERE cat_id = ?";
    $removeStmt = $conn->prepare($removeQuery);
    $removeStmt->bind_param("i", $categoryIdToRemove);

    if ($removeStmt->execute()) {
        echo '<script>
                alert("Success category was deleted.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Categories.php";
              </script>';
        exit();
    } else {
        echo '<script>
                alert("Error deleting the category.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Categories.php";
             </script>';
    }

    $removeStmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST["categoryname"];

    $checkQuery = "SELECT * FROM category WHERE cat_name = '$category'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {

        echo '<script>
                alert("This category already exits in the database");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Add-Category.html";
              </script>';
    } else {
        $category = $_POST["categoryname"];

        $sql = "INSERT INTO category (cat_name) VALUES ('$category')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>
                    alert("Category Addition Was successful");
                    window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Add-Category.html";
                </script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
