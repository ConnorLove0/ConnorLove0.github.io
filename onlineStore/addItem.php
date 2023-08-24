<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
var_dump($_POST);
error_reporting(E_ALL);
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'calove';
$DATABASE_PASS = 'VXvsjr71!';
$DATABASE_NAME = 'onlinestore';

// Create a new mysqli object and establish the connection
$mysqli = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check if the connection was successful
if ($mysqli->connect_errno) {
    die('Failed to connect to the database: ' . $mysqli->connect_error);
}
// Get the username from the session
$retrievedUsername = $_SESSION['username'];

// Debug: Check the value of $userId
$user_id = (int)$_POST['user_id'];
echo "Retrieved user ID: " . $user_id;
// Display the values received via POST
echo "user_id: " . $_POST['user_id'] . " (Type: " . gettype($_POST['user_id']) . ")<br>";
echo "item_id: " . $_POST['item_id'] . " (Type: " . gettype($_POST['item_id']) . ")<br>";
echo "item_title: " . $_POST['item_title'] . " (Type: " . gettype($_POST['item_title']) . ")<br>";
echo "item_price: " . $_POST['item_price'] . " (Type: " . gettype($_POST['item_price']) . ")<br>";
echo "item_image: " . $_POST['item_image'] . " (Type: " . gettype($_POST['item_image']) . ")<br>";
echo "quantitySelect: " . $_POST['quantitySelect'] . " (Type: " . gettype($_POST['quantitySelect']) . ")<br>";

    // User ID retrieved successfully, continue with the rest of the code
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "$_SERVER[REQUEST_METHOD] === 'POST'";
        if(isset($_POST['user_id'])) {
            echo "user_id is set";
        }
        else { echo "user_id is not set"; }
        if(isset($_POST['item_id'])) {
            echo "item_id is set";
        }
        else { echo "item_id is not set"; }
        if(isset($_POST['item_title'])) {
            echo "item_title is set";
        }
        else { echo "item_title is not set"; }
        if(isset($_POST['item_price'])) {
            echo "item_price is set";
        }
        else { echo "item_price is not set"; }
        
        if(isset($_POST['quantitySelect'])) {
            echo "quantitySelect is set";
        }
        else { echo "quantitySelect is not set"; }
    }

        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            &&  isset($_POST['item_id'], $_POST['item_title'], $_POST['item_price'], $_POST['item_image'], $_POST['quantitySelect'])) {
            // Set default values for color and size if they are not provided in the form
            $item_color = isset($_POST['item_color']) ? $_POST['item_color'] : "None";
            $item_size = isset($_POST['item_size']) ? $_POST['item_size'] : "None";
            if(isset($_POST['item_color'])) {
                echo "item_color is set";
            }
            else { echo "item_color is not set"; }
            if(isset($_POST['item_size'])) {
                echo "item_size is set";
            }
            else { echo "item_size is not set"; }

        // Prepare the data to be inserted into the table
        $user_id = (int) $_POST['user_id'];
        $item_id = (int) $_POST['item_id'];
        $item_title = $_POST['item_title'];
        $item_price = (float) $_POST['item_price'];
        $item_image = $_POST['item_image'];

        $quantitySelect = (int) $_POST['quantitySelect'];

        // Create a prepared statement
        $stmt = $mysqli->prepare('INSERT INTO shoppingcart (user_id, item_id, item_title, item_price, item_image, item_color, item_size, item_quantity)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)');

        // Bind the parameters to the prepared statement
        $stmt->bind_param('iisdsssi', $user_id, $item_id, $item_title, $item_price, $item_image, $item_color, $item_size, $quantitySelect);

        echo "Debug Output:";
        echo "userId: " . $user_id;
        echo "item_id: " . $item_id;
        echo "item_title: " . $item_title;
        echo "item_price: " . $item_price;
        echo "item_size: " . $item_size;
        echo "item_quantity: ".  $quantitySelect;
    // Execute the prepared statement
    if ($stmt->execute()) {
        // Item added to the shopping cart successfully
        echo 'From: AddItem.php: Item Added Successfully';
    } else {
        // Failed to add the item to the shopping cart
        echo 'Error executing SQL: ' . $stmt->error;
    }
$stmt->close();

}
?>