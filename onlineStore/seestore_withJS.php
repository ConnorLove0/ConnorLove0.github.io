<?php
//connect to database
$mysqli = mysqli_connect("localhost", "calove", "VXvsjr71!", "onlinestore");

$display_block = "<h1>My Categories</h1>";

//show "All" category button to display all products
$nav_buttons = "<div class='categoryButtons'><a href='seestore_withJS.php'><button class='catButton'>DISPLAY ALL</button></a>";

//show categories first
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cats_res) < 1) {
  $display_block = "<p><em>Sorry, no categories to browse.</em></p>";
} else {

  while ($cats = mysqli_fetch_array($get_cats_res)) {
    $cat_id = $cats['id'];
    $cat_title = strtoupper(stripslashes($cats['cat_title']));
    $cat_desc = stripslashes($cats['cat_desc']);

    // Create navigation buttons for each category
    $nav_buttons .= '<a href="?cat_id=' . $cat_id . '"><button class="catButton">' . $cat_title . '</button></a>';
  }

  $nav_buttons .= "</div>";
  $display_block .= $nav_buttons . "<p style='font-size: 15px;'>Scroll through the items in each category.</p>";

  // Check if a category is selected, and display the items for the selected category
  if (isset($_GET['cat_id'])) {
    $cat_id = $_GET['cat_id'];
    // Get the category title and description
    $get_cat_sql = "SELECT cat_title, cat_desc FROM store_categories WHERE id = '$cat_id'";
    $get_cat_res = mysqli_query($mysqli, $get_cat_sql) or die(mysqli_error($mysqli));
    if (mysqli_num_rows($get_cat_res) == 1) {
      $cat_info = mysqli_fetch_array($get_cat_res);
      $cat_title = strtoupper(stripslashes($cat_info['cat_title']));
      $cat_desc = stripslashes($cat_info['cat_desc']);

      $display_block .= "<h2>" . "<hr>" . $cat_title . "<br><span style='font-size: 12pt; font-weight: normal;'>" . $cat_desc . "</span><hr>" . "</h2>\n<p>" . "<hr>" . "</p>";

      //get items
      $get_items_sql = "SELECT id, item_title, item_price, item_desc, item_image FROM store_items WHERE cat_id = '$cat_id' ORDER BY item_title";
      $get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));

      if (mysqli_num_rows($get_items_res) < 1) {
        $display_block = "<p><em>Sorry, no items in this category.</em></p>";
      } else {
        $display_block .= "<section class=\"liquid-slider\" id=\"main-slider-" . $cat_id . "\">";

        while ($items = mysqli_fetch_array($get_items_res)) {
          $item_id = $items['id'];
          $item_title = stripslashes($items['item_title']);
          $item_price = $items['item_price'];
          $item_img = $items['item_image'];
          $item_desc = $items['item_desc'];

          $display_block .= <<<END_OF_TEXT
<div class="productCard">
  <h2 class="title">$item_title<hr></h2>
  <div class="content">
    <div class="image-container">
      <img class="Image" src="/phplogin/420710/Images/$item_img" alt="$item_title">
    </div>
    <div class="text-content">
      <p>$item_desc</p>
      <p><strong>Price: </strong>\$$item_price</p>
      <p><a href="showitem.php?item_id=$item_id"><button id="viewItemPage">View Item</button></a></p>
      <p><a href="addItem.php?item_id=$item_id"><button id="addItem">Add To Cart</button></a></p>
    </div>
  </div>
</div>
END_OF_TEXT;
        }
      }
      $display_block .= <<<END_OF_TEXT
</section>
<script type="text/javascript">
$(function(){
  $('#main-slider-$cat_id').liquidSlider({
    dynamicTabs: false,
    hoverArrows: false
  });
});
</script>
END_OF_TEXT;

    }
    //free results
    mysqli_free_result($get_items_res);
  } else {
    // No specific category selected, display all products and categories
    // Fetch and display all categories
    $get_all_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
    $get_all_cats_res = mysqli_query($mysqli, $get_all_cats_sql) or die(mysqli_error($mysqli));

    if (mysqli_num_rows($get_all_cats_res) < 1) {
      $display_block .= "<p><em>Sorry, no categories found.</em></p>";
    } else {
      // Display category titles and descriptions
      while ($cats = mysqli_fetch_array($get_all_cats_res)) {
        $cat_id = $cats['id'];
        $cat_title = strtoupper(stripslashes($cats['cat_title']));
        $cat_desc = stripslashes($cats['cat_desc']);

        $display_block .= "<h2>" . "<hr>" . $cat_title . "<br><span style='font-size: 12pt; font-weight: normal;'>" . $cat_desc . "</span>" . "<hr>" . "</h2>\n<p>" . "</p>";

        // Fetch and display items for each category
        $get_all_items_sql = "SELECT id, item_title, item_price, item_desc, item_image FROM store_items WHERE cat_id = '$cat_id' ORDER BY item_title";
        $get_all_items_res = mysqli_query($mysqli, $get_all_items_sql) or die(mysqli_error($mysqli));

        if (mysqli_num_rows($get_all_items_res) < 1) {
          $display_block .= "<p><em>Sorry, no items found.</em></p>";
        } else {
          $display_block .= "<section class=\"liquid-slider\" id=\"main-slider-all\">";

          while ($items = mysqli_fetch_array($get_all_items_res)) {
            $item_id = $items['id'];
            $item_title = stripslashes($items['item_title']);
            $item_price = $items['item_price'];
            $item_img = $items['item_image'];
            $item_desc = $items['item_desc'];

            $display_block .= <<<END_OF_TEXT
<div class="productCard">
  <h2 class="title">$item_title<hr></h2>
  <div class="content">
    <div class="image-container">
      <img class="Image" src="/phplogin/420710/Images/$item_img" alt="$item_title">
    </div>
    <div class="text-content">
      <p>$item_desc</p>
      <p><strong>Price: </strong>\$$item_price</p>
      <p><a href="/phplogin/420710/onlineStore/showitem.php?item_id=$item_id"><button id="viewItemPage">View Item</button></a></p>
      <p><a href="/phplogin/420710/onlineStore/addItem.php?item_id=$item_id"><button id="addItem">Add To Cart</button></a></p>
    </div>
  </div>
</div>
END_OF_TEXT;
          }
        }
        //free results
        mysqli_free_result($get_all_items_res);
      }
    }
  }
  //free results
  mysqli_free_result($get_cats_res);
}
//close connection to MySQL
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Categories</title>
  <link rel="stylesheet" href="layout.css">
  <link rel="stylesheet" href="liquidslider/css/liquid-slider.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.18/jquery.touchSwipe.min.js"></script>
  <script src="liquidslider/js/jquery.liquid-slider.min.js"></script>
  <style>
    body {
      background-image: url("/phplogin/420710/Images/cool-background.png");
      width: auto;
    }

    .productCard {
      text-align: center;
      border: #522d80 1px solid;
      margin-bottom: 10%;
      max-height: max-content;
      max-width: 50%;
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-left: auto;
      margin-right: auto;
      /* Center the elements horizontally */
    }

    .productCard .title {
      text-align: center;
      /* Center the title at the top */
    }

    .productCard .content {
      display: flex;
      /* Use flexbox to arrange the image and text content horizontally */
    }

    .productCard .Image {
      max-height: auto;
      max-width: 100%;
    }

    .productCard .image-container {
      flex: 1;
      margin: auto;
      height: auto;
      padding: 0.5rem;
    }

    .productCard .text-content {
      flex: 1;
      padding: 0.5rem;
    }

    /* Style for navigation buttons */
    .catButton,
    #addItem,
    #viewItemPage {
      font-weight: bold;
      background-color: #522d80;
      color: #f56600;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      margin: 5px;
      text-decoration: none;
    }

    .catButton:hover,
    #addItem:hover,
    viewItemPage:hover {
      background-color: #f56600;
      color: white;
    }

    .navHead p {
      margin: 0px;
      padding-left: 2px;
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
        <div id="currentUser">
          <?php
          if ($loggedInUsername) {
            echo '<p><strong>User: ' . $loggedInUsername . '</strong></p>';
            echo '<li><a href="/phplogin/420710/onlineStore/home.php">Profile</a></li>';
            echo '<li><a href="/phplogin/420710/onlineStore/logout.php">Log Out</a></li>';
          } else {
            echo '<p>Welcome, Guest</p>';
            echo '<li><a href="login.html">Sign In</a></li>';
          }
          ?>
        </div>
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