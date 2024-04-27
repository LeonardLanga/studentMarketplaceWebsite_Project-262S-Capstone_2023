<?php
session_start();
include 'db_connection.php';

if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];

    $query = "SELECT p.*, u.user_name, c.cat_name FROM products p 
            INNER JOIN users u ON p.seller_id = u.user_id
            INNER JOIN category c ON p.cat_id = c.cat_id
            WHERE product_id = $productId";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['productname'];
    $productPrice = $_POST['productprice'];
    $productCondition = $_POST['productcondition'];
    $productQuantity = $_POST['productquantity'];
    $categoryId = $_POST['categoryId'];
    $sellerId = $_POST['sellerId'];
    $productDescription = $_POST['productdescription'];

    if ($_FILES['image']['name'] !== '') {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $extensionsArr = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $extensionsArr)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {

                $imageUrl = "uploads/" . $_FILES['image']['name'];

                $updateImageQuery = ", product_image_url = '$imageUrl'";
            } else {
                echo '<script>
                        alert("Sorry, there was an error uploading your file.");
                        window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Products.php";
                    </script>';
            }
        } else {
            echo '<script>
                    alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
                  </script>';
        }
    } else {
        $updateImageQuery = '';
    }

    $updateQuery = "UPDATE products 
                    SET product_name = '$productName', 
                        product_price = '$productPrice', 
                        product_condition = '$productCondition', 
                        product_quantity = '$productQuantity', 
                        cat_id = '$categoryId', 
                        seller_id = '$sellerId', 
                        product_description = '$productDescription' 
                        $updateImageQuery
                    WHERE product_id = $productId";

    if (mysqli_query($conn, $updateQuery)) {
        echo    '<script>
                    alert("Product Update was successful!");
                    window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Products.php";
                  </script>';
        exit;
    } else {
        echo '<script>
                alert("Error updating record.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-update-product.php";
            </script>';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Update Product</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link rel="icon" href="favicon/favicon.ico" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/6a4151cb09.js" crossorigin="anonymous"></script>

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />

</head>

<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="d-flex justify-content-center py-4">
                                <a href="Admin-Products.php" class="logo d-flex align-items-center w-auto" title="Edu Market">
                                    <img src="logo/eduMarket.svg" alt="Edu Market" title="Edu Market" />
                                </a>
                            </div>


                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="col-12" style="margin-top: 10px">
                                        <a href="Admin-Products.php" style="font-size: 14px" title="back"><i class="fa-solid fa-arrow-left" style="color: black"></i></a>
                                    </div>
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">
                                            Update Product
                                        </h5>
                                    </div>

                                    <form class="row g-3 needs-validation" method="post" enctype="multipart/form-data" novalidate>
                                        <div class="col-12">
                                            <label for="productname" class="form-label">Product Name</label>
                                            <input type="text" name="productname" class="form-control" id="productname" value="<?php echo $row['product_name']; ?>" />
                                            <div class="invalid-feedback">
                                                Please, product name!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="text" name="productprice" class="form-control" id="price" value="<?php echo $row['product_price']; ?>" required />
                                            <div class="invalid-feedback">Please, enter price!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="condition" class="form-label">Condition</label>
                                            <div class="input-group has-validation">
                                                <select id="condition" name="productcondition" class="form-control">
                                                    <option value=""></option>
                                                    <option value="New" <?php if ($row['product_condition'] === 'New') echo 'selected'; ?>>New</option>
                                                    <option value="Like New" <?php if ($row['product_condition'] === 'Like New') echo 'selected'; ?>>Like New</option>
                                                    <option value="Good" <?php if ($row['product_condition'] === 'Good') echo 'selected'; ?>>Good</option>
                                                    <option value="Fair" <?php if ($row['product_condition'] === 'Fair') echo 'selected'; ?>>Fair</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="quantity" class="form-label">Quantity</label>
                                            <input type="number" min="1" name="productquantity" class="form-control" id="quantity" value="<?php echo $row['product_quantity']; ?>" required />
                                            <div class="invalid-feedback">
                                                Please, enter quantity!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="categoryId" class="form-label">Category Id</label>
                                            <input id="categoryId" name="categoryId" class="form-control" value="<?php echo $row['cat_id']; ?>" required></input>
                                            <div class="invalid-feedback">
                                                Please, enter category id!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="sellerId" class="form-label">Seller Id</label>
                                            <input id="sellerId" name="sellerId" class="form-control" value="<?php echo $row['seller_id']; ?>" required></input>
                                            <div class="invalid-feedback">
                                                Please, enter seller id!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="description" class="form-label">Product Description</label>
                                            <textarea id="description" name="productdescription" rows="5" class="form-control" required><?php echo $row['product_description']; ?></textarea>
                                            <div class="invalid-feedback">
                                                Please, enter product description!
                                            </div>
                                        </div>

                                        <div class="image_section">
                                            <label for="images" class="form-label">Product Images</label>
                                        </div>

                                        <div class="image-field" style="display: flex; align-items: center;">
                                            <div style="flex: 1;">
                                                <?php if ($row['product_image_url']) { ?>
                                                    <img src="<?php echo $row['product_image_url']; ?>" alt="Product Image" style="max-width: 100px; max-height: 100px; margin-top: 10px;">
                                                <?php } ?>
                                            </div>
                                            <div style="flex: 1;">
                                                <input type="file" id="image" name="image" accept="image/*" class="form-control" title="choose File" style="font-size: 12px;" />
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-center">
                                            <button class="btn btn-primary w-50" name="update-product" type="submit">
                                                Update Product
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center" title="back-to-top"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>