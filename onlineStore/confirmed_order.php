<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//connect to database
$conn = mysqli_connect("localhost", "calove", "VXvsjr71!", "onlinestore");

// confirmed_order.php
// Retrieve the order ID from the URL parameter
$order_id = $_GET["order_id"];
echo $order_id;
function getOrderDetails($order_id, $conn)
{
  // Connect to your database (you should replace this with your actual database connection code)

  // Query the database to retrieve order details based on order ID
  $query = "SELECT * FROM completed_orders WHERE order_id = ?";
  $stmt = mysqli_prepare($conn, $query);

  mysqli_stmt_bind_param($stmt, "s", $order_id); // Assuming $order_id is an string

  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) > 0) {
    $orderDetails = mysqli_fetch_assoc($result);
    return $orderDetails;
  } else {
    return false; // Order not found or error
  }
}

// Retrieve the order details from the database using the order ID
$orderDetails = getOrderDetails($order_id, $conn);

// Close the database connection (you should do this at the end of your script)
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Categories</title>
  <hr>
  <link rel="stylesheet" href="layout.css">
  <style>
    body {
      background-image: url("/phplogin/420710/Images/cool-background.png");
      width: auto;
    }

    .content_area p {
      font-size: 12pt;
    }

    .content_area a {
      text-decoration: none;
      font-size: 16pt;
    }

    ul {
      list-style: none;
    }

    .navHead p {
      margin: 0px;
      padding-left: 2px;
    }

    #completedOrderBox {
      padding-top: 2%;
      text-align: left;
    }

    #completedOrderBox p {
      font-size: 18pt;
    }
  </style>
</head>

