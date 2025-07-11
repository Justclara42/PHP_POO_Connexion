<?php
require('config.php');
session_start();
require_once "app/User.php";
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
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Dropdown pour utilisateur connecté -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlentities($_SESSION['username']) ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="edit.php">Éditer le profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete()">Supprimer le compte</a></li>
                            <script>
                                function confirmDelete() {
                                    if (confirm("Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.")) {
                                        window.location.href = "delete_account.php";
                                    }
                                }
                            </script>
                            <li><a class="dropdown-item" href="logout.php">Déconnexion</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">S'inscrire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Se connecter</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteneur principal -->
<div class="container main-container">
    <h1 class="title"><?= SITE_NAME ?></h1>

    <!-- Messages de session -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible" role="alert">
            <?= htmlentities($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <?= htmlentities($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <p>Bienvenue dans votre application PHP POO !</p>
    <div class="mt-4">
        <h2>Liste des utilisateurs</h2>
        <ul class="list-group">
            <?php
            $user = new User('', '', '');
            $users = $user->getAllUsers();
            if (!empty($users)) {
                foreach ($users as $user) {
                    // Vérification de la disponibilité de l'id
                    $userId = isset($user->id) ? htmlentities($user->id) : null;
                    $username = isset($user->username) ? htmlentities($user->username) : "Utilisateur inconnu";
                    $email = isset($user->email) ? htmlentities($user->email) : "Email indisponible";

                    echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                    echo $username . ' (' . $email . ')';
                    if ($userId) {
                        echo '<a href="profile.php?id=' . $userId . '" class="btn btn-info btn-sm">Voir profil</a>';
                    }
                    echo '</li>';
                }
            } else {
                echo '<li class="list-group-item">Aucun utilisateur trouvé.</li>';
            }
            ?>
        </ul>
    </div></div>

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