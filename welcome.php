<!--
    Reference: PHP (2023b). PHP: mysqli::real_escape_string - Manual. [Online] php.net. Available at: https://www.php.net/manual/en/mysqli.real-escape-string.php [Accessed 29th March 2023].
‌    Code Purpose: To make sure the user's input cannot be a SQL injection for the price and other search terms.
    Code Modifications: Being used on the user input from the HTML forms.
    Line Range Of Referenced Code: 26 to 43.
-->

<?php
// Start session
session_start();

// Redirect user to login page if not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Include configuration file
require_once('templates/config.php');
require_once('templates/header.php');

// Create a database connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Sanitize user input to prevent SQL injection
$email = mysqli_real_escape_string($link, $_SESSION['email']);

// Query the database to retrieve user's first and last name
$query = "SELECT first_name, last_name FROM `customers` WHERE `email`='$email'";
$result = mysqli_query($link, $query);
$row = mysqli_fetch_assoc($result);

// Set first name and last name variables
$first_name = $row['first_name'] ?? '';
$last_name = $row['last_name'] ?? '';

// Check if search term has been submitted
if (isset($_POST['search'])) {
    // Sanitize user input to prevent SQL injection
    $search_term = mysqli_real_escape_string($link, $_POST['search']);
    $price_range_min = mysqli_real_escape_string($link, $_POST['price_range_min']);
    $price_range_max = mysqli_real_escape_string($link, $_POST['price_range_max']);
    $category = mysqli_real_escape_string($link, $_POST['category']);

    // Build the search query by splitting users search query by space.
    $query = "SELECT * FROM `products` ";
    $searcharray = explode(" ", $search_term);
    $conditions = [];
    // loop through all of the individual words in the users search query.
    foreach ($searcharray as $searchentry) {
        if ($searchentry != "") {
            $conditions[] = "product_name LIKE '%$searchentry%'";
        }
    }

    // Add conditions to the search query based on user's selected search filters.
    if (!empty($conditions)) {
        $query .= "WHERE " . implode(" AND ", $conditions);
    }
    // If the user has chosen a price range append it to the search query.
    if (!empty($price_range_min) && !empty($price_range_max)) {
        // If there are previous conditions append the price range query after an AND statement.
        if (!empty($conditions)) {
            $query .= " AND ";
        // If it is only the price range query append with a WHERE statement.
        } else {
            $query .= "WHERE ";
        }
        $query .= "price >= $price_range_min AND price <= $price_range_max";
    }
    // Append the category search to the search query.
    if (!empty($category)) {
        // if there are any previous queries append the category search with AND statement.
        if (!empty($conditions) || (!empty($price_range_min) && !empty($price_range_max))) {
            $query .= " AND ";
            // Else append with a WHERE statement.
        } else {
            $query .= "WHERE ";
        }
        $query .= "category LIKE '%$category%'";
    }

    $result = mysqli_query($link, $query);

    // Check if there are any results
    if (mysqli_num_rows($result) == 0) {
        $error_message = "<h1>Sorry, no products named '$search_term' was found within the price range of '£$price_range_min' and '£$price_range_max' in the category '$category'</h1>";
        $result = null;
    }
} else {
    // Query the database to retrieve all products
    $query = "SELECT * FROM `products`";
    $result = mysqli_query($link, $query);
}

// Close database connection
mysqli_close($link);
?>
<div class="main-content">
    <!-- Display the welcome message with the users first and last name. -->
    <h1>Welcome <?php echo $first_name . ' ' . $last_name; ?>!</h1>
    <p>You are now logged in.</p>
    <!-- Display the search forms. -->
    <form action="" method="post">
        <h1>Search Products:</h1>
        <input type="text" id="search" name="search">
        <!-- Allow Users to select a specic prodcut category. -->
        <h1>Select Category:</h1>
        <select name="category" id="category">
            <option value="" disabled selected>Select Category</option>
            <option value="Climbing Gear">Climbing Gear</option>
            <option value="Climbing Shoes">Climbing Shoes</option>
        </select>
        <!-- Display Price Range Slider -->
        <h1>Price Range:</h1>
        <div class="price-range">
            <div id="price-range-slider"></div>
            <div class="range-values">
                <span class="min-value"></span>
                <span class="max-value"></span>
            </div>
        </div>
        <!-- Allow Users to submit the search requirements and assign price minimum and maximum to hidden inputs. -->
        <input type="hidden" id="price_range_min" name="price_range_min">
        <input type="hidden" id="price_range_max" name="price_range_max">
        <button type="submit">Search</button>
    </form>
    <!-- Display Search Query For testing if neccessary. -->
    <?php //echo "<h1>".$query."</h1>";?>
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
    <table>
        <!-- Create Table Headings that correspond to the products table. -->
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Purchase Products</th>
            </tr>
        </thead>
        <tbody>
            <!-- Loop through and display all relevent products from the products table based of users search query. -->
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo "<img src='images/" . $row['image']. "' width='250px' height='250px'/>"; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo "£".$row['price']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td>
                        <!-- Display the purchase input and button for every product that is currently displayed. -->
                        <form action="purchase.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $row['PRODUCT_ID']; ?>">
                            <input type="number" name="quantity" value="1" min="1" max="<?php echo $row['stock']; ?>">
                            <button type="submit">Purchase</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <!-- Display error messages if there any. -->
    <?php elseif ($error_message): ?>
        <?php echo $error_message; ?>
    <?php endif; ?>
    <!-- Display Logout form -->
    <form action="logout.php" method="post">
        <button type="submit">Logout</button>
    </form>
</div>
<!-- Include Footer code. -->
<?php
    require_once('templates/footer.php');
?>