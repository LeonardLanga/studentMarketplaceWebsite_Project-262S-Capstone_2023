<?php
session_start();
include 'db_connection.php';

if (isset($_POST['sell-product'])) {

    $productName = $_POST['productName'];
    $productPrice = $_POST['productprice'];
    $productCondition = $_POST['productcondition'];
    $productQuantity = $_POST['productquantity'];
    $categoryName = $_POST['productcategory'];
    $productDescription = $_POST['productdescription'];


    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }


    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_extensions)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {


            $image_path = $target_file;


            $categoryQuery = "SELECT cat_id FROM category WHERE cat_name = '$categoryName'";
            $result = $conn->query($categoryQuery);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $categoryId = $row['cat_id'];
            } else {

                die("Error: Category not found.");
            }

            $sellerId = $_SESSION['user_id'];


            $categoryId = $conn->real_escape_string($categoryId);
            $sellerId = $conn->real_escape_string($sellerId);
            $productInsertQuery = "INSERT INTO products (product_name, product_description, product_price, product_condition, product_quantity, product_image_url, cat_id, seller_id) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($productInsertQuery);
            $stmt->bind_param("ssssissi", $productName, $productDescription, $productPrice, $productCondition, $productQuantity, $image_path, $categoryId, $sellerId);
            $stmt->execute();


            echo '<script>
                    alert("Upload was successful!");
                    window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Sell-page.html";
                  </script>';
            exit();
        } else {
            echo '<script>
                     alert("Sorry, there was an error uploading your file.");
                  </script>';
        }
    }
} else {

    echo '<script>
            alert("Error!");
            window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Sell-page.html";
         </script>';
    exit();
}

$conn->close();
