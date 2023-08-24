<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'calove';
$DATABASE_PASS = 'VXvsjr71!';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // Return an error response if there is a database connection error
    echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
    exit;
}
// Get the username from the session
$loggedInUsername = $_SESSION['username'];

// Retrieve the user ID from the database based on the username
$stmt = $con->prepare('SELECT id FROM accounts WHERE username = ?');
$stmt->bind_param('s', $loggedInUsername);
$stmt->execute();
$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

// Check if the request is a POST request and if the required data is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['card_name'], $_POST['card_type'], $_POST['card_image_url'])) {

    $cardName = $_POST['card_name'];
    $cardType = $_POST['card_type'];
    $cardImageUrl = $_POST['card_image_url'];
    $created_at = date('Y-m-d H:i:s');

    // Prepare the INSERT statement to add the card to the user_cards table
    $stmt = $con->prepare('INSERT INTO user_cards (user_id, card_name, card_type, created_at, card_image_url)
        VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('issss', $userId, $cardName, $cardType, $created_at, $cardImageUrl);

    if ($stmt->execute()) {
        // Return a JSON response indicating success.
        echo  'Card added successfully!';
    } else {
        // Return a JSON response indicating failure.
        echo 'Failed to add the card.';
        echo 'Error executing SQL: ' . $stmt->error; // Log any SQL errors
    }

    $stmt->close();
}

?>