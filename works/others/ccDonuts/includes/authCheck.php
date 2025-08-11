<?php
if (!isset($_SESSION['customer']) || empty($_SESSION['customer'])) {
    header('Location: login.php');
    exit;
}
?>