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

function displayBandsAndAlbums($conn) {



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
}

// Display before removal
echo "<h1>Record Company - Bands and Albums (Before Removal)</h1>";
displayBandsAndAlbums($conn);

// Remove "Wu-Tang Clan" and "C.R.E.A.M" to the bands and albums tables
$remove_wu_tang_band_sql = "DELETE FROM bands WHERE name =  'Wu-Tang Clan'";
$remove_wu_tang_album_sql = "DELETE FROM albums WHERE name =  'C.R.E.A.M'";
if ($conn->query($remove_wu_tang_band_sql) === TRUE) {
    echo "<p>Wu-Tang Clan has been removed from bands.</p>";
} else {
    echo "Error adding Wu-Tang Clan to bands: " . $conn->error;
}

if ($conn->query($remove_wu_tang_album_sql) === TRUE) {
    echo "<p>C.R.E.A.M has been removed from albums.</p>";
} else {
    echo "Error adding Wu-Tang Clan to bands: " . $conn->error;
}

// Display after removal
echo "<h1>Record Company - Bands and Albums (After Removal)</h1>";
displayBandsAndAlbums($conn);


// Close the connection
$conn->close();
?>