<?php
session_start();
//connect to database
$mysqli = mysqli_connect("localhost", "calove", "VXvsjr71!", "onlinestore");

// Retrieve the user ID of the currently logged-in user
$display_block = "<h1>My Store - Item Detail<hr></h1>";

//create safe values for use
$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['item_id']);

include_once("getUser.php");

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
}

//validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.id ,si.item_title, si.item_price, si.item_desc, si.item_image FROM store_items AS si LEFT JOIN store_categories AS c on c.id = si.cat_id WHERE si.id = '" . $safe_item_id . "'";
$get_item_res = mysqli_query($mysqli, $get_item_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_item_res) < 1) {
   //invalid item
   $display_block .= "<p><em>Invalid item selection.</em></p>";
} else {
   //valid item, get info
   while ($item_info = mysqli_fetch_array($get_item_res)) {
      $cat_id = $item_info['cat_id'];
      $cat_title = strtoupper(stripslashes($item_info['cat_title']));
      $item_title = stripslashes($item_info['item_title']);
      $item_price = $item_info['item_price'];
      $item_desc = stripslashes($item_info['item_desc']);
      $item_image = $item_info['item_image'];

      // Display other products in the same category
      $get_other_items_sql = "SELECT id, item_title, item_image FROM store_items WHERE cat_id = '$cat_id' AND id != '$safe_item_id' ORDER BY id";
      $get_other_items_res = mysqli_query($mysqli, $get_other_items_sql) or die(mysqli_error($mysqli));
   }

   //make breadcrumb trail & display of item
   $display_block .= <<<END_OF_TEXT
   <p id="breadcrumbs"><em>You are viewing:</em>
   <strong><a href="seestore.php?cat_id=$cat_id">$cat_title</a> &gt; $item_title</strong></p>
   <div id="image"><img src="/phplogin/420710/Images/$item_image" alt="$item_title"></div>
   <div id="desc_container">
   <p><strong>Description: </strong> <span class="item-value">$item_desc</span></p><hr>
   <p id="item-price"><strong>Price:</strong> <span id="item-value-price">\$$item_price</p><hr>
END_OF_TEXT;

   // Form for item options
   $display_block .= '<form id="addToCartForm" action="addItem.php" method="post">';
   $display_block .= '<input type="hidden" name="user_id" value="' . $user_id . '">';
   $display_block .= '<input type="hidden" name="item_id" value="' . $safe_item_id . '">';
   $display_block .= '<input type="hidden" name="item_title" value="' . htmlspecialchars($item_title) . '">';
   $display_block .= '<input type="hidden" name="item_price" value="' . $item_price . '">';
   $display_block .= '<input type="hidden" name="item_image" value="' . $item_image . '">';

   //get colors
   $get_colors_sql = "SELECT item_color FROM store_item_color WHERE item_id = '" . $safe_item_id . "' ORDER BY item_color";
   $get_colors_res = mysqli_query($mysqli, $get_colors_sql) or die(mysqli_error($mysqli));

   $color_options = mysqli_fetch_all($get_colors_res, MYSQLI_ASSOC);
   $num_colors = count($color_options);

   if ($num_colors > 0) {
      $display_block .= "<p><strong>Available Colors: </strong>";

      // Dropdown menu for colors
      $display_block .= '<select name="item_color" required>';
      foreach ($color_options as $color_option) {
         $item_color = $color_option['item_color'];
         $display_block .= '<option value="' . $item_color . '">' . $item_color . '</option>';
      }
      $display_block .= '</select>';

      $display_block .= "<hr>";
   }

   //free result
   mysqli_free_result($get_colors_res);

   //get sizes
   $get_sizes_sql = "SELECT item_size FROM store_item_size WHERE item_id = '" . $safe_item_id . "' ORDER BY item_size";
   $get_sizes_res = mysqli_query($mysqli, $get_sizes_sql) or die(mysqli_error($mysqli));

   $size_options = mysqli_fetch_all($get_sizes_res, MYSQLI_ASSOC);
   $num_sizes = count($size_options);

   if ($num_sizes > 0) {
      $display_block .= "<p><strong>Available Sizes: </strong>";

      // Dropdown menu for sizes
      $display_block .= '<select name="item_size" required>';
      foreach ($size_options as $size_option) {
         $item_size = $size_option['item_size'];
         $display_block .= '<option value="' . $item_size . '">' . $item_size . '</option>';
      }
      $display_block .= '</select>';

      $display_block .= "<hr>";
   }

   //free result
   mysqli_free_result($get_sizes_res);

   // Number of Items input
   $display_block .= '<label for="quantitySelect" id="quantitySelectLabel" class="boldText"><strong>Number of Items: </strong></label>';
   $display_block .= '<input type="number" name="quantitySelect" id="quantitySelect" min="1" value="1" required>';
   $display_block .= '<hr>';
   $display_block .= '<button type="submit" id="AddItem">Add To Cart</button>';
   $display_block .= '</form>';

   //close up the div
   $display_block .= "</div>";

   if (mysqli_num_rows($get_other_items_res) > 0) {
      $display_block .= '<div id="other_products">';
      $display_block .= '<h2>Other Products in this Category:</h2>';
      $display_block .= '<div class="image-slider">';
      while ($other_item_info = mysqli_fetch_array($get_other_items_res)) {
         $other_item_id = $other_item_info['id'];
         $other_item_title = stripslashes($other_item_info['item_title']);
         $other_item_image = $other_item_info['item_image'];

         $display_block .= '<a href="showitem.php?item_id=' . $other_item_id . '">';
         $display_block .= '<img src="/phplogin/420710/Images/' . $other_item_image . '" alt="' . $other_item_title . '">';
         $display_block .= '</a>';
      }
      $display_block .= '</div>';
      $display_block .= '</div>';
   }

   //free result
   mysqli_free_result($get_item_res);
}
//close connection to MySQL
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <title>My Store</title>
   <link rel="stylesheet" href="layout.css">
   <style>
      .content_area p {
         margin: 0 5px;
         font-size: 15pt;
         padding-left: 5px;
         text-align: left;
         max-width:300px;
      }

      body {
         background-image: url("/phplogin/420710/Images/cool-background.png");
         width: auto;
      }

      .navHead p {
         margin: 0px;
         padding-left: 2px;
      }

      #breadcrumbs {
         color: #F56600;
         font-size: 12pt;
         background-color: #522D7F;
         margin-left: auto;
         margin-right: auto;
         text-align: center;
         border: #522D7F 3px solid;
         margin-bottom: 2%;
      }

      #breadcrumbs a {
         text-decoration: none;
         cursor: pointer;
         color: #F56600;
      }

      #breadcrumbs a:hover {
         color: white;
      }

      .content_area {
         margin-bottom: 100%;
      }

      #desc_container {
         border: #F56600 1px solid;
         box-sizing: border-box;
         margin-left: auto;
         margin-right: auto;
         margin-top: 3%;
         height: auto;
         width: auto;
         text-align: left;
         overflow: hidden;
         text-overflow: ellipsis;
      }

      #image {
         border: #522D7F 1px solid;
         margin-left: auto;
         margin-right: auto;
      }

      img {
         height: 350px;
      }

      /* Style for the dropdown menus */
      select {
         width: auto;
         min-width: 100px;
         padding: 5px;
         font-size: 14px;
         border: 1px solid #ccc;
         border-radius: 4px;
         background-color: #fff;
         color: #444;
         cursor: pointer;
      }

      /* Style for the number of items input field */
      #quantitySelect {
         margin-right: 10%;
         margin-left: 10%;
         width: 15%;
         text-align: center;
         padding: 5px;
         font-size: 14px;
         border: 1px solid #ccc;
         border-radius: 4px;
      }

      /* Adjust the width of the form container */
      #desc_container form {
         max-width: 300px;
         margin: auto;
      }

      #desc_container #text {
         text-align: right;
      }

      .boldText {
         font-weight: bold;
         font-size: 15pt;
         padding-left: 10px;
      }

      .item-value {
         margin-left: 10px;
         /* Adjust the spacing between the label and the value as needed */
      }

      #AddItem {
         color: #F56600;
         font-weight: bold;
         background-color: #522D7F;
         height: 30px;
         width: 100%;
      }

      #AddItem:hover {
         background-color: #F56600;
         color: white;
      }

      #item-value-price {
         padding-left: 60%;
      }

      /* CSS styles for the image slider */
      #other_products {
         margin-top: 30px;
      }

      .image-slider {
         display: flex;
         justify-content: center;
         align-items: center;
         overflow-x: auto;
         padding: 10px 0;
         scroll-behavior: smooth;
      }

      .image-slider img {
         width: 150px;
         height: 150px;
         margin-right: 10px;
         border: 1px solid #ccc;
         border-radius: 5px;
      }

      .image-slider a:last-child img {
         margin-right: 0;
      }

      /* Hide scrollbar */
      .image-slider::-webkit-scrollbar {
         display: none;
      }
   </style>
