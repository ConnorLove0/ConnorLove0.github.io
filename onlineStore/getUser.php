<?php
// connect to database (ensure you include your database connection details here)
$mysqli = mysqli_connect("localhost", "calove", "VXvsjr71!", "onlinestore");

// Retrieve the user ID based on the provided username (replace 'username_column' with the actual column name in your 'accounts' table that stores usernames)
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Prepare the statement using a parameterized query
    $stmt = mysqli_prepare($mysqli, "SELECT id FROM accounts WHERE username = ?");

    // Bind the username as a parameter
    mysqli_stmt_bind_param($stmt, "s", $username);

    // Execute the statement
    mysqli_stmt_execute($stmt);

    // Bind the result
    mysqli_stmt_bind_result($stmt, $user_id);

    $_SESSION['$user_id'] = $user_id;

    // Fetch the result
    mysqli_stmt_fetch($stmt);

    // Close the statement
    mysqli_stmt_close($stmt);

    // Now you have the $user_id that you can use as needed
}
// close connection to MySQL (Note: It's generally good practice to close the connection after you're done with the database operations)
?>