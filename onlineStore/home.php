<?php
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

// Retrieve user cart from the database.
$stmt = $con->prepare('SELECT cart_id, item_id, item_title, item_price, item_image, item_color, item_size FROM shoppingcart WHERE user_id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($cart_id, $item_id, $item_title, $item_price, $item_image, $item_color, $item_size);
$stmt->store_result();


// Retrieve usernames from the database.
$userStmt = $con->prepare('SELECT username, login_count FROM accounts');
$userStmt->execute();
$userStmt->bind_result($username, $login_count);
$accounts = array();
$accountLogins = array();


while ($userStmt->fetch()) {
    $accounts[] = $username;
}

// Fetch the user's address information from the database
$user_id = $_SESSION['username'];
$addressSql = "SELECT * FROM address WHERE 'username' = ?";
$stmt = $con->prepare($addressSql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user has an address
$userHasAddress = ($result->num_rows > 0);
$addressData = $result->fetch_assoc();

// Close the prepared statement
$stmt->close();



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
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
            background-color: #F56600;
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
            color: #4a536e;
            padding-right: 15px;
        }

        .content>div p {
            padding: 5px;
            margin: 0 0 10px 0;
        }

        .image-left {
            width: 0;
            text-align: center;
        }

        .info-right {
            flex: 2;
            padding: 10px;
            text-align: center;
            border: 1px solid #F56600;
            border-radius: 5px;
        }

        .card {
            border: 1px solid #522D80;
            width: 25%;
        }

        .remove-card-form,
        .viewCardDetails {
            background-color: #F56600;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        #removeButton {
            color: #F56600;
            background-color: #522D80;
            cursor: pointer;
        }

        #removeButton:hover {
            color: #F56600;
            background-color: white;
        }

        .address-details,
        #addAddressButton {
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }

        .address-details p {
            margin: 10px 0;
        }

        #addAddressButton {
            background-color: #F56600;
            color: #522d80;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        #addressFormContainer {
            width: auto;
        }

        #addressFormContainer p {
            text-align: left;
        }

        #closeOrderDetails {
            color: #F56600;
            background-color: #522D80;
        }

        #closeOrderDetails:hover {
            color: white;
            background-color: #522D80;
        }

        .order-link {
            text-decoration: none;
        }

        .order-link:hover {
            color: white;
        }
    </style>
    <script src="/phplogin/420710/JS/statsScriptP2.js"></script>
</head>

