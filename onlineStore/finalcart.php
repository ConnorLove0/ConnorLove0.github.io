<?php
session_start();
// Replace these credentials with your actual MySQL server credentials
$servername = "localhost";
$username = "calove";
$password = "VXvsjr71!";
$dbname = "onlinestore";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['id'];
//echo "<br>User ID is ". $user_id. "</br>";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Check if the form fields are set in the POST data
    if (isset($_GET['chosen-address'])) {
        $selectedAddress = $_GET['chosen-address'];
    }

    if (isset($_GET['selected-shipping'])) {
        $selectedShipping = $_GET['selected-shipping'];
        //echo "Selected Shipping Option: $selectedShipping<br>";
    } else {
        //echo "Selected Shipping Option not found<br>";
    }

    if (isset($_GET['selected-date'])) {
        $selectedDate = $_GET['selected-date'];
        //echo "Selected Delivery Date Option: $selectedDate<br>";
    } else {
        //echo "Selected Delivery Date Option not found<br>";
    }
} else {
    echo "Form data not received";
}

// Query to fetch data from the ShoppingCart table
$sql = "SELECT id, user_id, item_id, item_title, item_price, item_color, item_size, item_quantity FROM shoppingcart";


$result = $conn->query($sql);

// Initialize an empty array to store the cart items
$cartItems = array();

// Initialize totalPrice to 0
$totalPrice = 0;

// Check if there are items in the cart
if ($result->num_rows > 0) {
    // Fetch all the data and store it in the cartItems array
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;

        // Add the price of each item to the totalPrice
        $totalPrice += $row["item_price"] * $row["item_quantity"];
    }
}

function generateUniqueOrderId($user_id)
{
    $timestamp = time();
    $order_id = $user_id . "_" . $timestamp;
    return $order_id;
}


$isOrderSubmitted = false;

$order_id = generateUniqueOrderId($user_id);

// Insert the data into the completed_orders table
$insertQuery = "INSERT INTO completed_orders (order_id, user_id, selected_shipping, selected_date, selected_address, item_id, item_title, item_price, item_color, item_size, item_quantity)
                                SELECT ?, ?, ?, ?, ?, item_id, item_title, item_price, item_color, item_size, item_quantity
                                FROM shoppingcart WHERE user_id = ?";

$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bind_param("sssssi", $order_id, $user_id, $selectedShipping, $selectedDate, $selectedAddress, $user_id);

if ($insertStmt->execute()) {
    //echo "Order submitted successfully.";
    // Delete cart items from shoppingcart table
    $deleteQuery = "DELETE FROM shoppingcart WHERE user_id = ?";
    $insertStmt = $conn->prepare($deleteQuery);
    $insertStmt->bind_param("i", $user_id);
    $insertStmt->execute();
    //header($order_id);
    //echo "order_id $order_id";
    echo "$order_id";
    exit();
} else {
    echo "<p>Failed to submit order.</p>";
}

?>