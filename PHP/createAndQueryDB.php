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

// Fetch data from the "songs" table
$sql = "SELECT * FROM songs";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Company - Songs Table</title>
</head>
<body>
    <h1>Record Company - Songs Table</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Song ID</th><th>Title</th><th>Length</th><th>Album Id</th></tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["release_year"] . "</td>";
            echo "<td>" . $row["band_id"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No songs found in the database.";
    }

    // Close the connection
    $conn->close();
    ?>
</body>
</html>