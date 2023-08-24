<?php
//connect to database
$mysqli = mysqli_connect("sql202.infinityfree.com", "epiz_34238085", "XfYSwmoMvYg4", "epiz_34238085_online_store");

$display_block = "<h1>My Store - Item Detail</h1>";

//create safe values for use
$safe_item_id = mysqli_real_escape_string($mysqli, $_GET['item_id']);

//validate item
$get_item_sql = "SELECT c.id as cat_id, c.cat_title, si.item_title, si.item_price, si.item_desc, si.item_image FROM store_items AS si LEFT JOIN store_categories AS c on c.id = si.cat_id WHERE si.id = '" . $safe_item_id . "'";
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
   }

   //make breadcrumb trail & display of item
   $display_block .= <<<END_OF_TEXT
   <p><em>You are viewing:</em><br>
   <strong><a href="seestore.php?cat_id=$cat_id">$cat_title</a> &gt; $item_title</strong></p>
   <div style="float: left;"><img src="$item_image" alt="$item_title"></div>
   <div style="float: left; padding-left: 12px">
   <p><strong>Description:</strong><br>$item_desc</p>
   <p><strong>Price:</strong> \$$item_price</p>
END_OF_TEXT;

   //free result
   mysqli_free_result($get_item_res);

   //get colors
   $get_colors_sql = "SELECT item_color FROM store_item_color WHERE item_id = '" . $safe_item_id . "' ORDER BY item_color";
   $get_colors_res = mysqli_query($mysqli, $get_colors_sql) or die(mysqli_error($mysqli));

   if (mysqli_num_rows($get_colors_res) > 0) {
      $display_block .= "<p><strong>Available Colors:</strong><br>";
      while ($colors = mysqli_fetch_array($get_colors_res)) {
         $item_color = $colors['item_color'];
         $display_block .= $item_color . "<br>";
      }
   }

   //free result
   mysqli_free_result($get_colors_res);

   //get sizes
   $get_sizes_sql = "SELECT item_size FROM store_item_size WHERE item_id = '" . $safe_item_id . "' ORDER BY item_size";
   $get_sizes_res = mysqli_query($mysqli, $get_sizes_sql) or die(mysqli_error($mysqli));

   if (mysqli_num_rows($get_sizes_res) > 0) {
      $display_block .= "<p><strong>Available Sizes:</strong><br>";

      while ($sizes = mysqli_fetch_array($get_sizes_res)) {
         $item_size = $sizes['item_size'];
         $display_block .= $item_size . "<br>";
      }
   }

   //free result
   mysqli_free_result($get_sizes_res);

   //close up the div
   $display_block .= "</div>";

}
//close connection to MySQL
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <title>My Store</title>
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