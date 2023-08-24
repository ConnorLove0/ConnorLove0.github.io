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

// Display all bands and albums
$display_sql = "SELECT bands.name AS band_name, albums.name AS album_name, albums.release_year as release_year FROM bands
               LEFT JOIN albums ON bands.id = albums.band_id";
$result = $conn->query($display_sql);

// Check if the bands and albums are available
if ($result->num_rows > 0) {
    echo "<h1>Record Company - Bands and Albums</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Band Name</th><th>Album Name</th><th>Release Year</th></tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>". $row["band_name"] . "</td>";
        echo "<td>". $row["album_name"] . "</td>";
        echo "<td>". $row["release_year"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No bands and albums found in the database.";
}

// Add "Wu-Tang Clan" and "C.R.E.A.M" to the bands and albums tables
$wu_tang_band_sql = "INSERT INTO bands (name) VALUES ('Wu-Tang Clan')";
if ($conn->query($wu_tang_band_sql) === TRUE) {
    echo "<p>Wu-Tang Clan has been added to bands.</p>";
} else {
    echo "Error adding Wu-Tang Clan to bands: " . $conn->error;
}

$wu_tang_album_sql = "INSERT INTO albums (name, band_id, release_year) VALUES ('C.R.E.A.M', LAST_INSERT_ID(), '1994')";
if ($conn->query($wu_tang_album_sql) === TRUE) {
    echo "<p>C.R.E.A.M has been added to albums.</p>";
} else {
    echo "Error adding C.R.E.A.M to albums: " . $conn->error;
}

// Display all bands and albums after adding Wu-Tang Clan and C.R.E.A.M
$display_sql_after_fix = "SELECT bands.name AS band_name, albums.name AS album_name, albums.release_year as release_year FROM bands
                          LEFT JOIN albums ON bands.id = albums.band_id";
$result_after_fix = $conn->query($display_sql_after_fix);

if ($result_after_fix->num_rows > 0) {
    echo "<h1>Record Company - Bands and Albums After Adding Wu-Tang Clan and C.R.E.A.M</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Band Name</th><th>Album Title</th></tr>";

    // Output data of each row
    while ($row = $result_after_fix->fetch_assoc()) {
        echo "<tr>";
        echo "<td>". $row["band_name"] . "</td>";
        echo "<td>". $row["album_name"] . "</td>";
        echo "<td>". $row["release_year"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No bands and albums found in the database after adding Wu-Tang Clan and C.R.E.A.M.";
}

// Close the connection
$conn->close();
?>