</head>

<body>
   <header>

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
                           <li><a href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">Font
                                 File</a>
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
            <?php echo $display_block; ?>
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

   <footer>
      <div id="footer">|Created by calove (7/19/2023)|</div>
   </footer>
   <script>
      // Function to handle the form submission and display the popup message
      function addToCart(event) {
         // Prevent the default form submission
         event.preventDefault();

         // Perform the form submission using AJAX
         var form = document.getElementById('addToCartForm');
         var formData = new FormData(form);

         // Logging the card data to the console
         formData.forEach(function (value, key) {
            console.log(key + ': ' + value);
         });

         var xhr = new XMLHttpRequest();
         xhr.open(form.method, form.action, true);
         xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
               if (xhr.status === 200) {
                  // Display the success message as a popup
                  alert("Item added to the shopping cart successfully!");
               } else {
                  // Handle the case where the form submission failed
                  alert("Failed to add the item to the shopping cart.");
               }
            }
         };
         xhr.send(formData);
      }

      // Add click event listener to the Add To Cart button
      const addToCartButton = document.getElementById("AddItem");
      if (addToCartButton) {
         addToCartButton.addEventListener("click", addToCart);
      }

      // Add click event listener to the Log Out link
      const logOutLinkElement = document.getElementById("log-out-link");
      try {
         if (logOutLinkElement !== null) {
            logOutLinkElement.addEventListener("click", function (event) {
               logOut();
            });
         }
      } catch (error) { };
   </script>
</body>

</html>
<?php
mysqli_close($mysqli);
?>