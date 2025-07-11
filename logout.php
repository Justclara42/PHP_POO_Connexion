<?php
require_once "app/User.php";

// Créer une instance de la classe User (les arguments ne sont pas nécessaires ici)
$user = new User('', '', '');

// Appeler la méthode logout
$user->logout();