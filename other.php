<?php
session_start();
include 'db_connection.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Other Products</title>

  <!-- Favicon-->
  <link rel="icon" href="favicon/favicon.ico" />

  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="css1/styles.css" rel="stylesheet" />

</head>

<body>

  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" style="height: 100px">
    <div class="container px-4 px-lg-5">
      <a href="product-listing.php" class="navbar-brand" title="Edu Market">
        <img src="logo/eduMarket.svg" alt="Edu Market" width="180" height="100" />
      </a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="product-listing.php">All Products</a></li>
              <?php

              $query = "SELECT cat_id FROM category WHERE cat_name = 'Electronics'";
              $result = mysqli_query($conn, $query);

              if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $categoryId = $row['cat_id'];
                echo '<li><a class="dropdown-item" href="Electronics.php?category_id=' . $categoryId . '">Electronics</a></li>';
              } else {
                echo "Category ID not found!";
              }
              ?>
              <?php

              $query = "SELECT cat_id FROM category WHERE cat_name = 'Appliances'";
              $result = mysqli_query($conn, $query);

              if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $categoryId = $row['cat_id'];
                echo '<li><a class="dropdown-item" href="Appliances.php?category_id=' . $categoryId . '">Appliances</a></li>';
              } else {
                echo "Category ID not found!";
              }
              ?>
              <?php

              $query = "SELECT cat_id FROM category WHERE cat_name = 'Furniture'";
              $result = mysqli_query($conn, $query);

              if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $categoryId = $row['cat_id'];
                echo '<li><a class="dropdown-item" href="Furniture.php?category_id=' . $categoryId . '">Furniture</a></li>';
              } else {
                echo "Category ID not found!";
              }
              ?>
              <?php

              $query = "SELECT cat_id FROM category WHERE cat_name = 'Books'";
              $result = mysqli_query($conn, $query);

              if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $categoryId = $row['cat_id'];
                echo '<li><a class="dropdown-item" href="Books.php?category_id=' . $categoryId . '">Books</a></li>';
              } else {
                echo "Category ID not found!";
              }
              ?>
              <?php

              $query = "SELECT cat_id FROM category WHERE cat_name = 'Other'";
              $result = mysqli_query($conn, $query);

              if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $categoryId = $row['cat_id'];
                echo '<li><a class="dropdown-item" href="other.php?category_id=' . $categoryId . '">Other</a></li>';
              } else {
                echo "Category ID not found!";
              }
              ?>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="Sell-page.html" style="margin-left: 20px">Sell</a>
          </li>
        </ul>
        <div class="d-flex">
          <a class="btn btn-outline-dark" href="Cart.php" style="margin-right: 10px; border-radius: 2px">
            <i class="bi-cart-fill me-1"></i>
            Cart
          </a>
          <a class="btn btn-outline-dark" href="Account-management.php" style="border-radius: 2px">
            <i class="bi-person-fill me-1"></i>
            Account
          </a>
        </div>
      </div>
    </div>
  </nav>


  <header class="bg-dark py-5" style="margin-top: 80px">
    <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-white">
        <h1 class="display-4 fw-bolder">Shop Other Products</h1>
      </div>
    </div>
  </header>


  <section class="py-5" style="margin-bottom: 100px">
    <div class=" container px-4 px-lg-5 mt-5">
      <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
        <?php

        if (isset($_GET['category_id'])) {
          $category_id = $_GET['category_id'];

          $productQuery = "SELECT products.* FROM products 
                 INNER JOIN category ON products.cat_id = category.cat_id 
                 WHERE products.cat_id = ?";

          $stmt = $conn->prepare($productQuery);
          $stmt->bind_param("i", $category_id);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo '<div class="col mb-5">
                      <div class="card h-100" style="border-radius: 2px">
                        <a href="Product-description.php?id=' . $row["product_id"] . '">
                          <img class="card-img-top" src="' . $row["product_image_url"] . '" alt="..." style="height: 200px; border-radius: 0px"/>
                        </a>
                        <div class="card-body p-4">
                          <div class="text-center">
                            <h5 class="fw-bolder">' . $row["product_name"] . '</h5>
                            R' . $row["product_price"] . '
                          </div>
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                          <div class="text-center">
                            <a class="btn btn-outline-dark mt-auto" style="border-radius: 2px" href="Product-description.php?id=' . $row["product_id"] . '"
                              >View Details</a
                            >
                          </div>
                        </div>
                      </div>
                    </div>';
            }
          } else {
            echo "<p style='text-align: center'>No products found.</p>";
          }

          $stmt->close();
        } else {

          echo "<p>Category ID not provided.</p>";
        }

        $conn->close();
        ?>
      </div>
    </div>
  </section>



  <footer class="py-5 bg-dark">
    <div class="container">">
      <div class="container">
        <p class="m-0 text-center text-white">Have any queries. <a href="Contact-Us.php" style="text-decoration: none">Contact Us</a></p>
      </div>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>