<body>
  <header>
    <?php
    session_start();
    ?>
    <div class="header">
      <!--MENU-->
      <div class="menu">
        <nav>
          <input type="checkbox" id="show-search">
          <input type="checkbox" id="show-menu">
          <label for="show-menu" class="menu-icon"><i class="fas fa-bars"></i></label>
          <div class="menu_content">
            <div class="logo"><a href="#">CaLove</a></div>
            <ul class="links">
              <li><a href="/420710/index.html">Home</a></li>
              <li>
                <a href="#" class="desktop-link">HTML Code</a>
                <input type="checkbox" id="show-html">
                <label for="show-html">HTML Code</label>
                <ul>
                  <li><a href="insert_form.html">CREATE DB</a></li>
                  <li><a href="Facts_About_Snowboarding.html">Facts about Snowboarding</a></li>
                  <li><a href="Facts_About_Apples.html">Facts about Apples</a></li>
                  <li><a href="Facts_About_Sushi.html">Facts about Sushi</a></li>
                  <li><a href="sortDemo.html">Sort Demo</a></li>
                  <li><a href="ButtonMove.html">Moving Buttons</a></li>
                  <li><a href="cards.html">Card Demo</a></li>
                  <li><a href="keypress.html">KeyPress Demo</a></li>
                  <li><a href="prime.html">Prime Numbers</a></li>
                  <li><a href="jQueryDemo.html">jQuery Demo</a></li>
                  <li><a href="dynamicCardDemo.html">Dynamic Card Demo</a></li>
                  <li><a href="AJAXandPHP.html">AJAX and PHP Demo</a></li>
                  <li><a href="audioDemo.html">Audio Demo</a></li>
                  <li><a href="DMMTExamples.html">DMMT Examples</a></li>
                  <li><a href="pokemon_collect_app_p1.html">Collect App Phase 1</a></li>
                  <li>
                    <a href="#" class="desktop-link">HTML with Pictures</a>
                    <input type="checkbox" id="show-htmlp">
                    <label for="show-htmlp">HTML with Pictures</label>
                    <ul>
                      <li><a href="Ski_Maps.html">Ski Maps</a></li>
                      <li><a href="Apple_Pictures.html">More Apple Pictures</a></li>
                      <li><a href="Sushi_Pictures.html">More Sushi Pictures</a></li>
                    </ul>
                  </li>
                </ul>
              </li>
              <li>
                <a href="#" class="desktop-link">CSS Code</a>
                <input type="checkbox" id="show-css">
                <label for="show-css">CSS Code</label>
                <ul>
                  <li><a href="layout.css">layout.css</a></li>
                  <li><a href="ButtonMove.css">ButtonMove.css</a></li>
                  <li><a href="prime.css">prime.css</a></li>
                  <li><a href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">Font File</a>
                  </li>
                </ul>
              </li>
              <li>
                <a href="#" class="desktop-link">JavaScript Code</a>
                <input type="checkbox" id="show-js">
                <label for="show-js">JavaScript Code</label>
                <ul>
                  <li><a href="chapter04.html">Chapter04.html</a></li>
                  <li><a href="ButtonMove.js">ButtonMove.js</a></li>
                  <li><a href="cards.js">cards.js</a></li>
                  <li><a href="prime.js">prime.js</a></li>
                  <li><a href="loops.js">loops.js</a></li>
                </ul>
              </li>
              <li>
                <a href="#" class="desktop-link">PHP Code</a>
                <input type="checkbox" id="show-php">
                <label for="show-php">PHP Code</label>
                <ul>
                  <li><a href="seestore_withJS.php">FINAL PROJECT</a></li>
                  <li><a href="pokemon_collect_app_p2.php">Collect App Phase 2</a></li>
                  <li><a href="Exam2.php">Exam2.php</a></li>
                  <li><a href="helloworld.php">Helloworld.php</a></li>
                  <li><a href="IO_app.php">PHP File I/O App</a></li>
                  <li><a href="seestore.php">seestore.php</a></li>
                  <li><a href="seestore_withJS.php">seestore_withJS.php</a></li>
                  <li><a href="showitem.php">showitem.php</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <label for="show-search" class="search-icon"><i class="fas fa-search"></i></label>
          <form action="#" class="search-box">
            <input type="text" placeholder="Type Something to Search..." required>
            <button type="submit" class="go-icon"><i class="fas fa-long-arrow-alt-right"></i></button>
          </form>
        </nav>
      </div>
      <!--END OF MENU-->
    </div>
  </header>

  <div class="wrapper">
    <nav>
      <div class="content_area">
        <?php
        // Check if the user is logged in and if the username is set in the session
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username'])) {
          $loggedInUsername = $_SESSION['username'];
        } else {
          $loggedInUsername = "";
        }
        ?>
        <div id="completedOrderBox">
          <!-- Display order details -->
          <?php if ($orderDetails): ?>
            <h1><strong>Confirmed Order</strong></h1>
            <hr>
            <p><strong>Order ID: </strong>
              <?php echo $orderDetails['order_id']; ?>
            </p>
            <p><strong>Shipping Option: </strong>
              <?php echo $orderDetails['selected_shipping']; ?>
            </p>
            <p><strong>Delivery Speed: </strong>
              <?php echo $orderDetails['selected_date']; ?>
            </p>
            <p><strong>Selected Address: </strong>
              <?php echo $orderDetails['selected_address']; ?>
            </p>
            <!-- ... display other order details as needed ... -->
          <?php else: ?>
            <p>Order not found or an error occurred.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="left_side">
        <ul>
          <div class="navHead">
            <h1><strong>Sections</strong></h1>
            <hr>
            <li><a href="/420710/index.html">Home</a><br></li>
            <li><a href="mailto:calove@g.clemson.edu">Email</a></li>
          </div>
        </ul>
      </div>

      <div class="right_side">
        <ul>
          <div class="navHead">
            <?php
            if ($loggedInUsername) {
              echo '<p><strong>User: ' . $loggedInUsername . '</strong></p>';
              echo '<li><a href="/phplogin/420710/onlineStore/cart.php">My Cart</a></li>';
              echo '<li><a href="/phplogin/420710/onlineStore/home.php">Profile</a></li>';
              echo '<li><a href="/phplogin/420710/onlineStore/logout.php">Log Out</a></li>';
            } else {
              echo '<p>Welcome, Guest</p>';
              echo '<li><a href="login.html">Sign In</a></li>';
            }
            ?>
            <hr>
            <h1><strong>Pages</strong></h1>
            <hr>
            <li><a href="seestore_withJS.php">Product Index</a></li>
            <li><a href="seestore.php">Categories</a></li>
          </div>
        </ul>
      </div>
    </nav>
  </div>
  <script>
    // Add click event listener to the Log Out link
    const logOutLinkElement = document.getElementById("log-out-link");
    try {
      if (logOutLinkElement !== null) {
        logOutLinkElement.addEventListener("click", function (event) {
          logOut();
        });
      }
    }
    catch (error) { };
  </script>
</body>

</html>