<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
    echo json_encode(['username' => $username]);
} else {
    echo json_encode(['username' => null]);
}
?>