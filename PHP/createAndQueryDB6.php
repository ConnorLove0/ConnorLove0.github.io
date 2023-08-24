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
$sql = "SELECT albums.name as Name, albums.release_year as 'Release Year', SUM(songs.length) as 'Duration' FROM albums
JOIN songs on albums.id = songs.album_id
GROUP BY songs.album_id
ORDER BY Duration DESC
LIMIT 1;";

$result = $conn->query($sql);
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
        echo "<tr><th>Album Name</th><th>Duration</th><th>Release Year</th></tr>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>". $row["Name"] . "</td>";
            echo "<td>". $row["Duration"] . "</td>";
            echo "<td>". $row["Release Year"] . "</td>";
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