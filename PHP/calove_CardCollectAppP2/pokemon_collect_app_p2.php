<!--Connor Love-->
<!--7/18/2023-->
<!--Pokemon Collect App-->
<!--Senior-->

<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'calove';
$DATABASE_PASS = 'VXvsjr71!';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

?>


<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pokemon Collect App Phase 2</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        #show-filters-button, button.addCardButton {
            background-color: #522d80;
            color:#f56600;
            margin: 4px;
        }

        .filters-container {
            text-align: center;
        }

        .navHead p {
            margin: 0px;
            padding-left: 2px;
        }

        body {
            background-image: url("Images/cool-background.png");
            width: auto;
        }

        .results-container {
            display: flex;
            flex-flow: wrap;
            justify-content: center;
            width: 100%;
            margin-left: auto;

        }

        .content_area {
            margin-bottom: 20%;
        }

        .card-table-wrapper {
            display: flex;
            flex-direction: wrap;
            justify-content: center;
            height: 5px;
            max-width: calc(100% - 20px);
            margin: 0 auto;
        }

        .card-row {
            display: flex;
            margin-bottom: 0;
            flex-wrap: wrap;
            cursor: pointer;
            justify-content: space-between;
            width: 100%;
        }

        .pokemon-card {
            margin: 10px;
            cursor: pointer;
            flex-basis: 150px;
            height: fit-content;
        }

        #search-button, #filter-button {
            background-color: #522d80;
            color: #f56600;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }

        .dropdown-container label {
            background-color: #522d80;
            color: #f56600;
        }

        .dropdown-container {
            text-align: center;
        }

        .search-container button:hover {
            color: white;
        }

        .autocomplete {
            position: relative;
            display: inline-block;
        }

        .input {
            border: 1px solid transparent;
            background-color: #f1f1f1;
            padding: 10px;
            font-size: 16px;
        }

        input[type=submit] {
            background-color: darkblue;
            color: #fff;
            cursor: pointer;
        }

        .autocomplete-items {
            position: absolute;
            border: 1px solid #d4d4d4;
            border-bottom: none;
            border-top: none;
            z-index: 99;
            /*position the autocomplete items to be the same width as the container:*/
            top: 100%;
            left: 0;
            right: 0;
        }

        .autocomplete-items div {
            padding: 10px;
            cursor: pointer;
            background-color: #fff;
            border-bottom: 1px solid #d4d4d4;
        }

        /*when hovering an item:*/
        .autocomplete-items div:hover {
            background-color: #e9e9e9;
        }

        /*when navigating through the items using the arrow keys:*/
        .autocomplete-active {
            background-color: DodgerBlue !important;
            color: #ffffff;
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
            <div class="content_area">
                <?php
                // Check if the user is logged in and if the username is set in the session
                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['username'])) {
                    $loggedInUsername = $_SESSION['username'];
                }
                else {
                    $loggedInUsername = "";
                }
                ?>

                <h1>Pokemon Card Search App</h1>
                <form autocomplete="off" id="filter-form">
                    <p>Search for a Pokemon</p>
                    <!-- HTML code for filter elements -->
                    <button id="show-filters-button">Filters</button>

                    <div id="filters-container" style="display:none;">
                        <label for="filter-type">Type:</label>
                        <select id="filter-type">
                            <!-- The types options will be populated dynamically by JavaScript -->
                            <option value="">All</option>
                        </select>

                        <label for="filter-rarity">Rarity:</label>
                        <select id="filter-rarity">
                            <option value="">All</option>
                            <!-- The rarity options will be populated dynamically by JavaScript -->
                        </select>
                    </div>

                    <div class="autocomplete">
                        <input type="text" id="search-input" name="pokemonNames" placeholder="Enter Pokémon Name">
                    </div>
                    <button id="search-button">Search</button>
                </form>

                <datalist id="pokemon-options">
                    <!-- Add options here -->
                </datalist>

                <div class="dropdown-container">
                    <label for="pokemon-dropdown">Need Help?</label>
                    <select id="pokemon-dropdown">
                        <option value="" disabled selected>Pokemon Names</option>
                    </select>
                </div>

                <div class="results-container">
                    <hr>
                    <!--Search Results will be displayed here-->
                    <hr>
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
                            echo '<li><a href="/phplogin/420710/PHP/home.php">Profile</a></li>';
                            echo '<li><a href="/phplogin/420710/PHP/logout.php">Log Out</a></li>';
                        }
                        else {
                            echo '<p>Welcome, Guest</p>';
                            echo '<li><a href="login.html">Sign In</a></li>';
                        }
                        ?>
                        <hr>
                        <h1><strong>Pages</strong></h1>
                        <hr>
                        <li><a href="about.php">About API</a></li>
                        <li><a href="stats.php">Pokemon Stats</a></li>
                    </div>
                </ul>
            </div>
        </nav>
    </div>

    <footer>
        <div id="footer">|Created by calove (7/15/2023)|</div>
    </footer>
    <script src="/phplogin/420710/JS/statsScriptP2.js"></script>
    <script src="/phplogin/420710/JS/pokemonScriptP2.js"></script>
    <script>
        // Function to capitalize the first letter of a string
        function capitalizeFirstLetter(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // Function to update the autocomplete options based on the filtered names
        function updateAutocompleteOptions(names) {
            const dataList = document.getElementById("pokemon-options");
            dataList.innerHTML = "";

            names.forEach(name => {
                const capitalizedPokemonName = capitalizeFirstLetter(name);

                const option = document.createElement("option");
                option.value = capitalizedPokemonName;
                dataList.appendChild(option);
            });
        }

        // Add click event listener to the Log Out link
        const logOutLinkElement = document.getElementById("log-out-link");
        try {
            if (logOutLinkElement !== null) {
                logOutLinkElement.addEventListener("click", function (event) {
                    logOut();
                });
            }
        }
        catch(error) {};

        // JavaScript code to populate the dropdown menu
        document.addEventListener("DOMContentLoaded", async function () {
            const dropdownMenu = document.getElementById("pokemon-dropdown");

            try {
                // Fetch the list of all Pokémon names from the PokéAPI
                const response = await fetch("https://pokeapi.co/api/v2/pokemon?limit=150");
                const data = await response.json();

                console.log(data);

                // Extract the names of all Pokémon
                const pokemonNames = data.results.map((pokemon) => pokemon.name);
                console.log("Pokemon Names: "+ pokemonNames);
                // Sort the Pokémon names alphabetically
                pokemonNames.sort();

                updateAutocompleteOptions(pokemonNames);

                // Add event listeners to the filter inputs and search input
                let filterTypeSelect = document.getElementById("filter-type");
                let filterRaritySelect = document.getElementById("filter-rarity");

                // Call the function to filter cards automatically on page load

                function autocomplete(inp, arr) {
                    /*the autocomplete function takes two arguments,
                    the text field element and an array of possible autocompleted values:*/
                    var currentFocus;
                    /*execute a function when someone writes in the text field:*/
                    inp.addEventListener("input", function (e) {
                        var a, b, i, val = this.value;
                        /*close any already open lists of autocompleted values*/
                        closeAllLists();
                        if (!val) { return false; }
                        currentFocus = -1;
                        /*create a DIV element that will contain the items (values):*/
                        a = document.createElement("DIV");
                        a.setAttribute("id", this.id + "autocomplete-list");
                        a.setAttribute("class", "autocomplete-items");
                        /*append the DIV element as a child of the autocomplete container:*/
                        this.parentNode.appendChild(a);
                        /*for each item in the array...*/
                        for (i = 0; i < arr.length; i++) {
                            const capitalizedPokemonName = capitalizeFirstLetter(arr[i]);
                            /*check if the item starts with the same letters as the text field value:*/
                            if (capitalizedPokemonName.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                                /*create a DIV element for each matching element:*/
                                b = document.createElement("DIV");
                                /*make the matching letters bold:*/
                                b.innerHTML = "<strong>" + capitalizedPokemonName.substr(0, val.length) + "</strong>";
                                b.innerHTML += capitalizedPokemonName.substr(val.length);
                                /*insert a input field that will hold the current array item's value:*/
                                b.innerHTML += "<input type='hidden' value='" + capitalizedPokemonName + "'>";
                                /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function (e) {
                                    /*insert the value for the autocomplete text field:*/
                                    inp.value = this.getElementsByTagName("input")[0].value;
                                    /*close the list of autocompleted values,
                                    (or any other open lists of autocompleted values:*/
                                    closeAllLists();
                                });
                                a.appendChild(b);
                            }
                        }
                    });
                    /*execute a function presses a key on the keyboard:*/
                    inp.addEventListener("keydown", function (e) {
                        var x = document.getElementById(this.id + "autocomplete-list");
                        if (x) x = x.getElementsByTagName("div");
                        if (e.keyCode == 40) {
                            /*If the arrow DOWN key is pressed,
                            increase the currentFocus variable:*/
                            currentFocus++;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 38) { //up
                            /*If the arrow UP key is pressed,
                            decrease the currentFocus variable:*/
                            currentFocus--;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 13) {
                            /*If the ENTER key is pressed, prevent the form from being submitted,*/
                            e.preventDefault();
                            if (currentFocus > -1) {
                                /*and simulate a click on the "active" item:*/
                                if (x) x[currentFocus].click();
                            }
                        }
                    });
                    function addActive(x) {
                        /*a function to classify an item as "active":*/
                        if (!x) return false;
                        /*start by removing the "active" class on all items:*/
                        removeActive(x);
                        if (currentFocus >= x.length) currentFocus = 0;
                        if (currentFocus < 0) currentFocus = (x.length - 1);
                        /*add class "autocomplete-active":*/
                        x[currentFocus].classList.add("autocomplete-active");
                    }
                    function removeActive(x) {
                        /*a function to remove the "active" class from all autocomplete items:*/
                        for (var i = 0; i < x.length; i++) {
                            x[i].classList.remove("autocomplete-active");
                        }
                    }
                    function closeAllLists(element) {
                        /*close all autocomplete lists in the document,
                        except the one passed as an argument:*/
                        var x = document.getElementsByClassName("autocomplete-items");
                        for (var i = 0; i < x.length; i++) {
                            if (element != x[i] && element != inp) {
                                x[i].parentNode.removeChild(x[i]);
                            }
                        }
                    }
                    /*execute a function when someone clicks in the document:*/
                    document.addEventListener("click", function (e) {
                        closeAllLists(e.target);
                    });
                }
                autocomplete(document.getElementById("search-input"), (pokemonNames));

                // Function to toggle the display of the filters container
                function toggleFiltersContainer() {
                    const filtersContainer = document.getElementById("filters-container");

                    if (filtersContainer.style.display === "none") {
                        filtersContainer.style.display = "block";
                    } else {
                        filtersContainer.style.display = "none";
                    }
                }

                // Add click event listener to the "Filters" button
                const showFiltersButton = document.getElementById("show-filters-button");
                showFiltersButton.addEventListener("click", function (event) {
                    event.preventDefault();
                    toggleFiltersContainer();
                });

                //Event Listener to filter cards by type
                filterTypeSelect = document.getElementById("filter-type");
                filterTypeSelect.addEventListener("change", async function (event) {
                    event.preventDefault();

                    const selectType = filterTypeSelect.value;
                    filterPokemonByType(selectType);
                });

                //Event Listener to filter cards by rarity
                filterRaritySelect = document.getElementById("filter-rarity");
                filterRaritySelect.addEventListener("change", async function (event) {
                    event.preventDefault();

                    const selectRarity = filterRaritySelect.value;
                    filterPokemonByRarity(selectRarity);
                });


                // Iterate through the sorted list of Pokémon names and add them to the dropdown menu
                pokemonNames.forEach(function (pokemonName) {
                    const capitalizedPokemonName = capitalizeFirstLetter(pokemonName);
                    const optionElement = document.createElement("option");
                    optionElement.textContent = capitalizedPokemonName;
                    dropdownMenu.appendChild(optionElement);
                });

            } catch (error) {
                console.error("Error fetching Pokémon data:", error);
            }
        });
    </script>
</body>

</html>