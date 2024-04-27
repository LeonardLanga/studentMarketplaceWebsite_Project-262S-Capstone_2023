<?php
session_start();
include 'db_connection.php';

$error_message = '';

if (isset($_POST['signin'])) {
  $studentemail = $_POST['studentemail'];
  $userspassword = $_POST['userspassword'];

  $query = "SELECT user_id, user_student_email, user_password, user_role FROM Users WHERE user_student_email = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("s", $studentemail);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($userspassword, $user['user_password'])) {
      $_SESSION['user_id'] = $user['user_id'];
      $role = $user['user_role'];
      if ($role === 'Admin') {
        echo '<script>
                alert("Login successful! Redirecting to admin page.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Admin-Dashboard.php"; 
              </script>';
      } else if ($role === 'Customer') {
        echo '<script>
                alert("Login successful! Redirecting to user page.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Welcome-page.html"; 
              </script>';
      } else {
        echo '<script>
                alert("Invalid role. Please contact administrator.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Sign-in.html";
              </script>';
      }
      exit;
    } else {
      echo '<script>
              alert("Invalid password. Please try again.");
              window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Sign-in.html";
            </script>';
    }
  } else {
    echo '<script>
            alert("Invalid email. Please try again.");
            window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Sign-in.html";
          </script>';
  }
}

$conn->close();
