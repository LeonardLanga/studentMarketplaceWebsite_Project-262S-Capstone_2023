<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentemail = $_POST["studentemail"];

    $checkQuery = "SELECT * FROM users WHERE user_student_email = '$studentemail'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult->num_rows > 0) {

        echo '<script>
                alert("User with this email already registered.");
                window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Register.html";
              </script>';
    } else {

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $phonenumber = $_POST["phonenumber"];
        $studentemail = $_POST["studentemail"];
        $userspassword = $_POST["userspassword"];
        $residence = $_POST["residence"];
        $role = "Customer";
        $hashedPassword = password_hash($userspassword, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Users (user_name, user_lastname, user_tel_no, user_student_email, user_password, user_place_of_residence, user_role) 
        VALUES 
            ('$firstname', '$lastname', '$phonenumber', '$studentemail', '$hashedPassword', '$residence', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>
                    alert("Registration successful!");
                    window.location.href = "http://localhost/System_EduMarket-ecommerce_website/Sign-in.html";
                </script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
