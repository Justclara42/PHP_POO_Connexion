<?php
require('config.php');
session_start();
require_once "app/User.php";

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = "Vous devez être connecté pour supprimer votre compte.";
    header("Location: login.php");
    exit;
}

// Supprimer le compte de l'utilisateur
$user = new User('', '', '');
$user->deleteAccount($_SESSION['user_id']);