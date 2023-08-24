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

// Select the longest song from each album
$sql = "SELECT  s.name AS song_name, s.length AS Duration, a.name AS album_name, a.release_year as release_year
        FROM songs s
        JOIN (
            SELECT album_id, MAX(length) AS max_length
            FROM songs
            GROUP BY album_id
        ) max_songs
        ON s.album_id = max_songs.album_id AND s.length = max_songs.max_length
        JOIN albums a ON s.album_id = a.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>Record Company - Longest Song from Each Album</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Album</th><th>Release Year</th><th>Duration</th></th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>". $row["album_name"] . "</td>";
        echo "<td>". $row["release_year"] . "</td>";
        echo "<td>". $row["Duration"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No songs found in the database.";
}

// Close the connection
$conn->close();
?>