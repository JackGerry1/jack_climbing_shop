# User Registration and Login System

This code repository contains PHP files for a user registration and login system. It allows users to create an account, log in with their credentials, and log out when needed. The system uses a MySQL database to store user information securely.

## Files

The repository includes the following files:

1. `welcome.php`: This file is responsible for displaying a welcome message to logged-in users. It includes search forms to search for products based on user input. The file connects to the database, retrieves user information, and performs search queries. It also handles logout functionality.

2. `purchase.php`: This file handles the purchase of products by logged-in users. It interacts with the database to update product stock and record the purchase details. It sanitizes user input to prevent SQL injection.

3. `script.js`: This JavaScript file enhances the functionality of the search form in `welcome.php`. It sets up and updates a price range slider, allowing users to select a price range for product searches. It also updates the hidden input values based on the slider's position.

4. `register.php`: This file handles user registration. It validates user inputs, generates a salted hash of the password, and inserts the user's data into the database.

5. `login.php`: This file handles user login. It verifies the user's entered password against the stored salted hash in the database and sets session variables for authenticated users.

6. `logout.php`: This file handles user logout. It destroys the session and redirects the user to the login page.

7. `templates/config.php`: This file contains the configuration settings for connecting to the MySQL database. It should be modified with the appropriate database credentials before use.

8. `templates/header.php` and `templates/footer.php`: These files are included in `register.php` and `login.php` to provide a common header and footer for the pages, ensuring consistent styling and structure.

Please refer to the individual file descriptions for more details on their functionality and usage.

## References:

The code includes references to external resources for specific functions or concepts. These references provide additional information and context for the code implementation. Please refer to the following references for more details:

- [PHP: bin2hex - Manual](https://www.php.net/manual/en/function.bin2hex.php): Reference for the `bin2hex` function used to generate a salt for the user's password.
- [PHP: mysqli::real_escape_string - Manual](https://www.php.net/manual/en/mysqli.real-escape-string.php): Reference for the `mysqli_real_escape_string` function used to prevent SQL injection in user input.
- [PHP Login with Sessions and MySQL: the Complete Tutorial](https://alexwebdevelop.com/user-authentication/#security): Tutorial covering user authentication and login process.
- [PHP Password Hashing tutorial (with examples)](https://alexwebdevelop.com/php-password-hashing/): Tutorial explaining password hashing and verification in PHP.
- [Jquery User Interface: Slider](https://jqueryui.com/slider/#range) - Reference for implementing a slider using jQuery UI.

## register.php

This file handles user registration. It validates user inputs, generates a salted hash of the password, and inserts the user's data into the database.
- **References:**
  - [PHP: mysqli::real_escape_string - Manual](https://www.php.net/manual/en/mysqli.real-escape-string.php) - Reference for using mysqli_real_escape_string() function to prevent SQL injection.

- **Code Purpose:**
   - Validates user input to ensure data integrity.
   - Generates a salted hash of the password for secure storage.
   - Inserts user data into the database.

## login.php

This file handles user login. It verifies the user's entered password against the stored salted hash in the database and sets session variables for authenticated users.

- **References:**

   - [PHP: mysqli::real_escape_string - Manual](https://www.php.net/manual/en/mysqli.real-escape-string.php) - Reference for using mysqli_real_escape_string() function to prevent SQL injection.

- **Code Purpose:**
   - Validates user input to ensure data integrity.
   - Retrieves stored salted hash of the password from the database.
   - Verifies the entered password against the stored hash.
   - Sets session variables for authenticated users.

## logout.php

This file handles user logout. It destroys the session and redirects the user to the login page.

- **Code Purpose:**

    - Destroys the current session to log out the user.
    - Redirects the user to the login page for reauthentication.

## header.php and footer.php

These files are included in other PHP files, such as register.php and login.php, to provide a common header and footer for the pages, ensuring consistent styling and structure.

- **Code Purpose:**

   - Provides a common header and footer for PHP files.
   - Ensures consistent styling and structure across pages.


## welcome.php

This file is a PHP script that displays a welcome message to a logged-in user. It also provides a search functionality to search for products based on user input.

- **References:**
  - [PHP: mysqli::real_escape_string - Manual](https://www.php.net/manual/en/mysqli.real-escape-string.php) - Reference for using `mysqli_real_escape_string()` function to prevent SQL injection.

- **Code Purpose:**
  - Sanitizes user input to prevent SQL injection when querying the database.
  - Retrieves user's first and last name from the database.
  - Performs product search based on user's input and selected filters.

## purchase.php

This file is a PHP script that handles the purchase of products by a logged-in user. It updates the product stock in the database and inserts a purchase record.

- **References:**
  - [PHP: mysqli::real_escape_string - Manual](https://www.php.net/manual/en/mysqli.real-escape-string.php) - Reference for using `mysqli_real_escape_string()` function to prevent SQL injection.

- **Code Purpose:**
  - Sanitizes user input to prevent SQL injection when updating the database.
  - Retrieves user's customer ID from the database.
  - Retrieves product details from the database.
  - Updates product stock in the database.
  - Inserts a purchase record into the database.

## script.js

This file contains JavaScript code that provides functionality for the price range slider in the HTML form.

- **References:**
  - [Jquery User Interface: Slider](https://jqueryui.com/slider/#range) - Reference for implementing a slider using jQuery UI.

- **Code Purpose:**
  - Sets up a price range slider with default values.
  - Updates the slider values and positions as the user interacts with them.
  - Updates hidden inputs with the current slider values.

## Usage

To use this code, follow these steps:

1. Set up a MySQL database and update the `templates/config.php` file with your database credentials.
2. Upload the PHP files to your web server or run them on a local development environment with PHP and MySQL support.
3. Access `register.php` to create a new user account.
4. Access `login.php` to log in with the registered user credentials.
5. Access `logout.php` to log out of the current session.

Feel free to modify and customize the code according to your specific requirements.


