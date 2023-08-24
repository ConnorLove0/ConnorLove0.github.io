<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
//connect to database
$mysqli = mysqli_connect("sql202.infinityfree.com", "epiz_34238085", "XfYSwmoMvYg4", "epiz_34238085_online_store");

$display_block = "<h1>My Categories</h1>
<p>Select a category to see its items.</p>";

//show categories first
$get_cats_sql = "SELECT id, cat_title, cat_desc FROM store_categories ORDER BY cat_title";
$get_cats_res =  mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cats_res) < 1) {
   $display_block = "<p><em>Sorry, no categories to browse.</em></p>";
} else {
   while ($cats = mysqli_fetch_array($get_cats_res)) {
        $cat_id  = $cats['id'];
        $cat_title = strtoupper(stripslashes($cats['cat_title']));
        $cat_desc = stripslashes($cats['cat_desc']);

        $display_block .= "<p><strong><a href=\"".$_SERVER['PHP_SELF']."?cat_id=".$cat_id."\">".$cat_title."</a></strong><br>".$cat_desc."</p>";

        if (isset($_GET['cat_id']) && ($_GET['cat_id'] == $cat_id)) {

          //create safe value for use
  			  $safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']);

			   //get items
			   $get_items_sql = "SELECT id, item_title, item_price FROM store_items WHERE cat_id = '".$safe_cat_id."' ORDER BY item_title";
			   $get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));

			   if (mysqli_num_rows($get_items_res) < 1) {
               $display_block = "<p><em>Sorry, no items in this category.</em></p>";
            } else {
               $display_block .= "<ul>";

               while ($items = mysqli_fetch_array($get_items_res)) {
                  $item_id  = $items['id'];
                  $item_title = stripslashes($items['item_title']);
                  $item_price = $items['item_price'];

                  $display_block .= "<li><a href=\"showitem.php?item_id=".$item_id."\">".$item_title."</a> (\$".$item_price.")</li>";
                }

				    $display_block .= "</ul>";
			    }

          //free results
          mysqli_free_result($get_items_res);
		   }
	 }
}
//free results
mysqli_free_result($get_cats_res);

//close connection to MySQL
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Categories</title>
  <link rel="stylesheet" href="layout.css">
  <style>
    body {
      background-image: url("Images/cool-background.png");
        width: auto;
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
      <ul></ul>
    </div>
    </nav>
  </div>

  <footer>
    <div id="footer">|Created by calove (7/19/2023)|</div>
  </footer>
</body>

</html>
