<?php
$servername = "localhost";
$username = "calove"; // Replace with your MySQL username
$password = "VXvsjr71!"; // Replace with your MySQL password
$dbname = "record_company";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the average length of all songs
$sql = "SELECT AVG(length) AS average_length FROM songs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the result row
    $row = $result->fetch_assoc();
    $averageLength = $row["average_length"];

    // Display the average length of all songs
    echo "<h1>Record Company - Average Song Length</h1>";
    echo "<p>The average length of all songs is: " . $averageLength . " minutes.</p>";
} else {
    echo "No songs found in the database.";
}

// Close the connection
$conn->close();
?>