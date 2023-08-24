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

// Fetch data from the "bands" table
$sql = "SELECT name FROM bands";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Company - Bands</title>
</head>
<body>
    <h1>Record Company - Bands</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Name</th></tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>". $row["name"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No bands found in the database.";
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>