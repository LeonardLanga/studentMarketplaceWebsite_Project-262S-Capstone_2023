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

if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];
  $query = "SELECT * FROM users WHERE user_id = '$userId'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['updateUserInfo'])) {
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $residence = $_POST['res'];
  $tel_no = $_POST['phone'];
  $student_email = $_POST['email'];
  $userId = $_SESSION['user_id'];

  $query = "UPDATE users SET user_name = '$name', user_lastname = '$lastname', user_place_of_residence = '$residence', user_tel_no = '$tel_no', user_student_email = '$student_email' WHERE user_id = '$userId'";
  $result = mysqli_query($conn, $query);

  if ($result) {
    echo '<script>
            alert("Changes saved");
            window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Account-management.php";
          </script>';
    exit;
  } else {
    echo '<script>
            alert("Change Unsuccessful");
            window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Account-management.php";
          </script>';
  }
}

if (isset($_POST['changePassword'])) {
  $currentPassword = $_POST['currentpassword'];
  $newPassword = $_POST['newpassword'];
  $reenteredPassword = $_POST['renewpassword'];
  $userId = $_SESSION['user_id'];


  $query = "SELECT user_password FROM users WHERE user_id = '$userId'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);

  $storedPassword = $row['user_password'];

  if (password_verify($currentPassword, $storedPassword)) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateQuery = "UPDATE users SET user_password = '$hashedPassword' WHERE user_id = '$userId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
      echo '<script>
                  alert("Password Change Was Successful");
                  window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Account-management.php";
                </script>';
      exit;
    } else {
      echo '<script>
                alert("Password Change Was Unsuccessful");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Account-management.php";
              </script>';
    }
  } else {
    echo '<script>
            alert("Password entered does not match with current password");
            window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Account-management.php";
          </script>';
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Account Management</title>
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

  <script src="https://kit.fontawesome.com/6a4151cb09.js" crossorigin="anonymous"></script>
</head>

<body>

  <header id="header" class="header fixed-top d-flex align-items-center justify-content-between">

    <div>
      <a href="product-listing.php" class="logo d-flex" title="Edu Market">
        <img src="logo/eduMarket.svg" alt="" title="Edu Market" />
      </a>
    </div>

    <div class="d-flex" style="margin-right: 20px">
      <a class="btn btn-outline-dark" href="?logout=true" style="border-radius: 2px; font-size: 14px">
        Sign-out
        <i class="fa-solid fa-arrow-right-from-bracket"></i>
      </a>
    </div>

  </header>

  <main style="margin-top: 180px">

    <div class="container">
      <div class="pagetitle">
        <h1>Account Management</h1>
        <nav>
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="product-listing.php">Products</a>
            </li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </nav>
      </div>

      <section class="section profile my-5">
        <div class="col-xl-8 container">
          <div class="card">
            <div class="card-body pt-3">
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">
                    Overview
                  </button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">
                    Edit Profile
                  </button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">
                    Change Password
                  </button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Name :</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['user_name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Lastname :</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['user_lastname']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">
                      Student Residence
                    </div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['user_place_of_residence']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Tel-no</div>
                    <div class="col-lg-9 col-md-8"><?php echo $row['user_tel_no']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Student Email</div>
                    <div class="col-lg-9 col-md-8">
                      <?php echo $row['user_student_email']; ?>
                    </div>
                  </div>

                  <div class="text-center">
                    <a href="user-user-delete-account.php?user_id=<?php echo $row['user_id']; ?>" class="btn btn-primary">Delete Account</a>
                  </div>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                  <form method="post">
                    <div class="row mb-3">
                      <label for="name" class="col-md-4 col-lg-3 col-form-label">Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="name" type="text" class="form-control" id="name" value="<?php echo $row['user_name']; ?>" />
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Lastname</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="lastname" type="text" class="form-control" id="lastname" value="<?php echo $row['user_lastname']; ?>" />
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="res" class="col-md-4 col-lg-3 col-form-label">Residence</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="res" type="text" class="form-control" id="res" value="<?php echo $row['user_place_of_residence']; ?>" />
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Tel-no</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo $row['user_tel_no']; ?>" />
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="email" class="col-md-4 col-lg-3 col-form-label">Student Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="email" value="<?php echo $row['user_student_email']; ?>" />
                      </div>
                    </div>

                    <div class="text-center">
                      <input type="hidden" name="updateUserInfo" value="update">
                      <button type="submit" class="btn btn-primary">
                        Save Changes
                      </button>
                    </div>
                  </form>

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">

                  <form id="passwordChangeForm" method="post" onsubmit="return validatePasswordChange()">

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="currentpassword" type="password" class="form-control" id="currentPassword" required />
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword" required />
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword" required />
                      </div>
                    </div>

                    <div class="text-center">
                      <input type="hidden" name="changePassword" value="change">
                      <button type="submit" class="btn btn-primary">
                        Change Password
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

  <a href="#" title="back-to-top" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <script src="assets/js/main.js"></script>

  <script>
    function validatePasswordChange() {
      var newPassword = document.getElementById("newPassword").value;
      var renewPassword = document.getElementById("renewPassword").value;

      if (newPassword !== renewPassword) {
        alert("New password and re-entered password do not match");
        return false;
      }

      return true;
    }
  </script>

</body>

</html>