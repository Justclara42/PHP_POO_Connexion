# PHP POO - Application de gestion d'utilisateurs

Cette application est développée en **PHP** en utilisant la **programmation orientée objet (POO)**. Elle permet la gestion des utilisateurs, notamment la création, l'édition, et la suppression de comptes.

---

## Prérequis

1. **Serveur Web** : Apache, Nginx ou tout autre serveur avec support PHP.
2. **Version de PHP** : PHP 8.1 ou supérieur.
3. **Base de données MySQL/MariaDB** pour stocker les informations des utilisateurs.
4. **Composer** (facultatif) pour la gestion des dépendances.

---

## Configuration

### 1. Configuration de la base de données

Avant d'utiliser l'application, vous devez créer une base de données MySQL.

1. Ouvrez votre terminal MySQL et exécutez les commandes suivantes pour créer la base de données et sa table principale :
   ```sql
   CREATE DATABASE cours_poo CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
   ```

2. Créez la table `users` pour stocker les informations utilisateur :
   ```sql
   CREATE TABLE users (
       id INT AUTO_INCREMENT PRIMARY KEY,
       username VARCHAR(100) NOT NULL,
       email VARCHAR(255) NOT NULL UNIQUE,
       password VARCHAR(255) NOT NULL,
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
       updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
   );
   ```

3. Vérifiez que l'utilisateur MySQL dispose des autorisations nécessaires pour accéder à la base de données.

---

### 2. Configuration de l'application

Modifiez le fichier **`config.php`** pour qu'il corresponde aux informations de votre base de données MySQL. 

Exemple de configuration dans le fichier `config.php` :

---

## Bugs et Développement Futur

1. **Prochaine fonctionnalité** :  
   - Ajouter la pagination pour la liste des utilisateurs.

2. **Bugs connus :**  
   - Aucun bug majeur n'a encore été signalé.

---

## Support

Si vous avez des problèmes ou des questions, contactez-moi ou ouvrez un ticket de support. Je ferai de mon mieux pour vous assister !

Bon développement ! 🚀