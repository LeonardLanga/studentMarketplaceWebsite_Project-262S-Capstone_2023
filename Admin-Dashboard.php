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

$salesQuery = "SELECT p.product_name, p.product_price, p.cat_id, o.buyer_id, u.user_name as buyer_name, py.payment_date, o.order_quantity 
               FROM products p 
               INNER JOIN orders o ON p.product_id = o.product_id 
               INNER JOIN users u ON o.buyer_id = u.user_id
               INNER JOIN payments py ON o.order_id = py.order_id
               WHERE o.order_status = 'complete'";

$salesResult = $conn->query($salesQuery);

$categoryQuery = "SELECT cat_id, cat_name FROM category";
$categoryResult = $conn->query($categoryQuery);
$categoryMap = [];
if ($categoryResult->num_rows > 0) {
  while ($row = $categoryResult->fetch_assoc()) {
    $categoryMap[$row['cat_id']] = $row['cat_name'];
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Admin-Dashboard</title>
  <meta content="" name="description" />
  <meta content="" name="keywords" />

  <!-- Favicons -->
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
        <a class="nav-link" href="Admin-Dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="Admin-Products.php">
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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="Admin-Dashboard.php">Home</a>
          </li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>

    <section class="section dashboard">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Products</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cart"></i>
                    </div>
                    <div class="ps-3">
                      <?php

                      $countQuery = "SELECT COUNT(*) AS products_count FROM Products";
                      $result = $conn->query($countQuery);

                      if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $productsCount = $row['products_count'];

                        echo "<h6>$productsCount</h6>";
                      } else {
                        echo "<h6>0</h6>";
                      }

                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Sales</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <?php

                      $countQuery = "SELECT COUNT(*) AS sales_count FROM payments";
                      $result = $conn->query($countQuery);

                      if ($result->num_rows > 0) {

                        $row = $result->fetch_assoc();
                        $salesCount = $row['sales_count'];

                        echo "<h6>$salesCount</h6>";
                      } else {
                        echo "<h6>0</h6>";
                      }

                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-xl-12">
              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">System Users</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <?php

                      $countQuery = "SELECT COUNT(*) AS users_count FROM Users";
                      $result = $conn->query($countQuery);

                      if ($result->num_rows > 0) {

                        $row = $result->fetch_assoc();
                        $usersCount = $row['users_count'];

                        echo "<h6>$usersCount</h6>";
                      } else {
                        echo "<h6>0</h6>";
                      }

                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="pagetitle">
          <h1>Recent Sales</h1>
        </div>

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div style="margin-bottom: 20px"></div>
              <table id="example" class="table table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Day of sale</th>
                    <th>Quantity</th>
                    <th>Buyer</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($salesResult->num_rows > 0) {

                    while ($row = $salesResult->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["product_name"] . "</td>";
                      echo "<td>" . $row["product_price"] . "</td>";
                      echo "<td>" . $categoryMap[$row["cat_id"]] . "</td>";
                      echo "<td>" . $row["payment_date"] . "</td>";
                      echo "<td>" . $row["order_quantity"] . "</td>";
                      echo "<td>" . $row["buyer_name"] . "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='7'>No sales data available</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="pagetitle">
          <h1>Pending Orders</h1>
        </div>

        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <div style="margin-bottom: 20px"></div>
              <table id="example1" class="table table-striped" style="width: 100%">
                <thead>
                  <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Order Date</th>
                    <th>Quantity</th>
                    <th>Buyer</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $pendingOrdersQuery = "SELECT p.product_name, p.product_price, p.cat_id, o.order_date, o.order_quantity, u.user_name as buyer_name 
                                 FROM products p 
                                 INNER JOIN orders o ON p.product_id = o.product_id 
                                 INNER JOIN users u ON o.buyer_id = u.user_id
                                 WHERE o.order_status = 'pending'";

                  $pendingOrdersResult = $conn->query($pendingOrdersQuery);

                  if ($pendingOrdersResult->num_rows > 0) {

                    while ($row = $pendingOrdersResult->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["product_name"] . "</td>";
                      echo "<td>" . $row["product_price"] . "</td>";
                      echo "<td>" . $categoryMap[$row["cat_id"]] . "</td>";
                      echo "<td>" . $row["order_date"] . "</td>";
                      echo "<td>" . $row["order_quantity"] . "</td>";
                      echo "<td>" . $row["buyer_name"] . "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='6'>No pending orders available</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
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