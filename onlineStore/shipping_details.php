<?php
// Start the session
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Database configuration
$servername = "localhost";
$username = "calove";
$password = "VXvsjr71!";
$dbname = "onlinestore";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

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

function generateUniqueOrderId($user_id)
{
    $timestamp = time();
    $order_id = $user_id . "_" . $timestamp;
    return $order_id;
}

$user_id = $_SESSION['id'];
// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch addresses for the current user
function fetchAddressesForUser($user_id)
{
    global $conn;

    // Prepare and execute the query to fetch addresses
    $stmt = $conn->prepare("SELECT * FROM address WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Fetch results
    $result = $stmt->get_result();
    $addresses = array();

    while ($row = $result->fetch_assoc()) {
        $addresses[] = $row;
    }

    $stmt->close();

    return $addresses;
}

// Fetch addresses
$addresses = fetchAddressesForUser($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Shipping Details</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <style>
        .wrapper {
            margin-bottom: 100%;
            height: 100%;
            top: 0;
            overflow-y: auto;
        }

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

        .shipping-details-container {
            width: 600px;
            background-color: white;
            box-shadow: 0 0 9px 0 #f56600;
            margin: 30px auto;
            text-align: center;

        }

        .shipping-details-container h1 {
            background-color: #522d80;
            color: #f56600;
            font-size: 24px;
            padding: 10px 0;
            border-bottom: 1px solid #f56600;
            border-top: 1px solid #f56600;
        }

        .shipping-details-container h2 {
            font-size: 20px;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .addresses-list {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .address-item {
            width: 100%;
            background-color: #f0f0f0;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #addresses-content {
            padding: 20px;
        }

        .address-item p {
            margin: 0;
            font-size: 11pt;
        }

        .select-address-button,
        .add-address-button {
            background-color: #522d80;
            color: #f56600;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.2s, color 0.2s;
        }

        .select-address-button:hover,
        .add-address-button:hover {
            background-color: #f56600;
            color: white;
        }

        #chosen-address {
            margin-top: 20px;
            font-weight: bold;
        }

        #shipping-options-content {
            display: none;
            padding-bottom: 20px;
        }

        #final-cart-content {
            display: none;
        }

        #showAddresses,
        #showShippingOptions,
        #showFinalCart {
            color: #f56600;
            background-color: #522d80;
            cursor: pointer;
            padding: .3em.7em;
            margin: 2px;
        }

        #showAddresses:hover,
        #showShippingOptions:hover,
        #showFinalCart:hover {
            color: white;
            background-color: #f56600;
            cursor: pointer;
            padding: .3em.7em;
            margin: 2px;
        }

        .sidebar {
            padding-top: 2%;
            border-radius: 3px;
        }

        #chosen-address,
        #selected-date,
        #selected-shipping {
            display: block;
            background-color: #522d80;
            color: #f56600;
            border-radius: 3px;
            padding: 0px 5px 0px 5px;
            text-align: center;
            margin-left: 15%;
            margin-right: 15%;
        }

        #chosen-address-input {
            display: block;
            background-color: #522d80;
            color: #f56600;
            border-radius: 3px;
            padding: 0px 5px 0px 5px;
            text-align: center;
            margin: auto;
        }

        #chosen-address-input {
            width: 100%;
        }

        #shipping-option-label,
        #delivery-date-label {
            color: #f56600;
            background-color: #522d80;
            padding: 0px 5px 2px 5px;
            border-radius: 5px;
        }

        #final-cart-content {
            background-color: #ffffff;
            box-shadow: 0 0 9px 0 #f56600;
            margin: auto;
            width: 600px;
            text-align: center;
        }

        #final-cart-content h1 {
            text-align: center;
            background-color: #522d80;
            color: #f56600;
            font-size: 24px;
            padding: 10px 0 10px 0;
            border-bottom: 1px solid #f56600;
            border-top: 1px solid #f56600;
        }

        #final-cart-content form label {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            background-color: #522d80;
            color: #ffffff;
        }

        #final-cart-content form input[type="password"],
        #final-cart-content form input[type="text"] {
            width: 310px;
            height: 50px;
            border: 1px solid #dee0e4;
            margin-bottom: 20px;
            padding: 0 15px;
        }

        #final-cart-content form input[type="submit"] {
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

        #final-cart-content form input[type="submit"]:hover,
        #checkoutButton:hover {
            background-color: #f56600;
            color: #522d80;
            transition: background-color 0.2s;
        }

        #final-cart-content table {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }

        #final-cart-content th {
            background-color: #522d80;
            color: #f56600;
            padding: 10px;
            text-align: center;
        }

        #final-cart-content td {
            padding: 10px;
        }

        #final-cart-content p {
            color: #f56600;
            background-color: #522D80;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        #checkoutButton {
            width: 100%;
            height: 60px;
            margin: auto;
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

        #selected-shipping,
        #selected-date {
            margin: auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="content_area">
            <div class="shipping-details-container">
                <div class="sidebar">
                    <button id="showAddresses" onclick="showAddresses()">Addresses</button>
                    <button id="showShippingOptions" onclick="showShippingOptions()">Shipping Options</button>
                    <button id="showFinalCart" onclick="showFinalCart()">View Cart</button>
                </div>

                <div id="addresses-content" class="content">
                    <h1>Shipping Details</h1>
                    <h2>Choose an Address</h2>
                    <div class="addresses-list">
                        <!-- Display existing addresses connected to the current user's id -->
                        <!-- Loop through addresses and display each address -->
                        <?php
                        $addresses = fetchAddressesForUser($user_id);

                        foreach ($addresses as $address) {
                            echo '<div class="address-item">';
                            echo '<p>' . $address['street_address'] . ', ' . $address['city'] . ', ' . $address['state'] . ', ' . $address['postal_code'] . ', ' . $address['country'] . '</p>';
                            echo '<input type="hidden" name="selected_address" value="' . $address['address_id'] . '">';
                            echo '<button class="select-address-button" onclick="selectAddress(' . $address['address_id'] . ')">Select Address</button>';
                            echo '</div>';
                        }
                        ?>
                    </div>

                    <!-- Display the chosen address -->
                    <h2>Chosen Address</h2>
                    <div id="chosen-address">
                    </div>
                </div>

                <div id="shipping-options-content" class="content">
                    <h2>Shipping Options</h2>
                    <div>
                        <label for="shipping-option" id="shipping-option-label">Select Shipping Option:</label>
                        <select id="shipping-option" name="selected-shipping" onchange="updateChosenShippingOption()"
                            required>
                            <option value="Standard Shipping">Standard Shipping</option>
                            <option value="Express">Express Shipping</option>
                            <option value="Next-day">Next Day Shipping</option>
                        </select>
                    </div>
                    <div>
                        <label for="delivery-date" id="delivery-date-label">Select Expected Delivery Date:</label>
                        <select id="delivery-date" name="selected-date" onchange="updateSelectedDateOption()">
                            <option value="Standard Delivery">Standard</option>
                            <option value="Next Day Delivery">Next Day</option>
                            <option value="Within 2 days">Within 2 days</option>
                            <option value="Within 3 days">Within 3 days</option>
                        </select>
                    </div>
                    <input type="hidden" id="selected-address" name="selected-address" value="">
                </div>

                <div id="final-cart-content" class="content">
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
                    <form id="orderForm" action="finalcart.php" method="get">
                        <p>Selected Shipping Option: <input name="selected-shipping" id="selected-shipping" value="">
                        </p>
                        <p>Estimated Delivery Time: <input name="selected-date" id="selected-date" value=""></p>
                        <p>Selected Address: <input name="chosen-address" id="chosen-address-input" value=""></p>
                    </form>
                    <button id="checkoutButton" onclick="submitOrder()">Submit Order</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // JavaScript functions for showing different sections based on button clicks
        function showAddresses() {
            hideAllContent();
            document.getElementById('addresses-content').style.display = 'block';
        }

        function showShippingOptions() {
            hideAllContent();
            document.getElementById('shipping-options-content').style.display = 'block';
        }

        function showFinalCart() {
            hideAllContent();
            document.getElementById('final-cart-content').style.display = 'block';
            document.getElementById('selected-shipping').style.display = 'block';
            document.getElementById('selected-date').style.display = 'block';
            document.getElementById('chosen-address-input').style.display = 'block';
            // Update the form values
            var addressOptionSelect = document.getElementById('chosen-address');
            var chosenAddressOption = addressOptionSelect.value;
            console.log("Address: " + chosenAddressOption);

            var shippingOptionSelect = document.getElementById('shipping-option');
            var chosenShippingOption = shippingOptionSelect.value;
            console.log(chosenShippingOption);

            var dateOptionSelect = document.getElementById('delivery-date');
            var chosenDateOption = dateOptionSelect.value;
            console.log(chosenDateOption);

            // Update the values in the form
            var selectedShippingInput = document.getElementById('selected-shipping');
            var selectedDateInput = document.getElementById('selected-date');
            var selectedAddressInput = document.getElementById('chosen-address-input');

            selectedShippingInput.value = chosenShippingOption;
            selectedDateInput.value = chosenDateOption;
            selectedAddressInput.value = chosenAddressOption;
        }


        function hideAllContent() {
            document.getElementById('addresses-content').style.display = 'none';
            document.getElementById('shipping-options-content').style.display = 'none';
            document.getElementById('final-cart-content').style.display = 'none';

        }

        // Function to update the selected address before form submission
        function updateSelectedAddress(addressId) {
            document.getElementById('chosen-address').value = addressId;
        }

        // Function to select an address
        function selectAddress(addressId) {
            // Find the selected address in the list of addresses
            var selectedAddress = null;
            var addresses = <?php echo json_encode($addresses); ?>; // Assuming you have the addresses array available in JavaScript

            for (var i = 0; i < addresses.length; i++) {
                if (addresses[i].address_id === addressId) {
                    selectedAddress = addresses[i];
                    break;
                }
            }

            if (selectedAddress) {
                // Update the chosen-address div with the selected address details
                var chosenAddressDiv = document.getElementById('chosen-address');
                chosenAddressDiv.innerHTML = selectedAddress.street_address + ', ' + selectedAddress.city + ', ' + selectedAddress.postal_code + ', ' + selectedAddress.country;

                var selectedAddressInput = document.getElementById('chosen-address');
                selectedAddressInput.value = selectedAddress.street_address + ', ' + selectedAddress.city + ', ' + selectedAddress.postal_code + ', ' + selectedAddress.country;;
                console.log(selectedAddressInput.value);
            } else {
                console.error('Selected address not found in the list.');
            }
        }

        // Function to handle the form submission and display the popup message
        function addAddress(event) {
            // Prevent the default form submission
            event.preventDefault();

            // Perform the form submission using AJAX
            var form = document.getElementById('addAddressForm');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open(form.method, form.action, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Display the success message as a popup
                        // Fetch and display the updated list of addresses
                        window.location.href = "shipping_details.php";
                    } else {
                        // Handle the case where the form submission failed
                        alert("Failed to add the Address.");
                    }
                }
            };
            xhr.send(formData);
        }

        // Function to fetch and update the list of addresses
        function fetchAndUpdateAddresses() {
            var addressesList = document.getElementById('addresses-list');

            // Perform AJAX request to fetch addresses
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'shipping_details.php?action=fetch_addresses', true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        var addresses = JSON.parse(xhr.responseText);

                        addressesList.innerHTML = ''; // Clear existing list

                        // Loop through the addresses and create HTML elements for each
                        addresses.forEach(function (address) {
                            var addressItem = document.createElement('div');
                            addressItem.className = 'address-item';

                            var addressInfo = document.createElement('span');
                            addressInfo.textContent = address.street_address + ', ' + address.city + ', ' + address.postal_code + ', ' + address.country;

                            var selectButton = document.createElement('button');
                            selectButton.textContent = 'Select';
                            selectButton.onclick = function () {
                                selectAddress(address.address_id);
                            };

                            addressItem.appendChild(addressInfo);
                            addressItem.appendChild(selectButton);

                            addressesList.appendChild(addressItem);
                        });

                        // Clear the addAddressForm
                        document.getElementById('addAddressForm').reset();
                    } else {
                        // Handle the case where fetching addresses failed
                        console.error('Failed to fetch addresses.');
                    }
                }
            };
            xhr.send();
        }

        // Function to update the chosen shipping option
        function updateChosenShippingOption() {
            var shippingOptionSelect = document.getElementById('shipping-option');
            var chosenShippingOption = shippingOptionSelect.value;
            console.log(chosenShippingOption);

        }

        // Function to update the selected date option
        function updateSelectedDateOption() {
            var dateOptionSelect = document.getElementById('delivery-date');
            var selectedDateOption = dateOptionSelect.value;
            console.log(selectedDateOption);
        }

        function submitOrder() {
            console.log("Submitting checkout form...");

            // Get the form data
            var form = document.getElementById('orderForm');
            var formData = new FormData(form);

            // Create a URL-encoded string from the FormData
            var formDataString = new URLSearchParams(formData).toString();

            // Fetch and display the content from final_cart.php
            var finalCartContentDiv = document.getElementById('final-cart-content');
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'finalcart.php?' + formDataString, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Handle the response from final_cart.php if needed
                        var order_id = xhr.responseText;
                        console.log('Response:', order_id);

                        // Redirect the user to confirmed_order.php with the order_id
                        window.location.href = 'confirmed_order.php?order_id=' + order_id;
                    } else {
                        console.error('Failed to complete the checkout process.');
                    }
                }
            };
            xhr.send();
        }
        fetchAndUpdateAddresses();
    </script>
</body>

</html>