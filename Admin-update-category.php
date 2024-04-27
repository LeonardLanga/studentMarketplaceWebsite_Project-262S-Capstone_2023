<?php
session_start();
include 'db_connection.php';

if (isset($_GET['update_category'])) {
  $categoryId = $_GET['update_category'];

  $query = "SELECT * FROM Category WHERE Cat_id = $categoryId";

  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $catid = $_POST['categoryid'];
  $catname = $_POST['categoryname'];

  $updateQuery = $conn->prepare("UPDATE category SET cat_name = ? WHERE cat_id = ?");
  $updateQuery->bind_param("si", $catname, $catid);

  if ($updateQuery->execute()) {
    echo '<script>
              alert("Category Update was successful!");
              window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Categories.php";
          </script>';
    exit;
  } else {
    echo '<script>
              alert("Error updating record.");
              window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Categories.php";
          </script>';
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Add Category</title>
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
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex justify-content-center py-4">
                <a href="Admin-Dashboard.php" class="logo d-flex align-items-center w-auto" title="Edu Market">
                  <img src="logo/eduMarket.svg" alt="" title="Edu Market" />
                </a>
              </div>

              <div class="card mb-3">
                <div class="card-body">
                  <div class="col-12" style="margin-top: 10px">
                    <a href="Admin-Categories.php" style="font-size: 14px" title="back"><i class="fa-solid fa-arrow-left" style="color: black"></i></a>
                  </div>
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">
                      Update Category
                    </h5>
                  </div>

                  <form class="row g-3 needs-validation" method="post" novalidate>
                    <div class="col-12">
                      <label for="categoryname" class="form-label">Category name</label>
                      <input type="hidden" name="categoryid" class="form-control" id="categoryid" value="<?php echo $row['cat_id']; ?>" />
                      <input type="text" name="categoryname" class="form-control" id="categoryname" value="<?php echo $row['cat_name']; ?>" required />
                      <div class="invalid-feedback">
                        Please, enter category!
                      </div>
                    </div>

                    <div class="col-12 d-flex justify-content-center">
                      <button class="btn btn-primary w-50" type="submit">
                        Update
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