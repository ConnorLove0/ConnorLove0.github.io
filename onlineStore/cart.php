<?php
session_start();
// Replace these credentials with your actual MySQL server credentials
$servername = "localhost";
$username = "calove";
$password = "VXvsjr71!";
$dbname = "onlinestore";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['id'];
//echo "<br>User ID is ". $user_id. "</br>";

// Function to check if an address exists for a given user_id
function checkAddressExists($user_id)
{
    global $conn;

    // Prepare a query to check if an address exists
    $query = "SELECT * FROM address WHERE user_id = ?";

    // Prepare and bind the query
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    // Check if any rows are returned
    if ($result->num_rows > 0) {
        $stmt->close();
        return true; // Address exists

    } else {
        $stmt->close();
        return false; // Address does not exist
    }
}

// Query to fetch data from the ShoppingCart table
$sql = "SELECT id, user_id, item_id, item_title, item_price, item_color, item_size, item_quantity FROM shoppingcart";


$result = $conn->query($sql);

// Initialize an empty array to store the cart items
$cartItems = array();

// Initialize totalPrice to 0
$totalPrice = 0;

// Check if there are items in the cart
if ($result->num_rows > 0) {
    // Fetch all the data and store it in the cartItems array
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;

        // Add the price of each item to the totalPrice
        $totalPrice += $row["item_price"] * $row["item_quantity"];
    }
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <style>
        .wrapper {
            margin-bottom: 100%;
            height: 100%;
            top: 0;
            /* Enable vertical scrolling when the content overflows */
            overflow-y: auto;
        }

        /* Hide the scrollbar */
        .wrapper::-webkit-scrollbar {
            width: 0.5em;
        }

        .wrapper::-webkit-scrollbar-track {
            background-color: transparent;
        }

        * {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "segoe ui", roboto, oxygen, ubuntu, cantarell, "fira sans", "droid sans", "helvetica neue", Arial, sans-serif;
            font-size: 16px;
        }

        body {
            background-color: #435165;
        }

        .cart-container {
            width: 400px;
            background-color: #ffffff;
            box-shadow: 0 0 9px 0 #f56600;
            margin: 30px auto;
            width: 600px;
            text-align: center;
        }

        .cart-container h1 {
            text-align: center;
            background-color: #522d80;
            color: #f56600;
            font-size: 24px;
            padding: 10px 0 10px 0;
            border-bottom: 1px solid #f56600;
            border-top: 1px solid #f56600;
        }

        .cart-container form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding-top: 20px;
        }

        .cart-container form label {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            background-color: #522d80;
            color: #ffffff;
        }

        .cart-container form input[type="password"],
        .cart-container form input[type="text"] {
            width: 310px;
            height: 50px;
            border: 1px solid #dee0e4;
            margin-bottom: 20px;
            padding: 0 15px;
        }

        .cart-container form input[type="submit"] {
            width: 100%;
            padding: 15px;
            margin-top: 20px;
            background-color: #522d80;
            border: 0;
            cursor: pointer;
            font-weight: bold;
            color: #f56600;
            transition: background-color 0.2s;
        }

        .cart-container form input[type="submit"]:hover,
        #checkoutButton:hover {
            background-color: #f56600;
            color: #522d80;
            transition: background-color 0.2s;
        }

        .cart-container table {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }

        .cart-container th {
            background-color: #522d80;
            color: #f56600;
            padding: 10px;
            text-align: center;
        }

        .cart-container td {
            padding: 10px;
        }

        .cart-container p {
            color: #f56600;
        }

        #checkoutButton {
            width: 100%;
            height: 50px;
            margin-bottom: auto;
            color: #f56600;
            background-color: #522d80;
            cursor: pointer;
            font-weight: bold;
        }

        #price {
            background-color: #522d80;
            margin-left: auto;
            margin-bottom: 10px;
            margin-right: auto;
            border-radius: 5px;
            width: 50%;
            text-align: center;
            padding: 0;
        }

        .back-button {
            background-color: #522d80;
        }

        #back-button {
            margin-top: 1%;
            margin-bottom: 1%;
            color: #f56600;
            background-color: #522d80;
            border-radius: 5px;
        }

        #back-button:hover {
            color: white;
            background-color: #f56600;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <div class="content_area">
            <div class="cart-container">
                <!-- Back button to go to the previous page -->
                <div class="back-button">
                    <button id="back-button" onclick="goBack()">Not Done Shopping?</button>
                </div>
                <h1>Shopping Cart</h1>
                <table>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                    </tr>

                    <?php
                    // Check if there are items in the cart
                    if (!empty($cartItems)) {
                        foreach ($cartItems as $item) {
                            echo "<tr>";
                            echo "<td>" . $item["item_title"] . "</td>";
                            echo "<td>" . "$" . $item["item_price"] . "</td>";
                            echo "<td>" . $item["item_color"] . "</td>";
                            echo "<td>" . $item["item_size"] . "</td>";
                            echo "<td>" . $item["item_quantity"] . "</td>";
                            echo "</tr>";
                            echo "<tr><td colspan='5'><hr></td></tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No items in the shopping cart.</td></tr>";
                    }
                    ?>
                </table>
                <p id="price">Total Price:
                    <?php echo "$" . number_format($totalPrice, 2); ?>
                </p>
                <button id="checkoutButton" onclick="redirectToCheckout()">
                    <?php
                    if (checkAddressExists($user_id)) {
                        echo 'Checkout';
                    } else {
                        echo 'Add Address and Checkout';
                    }
                    ?>
                </button>
            </div>
        </div>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }

        function redirectToCheckout() {
            // Call the PHP function to check if the address exists
            var addressAdded = <?php echo checkAddressExists($user_id) ? 'true' : 'false'; ?>;

            if (addressAdded) {
                // Update the URL to include shipping_details.php as the next step
                window.location.href = "shipping_details.php";
            } else {
                // Redirect to address form
                window.location.href = "address.html";
            }
        }
    </script>
</body>

</html>