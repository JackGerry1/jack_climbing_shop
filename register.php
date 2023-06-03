<!--
    Reference: PHP (2023a). PHP: bin2hex - Manual. [Online] php.net. Available at: https://www.php.net/manual/en/function.bin2hex.php [Accessed 29th March 2023].
    Code Purpose: To generate an eight-byte long salt for the user's entered password with the random_byte function.
    Code Modifications: Using the created salt to create a salted hash version of the user's entered password to be inserted into the database.
    Line Range Of Referenced Code: 50 to 70.

    Reference: PHP (2023b). PHP: mysqli::real_escape_string - Manual. [Online] php.net. Available at: https://www.php.net/manual/en/mysqli.real-escape-string.php [Accessed 29th March 2023].
‌    Code Purpose: To make sure the user's input cannot be a SQL injection alongside the strip slashes function.
    Code Modifications: Being used on the user input from the HTML forms.
    Line Range Of Referenced Code: 32 to 38.

    Reference: Alex Web Develop (2019). PHP Login with Sessions and MySQL: the Complete Tutorial. [online] Alex Web Develop. Available at: https://alexwebdevelop.com/user-authentication/#security [Accessed 29th March 2023].
    Code Purpose: To register user accounts into a database table.
    Code Modifications: By allowing users to enter their address, postcode, first name and last name into the customer's table.
    Line Range Of Referenced Code: 50 to 70
   
    Reference: Alex Web Develop (2020). PHP Password Hashing tutorial (with examples). [online] Alex Web Develop. Available at: https://alexwebdevelop.com/php-password-hashing/ [Accessed 29th March 2023].
    Code Purpose: To create a salted hash of the user's password using the PASSWORD_DEFAULT parameter.
    Code Modifications: By getting the user's password from input in a registration form, which will be inserted into the customer's table in a database.
    Line Range Of Referenced Code: 50 to 70  
-->
<?php
// Include configuration file and Header file
require_once('templates/config.php');
require_once('templates/header.php');

// Create a database connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (isset($_POST['email'])) {
    // Sanitize user input to prevent SQL injection for all inputs in the HTML forms.
    $fname = mysqli_real_escape_string($link, $_POST['fname']);   
    $lname = mysqli_real_escape_string($link, $_POST['lname']);    
    $email = mysqli_real_escape_string($link, $_POST['email']);    
    $password = mysqli_real_escape_string($link, $_POST['password']);    
    $confirm_password = mysqli_real_escape_string($link, $_POST['confirm_password']);   
    $address = mysqli_real_escape_string($link, $_POST['address']);    
    $postcode = mysqli_real_escape_string($link, $_POST['postcode']);

    // Check if user already exists in database
    $query = "SELECT * FROM `customers` WHERE `email`='$email'";
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        $error = "Email Address Already In Use, Please Try A Different Email.";
    }
    // Check if the users entered passwords match. 
    elseif ($password != $confirm_password) {
        $error = "Passwords do not match.";
    }
    else {
        // Generate Salt For Password Hash.
        $salt = bin2hex(random_bytes(32));

        // Hash user's password
        $hashed_password = password_hash($password . $salt, PASSWORD_DEFAULT);

        // Insert user's data (including hashed password and salt) into the "customers" table in the MySQL database
        $query = "INSERT INTO customers (first_name, last_name, email, address, postcode, password_hash, password_salt) 
                  VALUES ('$fname', '$lname', '$email', '$address', '$postcode', '$hashed_password', '$salt')";
        $result = mysqli_query($link, $query);

        if ($result) {
            // Registration successful, redirect user to login page
            header('Location: login.php');
            exit;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($link);
        }
    }
} 
    
?>
<div class="main-content">
    <!-- Display the registration form and any error messages if needed. -->
    <form method="post">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <hr />
        <!-- Input Field for First Name -->
        <label for="fname"><b>First name</b></label>
        <input type="text" placeholder="Enter first name" name="fname" required maxlength="100"/>
        <!-- Input Field for Last Name -->
        <label for="lname"><b>Last name</b></label>
        <input type="text" placeholder="Enter last name" name="lname" required maxlength="100"/>
        <!-- Input Field for Email -->
        <label for="email"><b>Email</b></label>
        <input type="email" placeholder="Enter Email" name="email" required maxlength="100"/>
        <!-- Input Field for Password -->
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required maxlength="255"/>
        <!-- Input Field for Confrmation Password. -->
        <label for="confirm_password"><b>Confirm Password</b></label>
        <input type="password" placeholder="Confirm Password" name="confirm_password" required maxlength="255"/>
        <!-- Input Field for Address. -->
        <label for="address"><b>Address</b></label>
        <input type="text" placeholder="Enter Address" name="address" required maxlength="255"/>
        <!-- Input Field for Postcode. -->
        <label for="postcode"><b>Postcode</b></label>
        <input type="text" placeholder="Enter Postcode" name="postcode" required maxlength="8"/>
        <hr />
        <!-- Registration Button & Login Button If The User Already Has An Account. -->
        <button type="submit" class="registerbtn">Register</button>
        <p>Already have an account? <a href="login.php">Log in</a></p>
    </form>
</div>
<!-- Include Footer code. -->
<?php 
    require_once('templates/footer.php');    
?> 