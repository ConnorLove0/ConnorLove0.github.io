<?php
session_start();
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'calove';
$DATABASE_PASS = 'VXvsjr71!';
$DATABASE_NAME = 'onlinestore';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
    // Could not get the data that should have been sent.
    $response = array("error" => "Please fill both the username and password fields!");
    header("Content-Type: application/json");
    echo json_encode($response);
    exit();
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if (
    $stmt = $con->prepare('SELECT id, password, created_at, last_login,
login_count FROM accounts WHERE username = ?')
) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password, $created_at, $last_login, $login_count);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if ($_POST['password'] === $password) {
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in,
            //they basically act like cookies but remember the data on the server.
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['id'] = $id;
            $_SESSION['created_at'] = $created_at;
            $_SESSION['last_login'] = $last_login;
            $_SESSION['login_count'] = $login_count;

            // Update the last_login field in the database
            date_default_timezone_set('America/New_York');
            $current_datetime = date('Y-m-d H:i:s');
            $stmt_update = $con->prepare('UPDATE accounts SET last_login = ? WHERE id = ?');
            $stmt_update->bind_param('si', $current_datetime, $id);
            $stmt_update->execute();

            // Increment the login_count for the user in the database
            $new_login_count = $login_count + 1;
            $stmt_update = $con->prepare('UPDATE accounts SET login_count = ? WHERE id = ?');
            $stmt_update->bind_param('ii', $new_login_count, $id);
            $stmt_update->execute();

            error_log("Username: " . $_SESSION['username']);
            error_log("User ID: " . $id);
            error_log("Created At: " . $created_at);
            error_log("Last Login: " . $last_login);
            error_log("Login Count: " . $login_count);

            // Now we check if the data from the login form was submitted, isset() will check if the data exists.
            if (!isset($_POST['username'], $_POST['password'])) {
                // Could not get the data that should have been sent.
                // Could not get the data that should have been sent.
                $response = array("error" => "Please fill both the username and password fields!");
                header("Content-Type: application/json");
                echo json_encode($response);
                exit();
            }

            // Send the JSON response with the username if it's an AJAX request
            if (isset($_GET['getLoggedInUserData']) && $_GET['getLoggedInUserData'] === 'true') {
                if (isset($_SESSION['username'])) {
                    $userData = array(
                        "username" => $_SESSION['username'],
                        "id" => $_SESSION['id'],
                        "created_at" => $_SESSION['created_at'],
                        "last_login" => $_SESSION['last_login'],
                        "login_count" => $_SESSION['login_count']
                    );

                    header("Content-Type: application/json");
                    echo json_encode($userData);
                    exit();
                } else {
                    $response = array("error" => "User not logged in");
                    header("Content-Type: application/json");
                    echo json_encode($response);
                    exit();
                }
            }

            header('Location: home.php');
            header('Location: seestore.php');
        } else {
            // Incorrect password
            echo 'Incorrect username and/or password!';
        }
    } else {
        // Incorrect username
        echo 'Incorrect username and/or password!';
    }

    $stmt->close();
}
?>