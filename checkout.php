<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_SESSION['order_id']) && isset($_SESSION['total_amount'])) {

    $orderId = $_SESSION['order_id'];
    $totalAmount = $_SESSION['total_amount'];
    $paymentMethod = $_POST['paymethod'];

    $createPaymentQuery = "INSERT INTO payments (order_id, payment_amount, payment_method) VALUES (?, ?, ?)";
    $createPaymentStmt = $conn->prepare($createPaymentQuery);
    $createPaymentStmt->bind_param("ids", $orderId, $totalAmount, $paymentMethod);
    $createPaymentStmt->execute();

    $updateOrderQuery = "UPDATE orders SET order_status = 'complete' WHERE order_id = ?";
    $updateOrderStmt = $conn->prepare($updateOrderQuery);
    $updateOrderStmt->bind_param("i", $orderId);
    $updateOrderStmt->execute();

    $reduceQuantityQuery = "UPDATE products SET product_quantity = product_quantity - (SELECT order_quantity FROM orders WHERE order_id = ?) WHERE product_id IN (SELECT product_id FROM orders WHERE order_id = ?)";
    $reduceQuantityStmt = $conn->prepare($reduceQuantityQuery);
    $reduceQuantityStmt->bind_param("ii", $orderId, $orderId);
    $reduceQuantityStmt->execute();

    unset($_SESSION['order_id']);
    unset($_SESSION['total_amount']);
    echo '<script>
            alert("Payment Successful");
            window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Cart.php";
          </script>';
    exit();
  } else {
    echo '<script>
            alert("Sessions are not set");
            window.location.href = "http://localhost/System_EduMarket-ecommerce_website/checkout.php";
          </script>';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Checkout</title>
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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet" />

  <script src="https://kit.fontawesome.com/6a4151cb09.js" crossorigin="anonymous"></script>

</head>

<body>

  <header id="header" class="header fixed-top d-flex align-items-center justify-content-between">
    <div>
      <a href="product-listing.php" class="logo d-flex" title="Edu Market">
        <img src="logo/eduMarket.svg" alt="Edu Market" />
      </a>
    </div>
  </header>

  <main style="margin-top: 180px">

    <div class="container">
      <div class="pagetitle">
        <h1>Checkout</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="product-listing.php">Products</a>
            </li>
            <li class="breadcrumb-item">
              <a href="Cart.php">Cart</a>
            </li>
          </ol>
        </nav>
      </div>

      <section class="section profile my-5">
        <div class="col-xl-8 container">
          <div class="card">
            <div class="card-body pt-3">
              <h1 style="font-size: 26px; text-align: center" class="my-5">
                Payment Details
              </h1>
              <div class="tab-content pt-2">
                <form method="post">
                  <div class="row mb-3">
                    <label for="paymethod" class="col-md-4 col-lg-3 col-form-label">Payment method :</label>
                    <div class="col-md-8 col-lg-9">
                      <select id="paymethod" name="paymethod" class="form-control">
                        <option value=""></option>
                        <option value="Visa">Visa</option>
                        <option value="PayPal">PayPal</option>
                        <option value="EFT">EFT</option>
                      </select>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="cardnum" class="col-md-4 col-lg-3 col-form-label">Card Number :</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="cardnum" type="text" class="form-control" id="cardnum" />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="exdate" class="col-md-4 col-lg-3 col-form-label">Expiration Date :</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="exdate" type="date" class="form-control" id="exdate" />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="cvv" class="col-md-4 col-lg-3 col-form-label">CVV</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="cvv" type="text" class="form-control" id="cvv" maxlength="3" />
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="holdername" class="col-md-4 col-lg-3 col-form-label">Card Holder Name :
                    </label>
                    <div class="col-md-8 col-lg-9">
                      <input name="holdername" type="text" class="form-control" id="holdername" />
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary my-5">
                      Confirm Payment
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <a href="#" title="back-to-top" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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