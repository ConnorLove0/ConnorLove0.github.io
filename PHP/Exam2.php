<!--Connor Love-->
<!--CPSC 3750-->
<!--Programming Exam #2-->
<!--7/29/2023-->

<!DOCTYPE html>
<html>

<head>
    <title>Exam #2</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://codepen.io/retrofuturistic/pen/tlbHE">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-image: url("Images/cool-background.png");
        }

        .droparea {
            min-height: 100px;
            border: 2px dashed #ccc;
            padding: 10px;
            background-color: black;
        }

        .content_area {
            padding-bottom: 20%;
        }

        [draggable] {
            -moz-user-select: none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            user-select: none;
            /* Required to make elements draggable in old WebKit */
            -khtml-user-drag: element;
            -webkit-user-drag: element;
        }

        #columns {
            list-style-type: none;
        }

        .column {
            padding-bottom: 5px;
            margin: 0 auto;
            padding-top: 5px;
            text-align: center;
            cursor: pointer;
        }

        .column header {
            height: 20px;
            width: 150px;
            color: black;
            background-color: #522d80;
            padding: 5px;
            border-bottom: 1px solid #ddd;
            border-radius: 10px;
            border: 2px solid #666666;
        }

        .column.dragElem {
            opacity: 0.4;
        }

        .column.over {
            border: 2px dashed #000;
            border-top: 2px solid blue;
        }

        .draglist {
            width: 80%;
            margin: 0 auto;
            text-align: left;
            padding: 0;
        }

        .button {
            color: #f56600;
            background-color: #522d80;
        }

        .content_area h2 {
            color: #522d80;
        }

        @media screen and (max-width: 1250px) {
            .right_side {
                width: 10%;
            }
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
                                    <li><a href="Exam2.php">Exam #2</a></li>
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
                <h2>Exam #2
                    <hr>
                </h2>
                <?php
                //Reads the file and count the number of vowels in each word
                $wordsFile = "words.txt";
                $words = file($wordsFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                $wordCountByVowels = [];
                foreach ($words as $word) {
                    $vowelsCount = preg_match_all('/[AEIOU]/i', $word);
                    $wordCountByVowels[$vowelsCount][] = $word;
                }

                // Generates buttons for each unique number of vowels
                $vowelCounts = array_keys($wordCountByVowels);
                sort($vowelCounts);
                ?>

                <div>
                    <?php
                    // Displays buttons for different vowel counts
                    foreach ($vowelCounts as $vowelCount) {
                        echo '<button class = "button" onclick="showWords(' . $vowelCount . ')">' . $vowelCount . '</button>';
                    }
                    ?>
                </div>

                <div>
                    <?php
                    //Displays scrollable list of words for the selected vowel count
                    foreach ($vowelCounts as $vowelCount) {
                        echo '<div id="vowel-' . $vowelCount . '" style="display: none;">';
                        // Sort words by length
                        usort($wordCountByVowels[$vowelCount], function ($a, $b) {
                            return strlen($a) - strlen($b);
                        });
                        echo '<ul id="columns" class="draglist">';
                        foreach ($wordCountByVowels[$vowelCount] as $word) {
                            echo '<li class="column" draggable="true">' . $word . '</li>';
                        }
                        echo '</ul>';
                        echo '</div>';
                    }
                    ?>
                </div>

                <div>
                    <?php
                    // Displays the drop area and label for the number of words dropped
                    echo '<div id="drop-area" class="droparea" ondrop="drop(event)" ondragover="allowDrop(event)"></div>';
                    echo '<p>Number of words dropped: <span id="word-count">0</span></p>';
                    ?>
                    <button class="button" onclick="resetList()">Reset List</button>
                </div>
            </div>
        </nav>
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
                </div>
            </ul>
        </div>
    </div>
    <script>
        // JavaScript functions for drag and drop
        function allowDrop(event) {
            event.preventDefault();
        }

        function drag(event) {
            event.dataTransfer.setData("text", event.target.textContent);
        }

        function drop(event) {
            event.preventDefault();
            var data = event.dataTransfer.getData("text");
            var dropArea = document.getElementById("drop-area");
            var wordList = dropArea.innerHTML;
            dropArea.innerHTML = wordList + '<div>' + data + '</div>';
            updateWordCount();
        }

        function updateWordCount() {
            var wordCount = document.getElementById("drop-area").childElementCount;
            document.getElementById("word-count").textContent = wordCount;
        }

        function showWords(vowelCount) {
            // Hide all lists and then display the selected list
            var allLists = document.querySelectorAll("div[id^='vowel-']");
            for (var i = 0; i < allLists.length; i++) {
                allLists[i].style.display = "none";
            }
            var selectedList = document.getElementById("vowel-" + vowelCount);
            if (selectedList) {
                selectedList.style.display = "block";
            }
        }
        var dragSrcEl = null;

        function handleDragStart(e) {
            // Target (this) element is the source node.
            dragSrcEl = this;

            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.outerHTML);

            this.classList.add('dragElem');
        }

        function handleDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault(); // Necessary. Allows us to drop.
            }
            this.classList.add('over');

            e.dataTransfer.dropEffect = 'move'; // See the section on the DataTransfer object.

            return false;
        }

        function handleDragEnter(e) {
            // this / e.target is the current hover target.
        }

        function handleDragLeave(e) {
            this.classList.remove('over'); // this / e.target is previous target element.
        }

        function handleDrop(e) {
            // this/e.target is current target element.

            if (e.stopPropagation) {
                e.stopPropagation(); // Stops some browsers from redirecting.
            }

            if (dragSrcEl != this) {
                this.parentNode.removeChild(dragSrcEl);
                var dropHTML = e.dataTransfer.getData('text/html');
                this.insertAdjacentHTML('beforebegin', dropHTML);
                var dropElem = this.previousSibling;
                addDnDHandlers(dropElem);

            }
            this.classList.remove('over');
            return false;
        }

        function handleDragEnd(e) {
            this.classList.remove('over');
        }

        function addDnDHandlers(elem) {
            elem.addEventListener('dragstart', handleDragStart, false);
            elem.addEventListener('dragenter', handleDragEnter, false)
            elem.addEventListener('dragover', handleDragOver, false);
            elem.addEventListener('dragleave', handleDragLeave, false);
            elem.addEventListener('drop', handleDrop, false);
            elem.addEventListener('dragend', handleDragEnd, false);

        }

        var cols = document.querySelectorAll('#columns .column');
        [].forEach.call(cols, addDnDHandlers);

        function resetList() {
            // Hide all word lists
            var allLists = document.querySelectorAll("div[id^='vowel-']");
            for (var i = 0; i < allLists.length; i++) {
                allLists[i].style.display = "none";
            }

            // Clear the drop area and reset the word count
            document.getElementById("drop-area").innerHTML = "";
            document.getElementById("word-count").textContent = "0";

            // Reset the grayed-out appearance of all word list items
            var wordItems = document.querySelectorAll(".column");
            for (var j = 0; j < wordItems.length; j++) {
                wordItems[j].classList.remove("dragElem");
            }
        }
    </script>
</body>

</html>