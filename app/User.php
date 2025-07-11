<?php

require_once 'config.php';
class User
{
    // Propriétés de la classe User
    private int $id;
    private string $username;
    private string $password;
    private string $email;
    private string $created_at;
    private string $updated_at;
    // Méthode pour obtenir l'instance unique de la classe User (Singleton)

    public function __construct(string $email, string $username, string $password)
    {
        // Constructeur privé pour empêcher l'instanciation directe
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

public function getAllUsers()
{
    try {
        $pdo = new PDO(DSN, USER, PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Inclut l'ID pour éviter le problème de propriété manquante
        $query = "SELECT id, username, email FROM users";
        $statement = $pdo->query($query);

        // Retourner les résultats sous forme d'objets
        $users = $statement->fetchAll(PDO::FETCH_OBJ);
        return $users;
    } catch (PDOException $e) {
        throw new Exception("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
    }
}

public function create(array $data = [])
{
    // Logique pour afficher le formulaire de création d'un utilisateur
    if (isset($data) && !empty($data)) {
        // Gérer les erreurs de validation
        $errors = [];
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }
        if (empty($data['email'])) {
            $errors[] = 'L\'email est requis.';
        }
        if (empty($data['username'])) {
            $errors[] = 'Le nom d\'utilisateur est requis.';
        }
        if (empty($data['password'])) {
            $errors[] = 'Le mot de passe est requis.';
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            header("Location: register.php");
            exit;
        }

        // Récupérer et trim les données
        $pdo = new PDO(DSN, USER, PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $username = trim($data['username']);
        $email = trim($data['email']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $createdAt = date('Y-m-d H:i:s'); // Date actuelle pour created_at et updated_at
        $updatedAt = $createdAt;

        // Préparer la requête d'insertion
        $query = "INSERT INTO users (email, username, password, created_at, updated_at) 
                  VALUES (:email, :username, :password, :created_at, :updated_at)";

        $statement = $pdo->prepare($query);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':created_at', $createdAt, PDO::PARAM_STR);
        $statement->bindParam(':updated_at', $updatedAt, PDO::PARAM_STR);

        $statement->execute();

        $_SESSION['form_success'] = "Utilisateur créé avec succès.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['form_errors'] = $data['errors'];
        header("Location: register.php");
        exit;
    }
}

    public function store()
    {
        // Logique pour traiter le formulaire de création d'un utilisateur
        // Par exemple, valider les données, les insérer dans la base de données, etc.
    }
    public function edit($id)
    {
        // Logique pour afficher le formulaire d'édition d'un utilisateur
        // Par exemple, récupérer l'utilisateur par son ID depuis la base de données
        // et retourner les données à une vue ou un template.
    }
    public function update($id, array $data)
{
    try {
        $pdo = new PDO(DSN, USER, PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Validation des données
        $errors = [];
        if (empty($data['username'])) {
            $errors[] = "Le nom d'utilisateur est requis.";
        }
        if (empty($data['email'])) {
            $errors[] = "L'adresse email est requise.";
        }
        if (!empty($data['password']) || !empty($data['confirm_password'])) {
            if ($data['password'] !== $data['confirm_password']) {
                $errors[] = "Les mots de passe ne correspondent pas.";
            }
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            header("Location: edit.php");
            exit;
        }

        // Préparation des données pour mise à jour
        $username = trim($data['username']);
        $email = trim($data['email']);
        $updatedAt = date('Y-m-d H:i:s'); // Date actuelle pour updated_at

        $query = "UPDATE users SET username = :username, email = :email, updated_at = :updated_at";

        // Vérifier si un nouveau mot de passe est fourni
        if (!empty($data['password'])) {
            $query .= ", password = :password";
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }

        $query .= " WHERE id = :id";

        $statement = $pdo->prepare($query);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':updated_at', $updatedAt, PDO::PARAM_STR);
        if (!empty($data['password'])) {
            $statement->bindParam(':password', $data['password'], PDO::PARAM_STR);
        }
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        // Mise à jour des données de la session
        $_SESSION['username'] = $username;

        $_SESSION['success'] = "Profil mis à jour avec succès.";
        header("Location: index.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la mise à jour : " . $e->getMessage();
        header("Location: edit.php");
        exit;
    }
}
    public function delete($id)
    {
        // Logique pour supprimer un utilisateur
        // Par exemple, supprimer l'utilisateur de la base de données par son ID.
    }
    public function show($id)
    {
        try {
            $pdo = new PDO(DSN, USER, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT id, username, email, created_at, updated_at FROM users WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception("Utilisateur introuvable.");
            }

            return $user;
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la récupération des données : " . $e->getMessage());
        }
    }
    public function login(string $email, string $password)
    {
        // Initialiser la connexion à la base de données
        try {
            $pdo = new PDO(DSN, USER, PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Requête pour récupérer l'utilisateur par email
            $query = "SELECT * FROM users WHERE email = :email";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->execute();

            // Récupérer l'utilisateur
            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Vérification du mot de passe
                if (password_verify($password, $user['password'])) {
                    // Si la connexion est réussie
                    session_start();
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['success'] = "Connexion réussie ! Bienvenue {$user['username']}.";

                    // Redirection vers la page index.php
                    header("Location: index.php");
                    exit;
                } else {
                    // Mot de passe incorrect
                    session_start();
                    $_SESSION['error'] = "Mot de passe incorrect.";
                    header("Location: login.php");
                    exit;
                }
            } else {
                // Aucun utilisateur trouvé avec cet email
                session_start();
                $_SESSION['error'] = "Aucun utilisateur trouvé avec cet email.";
                header("Location: login.php");
                exit;
            }
        } catch (PDOException $e) {
            // Gestion des erreurs PDO
            session_start();
            $_SESSION['error'] = "Erreur de connexion à la base de données : " . $e->getMessage();
            header("Location: login.php");
            exit;
        }
    }
    public function authenticate()
    {
        // Logique pour traiter le formulaire de connexion
        // Par exemple, valider les identifiants, démarrer une session, etc.
    }
    public function logout()
    {
        session_start(); // Démarrer la session si elle n'est pas déjà démarrée
        session_unset(); // Supprimer toutes les variables de session
        session_destroy(); // Détruire la session
        header("Location: login.php"); // Rediriger vers la page de connexion
        exit; // S'assurer que le script s'arrête
    }

public function deleteAccount($id)
{
    try {
        $pdo = new PDO(DSN, USER, PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "DELETE FROM users WHERE id = :id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        // Déconnexion après suppression
        session_start();
        session_unset();
        session_destroy();

        $_SESSION['success'] = "Votre compte a été supprimé avec succès.";
        header("Location: register.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
        header("Location: edit.php");
        exit;
    }
}
}