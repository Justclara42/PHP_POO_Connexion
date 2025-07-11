<?php


session_start();
require_once "app/User.php";

if (!empty($_POST) && isset($_POST['email'], $_POST['username'], $_POST['password'],$_POST['confirm_password'])) {
    $user = new User($_POST['email'], $_POST['username'], $_POST['password'],$_POST['confirm_password']);
    // Logique pour traiter les données du formulaire, par exemple, enregistrer l'utilisateur dans la base de données
    $user->create($data = $_POST);
    $_SESSION['form_success'] = "Utilisateur créé avec succès !";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Nom du site -->
        <a class="navbar-brand" href="index.php"><?= SITE_NAME ?></a>
        <!-- Bouton Hamburger pour mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>

        <!-- Menu de navigation -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">S'inscrire</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Se connecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteneur principal -->
<div class="container main-container">
    <h1 class="title"><?= SITE_NAME ?></h1>
    <p>Bienvenue dans votre application PHP POO !</p>
    <div class="flex p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
        <?php
        if (isset($_SESSION["form_errors"]) && !empty($_SESSION["form_errors"])) {
            $errors = $_SESSION["form_errors"];
            foreach ($errors as $error) : ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <div><?= htmlentities($error); ?></div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endforeach;
        }
        unset($_SESSION["form_errors"]);
        ?>
        <?php
        if (isset($_SESSION["form_success"]) && !empty($_SESSION["form_success"])) {
            $success = $_SESSION["form_success"]; ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <div><?= htmlentities($success); ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        }
        unset($_SESSION["form_success"]);
        ?>
    </div>
    <form action="register.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Nom d'utilisateur</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmer Mot de passe</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Soumettre</button>

    </form>
</div>

<!-- Footer -->
<footer class="footer">
    <p class="footer-text">&copy; Cours PHP POO - 2025</p>
</footer>
<script src="assets/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>