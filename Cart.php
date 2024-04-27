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
  <title>Cart</title>

  <!-- Favicon-->
  <link rel="icon" href="favicon/favicon.ico" />

  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
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
          <a class="btn btn-outline-dark" href="Account-management.php" style="border-radius: 2px">
            <i class="bi-person-fill me-1"></i>
            Account
          </a>
        </div>
      </div>
    </div>
  </nav>

  <header class="bg-dark py-5" style="margin-top: 80px">
    <div class="container px-4 px-lg-5 my-5">
      <div class="text-center text-white">
        <h1 class="display-4 fw-bolder">Shopping Cart</h1>
      </div>
    </div>
  </header>

  <section class="py-5 my-5">
    <div class="container">
      <div class="shopping-cart" style="margin-bottom : 100px">
        <table>
          <thead>
            <th>image</th>
            <th>name</th>
            <th>price</th>
            <th>quantity</th>
            <th>total price</th>
            <th>action</th>
          </thead>
          <tbody>
            <?php $totalPrice = 0; ?>
            <?php $totalQuantity = 0; ?>
            <?php
            $userId = $_SESSION['user_id'];

            $cartQuery = "SELECT products.product_id, products.product_image_url, products.product_name, products.product_price, cart.quantity FROM cart INNER JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
            $cartStmt = $conn->prepare($cartQuery);
            $cartStmt->bind_param("i", $userId);
            $cartStmt->execute();
            $cartResult = $cartStmt->get_result();

            if ($cartResult->num_rows == 0) {
              echo '<tr>
                      <td colspan="6">Cart is empty.</td>';
              echo '</tr>';
            } else {
              while ($cartRow = $cartResult->fetch_assoc()) {
                echo '<tr style="border-bottom: 1px solid #dddddd;"></tr>';
                echo '<td><img src="' . $cartRow["product_image_url"] . '" height="100" alt="Product Image"></td>';
                echo '<td>' . $cartRow["product_name"] . '</td>';
                echo '<td>R ' . $cartRow["product_price"] . '</td>';
                echo '<td>';
                echo '<form action="handle-cart.php" method="post">';
                echo '<input type="number" min="1" name="cart_quantity" value="' . $cartRow["quantity"] . '" title="quantity" style="border-radius: 6px">';
                echo '<input type="hidden" name="product_id" value="' . $cartRow["product_id"] . '">';
                echo '<input type="submit" name="update_cart" value="update" class="option-btn" style="border-radius: 2px; margin-left: 10px">';
                echo '</form>';
                echo '</td>';
                echo '<td>R ' . ($cartRow["product_price"] * $cartRow["quantity"]) . '</td>';
                echo '<td><a href="handle-cart.php?remove_item=' . $cartRow["product_id"] . '"  class="delete-btn" style="border-radius: 2px">Remove</a></td>';
                echo '</tr>';

                $totalPrice += $cartRow["product_price"] * $cartRow["quantity"];
                $totalQuantity += $cartRow["quantity"];
              }
            }

            $cartStmt->close();
            $conn->close();
            ?>

            <tr class="table-bottom">
              <td colspan="4" style="color: white"> Total :</td>
              <td style="color: white">R <?php echo $totalPrice; ?></td>
              <td><a href="handle-cart.php?delete_all" class="delete-btn" style="border-radius: 2px">Remove all</a></td>
            </tr>

          </tbody>
        </table>

        <div class="cart-btn">
          <form action="handle-cart.php" method="post">
            <input type="hidden" name="total_quantity" value="<?php echo $totalQuantity; ?>">
            <input type="hidden" name="total_price" value="<?php echo $totalPrice; ?>">
            <input type="submit" name="proceed_to_checkout" value="Proceed to Checkout" class="shop-btn" style="border-radius: 2px">
          </form>
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

</body>

</html>