<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1>CaLove</h1>
            <a href="seestore_withJS.php">
                <i class="fas fa-user-circle"></i>Home</a>
            <a href="cart.php">
                <i class="fas fa-user-circle"></i>My Cart</a>
            <a href="profile.php"><i class="fas fa-user-circle"></i>Account Details</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </nav>
    <div class="content">
        <h2>Home Page</h2>
        <?php if ($_SESSION['login_count'] === '1') { ?>
            <p>Hello New User!</p>
        <?php } else { ?>
            <p>Welcome back,
                <?= $_SESSION['username'] ?>!
            </p>
        <?php } ?>

        <div id="completedOrdersList">
            <h3><strong>Prior Orders</strong></h3>
            <hr>
            <?php
            // Retrieve user's prior orders based on user_id
            $orderStmt = $con->prepare('SELECT DISTINCT order_id FROM completed_orders WHERE user_id = ?');
            $orderStmt->bind_param('s', $_SESSION['id']);
            $orderStmt->execute();
            $orderStmt->bind_result($order_id);

            if ($orderStmt->fetch()) {
                do {
                    echo '<p><a href="#" class="order-link" data-order-id="' . $order_id . '">' . "Order #: " . $order_id . '</a></p>';
                } while ($orderStmt->fetch());
            } else {
                echo '<p>No prior orders found.</p>';
            }

            $orderStmt->close();
            ?>
        </div>

        <div id="completedOrderBox" style="display: none;">
            <!-- Display order details -->
        </div>


        <h2>Details</h2>

        <!-- Display user's address here -->
        <div id="addressFormContainer">
            <?php
            // Check if the user's address exists
            if ($userHasAddress) {
                // Display user's address here
                echo "<p>User's Address: <hr></p>";
                echo "<p>Street Address: " . $addressData['street_address'] . "</p>";
                echo "<p>City: " . $addressData['city'] . "</p>";
                echo "<p>State: " . $addressData['state'] . "</p>";
                echo "<p>Postal Code: " . $addressData['postal_code'] . "</p>";
                echo "<p>Country: " . $addressData['country'] . "</p>";
                echo "<p>Phone Number: " . $addressData['phone_number'] . "</p>";
            } else {
                // Display "Add Address" button
                echo '<button id="addAddressButton" onclick="loadAddressForm()">Add Address</button>';
            }
            ?>
        </div>


        <!-- Display the address form (hidden by default) -->
        <div id="addressFormContainer" style="display: none;"></div>


        <h2>All Users</h2>
        <div class="user-log">
            <?php if ($_SESSION['username'] === 'calove'): ?>
                <p>Logged in as calove.</p>

                <p>
                <h4>All users:</h4>
                <ul>
                    <?php
                    $stmt = $con->prepare('SELECT username, email, created_at, last_login, login_count FROM accounts');
                    $stmt->execute();
                    $stmt->bind_result($username, $email, $created_at, $last_login, $login_count);

                    while ($stmt->fetch()) { ?>
                        <table>
                            <hr><strong>Username:</strong>
                            <?= $username ?><br>
                            <strong>Email:</strong>
                            <?= $email ?><br>
                            <strong>Created At:</strong>
                            <?= $created_at ?><br>
                            <strong>Last Login:</strong>
                            <?= $last_login ?><br>
                            <strong>Login Count:</strong>
                            <?= $login_count ?>
                            <hr>
                        </table>
                    <?php } ?>
                </ul>
                </p>
            <?php else: ?>
                <p>You are not authorized to view this information.</p>
            <?php endif; ?>
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

        function toggleAddressForm() {
            var addressForm = document.getElementById("addressFormContainer");
            var addButton = document.getElementById("addAddressButton");

            if (addressForm.style.display === "none") {
                // Show the address form
                addressForm.style.display = "block";
                addButton.style.display = "none";
            } else {
                // Hide the address form
                addressForm.style.display = "none";
                addButton.style.display = "block";
            }
        }
        document.addEventListener("DOMContentLoaded", function () {
            var orderLinks = document.querySelectorAll(".order-link");

            orderLinks.forEach(function (link) {
                link.addEventListener("click", function (event) {
                    event.preventDefault();
                    var orderId = link.getAttribute("data-order-id");
                    fetchOrderDetails(orderId);
                });
            });

            function fetchOrderDetails(orderId) {
                // Fetch order details using AJAX (similar to your previous AJAX code)
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'get_order_details.php?order_id=' + orderId, true);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            var orderDetails = JSON.parse(xhr.responseText);
                            displayOrderDetails(orderDetails);
                        } else {
                            console.error('Failed to retrieve order details.');
                        }
                    }
                };
                xhr.send();
            }

            function displayOrderDetails(orderDetails) {
                var completedOrderBox = document.getElementById('completedOrderBox');
                completedOrderBox.innerHTML = ''; // Clear previous content

                if (orderDetails) {
                    // Build and display order details HTML
                    var orderHtml = '<h3><strong>Confirmed Order</strong></h3><hr>';
                    orderHtml += '<p><strong>Order ID: </strong>' + orderDetails.order_id + '</p>';
                    orderHtml += '<p><strong>Shipping Option: </strong>' + orderDetails.selected_shipping + '</p>';
                    orderHtml += '<p><strong>Delivery Speed: </strong>' + orderDetails.selected_date + '</p>';
                    orderHtml += '<p><strong>Selected Address: </strong>' + orderDetails.selected_address + '</p>';
                    orderHtml += '<p><button id="closeOrderDetails">Close</button><p>';

                    completedOrderBox.innerHTML = orderHtml;
                    completedOrderBox.style.display = 'block'; // Show the box

                    // Add event listener to the close button
                    var closeOrderButton = document.getElementById('closeOrderDetails');
                    closeOrderButton.addEventListener('click', function () {
                        completedOrderBox.style.display = 'none';
                    });
                } else {
                    completedOrderBox.innerHTML = '<p>Order details not found.</p>';
                }
            }
        });
    </script>
</body>

</html>