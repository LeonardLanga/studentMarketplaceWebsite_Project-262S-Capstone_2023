<?php
session_start();

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  $to = "langaleonard97@gmail.com";
  $headers = "From: $email \r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  $emailContent = "You have received a new message from your website contact form.<br>";
  $emailContent .= "Here are the details:<br><br>";
  $emailContent .= "<strong>Name:</strong> $name<br>";
  $emailContent .= "<strong>Email:</strong> $email<br>";
  $emailContent .= "<strong>Subject:</strong> $subject<br>";
  $emailContent .= "<strong>Message:</strong><br>$message<br>";

  if (mail($to, $subject, $emailContent, $headers)) {
    echo '<script>
          alert("Your message has been sent. Thank you!");
          window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Contact-Us.php";
        </script>';
  } else {
    echo '<script>
          alert("Failed to send the message. Please try again later.");
          window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Contact-Us.php";
        </script>';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Contact-Us</title>
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

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet" />

</head>

<body>
  <header id="header" class="header fixed-top d-flex align-items-center justify-content-center">
    <div>
      <a href="product-listing.php" class="logo d-flex align-items-center" title="Edu Market">
        <img src="logo/eduMarket.svg" alt="Edu Market" />
      </a>
    </div>
  </header>
  <main style="margin-top: 180px">
    <div class="container">
      <section class="section contact">
        <div class="pagetitle" style="margin: 40px 0px">
          <h1>Contact Us</h1>
          <nav style="margin-top: 10px">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="product-listing.php">Products</a>
              </li>
              <li class="breadcrumb-item active">Contact Us</li>
            </ol>
          </nav>
        </div>
        <div class="row gy-4">
          <div class="col-xl-6">
            <div class="row">
              <div class="col-lg-6">
                <div class="info-box card">
                  <i class="bi bi-geo-alt"></i>
                  <h3>Address</h3>
                  <p>New Market Junction<br />New York, NY 535022</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="info-box card">
                  <i class="bi bi-telephone"></i>
                  <h3>Call Us</h3>
                  <p>+27 72 776 2597<br />+1 6678 254445 41</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="info-box card">
                  <i class="bi bi-envelope"></i>
                  <h3>Email Us</h3>
                  <p>221069054@mycput.ac.za<br />contact@example.com</p>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="info-box card">
                  <i class="bi bi-clock"></i>
                  <h3>Working Hours</h3>
                  <p>Monday - Friday<br />9:00AM - 05:00PM</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-6">

            <form method="post" class="php-email-form">
              <div class="row gy-4">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required />
                </div>

                <div class="col-md-6">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required />
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required />
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <button type="submit">Send Message</button>
                </div>
              </div>
            </form>

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
  <script src="../assets/js/main.js"></script>

</body>

</html>