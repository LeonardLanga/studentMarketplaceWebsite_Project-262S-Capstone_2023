<?php
session_start();
include 'db_connection.php';


if (isset($_GET['update_user'])) {
    $userId = $_GET['update_user'];

    $query = "SELECT * FROM Users WHERE user_id = $userId";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userspassword = $_POST["password"];

    if ($userspassword === '') {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $phonenumber = $_POST["phonenumber"];
        $studentemail = $_POST["studentemail"];
        $residence = $_POST["residence"];
        $role = $_POST["role"];

        $updateQuery = $conn->prepare("UPDATE Users 
                SET user_name = ?, user_lastname = ?, user_tel_no = ?, user_student_email = ?, user_place_of_residence = ?, user_role = ?
                WHERE user_id = ?");

        $updateQuery->bind_param("ssssssi", $firstname, $lastname, $phonenumber, $studentemail, $residence, $role, $userId);

        if ($updateQuery->execute()) {

            echo '<script>
                alert("User update was successful!");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Users.php";
            </script>';
            exit;
        } else {
            echo '<script>
                alert("Error updating record.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Users.php";
            </script>';
        }
    } else {
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $phonenumber = $_POST["phonenumber"];
        $studentemail = $_POST["studentemail"];
        $userspassword = $_POST["password"];
        $residence = $_POST["residence"];
        $role = $_POST["role"];

        $hashedPassword = password_hash($userspassword, PASSWORD_DEFAULT);

        $updateQuery = $conn->prepare("UPDATE Users 
                SET user_name = ?, user_lastname = ?, user_tel_no = ?, user_student_email = ?, user_password = ?, user_place_of_residence = ?, user_role = ?
                WHERE user_id = ?");

        $updateQuery->bind_param("sssssssi", $firstname, $lastname, $phonenumber, $studentemail, $hashedPassword, $residence, $role, $userId);

        if ($updateQuery->execute()) {
            echo '<script>
                alert("User update was successful!");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Users.php";
            </script>';
            exit;
        } else {
            echo '<script>
                alert("Error updating record.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Users.php";
            </script>';
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Add User</title>
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
                                <a href="Admin-Dashboard.php" class="logo d-flex align-items-center w-auto" title="Edu Market">
                                    <img src="logo/eduMarket.svg" alt="" title="Edu Market" />
                                </a>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="col-12" style="margin-top: 10px">
                                        <a href="Admin-Users.php" style="font-size: 14px" title="back"><i class="fa-solid fa-arrow-left" style="color: black"></i></a>
                                    </div>
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Update User</h5>
                                    </div>

                                    <form class="row g-3 needs-validation" method="post" onsubmit="return validatePassword()" novalidate>
                                        <div class="col-12">
                                            <label for="firstname" class="form-label">Name</label>
                                            <input type="text" name="firstname" class="form-control" id="firstname" value="<?php echo $row['user_name']; ?>" required />
                                            <div class="invalid-feedback">Please, enter name!</div>
                                        </div>

                                        <div class="col-12">
                                            <label for="lastname" class="form-label">Lastname</label>
                                            <input type="text" name="lastname" class="form-control" id="lastname" value="<?php echo $row['user_lastname']; ?>" required />
                                            <div class="invalid-feedback">
                                                Please, enter last name!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="phonenumber" class="form-label">Tel-no</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="phonenumber" class="form-control" id="phonenumber" maxlength="10" value="<?php echo $row['user_tel_no']; ?>" />
                                                <div class="invalid-feedback">
                                                    Please, enter a tel-no.
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="studentemail" class="form-label">Student Email</label>
                                            <input type="email" name="studentemail" class="form-control" id="studentemail" value="<?php echo $row['user_student_email']; ?>" required />
                                            <div class="invalid-feedback">
                                                Please, enter student email!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" />
                                        </div>

                                        <div class="col-12">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" />
                                        </div>

                                        <div class="col-12">
                                            <label for="role" class="form-label">Role</label>
                                            <select id="role" name="role" class="form-control">
                                                <option value=""></option>
                                                <option value="Admin" <?php if ($row['user_role'] === 'Admin') echo 'selected'; ?>>Admin</option>
                                                <option value="Customer" <?php if ($row['user_role'] === 'Customer') echo 'selected'; ?>>Customer</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Please enter your password!
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="residence" class="form-label">Place of Residence</label>
                                            <input type="text" name="residence" class="form-control" id="residence" value="<?php echo $row['user_place_of_residence']; ?>" required />
                                            <div class="invalid-feedback">
                                                Please, enter place of residence!
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

    <script src="assets/js/main.js"></script>

    <script>
        function validatePassword() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;

            if (password !== confirmPassword) {
                alert("password and confirm password do not match");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>