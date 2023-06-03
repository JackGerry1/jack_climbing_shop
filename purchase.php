<!-- 
    Reference: PHP (2023b). PHP: mysqli::real_escape_string - Manual. [Online] php.net. Available at: https://www.php.net/manual/en/mysqli.real-escape-string.php [Accessed 29th March 2023].
‌    Code Purpose: To make sure the users input cannot be a SQL injection by purchasing products. 
    Code Modifications: Being used on the users input from the HTML forms. 
    Line Range Of Referenced Code: 18 to 20.
-->
<?php
// Start session
session_start();

// Include configuration file
require_once('templates/config.php');

// Create a database connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Sanitize user input to prevent SQL injection
$email = mysqli_real_escape_string($link, $_SESSION['email']);
$product_id = mysqli_real_escape_string($link, $_POST['product_id']);
$quantity = mysqli_real_escape_string($link, $_POST['quantity']);

// Query the database to retrieve user's customer ID
$query = "SELECT customer_id FROM `customers` WHERE `email`='$email'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

// Set customer ID variable
$customer_id = $row['customer_id'] ?? '';

// Query the database to retrieve product details
$query = "SELECT * FROM `products` WHERE `PRODUCT_ID`='$product_id'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

// Calculate new stock value
$new_stock = $row['stock'] - $quantity;

// Update product stock in database
$query = "UPDATE `products` SET `stock`='$new_stock' WHERE `PRODUCT_ID`='$product_id'";
mysqli_query($link, $query);

// Get the current date and time
$purchase_date = date('Y-m-d H:i:s');

// Insert purchase record into database
$query = "INSERT INTO `purchases` (`customer_id`, `product_id`, `quantity`, `purchase_date`) VALUES ('$customer_id', '$product_id', '$quantity', '$purchase_date')";
mysqli_query($link, $query);

// Close database connection
mysqli_close($link);

// Redirect user back to the welcome page
header("Location: welcome.php");
exit();
?>
