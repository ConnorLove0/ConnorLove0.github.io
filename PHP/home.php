<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
    header('Location: http://localhost/phplogin/420710/login.html');
    exit;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'calove';
$DATABASE_PASS = 'VXvsjr71!';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Retrieve user cards from the database.
$stmt = $con->prepare('SELECT card_name, card_type, created_at, card_image_url FROM user_cards WHERE user_id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($card_name, $card_type, $created_at, $card_image_url);
$stmt->store_result(); // Add this line to store the result


// Retrieve usernames from the database.
$userStmt = $con->prepare('SELECT username, login_count FROM accounts');
$userStmt->execute();
$userStmt->bind_result($username, $login_count);
$accounts = array();
$accountLogins = array();


while ($userStmt->fetch()) {
    $accounts[] = $username;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        .navtop {
            background-color: #F56600;
            height: 60px;
            width: 100%;
            border: 0;
        }

        .navtop div {
            display: flex;
            margin: 0 auto;
            width: 1000px;
            height: 100%;
        }

        .navtop div h1,
        .navtop div a {
            display: inline-flex;
            align-items: center;
        }

        .navtop div h1 {
            flex: 1;
            font-size: 25px;
            padding: 0;
            margin: 0;
            color: #522d80;
            font-weight: bold;
        }

        .navtop div a {
            padding: 0 20px;
            text-decoration: none;
            color: #522d80;
            font-weight: bold;
        }

        .navtop div a i {
            padding: 2px 8px 0 0;
        }

        .navtop div a:hover {
            color: white;
        }

        body.loggedin {
            background-color: #522d80;
        }

        .content {
            width: 1000px;
            margin: 0 auto;
        }

        .content h2 {
            margin: 0;
            padding: 25px 0;
            font-size: 22px;
            border-bottom: 1px solid #F56600;
            color: #F56600;
        }

        .content>p,
        .content>div {
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);
            margin: 25px 0;
            padding: 25px;
            background-color: #F56600;
            color: #522d80;
            font-weight: bold;
        }

        .content>p table td,
        .content>div table td {
            padding: 5px;
        }

        .content>p table td:first-child,
        .content>div table td:first-child {
            font-weight: bold;
            color: #4a536e;
            padding-right: 15px;
        }

        .content>div p {
            padding: 5px;
            margin: 0 0 10px 0;
        }

        .image-left {
            width: 0;
            text-align: center;
        }

        .info-right {
            flex: 2;
            padding: 10px;
            text-align: center;
            border: 1px solid #F56600;
            border-radius: 5px;
        }

        .card {
            border: 1px solid #522D80;
            width: 25%;
        }

        .remove-card-form,
        .viewCardDetails {
            background-color: #F56600;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        #removeButton {
            color: #F56600;
            background-color: #522D80;
            cursor: pointer;
        }
        #removeButton:hover {
            color: #F56600;
            background-color: white;
        }
    </style>
    <script src="/phplogin/420710/JS/statsScriptP2.js"></script>
</head>

<body class="loggedin">
    <nav class="navtop">
        <div>
            <h1>CaLove</h1>
            <a href="/phplogin/420710/pokemon_collect_app_p2.php">
                <i class="fas fa-user-circle"></i>Pokemon Card App</a>
            <a href="/phplogin/420710/stats.php">
                <i class="fas fa-user-circle"></i>Pokemon Statistics</a>
            <a href="profile.php"><i class="fas fa-user-circle"></i>Account Details</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
        </div>
    </nav>
    <div class="content">
        <h2>Home Page</h2>
        <?php if ($_SESSION['login_count'] === '1') { ?>
            <p>Hello New User!</p>
        <?php }
        else { ?>
            <p>Welcome back, <?= $_SESSION['username'] ?>!</p>
        <?php } ?>
        <h2>Your Cards</h2>
        <!-- Display user's cards here -->
        <?php
        if ($stmt->num_rows === 0) {
            // No cards available
            echo "<p>No cards added yet!</p>";
        } else {
            while ($stmt->fetch()) { ?>
                <div class="card">
                    <div class="image-left">
                        <img src="<?= $card_image_url ?>" alt="<?= $card_name ?>" />
                    </div>
                    <!-- Display card information -->
                    <div class="info-right">
                        <hr><strong>Card Name:</strong>
                            <?= $card_name ?><br>
                        <hr><strong>Card Type:</strong>
                            <?= $card_type ?><br>
                        <hr><strong>Date Added:</strong>
                            <?= $created_at ?><br>
                        <form class="remove-card-form" action="/phplogin/420710/PHP/removeCard.php" method="post">
                            <!-- Store the card name in a hidden input -->
                            <input type="hidden" name="card_name" value="<?= $card_name ?>">
                            <!-- Button to remove the card -->
                            <button type="submit" id = "removeButton">Remove</button>
                        </form>
                    </div>
                </div>
            <?php }
        }
        ?>

        <h2>All Users</h2>
        <div class="user-log">
            <?php if ($_SESSION['username'] === 'calove'): ?>
                <p>Logged in as calove.</p>

                <p>
                <h4>All users:</h4>
                <ul>
                    <?php
                    $stmt = $con->prepare('SELECT username, email, created_at, last_login, login_count FROM accounts');
                    $stmt->execute();
                    $stmt->bind_result($username, $email, $created_at, $last_login, $login_count);

                    while ($stmt->fetch()) { ?>
                        <table>
                            <hr><strong>Username:</strong>
                            <?= $username ?><br>
                            <strong>Email:</strong>
                            <?= $email ?><br>
                            <strong>Created At:</strong>
                            <?= $created_at ?><br>
                            <strong>Last Login:</strong>
                            <?= $last_login ?><br>
                            <strong>Login Count:</strong>
                            <?= $login_count ?>
                            <hr>
                        </table>
                    <?php } ?>
                </ul>
                </p>
            <?php else: ?>
                <p>You are not authorized to view this information.</p>
            <?php endif; ?>
        </div>
    </div>
    <script>
        // Function to display a success alert
        function showSuccessAlert(message) {
            alert('Success: ' + message);
        }

        // Function to display an error alert
        function showErrorAlert(message) {
            alert('Error: ' + message);
        }

        // Add event listener to handle form submissions
        const removeCardForms = document.querySelectorAll('.remove-card-form');
        removeCardForms.forEach(form => {
            form.addEventListener('submit', function (event) {
                event.preventDefault();
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Show success alert
                            showSuccessAlert(data.message);
                            // Optional: You can remove the card element from the page on successful removal
                            form.closest('.card').remove();
                        } else {
                            // Show error alert
                            showErrorAlert(data.message);
                        }
                    })
                    .catch(error => {
                        showErrorAlert('An error occurred while processing the request.');
                        console.error('Error:', error);
                    });
            });
            
        });
        // Add event listener for the "View Card Details" links
    const viewCardDetailsLinks = document.querySelectorAll('.viewCardDetails');
    viewCardDetailsLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            const cardName = link.dataset.cardName;
            PokemonStatsApp.createPokemonCardPage({ name: cardName });
        });
    });
    </script>
</body>

</html>