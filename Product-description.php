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
  <title>Product description</title>

  <!-- Favicon-->
  <link rel="icon" href="favicon/favicon.ico" />

  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;600;800&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />

  <script src="https://kit.fontawesome.com/6a4151cb09.js" crossorigin="anonymous"></script>
  <!-- Core theme CSS (includes Bootstrap)-->

  <link href="css1/styles.css" rel="stylesheet" />

</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light" style="height: 100px">
    <div class="container px-4 px-lg-5">
      <a href="product-listing.php" class="navbar-brand" title="Edu Market">
        <img src="logo/eduMarket.svg" alt="Edu Market" width="180" height="100" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
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
            <i class=" bi-person-fill me-1"></i>
            Account
          </a>
        </div>
      </div>
    </div>

  </nav>

  <section class="py-5" style="margin-top: 80px">
    <div class="container px-4 px-lg-5 my-5">
      <div class="row gx-4 gx-lg-5">
        <div class="col-md-6">
          <?php
          if (isset($_GET['id'])) {
            $productId = $_GET['id'];
            $productQuery = "SELECT product_image_url FROM products WHERE product_id = $productId";
            $result = $conn->query($productQuery);

            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              echo '<img class="card-img-top mb-5 mb-md-0" src="' . $row["product_image_url"] . '" alt="..." />';
            } else {
              echo "<p>No product found.</p>";
            }
          } else {
            echo "<p>Product ID not provided.</p>";
          }
          ?>
        </div>
        <div class="col-md-6">
          <?php
          if (isset($_GET['id'])) {
            $productId = $_GET['id'];
            $productQuery = "SELECT * FROM products WHERE product_id = $productId";
            $result = $conn->query($productQuery);

            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              echo '<h1 class="display-5 fw-bolder" style="font-size: 28px;">' . $row["product_name"] . '</h1>';
              echo '<div class="fs-5 mb-5">';
              echo '<span> R' . $row["product_price"] . '</span>';
              echo '</div>';
              echo '<p>' . $row["product_description"] . '</p>';
              echo '<p> Condition : ' . $row["product_condition"] . '</p>';
              echo '<p> Quantity in stock : ' . $row["product_quantity"] . '</p>';
              echo '<p> Posted : ' . $row["product_date_of_upload"] . '</sp>';
            } else {
              echo "<p>No product found.</p>";
            }
          } else {
            echo "<p>Product ID not provided.</p>";
          }
          ?>

          <p>Seller:
            <?php
            if (isset($row["seller_id"])) {
              $sellerId = $row["seller_id"];

              $sellerQuery = "SELECT * FROM users WHERE user_id = $sellerId";
              $sellerResult = $conn->query($sellerQuery);

              if ($sellerResult->num_rows > 0) {
                $sellerRow = $sellerResult->fetch_assoc();
                echo $sellerRow["user_name"];
                echo "<br>";
                echo "Tel no: " . $sellerRow["user_tel_no"];
                echo "<br>";
                echo "Email: " . $sellerRow["user_student_email"];
                echo "<br>";
                echo "Residence: " . $sellerRow["user_place_of_residence"];
              } else {
                echo "Seller information not found.";
              }
            } else {
              echo "Seller ID not provided.";
            }
            ?>
          </p>

          <div class="d-flex">
            <input class="form-control text-center me-3" id="inputQuantity" type="number" min="1" value="1" style="max-width: 3rem" title="Enter Quantity" />
            <button class="btn btn-outline-dark flex-shrink-0" type="button" onclick="addToCart()" style="border-radius: 2px">
              <i class="bi-cart-fill me-1"></i>
              Add to cart
            </button>
          </div>

          <!-- max="<?php echo $row['product_quantity']; ?>" -->

        </div>
      </div>
    </div>
  </section>


  <footer class="py-5 bg-dark">
    <div class="container">">
      <div class="container">
        <p class="m-0 text-center text-white">Have any queries. <a href="Contact-Us.php" style="text-decoration: none">Contact Us</a></p>
      </div>
  </footer>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


  <script>
    function addToCart() {
      var inputElement = document.getElementById('inputQuantity');
      var selectedQuantity = inputElement.value;
      var maxQuantity = <?php echo $row['product_quantity']; ?>;

      if (selectedQuantity > maxQuantity) {
        alert('Cannot add more than the available stock quantity.');
      } else {
        var productId = <?php echo $row['product_id']; ?>;
        var quantity = selectedQuantity;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'add-to-cart.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              if (xhr.responseText.trim() === "Product already exists in the cart.") {
                alert('Product already exists in the cart. Go to cart to update quantity');
              } else if (xhr.responseText.trim() === "Product added to cart!") {
                alert('Product added to cart!');
              } else {
                alert('Error adding product to cart');
              }
            }
          }
        };
        xhr.send('productId=' + productId + '&quantity=' + quantity);
      }
    }
  </script>



</body>

</html>