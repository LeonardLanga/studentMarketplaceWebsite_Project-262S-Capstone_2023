<?php
session_start();
include 'db_connection.php';

if (isset($_GET['logout'])) {
  session_destroy();
  echo '<script>
          alert("Sign-out successful");
          window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Sign-in.html";
        </script>';
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Products</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <link rel="icon" href="favicon/favicon.ico" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;600;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

  <script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>

  <script defer src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <script defer src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script defer src="js/my-script.js"></script>
  <script src="https://kit.fontawesome.com/6a4151cb09.js" crossorigin="anonymous"></script>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet" />

</head>

<body>
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="Admin-Dashboard.php" class="logo d-flex align-items-center" title="Edu Market">
        <img src="logo/eduMarket.svg" alt="" title="Edu Market" />
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
  </header>

  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="Admin-Dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="Admin-Products.php">
          <i class="fa-solid fa-cart-shopping"></i>
          <span>Products</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="Admin-Categories.php">
          <i class="fa-solid fa-filter"></i>
          <span>Categories</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="Admin-Users.php">
          <i class="fa-solid fa-user"></i>
          <span>Users</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed logo-out" href="?logout=true">
          <i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal"></i>
          <span class="my-style">Log-out</span>
        </a>
      </li>

    </ul>
  </aside>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Products</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="Admin-Dashboard.php">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Products</li>
        </ol>
      </nav>
    </div>

    <div class="link-to-login">
      <a href="Admin-Add-Product.html">Add Product</a>
    </div>

    <section class="section dashboard">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div style="margin-bottom: 20px"></div>
            <table id="example" class="table table-striped" style="width: 100%">
              <thead>
                <tr>
                  <th>Image</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $productQuery = "SELECT p.*, c.cat_name FROM products p 
                        INNER JOIN category c ON p.cat_id = c.cat_id";
                $productResult = $conn->query($productQuery);

                if ($productResult->num_rows > 0) {
                  while ($row = $productResult->fetch_assoc()) {
                    echo "<tr>";
                    echo '<td><img src="' . $row['product_image_url'] . '" height="100" alt="Product Image"></td>';
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['cat_name'] . "</td>";
                    echo "<td>" . $row['product_price'] . "</td>";
                    echo "<td>" . $row['product_quantity'] . "</td>";
                    echo "<td>
                            <div class='crud-operations'>
                              <a href='Admin-update-product.php?product_id=" . $row['product_id'] . "'  class='update'>Update</a>
                              <a href='Admin-delete-product.php?product_id=" . $row['product_id'] . "' class='delete'>Delete</a>
                            </div>
                          </td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='6'>No product data available</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div style="margin-bottom: 20px"></div>
            <table id="example1" class="table table-striped" style="width: 100%">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Condition</th>
                  <th>Upload date</th>
                  <th>Seller</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $productQuery = "SELECT p.*, u.user_name FROM products p 
                            INNER JOIN users u ON p.seller_id = u.user_id";
                $productResult = $conn->query($productQuery);

                if ($productResult->num_rows > 0) {
                  while ($row = $productResult->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['product_description'] . "</td>";
                    echo "<td>" . $row['product_condition'] . "</td>";
                    echo "<td>" . $row['product_date_of_upload'] . "</td>";
                    echo "<td>" . $row['user_name'] . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='5'>No product data available</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
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