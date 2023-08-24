<?php
// Include the backend file to access its functions
require_once 'IO_backend.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numbers'])) {
    // Get the list of numbers from the form
    $numbers = explode(',', $_POST['numbers']);
    process_numbers($numbers);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Number Checker App</title>
    <!-- Add any necessary CSS styling here -->
</head>
<body>
    <form action="IO_app.php" method="post">
        <label for="numbers">Enter a list of numbers (comma-separated):</label>
        <input type="text" name="numbers" id="numbers" required>
        <button type="submit">CHECK THESE NUMBERS</button>
    </form>
    
    <!-- Add buttons for ARMSTRONG, FIBONACCI, PRIME, NONE, and RESET here -->
    <button onclick="displayNumbers('armstrong.txt')">ARMSTRONG</button>
    <button onclick="displayNumbers('fibonacci.txt')">FIBONACCI</button>
    <button onclick="displayNumbers('prime.txt')">PRIME</button>
    <button onclick="displayNumbers('none.txt')">NONE</button>
    <button onclick="resetApp()">RESET</button>

    <div id="result">

    </div>

    <script>
        function displayNumbers(fileName) {
            // Use AJAX to retrieve the numbers from the file and display them below the form
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("result").innerHTML = this.responseText;
                }
                else if (this.responseText.trim() === "") {
                    document.getElementById("result").innerHTML = "File is empty.";
                }
                else {
                document.getElementById("result").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "IO_backend.php?operation=read&file=" + encodeURIComponent(fileName), true);
            xhttp.send();
        }

        function resetApp() {
            // Use AJAX to call the backend script to reset the app
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    // Reload the page after resetting the app
                    location.reload();
                }
            };
            xhttp.open("GET", "IO_backend.php?operation=reset", true);
            xhttp.send();
        }
    </script>
</body>
</html>