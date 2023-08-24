<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'calove';
$DATABASE_PASS = 'VXvsjr71!';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
} else {
    $loggedInUsername = null;
}

// Retrieve the card content from the query parameter
$cardContent = $_GET['cardContent'] ?? '';

// Echo the card content to display it on the page and pass it to JavaScript
echo '<script>const cardContent = ' . json_encode($cardContent) . ';</script>';

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Display Pokemon Card</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="/phplogin/420710/JS/statsScriptP2.js"></script>
    <style>
        .navHead p {
            margin: 0px;
            padding-left: 2px;
        }
        body {
            background-image: url("Images/cool-background.png");
            width: auto;
        }

        .card-content {
            width: 100%;
            height: 100%;
            padding-bottom: 20%;
        }

        .card-content p {
            text-align: left;
        }

        #show-html {
            overflow-y: auto;
        }

        .backTo {
            background-color: #522D80;
            color: #F56600;
            text-align: center;
            font-weight: bold;
            padding-left: 25px;
            padding-right: 25px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .content_area ul {
            padding-top: 5px;
            margin: 0;
            padding-left: 0;
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
                                    <li><a
                                            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">Font
                                            File</a></li>
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
            <?php
            // Check if the user is logged in and if the username is set in the session
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username'])) {
                $loggedInUsername = $_SESSION['username'];
            }
            ?>
            <div class="content_area">
                <ul><a href="/phplogin/420710/pokemon_collect_app_p2.php" class="backTo">Go to Card Search</a></ul>
                <ul><a href="/phplogin/420710/stats.php" class="backTo">Go to Card Statistics</a></ul>
                <div class="card-content">
                    <?php
                   // Retrieve the card content from the query parameter
                    $cardContent = $_GET['cardContent'] ?? '';

                    //Decode the card content (it was encoded with encodeURIComponent in JavaScript)
                   $decodedCardContent = urldecode($cardContent);

                    //Echo the card content to display it on the page
                    echo $decodedCardContent;
                ?>

                </div>
            </div>

            <div class="left_side">
                <ul>
                    <div class="navHead">
                        <h1><strong>Sections</strong></h1>
                        <hr>
                        <li><a href="#" id="backButton">Back</a></li>
                        <li><a href="/420710/index.html">Home</a><br></li>
                        <li><a href="mailto:calove@g.clemson.edu">Email</a></li>
                    </div>
                </ul>
            </div>

            <div class="right_side">
                <ul>
                    <div class="navHead">
                        <?php
                        if ($loggedInUsername !== null) {
                            echo '<p><strong>User: ' . $loggedInUsername . '</strong></p>';
                            echo '<li><a href="/phplogin/420710/PHP/home.php">Profile</a></li>';
                            echo '<li><a href="/phplogin/420710/PHP/logout.php">Log Out</a></li>';
                        } else {
                            echo '<p>Welcome, Guest</p>';
                            echo '<li><a href="login.html">Sign In</a></li>';
                        }
                        ?>
                        <h1><strong>Pages</strong></h1>
                        <hr>
                        <li><a href="/phplogin/420710/about.php">About API</a></li>
                        <li><a href="/phplogin/420710/pokemon_collect_app_p2.php">Pokemon Cards</a></li>
                        <li><a href="/phplogin/420710/stats.php">Pokemon Stats</a></li>
                    </div>
                </ul>
            </div>
        </nav>
    </div>
    <footer>
        <div id="footer">|Created by calove (7/20/2023)|</div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Add click event listener to the back button link
        document.getElementById("backButton").addEventListener("click", function () {
            // Go back to the previous page
            history.back();
        });

    </script>
</body>

</html>