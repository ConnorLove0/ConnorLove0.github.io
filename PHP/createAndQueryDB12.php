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

// Get the number of songs for each band
$sql = "SELECT bands.name AS Band, COUNT(songs.id) AS 'Number of Songs'
        FROM bands
        LEFT JOIN albums ON bands.id = albums.band_id
        LEFT JOIN songs ON albums.id = songs.album_id
        GROUP BY bands.id
        HAVING COUNT(songs.id) > 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Record Company - Number of Songs for Each Band</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Band</th><th>Number of Songs</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>". $row["Band"] . "</td>";
        echo "<td>". $row["Number of Songs"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No bands found in the database.";
}

// Close the connection
$conn->close();
?>