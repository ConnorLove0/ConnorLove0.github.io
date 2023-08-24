<?php
session_start();
session_destroy();
// Redirect to the login page:
header('Location: /phplogin/420710/pokemon_collect_app_p2.php');
?>