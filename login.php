<!--
    Reference: PHP (2023b). PHP: mysqli::real_escape_string - Manual. [Online] php.net. Available at: https://www.php.net/manual/en/mysqli.real-escape-string.php [Accessed 29th March 2023].
‌    Code Purpose: To make sure the user's input cannot be a SQL injection alongside the stripslashes function.
    Code Modifications: Being used on the user input from the HTML forms.
    Line Range Of Referenced Code: 27 to 28.

    Reference: Alex Web Develop (2019). PHP Login with Sessions and MySQL: the Complete Tutorial. [online] Alex Web Develop. Available at: https://alexwebdevelop.com/user-authentication/#security [Accessed 29th March 2023].
    Code Purpose: To allow users to login into their accounts.
    Code Modifications: If the user has logged in successfully they will be redirected to the welcome page.
    Line Range Of Referenced Code: 39 to 50
   
    Reference: Alex Web Develop (2020). PHP Password Hashing tutorial (with examples). [online] Alex Web Develop. Available at: https://alexwebdevelop.com/php-password-hashing/ [Accessed 29th March 2023].
    Code Purpose: To verify that the user's entered password matches the stored salted hash in the database.  
    Code Modifications: By allowing users to enter their password using an HTML form.
    Line Range Of Referenced Code: 39 to 50
-->

<?php
// Include configuration file & header file.
require_once('templates/config.php');
require_once('templates/header.php');

// Create a database connection
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Start the session
session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    // Sanitize user input to prevent SQL injection    
    $email = mysqli_real_escape_string($link, $_POST['email']);    
    $password = mysqli_real_escape_string($link, $_POST['password']);

    // Check if email and password match records in database
    $query = "SELECT * FROM `customers` WHERE `email`='$email'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password . $row['password_salt'], $row['password_hash'])) {
        // Login successful, set session variables and redirect to welcome page
        session_start();
        $_SESSION['email'] = $row['email'];
        $_SESSION['customer_id'] = $row['customer_id'];
        header("Location: welcome.php");
        exit();
    } else {
        // Login failed, display error message or redirect to login page
        header("Location: login.php?error=1");
        exit();
    }    
} else {
    // display error message and redirect to login page
    $error = "Please enter your email and password.";

    if (isset($_GET['error'])) {
        $error = "Login failed. Please try again.";
    }
}
?>
<div class="main-content">
    <!-- Display Login Form & Error Messages when there is one. -->
    <form method="post">
        <h1>Login</h1>
        <p>Please fill in your credentials to login.</p>
        <hr />
        <?php if (isset($error)): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <!-- Allow Users To Enter Their Email. -->
        <label for="email"><b>Email</b></label>
        <input
            type="email"
            placeholder="Enter Email"
            name="email"
            required
        />
        <!-- Allow Users To Enter Their Password. -->
        <label for="password"><b>Password</b></label>
        <input
            type="password"
            placeholder="Enter Password"
            name="password"
            required
        />

        <hr />
        <!-- Login Button & Redirect Button To Registration Page. -->
        <button type="submit" class="loginbtn">Login</button>
        <p>Don't have an account? <a href="register.php">Register Now</a></p>
    </form>
</div>
<!-- Include Footer code. -->
<?php
    require_once('templates/footer.php');
?>
