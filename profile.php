<?php
require('config.php');
session_start();
require_once "app/User.php";

// Vérifier si l'ID de l'utilisateur est fourni dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID utilisateur invalide.";
    header("Location: index.php");
    exit;
}

$userId = intval($_GET['id']);
$user = new User('', '', '');

try {
    // Récupérer les données de l'utilisateur
    $userData = $user->show($userId);

    // Configuration locale pour l'horodatage
    date_default_timezone_set('Europe/Paris');

    // Fonction pour formater les dates avec IntlDateFormatter
    function formatDate($dateString) {
        if (empty($dateString)) {
            return "Non défini";
        }
        $timestamp = strtotime($dateString); // Convertir la date en timestamp

        // Création du formatteur de date
        $formatter = new IntlDateFormatter(
            'fr_FR', // Langue : français
            IntlDateFormatter::FULL, // Longueur complète (e.g. 'Vendredi 11 juillet 2025')
            IntlDateFormatter::NONE, // Pas d'affichage de l'heure
            'Europe/Paris', // Fuseau horaire
            IntlDateFormatter::GREGORIAN // Calendrier grégorien
        );

        return $formatter->format($timestamp); // Formater la date
    }

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de <?= htmlentities($userData['username']) ?> - <?= SITE_NAME ?></title>
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><?= SITE_NAME ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Accueil</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlentities($_SESSION['username']) ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="edit.php">Éditer le profil</a></li>
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

<div class="container main-container">
    <h1>Profil de <?= htmlentities($userData['username']) ?></h1>
    <p><strong>Nom d'utilisateur :</strong> <?= htmlentities($userData['username']) ?></p>
    <p><strong>Email :</strong> <?= htmlentities($userData['email']) ?></p>
    <p><strong>Date de création :</strong> <?= formatDate($userData['created_at']) ?></p>
    <p><strong>Dernière mise à jour :</strong> <?= formatDate($userData['updated_at']) ?></p>
    <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
</div>

<footer class="footer">
    <p class="footer-text">&copy; Cours PHP POO - 2025</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"></script>
</body>

</html>