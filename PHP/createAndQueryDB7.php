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
$sql = "SELECT * FROM albums WHERE release_year IS NULL;";
$result = $conn->query($sql);

$update_sql = "UPDATE albums SET release_year = '1986' WHERE release_year IS NULL";
$fixedresult = $conn->query($update_sql);

$afterfixsql = "SELECT * FROM albums WHERE release_year = '1986'";
$after_fix_result = $conn->query($afterfixsql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Record Company - Bands</title>
</head>
<body>
    <h1>Record Company - Longest Album</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Album Name</th><th>Release Year</th></tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>". $row["name"] . "</td>";
            echo "<td>". $row["release_year"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No bands found in the database.";
    }

    $update_sql = "UPDATE albums SET release_year = '1986' WHERE release_year IS NULL";

    if ($after_fix_result->num_rows > 0) {
        echo "<h2>Albums after Fix:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Album Name</th><th>Release Year</th></tr>";

        // Output data of each row
        while ($row = $after_fix_result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>". $row["name"] . "</td>";
            echo "<td>". $row["release_year"] . "</td>";
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