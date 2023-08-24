<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'calove';
$DATABASE_PASS = 'VXvsjr71!';
$DATABASE_NAME = 'onlinestore';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// We don't have the password or email info stored in sessions, so instead, we can get the results from the database.
$stmt = $con->prepare('SELECT password, email, created_at, last_login, login_count  FROM accounts WHERE id = ?');
// In this case we can use the account ID to get the account info.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $created_at, $last_login, $login_count);
$stmt->fetch();
$stmt->close();


// Fetch the user's address information from the database
$user_id = $_SESSION['username'];
$addressSql = "SELECT * FROM address WHERE 'user_id' = ?";
$stmt = $con->prepare($addressSql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user has an address
$userHasAddress = ($result->num_rows > 0);
$addressData = $result->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Profile Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        .navtop {
            background-color: #F56600;
            height: 60px;
            width: 100%;
            border: 0;
        }

        .navtop div {
            display: flex;
            margin: 0 auto;
            width: 1000px;
            height: 100%;
        }

        .navtop div h1,
        .navtop div a {
            display: inline-flex;
            align-items: center;
        }

        .navtop div h1 {
            flex: 1;
            font-size: 25px;
            padding: 0;
            margin: 0;
            color: #522d80;
            font-weight: bold;
        }

        .navtop div a {
            padding: 0 20px;
            text-decoration: none;
            color: #522d80;
            font-weight: bold;
        }

        .navtop div a i {
            padding: 2px 8px 0 0;
        }

        .navtop div a:hover {
            color: white;
        }

        body.loggedin {
            background-color: #522d80;
        }

        .content {
            width: 1000px;
            margin: 0 auto;
        }

        .content h2 {
            margin: 0;
            padding: 25px 0;
            font-size: 22px;
            border-bottom: 1px solid #F56600;
            color: #F56600;
        }

        .content>p,
        .content>div {
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);
            margin: 25px 0;
            padding: 25px;
            background-color: white;
            color: #522d80;
            font-weight: bold;
        }

        .content>p table td,
        .content>div table td {
            padding: 5px;
        }

        .content>p table td:first-child,
        .content>div table td:first-child {
            font-weight: bold;
            color: #522d80;
            padding-right: 15px;
        }

        .content>div p {
            padding: 5px;
            margin: 0 0 10px 0;
        }

        #addAddressButton {
            background-color: #522d80;
            color: #F56600;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        #addAddressButton:hover {
            background-color: #F56600;
            color: white;
        }
    </style>

</head>

<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1>Calove Online Store</h1>
            <a href="home.php"><i class="fas fa-user-circle"></i>Profile</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </nav>
    <div class="content">
        <h2>Profile Page</h2>
        <div>
            <p>Your account details are below:</p>
            <table>
                <tr>
                    <td>Username:</td>
                    <td>
                        <?= $_SESSION['username'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <?= $password ?>
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>
                        <?= $email ?>
                    </td>
                </tr>
                <tr>
                    <td>User Since:</td>
                    <td>
                        <?= $created_at ?>
                    </td>
                </tr>
                <tr>
                    <td>Last Login:</td>
                    <td>
                        <?= $last_login ?>
                    </td>
                </tr>
                <tr>
                    <td>Login Count:</td>
                    <td>
                        <?= $login_count ?>
                    </td>
                </tr>
            </table>
        </div>
        <div id="addressFormContainer">
            <?php
            // Check if the user's address exists
            if ($userHasAddress) {
                // Display user's address here
                echo "<p>User's Address:</p><hr>";
                echo "<p>Street Address: " . $addressData['street_address'] . "</p>";
                echo "<p>City: " . $addressData['city'] . "</p>";
                echo "<p>State: " . $addressData['state'] . "</p>";
                echo "<p>Postal Code: " . $addressData['postal_code'] . "</p>";
                echo "<p>Country: " . $addressData['country'] . "</p>";
                echo "<p>Phone Number: " . $addressData['phone_number'] . "</p>";
                echo "<p>Email: " . $addressData['email'] . "</p>";
                echo '<button id="addAddressButton" onclick="loadAddressForm()">Add Address</button>';

            } else {
                // Display "Add Address" button
                echo '<button id="addAddressButton" onclick="loadAddressForm()">Add Address</button>';
            }
            ?>

            <!-- Display the address form (hidden by default) -->
            <div id="addressForm" style="display: none;"></div>

        </div>


    </div>
    <script>
        function loadAddressForm() {
            // Fetch the address.html content using AJAX
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    // Replace the content of the addressFormContainer with the address.html content
                    document.getElementById("addressFormContainer").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "address.html", true);
            xhttp.send();
        }
        // Function to display a success alert
        function showSuccessAlert(message) {
            alert('Success: ' + message);
        }

        // Function to display an error alert
        function showErrorAlert(message) {
            alert('Error: ' + message);
        }

        // Add event listener to handle form submissions
        const removeCardForms = document.querySelectorAll('.remove-card-form');
        removeCardForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success alert
                            showSuccessAlert(data.message);
                            // Optional: You can remove the card element from the page on successful removal
                            form.closest('.card').remove();
                        } else {
                            // Show error alert
                            showErrorAlert(data.message);
                        }
                    })
                    .catch(error => {
                        showErrorAlert('An error occurred while processing the request.');
                        console.error('Error:', error);
                    });
            });

        });
    </script>
</body>

</html>