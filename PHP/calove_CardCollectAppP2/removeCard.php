<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'calove';
$DATABASE_PASS = 'VXvsjr71!';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['loggedin'])) {
    header('Location: http://localhost/phplogin/420710/login.html');
    exit;
}

// Check if the request is a POST request and if the required data is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['card_name'])) {
    $loggedInUserId = $_SESSION['id'];
    $cardName = $_POST['card_name'];

    // Prepare the DELETE statement to remove the card from the user_cards table
    $stmt = $con->prepare('DELETE FROM user_cards WHERE user_id = ? AND card_name = ?');
    $stmt->bind_param('is', $loggedInUserId, $cardName);

    if ($stmt->execute()) {
        // Return a JSON response indicating success.
        echo json_encode(array('status' => 'success', 'message' => 'Card removed successfully!'));
    } else {
        // Return a JSON response indicating failure.
        echo json_encode(array('status' => 'error', 'message' => 'Failed to remove the card.'));
        echo 'Error executing SQL: ' . $stmt->error; // Log any SQL errors
    }

    $stmt->close();
}
?>