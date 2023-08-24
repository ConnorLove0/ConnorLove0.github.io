<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user_id = $_SESSION['id'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database configuration
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

    // Get the address data from the form
    $street_address = $mysqli->real_escape_string($_POST['street_address']);
    $city = $mysqli->real_escape_string($_POST['city']);
    $state = $mysqli->real_escape_string($_POST['state']);
    $postal_code = $mysqli->real_escape_string($_POST['postal_code']);
    $country = $mysqli->real_escape_string($_POST['country']);
    $phone_number = $mysqli->real_escape_string($_POST['phone_number']);

    // Create the SQL query to insert the address data into the address table
    $query = "INSERT INTO address (user_id, street_address, city, state, postal_code, country, phone_number) 
              VALUES ('$user_id', '$street_address', '$city', '$state', '$postal_code', '$country', '$phone_number')";

    // Execute the query
    if ($mysqli->query($query)) {
        // Address added successfully
        //echo "Address added successfully!";
    } else {
        // Failed to add the address
        echo "Failed to add the address: " . $mysqli->error;
    }

    // Close the database connection
    $mysqli->close();
}
?>